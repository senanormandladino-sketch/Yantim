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
    tipo_doc: document.getElementById('tipo_doc'),
    num_doc: document.getElementById('num_doc'),
    primer_nombre: document.getElementById('primer_nombre'),
    segundo_nombre: document.getElementById('segundo_nombre'),
    primer_apellido: document.getElementById('primer_apellido'),
    segundo_apellido: document.getElementById('segundo_apellido'),
    correo: document.getElementById('correo'),
    telefono: document.getElementById('telefono'),
    contrasena: document.getElementById('contrasena'),
    rol: document.getElementById('rol'),
    fecha_nac: document.getElementById('fecha_nac'),
    direccion: document.getElementById('direccion')
  };

  const regex = {
    texto: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,30}$/,
    correo: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    telefono: /^3\d{9}$/,
    num_doc: /^\d{6,12}$/
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

    if (input === campos.num_doc) {
      esValido = regex.num_doc.test(valor);
      if (!esValido) mensajeError = 'El documento debe tener entre 6 y 12 dígitos';
    } else if ([campos.primer_nombre, campos.primer_apellido].includes(input)) {
      esValido = regex.texto.test(valor);
      if (!esValido) mensajeError = 'Solo se permiten letras';
    } else if ([campos.segundo_nombre, campos.segundo_apellido].includes(input)) {
      esValido = regex.texto.test(valor);
      if (!esValido) mensajeError = 'Solo se permiten letras';
    } else if (input === campos.correo) {
      esValido = regex.correo.test(valor);
      if (!esValido) mensajeError = 'Correo electrónico no válido';
    } else if (input === campos.telefono) {
      esValido = regex.telefono.test(valor);
      if (!esValido) mensajeError = 'Debe iniciar con 3 y tener 10 dígitos';
    } else if (input === campos.password) {
      const valorPassword = input.value;
      const tieneMayuscula = /[A-Z]/.test(valorPassword);
      const tieneEspecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(valorPassword);
      const tieneLongitud = valorPassword.length >= 8;

      if (!tieneLongitud || !tieneMayuscula || !tieneEspecial) {
        esValido = false;
        mensajeError = 'Debe incluir minimo 8 caracteres, una mayuscula y un caracter especial';
      }
    } else if (input === campos.direccion) {
      esValido = valor.length >= 5;
      if (!esValido) mensajeError = 'Mínimo 5 caracteres';
    } else if (input === campos.fecha_nac) {
      const fechaNacimiento = new Date(valor);
      const hoy = new Date();
      let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
      const mes = hoy.getMonth() - fechaNacimiento.getMonth();
      if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) edad--;
      
      esValido = edad >= 13 && edad <= 130;
      if (!esValido) mensajeError = 'Ingrese una fecha de nacimiento valida';
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