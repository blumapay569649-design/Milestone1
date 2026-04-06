

<?php $__env->startSection('content'); ?>
    <h1>Welcome, <?php echo e($user->name); ?></h1>

    <p><strong>Role:</strong> <?php echo e(ucfirst($user->role)); ?></p>
    <p><strong>Status:</strong> <?php echo e($user->is_banned ? 'Banned' : 'Active'); ?></p>

    <?php if($user->isAdmin()): ?>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top: 24px;">
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>User Management</h2>
                <p>Manage users, ban accounts, reset passwords, and delete users.</p>
                <a href="<?php echo e(route('admin.users')); ?>">Manage users</a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top: 24px;">
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>Create Warehouse</h2>
                <p>Create a new warehouse to manage your inventory.</p>
                <a href="<?php echo e(route('warehouses.create')); ?>">Create Warehouse</a>
            </div>
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>My Warehouses</h2>
                <p>View and manage your warehouses.</p>
                <a href="<?php echo e(route('warehouses.index')); ?>">View Warehouses</a>
            </div>
            <div style="background:#f3f4f6; padding:18px; border-radius:12px;">
                <h2>Invitations</h2>
                <p>Check pending warehouse invitations.</p>
                <a href="<?php echo e(route('invitations.index')); ?>">View Invitations</a>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/dashboard.blade.php ENDPATH**/ ?>