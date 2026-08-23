<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DashboardItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    public function index()
    {
        $dbStatus = [
            'connected' => false,
            'driver' => config('database.default'),
            'host' => config('database.connections.' . config('database.default') . '.host'),
            'database' => config('database.connections.' . config('database.default') . '.database'),
            'error' => null,
            'version' => null,
            'is_fallback' => false,
        ];

        // Attempt 1: Connect to configured database (Neon PostgreSQL or default)
        try {
            $pdo = DB::connection()->getPdo();
            $dbStatus['connected'] = true;
            $dbStatus['version'] = DB::selectOne("SELECT version()")?->version ?? 'PostgreSQL';
        } catch (\Exception $e) {
            // Attempt 2: If Neon PostgreSQL is disabled or fails, fallback to SQLite in /tmp
            try {
                $sqlitePath = is_writable('/tmp') ? '/tmp/database.sqlite' : database_path('database.sqlite');
                if (!file_exists($sqlitePath)) {
                    @touch($sqlitePath);
                }

                Config::set('database.default', 'sqlite');
                Config::set('database.connections.sqlite.database', $sqlitePath);
                DB::purge('sqlite');
                DB::reconnect('sqlite');

                $pdo = DB::connection('sqlite')->getPdo();
                $dbStatus['connected'] = true;
                $dbStatus['driver'] = 'sqlite (محلّي / احتياطي)';
                $dbStatus['is_fallback'] = true;
                $dbStatus['error'] = 'ملاحظة: تعذر الاتصال بـ Neon Cloud PostgreSQL، تم تفعيل قاعدة البيانات الاحتياطية تلقائياً.';
            } catch (\Exception $fallbackEx) {
                $dbStatus['connected'] = false;
                $dbStatus['error'] = $e->getMessage();
            }
        }

        $items = collect();
        $stats = [
            'total' => 0,
            'operational' => 0,
            'completed' => 0,
            'pending' => 0,
            'health_score' => 100,
        ];

        if ($dbStatus['connected']) {
            try {
                // Auto-run migration & seeding if table does not exist yet
                if (!Schema::hasTable('dashboard_items')) {
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed', ['--force' => true]);
                }

                $items = DashboardItem::orderBy('id', 'desc')->get();
                $stats['total'] = $items->count();
                $stats['operational'] = $items->where('status', 'Operational')->count();
                $stats['completed'] = $items->where('status', 'Completed')->count();
                $stats['pending'] = $items->whereIn('status', ['Pending', 'In Progress'])->count();
                $stats['health_score'] = $stats['total'] > 0 
                    ? round((($stats['operational'] + $stats['completed']) / $stats['total']) * 100) 
                    : 100;
            } catch (\Exception $e) {
                $dbStatus['error'] = 'حدث خطأ عند استعلام قاعدة البيانات: ' . $e->getMessage();
            }
        }

        return view('dashboard', compact('items', 'dbStatus', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'status' => 'required|string|max:50',
            'metric_value' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
        ]);

        $validated['metric_value'] = $validated['metric_value'] ?? 100;

        DashboardItem::create($validated);

        return redirect()->route('dashboard')->with('success', 'تم إضافة العنصر الجديد بنجاح إلى قاعدة البيانات!');
    }

    public function update(Request $request, $id)
    {
        $item = DashboardItem::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $item->update($validated);

        return redirect()->route('dashboard')->with('success', 'تم تحديث حالة العنصر بنجاح!');
    }

    public function destroy($id)
    {
        $item = DashboardItem::findOrFail($id);
        $item->delete();

        return redirect()->route('dashboard')->with('success', 'تم حذف العنصر بنجاح!');
    }

    public function dbCheck()
    {
        try {
            $pdo = DB::connection()->getPdo();
            $version = DB::selectOne("SELECT version()")?->version;
            $tableCount = Schema::hasTable('dashboard_items') ? DB::table('dashboard_items')->count() : 0;

            return response()->json([
                'status' => 'success',
                'connected' => true,
                'connection' => config('database.default'),
                'host' => config('database.connections.' . config('database.default') . '.host'),
                'database' => config('database.connections.' . config('database.default') . '.database'),
                'pgsql_version' => $version,
                'items_count' => $tableCount,
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'connected' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toIso8601String(),
            ], 500);
        }
    }
}
