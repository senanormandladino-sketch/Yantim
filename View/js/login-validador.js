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
    correo: document.getElementById('correo'),
    password: document.getElementById('password')
  };

  const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

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
    const valor = input.value.trim();

    if (valor === '') {
      input.style.borderColor = '';
      ocultarTooltip();
      return true;
    }

    let esValido = true;
    let mensajeError = '';

    if (input === campos.correo) {
      esValido = regexCorreo.test(valor);
      if (!esValido) mensajeError = 'Ingresa un correo válido (ej: usuario@dominio.com)';
    } else if (input === campos.password) {
      esValido = input.value.length >= 1;
      if (!esValido) mensajeError = 'Ingresa tu contraseña';
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




  form.addEventListener('submit', async (e) => {
    e.preventDefault();


    let primerInputInvalido = null;
    Object.values(campos).forEach(input => {
      if (input && input.hasAttribute('required')) {
        const esValido = validarCampo(input);
        if (!esValido && !primerInputInvalido) {
          primerInputInvalido = input;
        }
      }
    });

    if (primerInputInvalido) {
      primerInputInvalido.focus();
      validarCampo(primerInputInvalido);
      return;
    }


    const formData = new FormData(form);

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData
      });

      const data = await response.json();

      if (data.success) {

        window.location.href = data.redirect;
      } else {

        let inputObjetivo = null;

        if (data.error_type === 'correo') {
          inputObjetivo = campos.correo;
        } else if (data.error_type === 'password') {
          inputObjetivo = campos.password;
        } else {
          inputObjetivo = campos.correo;
        }


        if (inputObjetivo) {
          inputObjetivo.style.borderColor = '#ef4444';
          inputObjetivo.focus();
          mostrarTooltip(inputObjetivo, data.message);
        }
      }
    } catch (error) {
      console.error('Error al procesar la autenticación:', error);
      mostrarTooltip(campos.correo, 'Error de conexión con el servidor.');
    }
  });
});