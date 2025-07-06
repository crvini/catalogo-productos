export function renderTabla(data) {
  const rows = data.map(p => `
    <tr>
      <td>${p.codigo}</td>
      <td>${p.nombre}</td>
      <td>${p.cantidad}</td>
      <td>${p.precio}</td>
      <td>${p.fecha_ingreso}</td>
      <td>${p.fecha_vencimiento}</td>
      <td>${p.foto ? `<img src="${p.foto.replace('public/', '')}" width="60">` : ''}</td>
      <td>
        <button class="btn btn-warning btnEditar" data-id="${p.id}">Editar</button>
        <button class="btn btn-danger btnEliminar" data-id="${p.id}">Eliminar</button>
      </td>
    </tr>
  `).join('');

  $('#tablaProductos tbody').html(rows);
}

export function resetFormulario() {
  $('#formProducto')[0].reset();
  $('#formProducto input[name=id]').val('');
}

export function llenarFormulario(producto) {
  for (const key in producto) {
    if (key === 'foto') continue;

    const input = $(`#formProducto [name="${key}"]`);
    if (input.length) input.val(producto[key]);
  }
  $('#formProducto input[name=id]').val(producto.id);
}

