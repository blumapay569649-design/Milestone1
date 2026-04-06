

<?php $__env->startSection('content'); ?>
    <h1>Warehouses</h1>

    <p><a href="<?php echo e(route('warehouses.create')); ?>">Create a new warehouse</a></p>

    <h2>Your Owned Warehouses</h2>
    <?php if($ownedWarehouses->isEmpty()): ?>
        <p>No warehouses created yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Members</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ownedWarehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($warehouse->name); ?></td>
                        <td><?php echo e($warehouse->description); ?></td>
                        <td><?php echo e($warehouse->members_count); ?></td>
                        <td><?php echo e($warehouse->created_at->format('M d, Y')); ?></td>
                        <td><a href="<?php echo e(route('warehouses.show', $warehouse)); ?>">View</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Warehouses Shared With You (STAFF)</h2>
    <?php if($sharedWarehouses->isEmpty()): ?>
        <p>No shared warehouses yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Owner</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $sharedWarehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($warehouse->name); ?> <strong>(STAFF)</strong></td>
                        <td><?php echo e($warehouse->description); ?></td>
                        <td><?php echo e($warehouse->owner->name); ?></td>
                        <td><?php echo e($warehouse->members_count); ?></td>
                        <td><a href="<?php echo e(route('warehouses.show', $warehouse)); ?>">View</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/warehouses/index.blade.php ENDPATH**/ ?>