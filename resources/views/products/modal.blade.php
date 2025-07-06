<div class="modal" id="modalProducto" tabindex="-1">
  <div class="modal-dialog">
    <form id="formProducto" enctype="multipart/form-data" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="mb-3"><label>Código</label><input type="text" name="codigo" class="form-control" required></div>
            <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="mb-3"><label>Cantidad</label><input type="number" name="cantidad" class="form-control" required></div>
            <div class="mb-3"><label>Precio</label><input type="number" step="0.01" name="precio" class="form-control" required></div>
            <div class="mb-3"><label>Fecha Ingreso</label><input type="date" name="fecha_ingreso" class="form-control" required></div>
            <div class="mb-3"><label>Fecha Vencimiento</label><input type="date" name="fecha_vencimiento" class="form-control" required></div>
            <div class="mb-3"><label>Fotografía</label><input type="file" name="foto" accept=".jpg,.jpeg,.png,.gif" class="form-control"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
