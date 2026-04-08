

<?php $__env->startSection('content'); ?>
    <h1>User Management</h1>

    <form method="GET" action="<?php echo e(route('admin.users')); ?>" style="margin-bottom: 20px; display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
        <input type="text" name="search" value="<?php echo e(old('search', $search ?? '')); ?>" placeholder="Search user by ID or email" style="flex:1; min-width:220px; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px;" />
        <button type="submit" class="button-pill" style="margin:0;">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e(ucfirst($user->role)); ?></td>
                    <td><?php echo e($user->is_banned ? 'Banned' : 'Active'); ?></td>
                        <td style="display:flex; gap:8px; flex-wrap: wrap;">
                        <?php if($user->id !== auth()->id()): ?>
                            <form method="POST" action="<?php echo e(route('admin.users.ban', $user)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="is_banned" value="<?php echo e($user->is_banned ? 0 : 1); ?>">
                                <button type="submit" class="button-secondary"><?php echo e($user->is_banned ? 'Unban' : 'Ban'); ?></button>
                            </form>
                        <?php endif; ?>
                        <?php if(!$user->isAdmin()): ?>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="button-alert" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('admin.users.reset-password', $user)); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <input type="password" name="password" placeholder="New password" required style="width:auto; min-width:180px;">
                            <input type="password" name="password_confirmation" placeholder="Confirm password" required style="width:auto; min-width:180px; margin-top:8px;">
                            <button type="submit" class="button-secondary">Reset Password</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/admin/users.blade.php ENDPATH**/ ?>