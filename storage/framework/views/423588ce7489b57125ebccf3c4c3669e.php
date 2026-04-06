

<?php $__env->startSection('content'); ?>
    <h1>Invitations</h1>

    <?php if($invitations->isEmpty()): ?>
        <p>No pending invitations.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Warehouse</th>
                    <th>Invited By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invitation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($invitation->warehouse->name); ?></td>
                        <td><?php echo e($invitation->inviter->name); ?></td>
                        <td>
                            <form method="POST" action="<?php echo e(route('invitations.accept', $invitation)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit">Accept</button>
                            </form>
                            <form method="POST" action="<?php echo e(route('invitations.decline', $invitation)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit">Decline</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/invitations/index.blade.php ENDPATH**/ ?>