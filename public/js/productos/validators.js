// validators.js

export function validarFormulario(form) {
  const formData = new FormData(form);
  const codigo = formData.get('codigo');
  const nombre = formData.get('nombre');
  const cantidad = formData.get('cantidad');
  const precio = formData.get('precio');
  const fechaIngreso = new Date(formData.get('fecha_ingreso'));
  const fechaVenc = new Date(formData.get('fecha_vencimiento'));
  const foto = formData.get('foto');
  const hoy = new Date();
  const inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);

  let valido = true;
  const errores = {};

  if (!/^[a-zA-Z0-9]+$/.test(codigo)) {
    errores.codigo = 'El código solo debe contener letras y números.';
    valido = false;
  }

  if (!/^[\p{L}\s]+$/u.test(nombre)) {
    errores.nombre = 'El nombre solo debe contener letras.';
    valido = false;
  }

  if (isNaN(cantidad) || cantidad < 1) {
    errores.cantidad = 'Cantidad inválida, debe ser mayor que cero.';
    valido = false;
  }

  if (isNaN(precio) || precio < 0) {
    errores.precio = 'Precio inválido, no puede ser negativo.';
    valido = false;
  }

  if (fechaIngreso < inicioMes) {
    errores.fecha_ingreso = 'La fecha de ingreso debe ser posterior al inicio del mes.';
    valido = false;
  }

  if (fechaVenc < inicioMes || fechaVenc < fechaIngreso) {
    errores.fecha_vencimiento = 'La fecha de vencimiento debe ser posterior a la de ingreso y al inicio del mes.';
    valido = false;
  }

  if (foto && foto.size > 1536 * 1024) {
    errores.foto = 'La imagen no debe pesar más de 1.5MB.';
    valido = false;
  }

  if (foto && !['image/jpeg','image/png','image/gif','image/jpg'].includes(foto.type)) {
    errores.foto = 'Formato de imagen no permitido.';
    valido = false;
  }

  mostrarErrores(form, errores);
  return valido;
}

export function mostrarErrores(form, errores) {
  for (const campo in errores) {
    const input = form.querySelector(`[name="${campo}"]`);
    if (input) {
      const errorEl = document.createElement('div');
      errorEl.className = 'text-danger small';
      errorEl.textContent = errores[campo];
      input.classList.add('is-invalid');
      input.parentNode.appendChild(errorEl);
    }
  }
}

export function limpiarErrores(form) {
  form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
  form.querySelectorAll('.text-danger').forEach(el => el.remove());
}
