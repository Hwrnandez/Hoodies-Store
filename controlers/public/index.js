// Constante para completar la ruta de la API.
const CATEGORIA_API = 'services/public/categoria.php';
// Constante para establecer el contenedor de categorías.
const CATEGORIAS = document.getElementById('categorias');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    
});