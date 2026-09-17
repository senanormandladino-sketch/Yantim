document.addEventListener('DOMContentLoaded', () => {

  const precioElem = document.getElementById('precioDinamico');
  const inputCantidad = document.getElementById('cantidad');
  const precioUnitario = parseFloat(precioElem ? precioElem.getAttribute('data-precio-unitario') : 0);


  const sidebar = document.getElementById('carrito--sidebar');
  const btnAbrir = document.getElementById('btn--abrir-carrito');
  const btnCerrar = document.getElementById('btn--cerrar-carrito');
  const contenedorItems = document.getElementById('carrito--items');

  const contadorFlotante = document.getElementById('carrito--contador');
  const contadorTotalFooter = document.getElementById('carrito--total-productos');
  const precioTotalFooter = document.getElementById('carrito--precio-total');

  let carrito = JSON.parse(localStorage.getItem('amazon_cart')) || [];


  function actualizarPrecioVista() {
    if (!precioElem || !inputCantidad) return;
    const cantidad = parseInt(inputCantidad.value) || 1;
    const total = precioUnitario * cantidad;
    precioElem.textContent = '$' + total.toLocaleString('es-CO');
  }

  window.restar = () => {
    if (parseInt(inputCantidad.value) > 1) {
      inputCantidad.value = parseInt(inputCantidad.value) - 1;
      actualizarPrecioVista();
    }
  };

  window.sumar = (maxStock) => {
    if (parseInt(inputCantidad.value) < maxStock) {
      inputCantidad.value = parseInt(inputCantidad.value) + 1;
      actualizarPrecioVista();
    }
  };


  if (btnAbrir) btnAbrir.addEventListener('click', () => sidebar.classList.add('active'));
  if (btnCerrar) btnCerrar.addEventListener('click', () => sidebar.classList.remove('active'));


  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('boton--carrito')) {
      const boton = e.target;
      const cantidadAAgregar = inputCantidad ? parseInt(inputCantidad.value) || 1 : 1;

      const producto = {
        id: boton.getAttribute('data-id'),
        nombre: boton.getAttribute('data-nombre'),
        precio: parseFloat(boton.getAttribute('data-precio')),
        foto: boton.getAttribute('data-foto'),
        cantidad: cantidadAAgregar
      };

      const existe = carrito.find(item => item.id === producto.id);
      if (existe) {
        existe.cantidad += cantidadAAgregar;
      } else {
        carrito.push(producto);
      }

      actualizarCarritoUI();
      sidebar.classList.add('active');
    }
  });


  window.cambiarCantidadCarrito = (id, delta) => {
    const item = carrito.find(p => p.id === String(id));
    if (item) {
      item.cantidad += delta;
      if (item.cantidad <= 0) {
        eliminarItem(id);
      } else {
        actualizarCarritoUI();
      }
    }
  };

  window.eliminarItem = (id) => {
    carrito = carrito.filter(item => item.id !== String(id));
    actualizarCarritoUI();
  };


  function actualizarCarritoUI() {
    localStorage.setItem('amazon_cart', JSON.stringify(carrito));
    contenedorItems.innerHTML = '';
    let totalPrecio = 0;
    let totalProductos = 0;

    if (carrito.length === 0) {
      contenedorItems.innerHTML = '<p style="text-align:center; color:#64748b; margin-top:20px;">Tu carrito está vacío.</p>';
    } else {
      carrito.forEach(item => {
        const subtotalItem = item.precio * item.cantidad;
        totalPrecio += subtotalItem;
        totalProductos += item.cantidad;

        contenedorItems.innerHTML += `
          <div class="carrito--item">
            <img src="${item.foto}" class="cart--img" alt="${item.nombre}">
            <div class="cart--info">
              <h4>${item.nombre}</h4>
              <p>$${subtotalItem.toLocaleString('es-CO')}</p>
              <div class="cart--controles">
                <button type="button" class="btn--cantidad" onclick="cambiarCantidadCarrito('${item.id}', -1)">-</button>
                <span>${item.cantidad}</span>
                <button type="button" class="btn--cantidad" onclick="cambiarCantidadCarrito('${item.id}', 1)">+</button>
                <button type="button" class="cart--btn-eliminar" onclick="eliminarItem('${item.id}')">Eliminar</button>
              </div>
            </div>
          </div>
        `;
      });
    }

    if (contadorFlotante) contadorFlotante.textContent = totalProductos;
    if (contadorTotalFooter) contadorTotalFooter.textContent = totalProductos;
    if (precioTotalFooter) precioTotalFooter.textContent = `$${totalPrecio.toLocaleString('es-CO')}`;
  }

  actualizarCarritoUI();
});