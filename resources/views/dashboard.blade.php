<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الجامعية | Laravel & Cloud Neon PostgreSQL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --accent-green: #10b981;
            --accent-blue: #3b82f6;
            --accent-yellow: #f59e0b;
            --accent-red: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            padding: 2rem 1.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .brand h1 {
            font-size: 1.85rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid var(--border-color);
            padding: 0.6rem 1.2rem;
            border-radius: 9999px;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .pulse-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
        }

        .pulse-dot.online {
            background: var(--accent-green);
            box-shadow: 0 0 12px var(--accent-green);
        }

        .pulse-dot.offline {
            background: var(--accent-red);
            box-shadow: 0 0 12px var(--accent-red);
        }

        .alert-bar {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.92rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #6ee7b7;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .card-stat {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-2px);
            border-color: rgba(99, 102, 241, 0.4);
        }

        .card-stat .title {
            font-size: 0.88rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-stat .value {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .card-stat .subtext {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: white;
            padding: 0.65rem 1.3rem;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s ease, transform 0.1s ease;
        }

        .btn:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .btn-sm {
            padding: 0.4rem 0.85rem;
            font-size: 0.82rem;
            border-radius: 8px;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.4);
        }

        .card-table {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        th {
            background: rgba(15, 23, 42, 0.7);
            padding: 1.1rem 1.25rem;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 700;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 1.1rem 1.25rem;
            font-size: 0.92rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .pill {
            display: inline-block;
            padding: 0.3rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .pill-operational { background: rgba(16, 185, 129, 0.18); color: #34d399; }
        .pill-completed { background: rgba(59, 130, 246, 0.18); color: #60a5fa; }
        .pill-in-progress { background: rgba(245, 158, 11, 0.18); color: #fbbf24; }
        .pill-pending { background: rgba(148, 163, 184, 0.18); color: #cbd5e1; }

        .form-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.75rem;
            margin-bottom: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.1rem;
            margin-bottom: 1.1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .form-group label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 0.65rem 0.9rem;
            border-radius: 10px;
            font-size: 0.92rem;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        footer {
            margin-top: 3.5rem;
            text-align: center;
            font-size: 0.88rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            padding-top: 1.75rem;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <div class="brand">
            <h1>لوحة التحكم الجامعية (Laravel)</h1>
            <p>تطبيق سحابي (Serverless) • متصل بقاعدة بيانات Neon PostgreSQL</p>
        </div>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="/db-check" target="_blank" class="btn btn-secondary btn-sm">
                🔍 فحص التشخيص (DB Check)
            </a>
            <div class="badge-status">
                @if($dbStatus['connected'])
                    <span class="pulse-dot online"></span>
                    <span>متصل بقاعدة البيانات Neon PostgreSQL</span>
                @else
                    <span class="pulse-dot offline"></span>
                    <span>الاتصال بقاعدة البيانات غير نشط</span>
                @endif
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(!$dbStatus['connected'])
        <div class="alert-bar">
            <strong>خطأ في قاعدة البيانات:</strong> {{ $dbStatus['error'] }}
            <br>
            <small>يرجى التأكد من ضبط متغيرات Neon PostgreSQL في Vercel (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSLMODE=require`).</small>
        </div>
    @endif

    <!-- إحصائيات النظام -->
    <div class="grid-stats">
        <div class="card-stat">
            <div class="title">إجمالي عناصر لوحة التحكم</div>
            <div class="value">{{ $stats['total'] }}</div>
            <div class="subtext">وحدات ومهام مسجلة</div>
        </div>
        <div class="card-stat">
            <div class="title">الأنظمة التشغيلية</div>
            <div class="value" style="color: #34d399;">{{ $stats['operational'] }}</div>
            <div class="subtext">خدمات سحابية قيد العمل</div>
        </div>
        <div class="card-stat">
            <div class="title">المهام المكتملة</div>
            <div class="value" style="color: #60a5fa;">{{ $stats['completed'] }}</div>
            <div class="subtext">متطلبات منجزة</div>
        </div>
        <div class="card-stat">
            <div class="title">كفاءة النظام الإجمالية</div>
            <div class="value" style="color: #a5b4fc;">{{ $stats['health_score'] }}%</div>
            <div class="subtext">مؤشر الجاهزية التشغيلية</div>
        </div>
    </div>

    <!-- نموذج إضافة عنصر جديد -->
    <div class="form-card">
        <h3 class="section-title" style="margin-bottom: 1.1rem; font-size: 1.15rem;">إضافة وحدة أو مهمة جديدة</h3>
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>اسم الوحدة / المهمة</label>
                    <input type="text" name="title" class="form-control" placeholder="مثال: نظام إدارة الجلسات" required>
                </div>
                <div class="form-group">
                    <label>التصنيف / القسم</label>
                    <input type="text" name="category" class="form-control" placeholder="مثال: البنية التحتية" required>
                </div>
                <div class="form-group">
                    <label>الحالة التشغيلية</label>
                    <select name="status" class="form-control" required>
                        <option value="Operational">تشغيلي (Operational)</option>
                        <option value="Completed">مكتمل (Completed)</option>
                        <option value="In Progress">قيد التنفيذ (In Progress)</option>
                        <option value="Pending">قيد الانتظار (Pending)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>نسبة الأداء / الكفاءة (%)</label>
                    <input type="number" name="metric_value" class="form-control" value="100" min="0" max="100">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label>الوصف والتفاصيل</label>
                <input type="text" name="description" class="form-control" placeholder="ملخص تقني أو ملاحظات تشغيلية">
            </div>
            <button type="submit" class="btn">+ إضافة المهمة</button>
        </form>
    </div>

    <!-- جدول البيانات -->
    <div class="section-header">
        <h2 class="section-title">معايير النظام وعناصر لوحة التحكم</h2>
        <span style="font-size: 0.88rem; color: var(--text-muted);">استعلامات فورية مدعومة بقاعدة بيانات Neon Cloud PostgreSQL</span>
    </div>

    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>المعرّف</th>
                    <th>العنوان والوصف</th>
                    <th>التصنيف</th>
                    <th>الأداء</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>#{{ $item->id }}</td>
                        <td>
                            <strong>{{ $item->title }}</strong>
                            @if($item->description)
                                <div style="font-size: 0.82rem; color: var(--text-muted); margin-top: 2px;">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td><span style="background: rgba(255,255,255,0.06); padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.82rem;">{{ $item->category }}</span></td>
                        <td><strong>{{ $item->metric_value }}%</strong></td>
                        <td>
                            @php
                                $statusClass = match(strtolower($item->status)) {
                                    'operational' => 'pill-operational',
                                    'completed' => 'pill-completed',
                                    'in progress' => 'pill-in-progress',
                                    default => 'pill-pending',
                                };
                                $statusText = match(strtolower($item->status)) {
                                    'operational' => 'تشغيلي',
                                    'completed' => 'مكتمل',
                                    'in progress' => 'قيد التنفيذ',
                                    default => 'قيد الانتظار',
                                };
                            @endphp
                            <span class="pill {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <form action="{{ route('items.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $item->status === 'Operational' ? 'Completed' : 'Operational' }}">
                                    <button type="submit" class="btn btn-secondary btn-sm">تغيير الحالة</button>
                                </form>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من حذف العنصر رقم #{{ $item->id }}؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                            لا توجد عناصر في قاعدة البيانات حالياً. قم بملء النموذج أهلاه أو تشغيل التغذية الأولية.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <footer>
        <p>واجب جامعي • تطبيق مدمج ومستضاف على <strong>Vercel Free Tier</strong> • متصل بقاعدة بيانات <strong>Neon Cloud PostgreSQL</strong></p>
    </footer>
</div>

</body>
</html>
