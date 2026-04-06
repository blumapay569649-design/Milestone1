

<?php $__env->startSection('content'); ?>
    <h1>Suppliers</h1>

    <p><a href="<?php echo e(route('suppliers.create')); ?>">Add New Supplier</a></p>

    <?php if($suppliers->isEmpty()): ?>
        <p>No suppliers found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($supplier->name); ?></td>
                        <td><?php echo e($supplier->email ?: 'N/A'); ?></td>
                        <td><?php echo e($supplier->phone ?: 'N/A'); ?></td>
                        <td><?php echo e($supplier->products_count); ?></td>
                        <td>
                            <a href="<?php echo e(route('suppliers.edit', $supplier)); ?>">Edit</a>
                            <form method="POST" action="<?php echo e(route('suppliers.destroy', $supplier)); ?>" style="display:inline; margin-left:10px;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/suppliers/index.blade.php ENDPATH**/ ?>