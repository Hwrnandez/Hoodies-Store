const PRODUCTO_API = 'services/admin/productos.php';
const PEDIDO_API = 'services/admin/pedidos.php';

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();

    graficoPastelCategorias();
    graficoBarrasMarcas ();
    graficopastelonCategorias();
    graficoBarrasPedidosEstado();
});

    /*
*   Función asíncrona para mostrar un gráfico de pastel con el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/


const graficoPastelCategorias = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'porcentajeProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let categorias = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.nombre_categoria);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función para generar y mostrar un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart1', categorias, porcentajes, 'Porcentaje de productos por categoría');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}

const graficoBarrasMarcas = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'cantidadProductosMarca');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let marcas = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            marcas.push(row.nombre_marca);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart2', marcas, cantidades, 'Cantidad de productos', 'Cantidad de productos por marcas');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.error);
    }
}
const graficopastelonCategorias = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'cantidadProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let categorias = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.nombre_categoria);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('chart3', categorias, cantidades, 'Cantidad de productos por categoría');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.error);
    }
}

const graficoBarrasPedidosEstado = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PEDIDO_API, 'cantidadPedidosEstado');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let estados = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estados.push(row.estado_pedido);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart4', estados, cantidades, 'Cantidad de Pedidos por Estado', 'Cantidad de Pedidos por Estado');
    } else {
        document.getElementById('chart4').remove();
        console.log(DATA.error);
    }
}