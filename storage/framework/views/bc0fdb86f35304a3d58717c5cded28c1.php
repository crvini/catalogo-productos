<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2>Catálogo de Productos</h2>
    <button id="btnAgregar" class="btn btn-primary mb-3">Agregar Producto</button>
    <div id="tablaProductosWrapper">
        <?php echo $__env->make('products.tabla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <nav><ul class="pagination" id="paginacion"></ul></nav>
</div>

<?php echo $__env->make('products.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script type="module" src="/js/productos/app.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/index.blade.php ENDPATH**/ ?>