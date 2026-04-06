

<?php $__env->startSection('content'); ?>
    <h1>Create Item in <?php echo e($warehouse->name); ?></h1>

    <form method="POST" action="<?php echo e(route('warehouses.items.store', $warehouse)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <label for="name">Item Name</label>
        <input type="text" name="name" id="name" required>

        <label for="qty">Quantity</label>
        <input type="number" name="qty" id="qty" min="1" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>

        <label for="image">Image (optional, max 50MB)</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Create Item</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/items/create.blade.php ENDPATH**/ ?>