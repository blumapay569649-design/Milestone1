

<?php $__env->startSection('content'); ?>
    <h1>Items in <?php echo e($warehouse->name); ?></h1>

    <p><a href="<?php echo e(route('warehouses.show', $warehouse)); ?>">Back to Warehouse</a></p>

    <?php if($warehouse->isOwnedBy(auth()->user()) || $warehouse->hasMember(auth()->user())): ?>
        <p><a href="<?php echo e(route('warehouses.items.create', $warehouse)); ?>">Add New Item</a></p>
    <?php endif; ?>

    <?php if($items->isEmpty()): ?>
        <p>No items in this warehouse.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->name); ?></td>
                        <td><?php echo e($item->qty); ?></td>
                        <td>$<?php echo e(number_format($item->price, 2)); ?></td>
                        <td>$<?php echo e(number_format($item->total_price, 2)); ?></td>
                        <td style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                            <button type="button" class="button-secondary" onclick="toggleImage(<?php echo e($item->id); ?>)">View Image</button>
                            <?php if($warehouse->isOwnedBy(auth()->user()) || $warehouse->hasMember(auth()->user())): ?>
                                <a href="<?php echo e(route('warehouses.items.edit', [$warehouse, $item])); ?>" class="button-secondary">Edit</a>
                                <form method="POST" action="<?php echo e(route('warehouses.items.destroy', [$warehouse, $item])); ?>" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="button-alert" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr id="item-image-<?php echo e($item->id); ?>" class="hidden" style="background:#f9fafb;">
                        <td colspan="5" style="padding:16px;">
                            <?php if($item->image_path): ?>
                                <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                                    <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>" style="max-width: 180px; max-height: 180px; border-radius:12px; border:1px solid #e5e7eb;">
                                    <div>
                                        <p><strong><?php echo e($item->name); ?></strong></p>
                                        <p>Quantity: <?php echo e($item->qty); ?></p>
                                        <p>Price: $<?php echo e(number_format($item->price, 2)); ?></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p>No image attached for this item.</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

    <script>
        function toggleImage(itemId) {
            document.querySelectorAll('[id^="item-image-"]').forEach(row => {
                if (row.id === 'item-image-' + itemId) {
                    row.classList.toggle('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/items/index.blade.php ENDPATH**/ ?>