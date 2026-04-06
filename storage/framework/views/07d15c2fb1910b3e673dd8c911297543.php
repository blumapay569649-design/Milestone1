

<?php $__env->startSection('content'); ?>
    <h1>Edit Item in <?php echo e($warehouse->name); ?></h1>

    <form method="POST" action="<?php echo e(route('warehouses.items.update', [$warehouse, $item])); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <label for="name">Item Name</label>
        <input type="text" name="name" id="name" value="<?php echo e($item->name); ?>" required>

        <label for="qty">Quantity</label>
        <input type="number" name="qty" id="qty" min="1" value="<?php echo e($item->qty); ?>" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" min="0" value="<?php echo e($item->price); ?>" required>

        <label for="image">Image (optional, max 50MB)</label>
        <input type="file" name="image" id="image" accept="image/*">

        <div id="image-preview" style="margin-top:12px;">
            <?php if($item->image_path): ?>
                <p>Current image preview:</p>
                <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>" style="max-width: 200px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <?php endif; ?>
        </div>

        <button type="submit">Update Item</button>
    </form>

    <script>
        const imageInput = document.getElementById('image');
        const preview = document.getElementById('image-preview');

        if (imageInput) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    preview.innerHTML = '<p>Selected image preview:</p><img src="' + event.target.result + '" alt="Preview" style="max-width: 200px; border-radius: 12px; border: 1px solid #e5e7eb;">';
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_milestone1\resources\views/items/edit.blade.php ENDPATH**/ ?>