document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.contacto-form');
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
    correo: document.getElementById('correo'),
    asunto: document.getElementById('asunto'),
    mensaje: document.getElementById('mensaje')
  };

  const regex = {
    nombre: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,30}$/,
    correo: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
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

    if (valor === '') {
      input.style.borderColor = '';
      ocultarTooltip();
      return true;
    }

    let esValido = true;
    let mensajeError = '';

    if (input === campos.nombre) {
      esValido = regex.nombre.test(valor);
      if (!esValido) mensajeError = 'Solo se permiten letras';
    } else if (input === campos.correo) {
      esValido = regex.correo.test(valor);
      if (!esValido) mensajeError = 'Ingresa un correo electrónico válido';
    } else if (input === campos.asunto) {
      esValido = valor.length >= 4 && valor.length <= 100;
      if (!esValido) mensajeError = 'El asunto debe tener entre 4 y 100 caracteres';
    } else if (input === campos.mensaje) {
      esValido = valor.length >= 10 && valor.length <= 1000;
      if (!esValido) mensajeError = 'El mensaje debe tener al menos 10 caracteres';
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


  form.addEventListener('input', (e) => validarCampo(e.target));
  form.addEventListener('change', (e) => validarCampo(e.target));
  form.addEventListener('focusout', ocultarTooltip);


  form.addEventListener('submit', (e) => {
    let primerInputInvalido = null;

    Object.values(campos).forEach(input => {
      if (input) {
        if (input.hasAttribute('required') || input.value.trim() !== '') {
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