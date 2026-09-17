document.addEventListener('DOMContentLoaded', () => {

  const botonesPrincipales = document.querySelectorAll('.contenedor--categorias-principales .btn--categoria');
  const botonTodos = document.querySelector('[data-filtro="todos"]');
  const tarjetasProductos = document.querySelectorAll('.producto--catalogo');
  const buscador = document.getElementById('buscador-input');

  let filtroPrincipal = 'todos';


  function filtrarCatalogo() {
    const textoBusqueda = buscador.value.toLowerCase().trim();

    tarjetasProductos.forEach(producto => {

      const catPrincipal = producto.getAttribute('data-principal');
      const nombre = producto.querySelector('.h3--productos').textContent.toLowerCase();
      const descripcion = producto.querySelector('.descripcion--productos').textContent.toLowerCase();


      const coincidePrincipal = (filtroPrincipal === 'todos' || String(catPrincipal) === String(filtroPrincipal));
      const coincideTexto = (nombre.includes(textoBusqueda) || descripcion.includes(textoBusqueda));


      if (coincidePrincipal && coincideTexto) {
        producto.style.display = 'flex';
      } else {
        producto.style.display = 'none';
      }
    });
  }


  botonesPrincipales.forEach(boton => {
    boton.addEventListener('click', () => {

      botonesPrincipales.forEach(btn => btn.classList.remove('activo'));
      boton.classList.add('activo');


      filtroPrincipal = boton.getAttribute('data-filtro');
      filtrarCatalogo();
    });
  });


  if (buscador) {
    buscador.addEventListener('input', () => {
      const textoBusqueda = buscador.value.trim();


      if (textoBusqueda.length > 0 && filtroPrincipal !== 'todos') {
        filtroPrincipal = 'todos';

        botonesPrincipales.forEach(btn => btn.classList.remove('activo'));
        if (botonTodos) {
          botonTodos.classList.add('activo');
        }
      }

      filtrarCatalogo();
    });
  }
});



