

<?php $__env->startSection('content'); ?>
    <h1>Login</h1>
    <form action="<?php echo e(route('login')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
            <input type="checkbox" name="remember" id="remember" style="width: 1rem; height: 1rem; cursor: pointer;">
            <label for="remember" style="margin: 0; cursor: pointer;">Remember me</label>
        </div>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="<?php echo e(route('register')); ?>">Register</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/auth/login.blade.php ENDPATH**/ ?>