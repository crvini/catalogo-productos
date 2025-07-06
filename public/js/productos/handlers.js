import {
  listarProductos,
  guardarProducto,
  obtenerProducto,
  eliminarProducto
} from './api.js';

import {
  renderTabla,
  resetFormulario,
  llenarFormulario
} from './ui.js';

import {
  validarFormulario,
  limpiarErrores
} from './validators.js';

export function setupHandlers() {
  const modalElement = document.getElementById('modalProducto');
  const modal = new bootstrap.Modal(modalElement);
  let paginaActual = 1;
  let orden = 'asc';

  function cargarYMostrarProductos() {
    listarProductos(paginaActual, orden, res => {
      renderTabla(res.data);
    });
  }

  $('#btnAgregar').on('click', () => {
    resetFormulario();
    modal.show();
  });

  $('#formProducto').off('submit').on('submit', function (e) {
    e.preventDefault();
    const form = this;
    limpiarErrores(form);

    const formData = new FormData(form);
    const id = formData.get('id');

    if (!validarFormulario(form)) return;

    guardarProducto(formData, id,
      () => {
        modal.hide();
        cargarYMostrarProductos();
      },
      (jqXHR) => {
        const msg = jqXHR.responseJSON?.message || 'Error desconocido';
        alert(`Error al guardar: ${msg}`);
      }
    );
  });

  $('#tablaProductos').on('click', '.btnEditar', function () {
    const id = $(this).data('id');
    obtenerProducto(id, producto => {
      resetFormulario();
      llenarFormulario(producto);
      modal.show();
    });
  });

  $('#tablaProductos').on('click', '.btnEliminar', function () {
    const id = $(this).data('id');
    if (confirm('¿Eliminar producto?')) {
      eliminarProducto(id, cargarYMostrarProductos);
    }
  });

  cargarYMostrarProductos();
}
