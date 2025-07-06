export function setCSRFToken() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
}

export function listarProductos(pagina, orden, onSuccess) {
  $.get(`/productos/list?page=${pagina}&orden=${orden}`, onSuccess);
}

export function guardarProducto(formData, id, onSuccess, onError) {
  const url = id ? `/productos/update/${id}` : '/productos/store';

  $.ajax({
    url,
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: onSuccess,
    error: onError
  });
}

export function obtenerProducto(id, callback) {
  $.get(`/productos/${id}`, callback);
}

export function eliminarProducto(id, callback) {
  $.ajax({
    url: `/productos/delete/${id}`,
    method: 'DELETE',
    success: callback
  });
}
