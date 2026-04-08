

<?php $__env->startSection('content'); ?>
    <h1>Register</h1>
    <form action="<?php echo e(route('register')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required>

        <label for="birthdate">Birthdate</label>
        <input type="date" name="birthdate" id="birthdate" value="<?php echo e(old('birthdate')); ?>" required>

        <input type="hidden" name="role" value="user">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="<?php echo e(route('login')); ?>">Login</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/auth/register.blade.php ENDPATH**/ ?>