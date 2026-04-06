

<?php $__env->startSection('content'); ?>
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:24px; flex-wrap:wrap; margin-bottom:24px;">
        <div>
            <h1><?php echo e($warehouse->name); ?></h1>
            <p><?php echo e($warehouse->description); ?></p>
            <p><strong>Owner:</strong> <?php echo e($warehouse->owner->name); ?></p>
        </div>
    </div>

    <div class="toolbar">
        <button type="button" onclick="showSection('inventory')" class="button-pill">Inventory</button>
        <button type="button" onclick="showSection('management')" class="button-pill">Management</button>
        <button type="button" onclick="toggleDropdown('others-menu')" class="button-pill">Others ▾</button>
    </div>

    <div id="others-menu" class="drawer hidden">
        <?php if($warehouse->isOwnedBy($user)): ?>
            <button type="button" onclick="toggleDrawer('invite-drawer')">Invite</button>
            <button type="button" onclick="toggleDrawer('transfer-drawer')">Transfer Ownership</button>
            <button type="button" onclick="toggleDrawer('delete-drawer')">Delete Warehouse</button>
        <?php else: ?>
            <button type="button" onclick="toggleDrawer('leave-drawer')">Leave Warehouse</button>
        <?php endif; ?>
    </div>

    <div id="inventory" class="section-tab active">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:16px;">
            <h2>Inventory</h2>
            <?php if($user->canAccessWarehouse($warehouse)): ?>
                <a href="<?php echo e(route('warehouses.items.create', $warehouse)); ?>" class="button-pill">Add Item</a>
            <?php endif; ?>
        </div>

        <?php if($warehouse->items->isEmpty()): ?>
            <p>No items yet. Use the Add Item button to create inventory.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $warehouse->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->qty); ?></td>
                            <td>$<?php echo e(number_format($item->price, 2)); ?></td>
                            <td>$<?php echo e(number_format($item->total_price, 2)); ?></td>
                            <td>
                                <?php if($item->image_path): ?>
                                    <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>" style="max-width:60px; max-height:60px; border-radius:8px;">
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td style="display:flex; justify-content:center; gap:8px; flex-wrap:wrap;">
                                <?php if($user->canAccessWarehouse($warehouse)): ?>
                                    <a href="<?php echo e(route('warehouses.items.edit', [$warehouse, $item])); ?>" class="button-secondary" style="padding:8px 12px;">Edit</a>
                                    <form method="POST" action="<?php echo e(route('warehouses.items.destroy', [$warehouse, $item])); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="button-alert" style="padding:8px 12px;" onclick="return confirm('Delete this item?')">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div id="management" class="section-tab">
        <h2>Members</h2>
        <ul>
            <?php $__currentLoopData = $warehouse->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($member->name); ?> (<?php echo e($member->email); ?>)</li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <h2 style="margin-top:24px;">Notifications</h2>
        <?php if($warehouse->comments->isEmpty()): ?>
            <p>No notifications yet.</p>
        <?php else: ?>
            <ul>
                <?php $__currentLoopData = $warehouse->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><strong><?php echo e($comment->user->name); ?>:</strong> <?php echo e($comment->comment); ?> <small>(<?php echo e($comment->created_at->diffForHumans()); ?>)</small></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>

        <div style="margin-top:24px;">
            <h2>Add Comment</h2>
            <form method="POST" action="<?php echo e(route('warehouses.comments.store', $warehouse)); ?>">
                <?php echo csrf_field(); ?>
                <textarea name="comment" rows="3" required></textarea>
                <button type="submit" class="button-pill">Post Comment</button>
            </form>
        </div>
    </div>

    <div id="invite-drawer" class="drawer hidden">
        <h3>Invite Member</h3>
        <form method="POST" action="<?php echo e(route('warehouses.invite', $warehouse)); ?>">
            <?php echo csrf_field(); ?>
            <label for="email">User Email</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Send Invitation</button>
        </form>
    </div>

    <div id="transfer-drawer" class="drawer hidden">
        <h3>Transfer Ownership</h3>
        <form method="POST" action="<?php echo e(route('warehouses.transfer-ownership', $warehouse)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label for="new_owner_email">New owner email</label>
            <input type="email" name="new_owner_email" id="new_owner_email" required>
            <button type="submit">Transfer Ownership</button>
        </form>
    </div>

    <div id="delete-drawer" class="drawer hidden">
        <h3>Delete Warehouse</h3>
        <p>Are you sure you want to delete this warehouse? This action cannot be undone.</p>
        <form method="POST" action="<?php echo e(route('warehouses.destroy', $warehouse)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="button-alert">Delete Warehouse</button>
        </form>
    </div>

    <div id="leave-drawer" class="drawer hidden">
        <h3>Leave Warehouse</h3>
        <p>Do you want to leave this warehouse as staff?</p>
        <form method="POST" action="<?php echo e(route('warehouses.leave', $warehouse)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="button-alert">Leave Warehouse</button>
        </form>
    </div>

    <script>
        function showSection(section) {
            document.querySelectorAll('.section-tab').forEach(el => el.classList.remove('active'));
            document.getElementById(section).classList.add('active');
        }

        function toggleDropdown(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.toggle('hidden');
            document.querySelectorAll('.drawer').forEach(drawer => {
                if (drawer.id !== id) drawer.classList.add('hidden');
            });
        }

        function toggleDrawer(id) {
            document.querySelectorAll('.drawer').forEach(drawer => {
                if (drawer.id === id) {
                    drawer.classList.toggle('hidden');
                } else {
                    drawer.classList.add('hidden');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/warehouses/show.blade.php ENDPATH**/ ?>