<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DashboardItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        ];

        try {
            $pdo = DB::connection()->getPdo();
            $dbStatus['connected'] = true;
            $dbStatus['version'] = DB::selectOne("SELECT version()")?->version ?? 'PostgreSQL';
        } catch (\Exception $e) {
            $dbStatus['connected'] = false;
            $dbStatus['error'] = $e->getMessage();
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
                $items = DashboardItem::orderBy('id', 'desc')->get();
                $stats['total'] = $items->count();
                $stats['operational'] = $items->where('status', 'Operational')->count();
                $stats['completed'] = $items->where('status', 'Completed')->count();
                $stats['pending'] = $items->whereIn('status', ['Pending', 'In Progress'])->count();
                $stats['health_score'] = $stats['total'] > 0 
                    ? round((($stats['operational'] + $stats['completed']) / $stats['total']) * 100) 
                    : 100;
            } catch (\Exception $e) {
                // Table might not exist yet before migration
                $dbStatus['error'] = 'Database connected, but dashboard_items table is missing. Run migration.';
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

        return redirect()->route('dashboard')->with('success', 'Dashboard item created successfully!');
    }

    public function update(Request $request, $id)
    {
        $item = DashboardItem::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $item->update($validated);

        return redirect()->route('dashboard')->with('success', 'Item status updated successfully!');
    }

    public function destroy($id)
    {
        $item = DashboardItem::findOrFail($id);
        $item->delete();

        return redirect()->route('dashboard')->with('success', 'Item removed successfully!');
    }

    public function dbCheck()
    {
        try {
            $pdo = DB::connection()->getPdo();
            $version = DB::selectOne("SELECT version()")?->version;
            $tableCount = DB::table('dashboard_items')->count();

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
