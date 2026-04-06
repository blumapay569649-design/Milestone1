

<?php $__env->startSection('content'); ?>
    <h1>Create Warehouse</h1>

    <form method="POST" action="<?php echo e(route('warehouses.store')); ?>">
        <?php echo csrf_field(); ?>
        <label for="name">Warehouse Name</label>
        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4"><?php echo e(old('description')); ?></textarea>

        <button type="submit">Create Warehouse</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/warehouses/create.blade.php ENDPATH**/ ?>