

<?php $__env->startSection('content'); ?>
    <h1><?php echo e($item->name); ?></h1>

    <p><strong>Warehouse:</strong> <?php echo e($warehouse->name); ?></p>
    <p><strong>Quantity:</strong> <?php echo e($item->qty); ?></p>
    <p><strong>Price:</strong> $<?php echo e(number_format($item->price, 2)); ?></p>
    <p><strong>Total Price:</strong> $<?php echo e(number_format($item->total_price, 2)); ?></p>

    <?php if($item->image_path): ?>
        <p><strong>Image:</strong></p>
        <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>" style="max-width: 300px;">
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="<?php echo e(route('warehouses.items.edit', [$warehouse, $item])); ?>">Edit Item</a>
        <form method="POST" action="<?php echo e(route('warehouses.items.destroy', [$warehouse, $item])); ?>" style="display:inline; margin-left:10px;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" onclick="return confirm('Are you sure?')">Delete Item</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/items/show.blade.php ENDPATH**/ ?>