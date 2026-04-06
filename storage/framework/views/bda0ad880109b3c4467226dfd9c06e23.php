<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Inventory Management')); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f3f4f6; color: #111827; min-height: 100vh; }
        .layout { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
        .sidebar { background: #111827; color: white; display: flex; flex-direction: column; padding: 24px; gap: 16px; }
        .sidebar .brand { font-size: 1.25rem; font-weight: 700; margin-bottom: 16px; }
        .sidebar .user-id { font-size: 0.875rem; opacity: 0.75; margin-bottom: 16px; }
        .sidebar .section-title { margin-top: 24px; font-size: 0.75rem; text-transform: uppercase; opacity: .75; letter-spacing: .08em; }
        .sidebar a, .sidebar button { display: block; color: white; text-decoration: none; margin-bottom: 8px; padding: 14px 16px; border-radius: 8px; border: none; text-align: left; background: transparent; width: 100%; box-sizing: border-box; cursor: pointer; }
        .sidebar a:hover, .sidebar button:hover { background: rgba(255,255,255,.08); }
        .sidebar a.active { background: rgba(37, 99, 235, 0.22); font-weight: 600; }
        .sidebar .logout-btn { background: #dc2626; color: white; margin-top: auto; }
        .main { padding: 24px; min-width: 0; }
        .panel { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08); overflow-x: auto; }
        form input, form select, form button, form textarea { width: 100%; margin-top: 8px; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font: inherit; box-sizing: border-box; }
        form button { background: #2563eb; color: white; border: none; cursor: pointer; }
        .grid { display: grid; gap: 16px; }
        .notice { padding: 16px; border-radius: 12px; background: #ecfdf5; color: #166534; margin-bottom: 16px; }
        .error { padding: 16px; border-radius: 12px; background: #fee2e2; color: #b91c1c; margin-bottom: 16px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 14px 12px; border-bottom: 1px solid #e5e7eb; text-align: center; }
        .button-secondary { background: #4b5563; color: white; border-radius: 20%; min-height: 10px; margin-top: 2.5%;}
        .button-alert { background: #dc2626; color: white; }
        .button-pill { padding: 10px 16px; border-radius: 999px; background: #2563eb; color: white; display: inline-block; border: none; cursor: pointer; }
        .toolbar { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
        .toolbar button { min-width: 140px; }
        .drawer { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px; margin-top: 16px; }
        .drawer button { width: 100%; max-width: 240px; margin: 0 auto 12px; padding: 10px 14px; border-radius: 10px; border: none; background: #2563eb; color: white; cursor: pointer; display: block; text-align: center; }
        .drawer button:hover { background: #1d4ed8; }
        .hidden { display: none; }
        .drawer.hidden { display: none; }
        .section-tab { display: none; }
        .section-tab.active { display: block; }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Warehouse System Cooperative</div>
            <?php if(auth()->check()): ?>
                <div class="user-id">User ID: <?php echo e(auth()->id()); ?></div>
            <?php endif; ?>
            <?php if(auth()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">Dashboard</a>
                <?php if (! (auth()->user()->isAdmin())): ?>
                    <a href="<?php echo e(route('warehouses.index')); ?>" class="<?php echo e(request()->routeIs('warehouses.*') ? 'active' : ''); ?>">Warehouses</a>
                    <a href="<?php echo e(route('invitations.index')); ?>" class="<?php echo e(request()->routeIs('invitations.*') ? 'active' : ''); ?>">Invitations</a>
                <?php endif; ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.users')); ?>" class="<?php echo e(request()->routeIs('admin.*') ? 'active' : ''); ?>">User Management</a>
                <?php endif; ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="<?php echo e(request()->routeIs('login') ? 'active' : ''); ?>">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="<?php echo e(request()->routeIs('register') ? 'active' : ''); ?>">Register</a>
            <?php endif; ?>
        </aside>

        <main class="main">
            <?php if(session('status')): ?>
                <div class="notice"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="error">
                    <ul style="margin:0; padding-left:18px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="panel">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/layouts/app.blade.php ENDPATH**/ ?>