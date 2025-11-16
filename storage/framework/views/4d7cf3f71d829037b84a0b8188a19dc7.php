<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildSchema()); ?>

</div>
<?php /**PATH D:\workspace\Projet1-main-main\Projet1-main-main\vendor\filament\schemas\resources\views/components/grid.blade.php ENDPATH**/ ?>