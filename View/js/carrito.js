document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('carrito--sidebar');
  const btnAbrir = document.getElementById('btn--abrir-carrito');
  const btnCerrar = document.getElementById('btn--cerrar-carrito');
  const contenedorItems = document.getElementById('carrito--items');

  const contadorFlotante = document.getElementById('carrito--contador');
  const contadorTotalFooter = document.getElementById('carrito--total-productos');
  const precioTotalFooter = document.getElementById('carrito--precio-total');


  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
  carrito = carrito.filter(item => item && (item.id || item.id_producto) && item.nombre && item.nombre !== 'null' && !isNaN(item.precio));


  if (btnAbrir) {
    btnAbrir.addEventListener('click', (e) => {
      e.stopPropagation();
      sidebar?.classList.add('active');
    });
  }

  if (btnCerrar) {
    btnCerrar.addEventListener('click', (e) => {
      e.stopPropagation();
      sidebar?.classList.remove('active');
    });
  }


  window.addEventListener('storage', (e) => {
    if (e.key === 'carrito') {
      carrito = JSON.parse(e.newValue) || [];
      carrito = carrito.filter(item => item && (item.id || item.id_producto) && item.nombre && item.nombre !== 'null' && !isNaN(item.precio));
      actualizarCarritoUI(null);
    }
  });


  document.addEventListener('click', (e) => {
    const boton = e.target.closest('.boton--carrito');
    if (boton) {

      if (boton.tagName === 'A' && boton.getAttribute('href')?.includes('Inicio_secion')) {
        return;
      }

      e.preventDefault();
      e.stopPropagation();


      const inputCant = document.getElementById('cantidad');
      const cantidadAAgregar = inputCant ? (parseInt(inputCant.value) || 1) : 1;

      const id = boton.getAttribute('data-id');
      const nombre = boton.getAttribute('data-nombre');
      const precio = parseFloat(boton.getAttribute('data-precio'));
      const foto = boton.getAttribute('data-foto');

      if (!id || !nombre || nombre === 'null' || isNaN(precio)) {
        console.error('Error: Atributos data-* faltantes o inválidos en el botón.');
        return;
      }

      const idString = String(id);
      const existe = carrito.find(item => String(item.id || item.id_producto) === idString);

      if (existe) {
        existe.cantidad = parseInt(existe.cantidad) + cantidadAAgregar;
      } else {
        carrito.push({
          id: idString,
          id_producto: idString,
          nombre: nombre,
          precio: precio,
          foto: foto,
          cantidad: cantidadAAgregar
        });
      }

      actualizarCarritoUI(true);
    }
  });



 window.cambiarCantidadCarrito = async (id, delta, event) => {
  if (event) event.stopPropagation();

  const idString = String(id);
  const item = carrito.find(p => String(p.id || p.id_producto) === idString);

  if (!item) return;

  const nuevaCantidad = parseInt(item.cantidad) + delta;

  if (delta > 0) {
    try {
      const response = await fetch(`../Controller/ProductoController.php?accion=obtenerStock&id=${encodeURIComponent(idString)}`);
      
      if (!response.ok) {
        throw new Error(`Error en el servidor: ${response.status}`);
      }

      const texto = await response.text();
      if (!texto.trim()) {
        throw new Error('Respuesta vacía del servidor');
      }

      const data = JSON.parse(texto);

      if (data.error) {
        alert(data.error);
        return;
      }

      const stockRealBD = data.stock;

      if (nuevaCantidad > stockRealBD) {
        return;
      }
    } catch (error) {
      console.error('Error al validar stock:', error);
      alert('Ocurrió un error al verificar la disponibilidad del producto.');
      return;
    }
  }

  item.cantidad = nuevaCantidad;

  if (item.cantidad <= 0) {
    eliminarItem(idString, event);
  } else {
    actualizarCarritoUI(null);
  }
};                    


  window.eliminarItem = (id, event) => {
    if (event) event.stopPropagation();

    const idString = String(id);
    carrito = carrito.filter(item => String(item.id || item.id_producto) !== idString);
    actualizarCarritoUI(null);
  };


  function actualizarCarritoUI(abrirSidebar = null) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    
    let totalPrecio = 0;
    let totalProductos = 0;

    if (contenedorItems) {
      contenedorItems.innerHTML = '';

      if (carrito.length === 0) {
        contenedorItems.innerHTML = '<p style="text-align:center; color:#64748b; margin-top:20px;">Tu carrito está vacío.</p>';
      } else {
        carrito.forEach(item => {
          const itemId = String(item.id || item.id_producto);
          const subtotalItem = parseFloat(item.precio) * parseInt(item.cantidad);
          
          totalPrecio += subtotalItem;
          totalProductos += parseInt(item.cantidad);

          contenedorItems.innerHTML += `
            <div class="carrito--item">
              <img src="${item.foto}" class="cart--img" alt="${item.nombre}">
              <div class="cart--info">
                <h4>${item.nombre}</h4>
                <p>$${subtotalItem.toLocaleString('es-CO')}</p>
                <div class="cart--controles">
                  <button type="button" class="btn--cantidad" onclick="cambiarCantidadCarrito('${itemId}', -1, event)">-</button>
                  <span>${item.cantidad}<span>
                  <button type="button" class="btn--cantidad" onclick="cambiarCantidadCarrito('${itemId}', 1, event)">+</button>
                  <button type="button" class="cart--btn-eliminar" onclick="eliminarItem('${itemId}', event)">Eliminar</button>
                </div>
              </div>
            </div>
          `;
        });
      }
    } else {
      totalProductos = carrito.reduce((acc, item) => acc + parseInt(item.cantidad), 0);
      totalPrecio = carrito.reduce((acc, item) => acc + (parseFloat(item.precio) * parseInt(item.cantidad)), 0);
    }

    if (contadorFlotante) contadorFlotante.textContent = totalProductos;
    if (contadorTotalFooter) contadorTotalFooter.textContent = totalProductos;
    if (precioTotalFooter) precioTotalFooter.textContent = `$${totalPrecio.toLocaleString('es-CO')}`;

    document.querySelectorAll('.boton--carrito').forEach(btnAgregar => {
  const idProd = String(btnAgregar.dataset.id);
  const stockBD = parseInt(btnAgregar.dataset.stock || 0);


  const itemEnCarrito = carrito.find(p => String(p.id || p.id_producto) === idProd);
  const cantidadEnCarrito = itemEnCarrito ? parseInt(itemEnCarrito.cantidad) : 0;


  if (stockBD <= 0 || cantidadEnCarrito >= stockBD) {
    btnAgregar.disabled = true;
    btnAgregar.classList.add('btn-disabled');
    btnAgregar.innerText = stockBD <= 0 ? 'Sin Stock' : 'Límite alcanzado';
  } 
  else {
    btnAgregar.disabled = false;
    btnAgregar.classList.remove('btn-disabled');
    btnAgregar.innerText = 'Agregar al carrito';
  }
});


    if (sidebar) {
      if (abrirSidebar === true) {
        sidebar.classList.add('active');
      } else if (abrirSidebar === false) {
        sidebar.classList.remove('active');
      }
    }
  }


  actualizarCarritoUI(false);
});
