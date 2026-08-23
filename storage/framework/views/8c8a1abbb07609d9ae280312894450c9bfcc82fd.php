<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Laravel Dashboard | Cloud Neon PostgreSQL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .pulse-dot.online {
            background: var(--accent-green);
            box-shadow: 0 0 10px var(--accent-green);
        }

        .pulse-dot.offline {
            background: var(--accent-red);
            box-shadow: 0 0 10px var(--accent-red);
        }

        .alert-bar {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
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
            border-color: rgba(99, 102, 241, 0.3);
        }

        .card-stat .title {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .card-stat .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .card-stat .subtext {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
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
            text-align: left;
        }

        th {
            background: rgba(15, 23, 42, 0.6);
            padding: 1rem 1.25rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
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
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pill-operational { background: rgba(16, 185, 129, 0.15); color: #34d399; }
        .pill-completed { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
        .pill-in-progress { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
        .pill-pending { background: rgba(148, 163, 184, 0.15); color: #cbd5e1; }

        .form-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-group label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 0.6rem 0.8rem;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        footer {
            margin-top: 3rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <div class="brand">
            <h1>University Laravel Dashboard</h1>
            <p>Cloud Serverless Application • Neon PostgreSQL Managed Database</p>
        </div>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="/db-check" target="_blank" class="btn btn-secondary btn-sm">
                🔍 API Diagnostics (/db-check)
            </a>
            <div class="badge-status">
                <?php if($dbStatus['connected']): ?>
                    <span class="pulse-dot online"></span>
                    <span>Neon PostgreSQL Connected</span>
                <?php else: ?>
                    <span class="pulse-dot offline"></span>
                    <span>DB Connection Disconnected</span>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <?php if(session('success')): ?>
        <div class="alert-success">
            ✓ <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(!$dbStatus['connected']): ?>
        <div class="alert-bar">
            <strong>Database Error:</strong> <?php echo e($dbStatus['error']); ?>

            <br>
            <small>Please ensure Neon PostgreSQL credentials are set in <code>.env</code> (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSLMODE=require`).</small>
        </div>
    <?php endif; ?>

    <!-- STATS OVERVIEW -->
    <div class="grid-stats">
        <div class="card-stat">
            <div class="title">Total Dashboard Items</div>
            <div class="value"><?php echo e($stats['total']); ?></div>
            <div class="subtext">Registered metrics & modules</div>
        </div>
        <div class="card-stat">
            <div class="title">Operational Systems</div>
            <div class="value" style="color: #34d399;"><?php echo e($stats['operational']); ?></div>
            <div class="subtext">Live cloud services</div>
        </div>
        <div class="card-stat">
            <div class="title">Completed Tasks</div>
            <div class="value" style="color: #60a5fa;"><?php echo e($stats['completed']); ?></div>
            <div class="subtext">Finished assignments</div>
        </div>
        <div class="card-stat">
            <div class="title">System Health</div>
            <div class="value" style="color: #a5b4fc;"><?php echo e($stats['health_score']); ?>%</div>
            <div class="subtext">Overall operational status</div>
        </div>
    </div>

    <!-- NEW ITEM FORM -->
    <div class="form-card">
        <h3 class="section-title" style="margin-bottom: 1rem; font-size: 1.1rem;">Add Dashboard Module / Task</h3>
        <form action="<?php echo e(route('items.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-grid">
                <div class="form-group">
                    <label>Module / Task Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Storage Queue Worker" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control" placeholder="e.g. Infrastructure" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Operational">Operational</option>
                        <option value="Completed">Completed</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Metric Value (%)</label>
                    <input type="number" name="metric_value" class="form-control" value="100" min="0" max="100">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Description</label>
                <input type="text" name="description" class="form-control" placeholder="Brief technical summary or operational note">
            </div>
            <button type="submit" class="btn">+ Create Item</button>
        </form>
    </div>

    <!-- DATA TABLE -->
    <div class="section-header">
        <h2 class="section-title">System Metrics & Dashboard Items</h2>
        <span style="font-size: 0.85rem; color: var(--text-muted);">Real-time queries powered by Neon PostgreSQL</span>
    </div>

    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title & Description</th>
                    <th>Category</th>
                    <th>Metric</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>#<?php echo e($item->id); ?></td>
                        <td>
                            <strong><?php echo e($item->title); ?></strong>
                            <?php if($item->description): ?>
                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;"><?php echo e($item->description); ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span style="background: rgba(255,255,255,0.05); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;"><?php echo e($item->category); ?></span></td>
                        <td><strong><?php echo e($item->metric_value); ?>%</strong></td>
                        <td>
                            <?php
                                $statusClass = match(strtolower($item->status)) {
                                    'operational' => 'pill-operational',
                                    'completed' => 'pill-completed',
                                    'in progress' => 'pill-in-progress',
                                    default => 'pill-pending',
                                };
                            ?>
                            <span class="pill <?php echo e($statusClass); ?>"><?php echo e($item->status); ?></span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <form action="<?php echo e(route('items.update', $item->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <input type="hidden" name="status" value="<?php echo e($item->status === 'Operational' ? 'Completed' : 'Operational'); ?>">
                                    <button type="submit" class="btn btn-secondary btn-sm">Toggle Status</button>
                                </form>
                                <form action="<?php echo e(route('items.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Delete item #<?php echo e($item->id); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                            No items found in database. Add a new module or run database seed.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>University Project Assignment • Deployed on <strong>Vercel Free Tier</strong> • Connected to <strong>Neon Cloud PostgreSQL</strong></p>
    </footer>
</div>

</body>
</html>
<?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\HAMDAN\resources\views\dashboard.blade.php ENDPATH**/ ?>