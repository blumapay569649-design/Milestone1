

<?php $__env->startSection('content'); ?>
    <h1>Categories</h1>

    <p><a href="<?php echo e(route('categories.create')); ?>">Add New Category</a></p>

    <?php if($categories->isEmpty()): ?>
        <p>No categories found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($category->name); ?></td>
                        <td><?php echo e($category->description ?: 'N/A'); ?></td>
                        <td><?php echo e($category->products_count); ?></td>
                        <td>
                            <a href="<?php echo e(route('categories.edit', $category)); ?>">Edit</a>
                            <form method="POST" action="<?php echo e(route('categories.destroy', $category)); ?>" style="display:inline; margin-left:10px;">
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/categories/index.blade.php ENDPATH**/ ?>