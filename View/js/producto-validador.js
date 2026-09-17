document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.contenedor__form');
  if (!form) return;


  let tooltip = document.getElementById('tooltip-validacion');
  let textoTooltip = null;

  if (!tooltip) {
    tooltip = document.createElement('div');
    tooltip.id = 'tooltip-validacion';
    tooltip.style.cssText = `
      position: absolute;
      display: none;
      background-color: #ef4444;
      color: #ffffff;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 500;
      white-space: nowrap;
      z-index: 99999;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
      pointer-events: none;
      transition: opacity 0.15s ease;
    `;

    textoTooltip = document.createElement('span');
    textoTooltip.id = 'tooltip-texto';
    tooltip.appendChild(textoTooltip);

    const flecha = document.createElement('div');
    flecha.style.cssText = `
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-top: 5px solid #ef4444;
    `;
    tooltip.appendChild(flecha);
    document.body.appendChild(tooltip);
  } else {
    textoTooltip = document.getElementById('tooltip-texto');
  }


  const campos = {
    nombre: document.getElementById('nombre'),
    categoria: document.getElementById('categoria'),
    descripcion: document.getElementById('descripcion'),
    inventario: document.getElementById('inventario'),
    precio: document.getElementById('precio'),
    foto_texto: document.getElementById('foto_texto'),
    foto_archivo: document.getElementById('foto_archivo')
  };

  const ocultarTooltip = () => {
    tooltip.style.display = 'none';
  };


  const mostrarTooltip = (input, mensaje) => {
    if (!mensaje || !input) {
      ocultarTooltip();
      return;
    }

    textoTooltip.textContent = mensaje;
    tooltip.style.display = 'block';

    const rect = input.getBoundingClientRect();
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

    const top = rect.top + scrollTop - tooltip.offsetHeight - 6;
    const left = rect.left + scrollLeft + (rect.width / 2) - (tooltip.offsetWidth / 2);

    tooltip.style.top = `${Math.max(0, top)}px`;
    tooltip.style.left = `${Math.max(0, left)}px`;
  };

  const validarCampo = (input) => {
    if (!input) return true;
    const valor = input.value.trim();


    if (valor === '' && input.type !== 'file') {
      input.style.borderColor = '';
      ocultarTooltip();
      return true;
    }

    let esValido = true;
    let mensajeError = '';

    if (input === campos.nombre) {
      esValido = valor.length >= 3 && valor.length <= 100;
      if (!esValido) mensajeError = 'El nombre debe tener entre 3 y 100 caracteres';
    } else if (input === campos.categoria) {
      esValido = valor !== '';
      if (!esValido) mensajeError = 'Por favor selecciona una categoría';
    } else if (input === campos.descripcion) {
      esValido = valor.length >= 10;
      if (!esValido) mensajeError = 'La descripción debe tener al menos 10 caracteres';
    } else if (input === campos.inventario) {
      const num = Number(valor);
      esValido = Number.isInteger(num) && num >= 0;
      if (!esValido) mensajeError = 'Ingresa una cantidad entera válida (0 o mayor)';
    } else if (input === campos.precio) {
      const precioNum = parseFloat(valor);
      esValido = !isNaN(precioNum) && precioNum > 0;
      if (!esValido) mensajeError = 'El precio debe ser un número mayor a 0';
    } else if (input === campos.foto_archivo && input.files.length > 0) {
      const archivo = input.files[0];
      const extensionesValidas = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
      esValido = extensionesValidas.includes(archivo.type);
      if (!esValido) mensajeError = 'Solo se permiten imágenes (JPG, PNG, WEBP)';
    }

    if (!esValido) {
      input.style.borderColor = '#ef4444';
      mostrarTooltip(input, mensajeError);
    } else {
      input.style.borderColor = '#22c55e';
      ocultarTooltip();
    }

    return esValido;
  };


  if (campos.descripcion) {
    const ajustar = () => {
      campos.descripcion.style.height = 'auto';
      campos.descripcion.style.height = campos.descripcion.scrollHeight + 'px';
    };
    campos.descripcion.addEventListener('input', ajustar);
  }


  form.addEventListener('input', (e) => validarCampo(e.target));
  form.addEventListener('change', (e) => validarCampo(e.target));
  form.addEventListener('focusout', ocultarTooltip);


  form.addEventListener('submit', (e) => {
    let primerInputInvalido = null;


    const tieneRuta = campos.foto_texto && campos.foto_texto.value.trim() !== '';
    const tieneArchivo = campos.foto_archivo && campos.foto_archivo.files.length > 0;

    if (!tieneRuta && !tieneArchivo) {
      e.preventDefault();
      campos.foto_texto.style.borderColor = '#ef4444';
      campos.foto_texto.focus();
      mostrarTooltip(campos.foto_texto, 'Debes ingresar una URL o subir un archivo de imagen');
      return;
    }


    Object.values(campos).forEach(input => {
      if (input) {
        if (input.hasAttribute('required') || input.value.trim() !== '' || input.type === 'file') {
          const esValido = validarCampo(input);
          if (!esValido && !primerInputInvalido) {
            primerInputInvalido = input;
          }
        }
      }
    });

    if (primerInputInvalido) {
      e.preventDefault();
      primerInputInvalido.focus();
      validarCampo(primerInputInvalido);
    }
  });
});