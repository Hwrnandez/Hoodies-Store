// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/public/producto.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
const PRODUCTOS = document.getElementById('producto');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('idCategoria', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const DATA = await fetchData(PRODUCTO_API, 'readProductosCategoria', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        
        // Se asigna como título principal la categoría de los productos.
        MAIN_TITLE.textContent = `Categoría: ${PARAMS.get('nombre')}`;
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
           
            // Se crean y conca tenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
                <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
                    <div class="card mb-3" id="cards">
                        <img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="card-img-top" alt="${row.nombre_producto}">
                        <div class="card-body">
                            <h5 class="card-title text-center">${row.nombre_producto}</h5>
                        </div>
                        <ul class="list-group list-group-flush" id="lista">
                            <li class="list-group-item"id="lista">Precio unitario (US$): ${row.precio_producto}</li>
                            <li class="list-group-item"id="lista">Precio unitario (US$): ${row.precio_producto}</li>
                            <li class="list-group-item"id="lista">Descripcion: ${row.descripcion_producto}</li>
                        </ul>
                        <div class="card-body text-center" >
                            <a href="detalle_producto.html?id=${row.id_producto}" class="btn btn-outline-secondary0'" id="verDetalle">Ver detalle</a>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        console.log(DATA.error);
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        MAIN_TITLE.textContent = DATA.error;
    }
});