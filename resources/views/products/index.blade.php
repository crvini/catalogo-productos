@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Catálogo de Productos</h2>
    <button id="btnAgregar" class="btn btn-primary mb-3">Agregar Producto</button>
    <table class="table table-bordered" id="tablaProductos">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th id="ordenarFechaIngreso" style="cursor:pointer">Fecha Ingreso ▲▼</th>
                <th>Fecha Vencimiento</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <nav>
        <ul class="pagination" id="paginacion"></ul>
    </nav>
</div>

<!-- Modal -->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    let paginaActual = 1;
    let ordenAsc = true;

    function cargarProductos(pagina = 1, orden = 'asc') {
        $.get(`/productos/list?page=${pagina}&orden=${orden}`, function (res) {
            const rows = res.data.map(p => `
                <tr>
                    <td>${p.codigo}</td>
                    <td>${p.nombre}</td>
                    <td>${p.cantidad}</td>
                    <td>${p.precio}</td>
                    <td>${p.fecha_ingreso}</td>
                    <td>${p.fecha_vencimiento}</td>
                    <td>${p.foto ? '<img src="/' + p.foto.replace('public/', '') + '" width="60">' : ''}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btnEditar" data-id="${p.id}">Editar</button>
                        <button class="btn btn-sm btn-danger btnEliminar" data-id="${p.id}">Eliminar</button>
                    </td>
                </tr>
            `);
            $('#tablaProductos tbody').html(rows.join(''));
            let paginacionHTML = '';
            for (let i = 1; i <= res.last_page; i++) {
                paginacionHTML += `<li class="page-item ${i === res.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            }
            $('#paginacion').html(paginacionHTML);
        });
    }

    $(document).on('click', '#ordenarFechaIngreso', function () {
        ordenAsc = !ordenAsc;
        cargarProductos(paginaActual, ordenAsc ? 'asc' : 'desc');
    });

    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        paginaActual = parseInt($(this).data('page'));
        cargarProductos(paginaActual, ordenAsc ? 'asc' : 'desc');
    });

    $('#btnAgregar').on('click', function () {
        $('#formProducto')[0].reset();
        $('#formProducto').removeData('edit-id');
        modal.show();
    });

    function validarFormulario(formData) {
        const codigo = formData.get('codigo');
        const nombre = formData.get('nombre');
        const fechaIngreso = new Date(formData.get('fecha_ingreso'));
        const fechaVenc = new Date(formData.get('fecha_vencimiento'));
        const foto = formData.get('foto');

        if (!/^[a-zA-Z0-9]+$/.test(codigo)) {
            alert('El código solo debe contener letras y números.');
            return false;
        }
        if (!/^[\p{L}\s]+$/u.test(nombre)) {
            alert('El nombre solo debe contener letras.');
            return false;
        }
        if (fechaIngreso > fechaVenc) {
            alert('La fecha de ingreso no debe ser mayor que la de vencimiento.');
            return false;
        }
        if (foto && foto.size > 1536 * 1024) {
            alert('La imagen no debe pesar más de 1.5MB.');
            return false;
        }
        if (foto && !['image/jpeg','image/png','image/gif','image/jpg'].includes(foto.type)) {
            alert('Formato de imagen no permitido.');
            return false;
        }
        return true;
    }

    $('#formProducto').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = $('#formProducto').data('edit-id');
        const url = id ? `/productos/update/${id}` : '/productos/store';
        formData.append('_token', '{{ csrf_token() }}');

        if (!validarFormulario(formData)) return;

        $.ajax({
            url,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                modal.hide();
                cargarProductos();
                $('#formProducto').removeData('edit-id');
            },
            error: function (xhr) {
                alert('Error al guardar: ' + xhr.responseText);
            }
        });
    });

    $(document).on('click', '.btnEditar', function () {
        const id = $(this).data('id');
        $.get(`/productos/${id}`, function (data) {
            $('#formProducto')[0].reset();
            for (let campo in data) {
                if (campo !== 'foto') {
                    $(`[name="${campo}"]`).val(data[campo]);
                }
            }
            $('#formProducto').data('edit-id', id);
            modal.show();
        });
    });

    $(document).on('click', '.btnEliminar', function () {
        if (confirm('¿Seguro que deseas eliminar este producto?')) {
            const id = $(this).data('id');
            $.ajax({
                url: `/productos/delete/${id}`,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function () {
                    cargarProductos();
                }
            });
        }
    });

    cargarProductos();
    const hoy = new Date();
const inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
const minFecha = inicioMes.toISOString().split('T')[0];

$('input[name="fecha_ingreso"]').attr('min', minFecha);
$('input[name="fecha_vencimiento"]').attr('min', minFecha);

});
</script>
@endsection
