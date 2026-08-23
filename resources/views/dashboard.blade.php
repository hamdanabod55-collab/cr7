<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الجامعية | Laravel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #1e293b;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* الهيدر */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .title-area h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #0f172a;
        }

        .title-area p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .db-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.9rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .db-badge.online {
            background: #dcfce7;
            color: #15803d;
        }

        .db-badge.offline {
            background: #fee2e2;
            color: #b91c1c;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot.online { background: #22c55e; }
        .dot.offline { background: #ef4444; }

        /* الكروت البسيطة */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #ffffff;
            padding: 1.25rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .stat-card .label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .stat-card .number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* التنبيهات */
        .alert-success {
            background: #dcfce7;
            color: #15803d;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* النموذج */
        .card-form {
            background: #ffffff;
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .card-form h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .form-input, .form-select {
            flex: 1;
            min-width: 180px;
            padding: 0.55rem 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.88rem;
            outline: none;
        }

        .form-input:focus, .form-select:focus {
            border-color: #2563eb;
        }

        .btn-add {
            background: #2563eb;
            color: white;
            padding: 0.55rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-add:hover {
            background: #1d4ed8;
        }

        /* الجدول */
        .table-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        th {
            background: #f1f5f9;
            padding: 0.85rem 1.25rem;
            font-size: 0.82rem;
            color: #475569;
            font-weight: 700;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 0.9rem 1.25rem;
            font-size: 0.88rem;
            border-bottom: 1px solid #f1f5f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-op { background: #dcfce7; color: #166534; }
        .badge-done { background: #dbeafe; color: #1e40af; }
        .badge-pend { background: #fef3c7; color: #92400e; }

        .btn-sm {
            padding: 0.3rem 0.65rem;
            font-size: 0.78rem;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            cursor: pointer;
        }

        .btn-sm:hover { background: #f8fafc; }

        .btn-del {
            color: #dc2626;
            border-color: #fca5a5;
            background: #fef2f2;
        }

        .btn-del:hover { background: #fee2e2; }

        footer {
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- الهيدر -->
    <header>
        <div class="title-area">
            <h1>لوحة التحكم الجامعية</h1>
            <p>تطبيق Laravel بسيط • Neon Cloud PostgreSQL</p>
        </div>
        <div>
            @if($dbStatus['connected'])
                <span class="db-badge online">
                    <span class="dot online"></span>
                    @if($dbStatus['is_fallback'] ?? false)
                        متصل بقاعدة البيانات السحابية (Vercel SQLite)
                    @elseif(str_contains(strtolower($dbStatus['host']), 'render.com'))
                        متصل بقاعدة بيانات PostgreSQL (Render Cloud)
                    @else
                        متصل بقاعدة بيانات Cloud PostgreSQL
                    @endif
                </span>
            @else
                <span class="db-badge offline">
                    <span class="dot offline"></span>
                    غير متصل بقاعدة البيانات
                </span>
            @endif
        </div>
    </header>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- الكروت الإحصائية البسيطة -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">إجمالي المهام</div>
            <div class="number">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">مكتملة</div>
            <div class="number" style="color: #2563eb;">{{ $stats['completed'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">تشغيلية / نشطة</div>
            <div class="number" style="color: #16a34a;">{{ $stats['operational'] }}</div>
        </div>
    </div>

    <!-- نموذج إضافة بسيط -->
    <div class="card-form">
        <h3>إضافة مهمة جديدة</h3>
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <input type="text" name="title" class="form-input" placeholder="اسم المهمة" required>
                <input type="text" name="category" class="form-input" placeholder="التصنيف (مثال: البرمجة)" required>
                <select name="status" class="form-select" required>
                    <option value="Operational">تشغيلي</option>
                    <option value="Completed">مكتمل</option>
                    <option value="Pending">قيد الانتظار</option>
                </select>
                <button type="submit" class="btn-add">+ إضافة</button>
            </div>
        </form>
    </div>

    <!-- جدول البيانات البسيط -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المهمة</th>
                    <th>التصنيف</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><strong>{{ $item->title }}</strong></td>
                        <td>{{ $item->category }}</td>
                        <td>
                            @php
                                $bClass = match(strtolower($item->status)) {
                                    'operational' => 'badge-op',
                                    'completed' => 'badge-done',
                                    default => 'badge-pend',
                                };
                                $bText = match(strtolower($item->status)) {
                                    'operational' => 'تشغيلي',
                                    'completed' => 'مكتمل',
                                    default => 'قيد الانتظار',
                                };
                            @endphp
                            <span class="badge {{ $bClass }}">{{ $bText }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.4rem;">
                                <form action="{{ route('items.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $item->status === 'Operational' ? 'Completed' : 'Operational' }}">
                                    <button type="submit" class="btn-sm">تغيير الحالة</button>
                                </form>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('حذف المهمة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-del">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94a3b8; padding: 1.5rem;">
                            لا توجد مهام حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <footer>
        <p>مشروع جامعي بسيط • Laravel & Neon PostgreSQL • Vercel Deployment</p>
    </footer>
</div>

</body>
</html>
