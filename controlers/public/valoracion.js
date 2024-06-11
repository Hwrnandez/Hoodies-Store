let rating = 0;  // Variable global para almacenar el valor del rating
 
// Ciclo para seleccionar todas las estrellas
stars.forEach(function (star, index) {
    star.addEventListener('click', function () {
        for (let i = 0; i <= index; i++) {
            stars[i].classList.add('checked');
        }
        for (let i = index + 1; i < stars.length; i++) {
            stars[i].classList.remove('checked');
        }
        // Asignar la variable con el valor de la estrella seleccionada
        rating = index + 1;
        // Imprimir la variable en la consola
        console.log('Rating seleccionado:', rating);
    });
});
 
// Evento para enviar la valoración
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    const action = 'createValoracion';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    FORM.append('idProducto', IDPRODUCTO);
    FORM.append('calificacionValoracion', rating);  // Utiliza la variable global rating
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PRODUCTOS_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message);
        await fillComentarios(IDPRODUCTO);
        COMENTARIO_VALORACION.value = '';  // Borra el texto del comentario
        stars.forEach(function (star) {
            star.classList.remove('checked');  // Reinicia las estrellas a 0
        });
        rating = 0;  // Reinicia la variable de rating a 0
    } else {
        sweetAlert(2, DATA.error, false);
        console.log(DATA.message);
    }
});
 
// Función para llenar los comentarios de los productos
const fillComentarios = async (id) => {
    COMENTARIOS.innerHTML = '';
    const FORM = new FormData();
    FORM.append('idProducto', id);
    const DATA = await fetchData(PRODUCTOS_API, 'readComentarios', FORM);
 
    if (DATA.status) {
        DATA.dataset.forEach(row => {
            COMENTARIOS.innerHTML += `
                <div class="row py-3">
                    <div class="col-1 py-2">
                        <img class="rounded-circle" width="75" height="75" alt="${row.nombre_cliente}" src="${SERVER_URL}images/clientes/${row.imagen_cliente}">
                    </div>
                    <!-- Contenedor de comentarios -->
                    <div class="col-12 col-lg-10 comentarios_clientes">
                        <div class="row">
                            <div class="col-9 col-lg-12 py-2 px-4">
                                <!-- Comentario del usuario -->
                                <p class="fw-semibold">${row.nombre_cliente + ' ' + row.apellido_cliente}</p>
                                <p>${row.comentario}</p>
                                <div class="row">
                                    <!-- Estrellas de la valoración -->
                                    <div class="col-8 col-lg-8">
                                        ${generateStars(row.calificacion)}
                                    </div>
                                    <!-- Fecha de publicación del comentario -->
                                    <div class="col-8 col-lg-4 ">
                                        <p class="fs-6"><b>${row.fecha_formato}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
    }
};
 
// Función para generar las estrellas de la valoración
const generateStars = (rating) => {
    let starsHTML = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            starsHTML += `
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-star-fill estrella_ejemplo" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                </svg>
            `;
        } else {
            starsHTML += `
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-star-fill estrella_ejemplo_apagada" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                </svg>
            `;
        }
    }
    return starsHTML;
};