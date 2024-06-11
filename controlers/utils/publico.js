/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar la plantilla del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/clientes.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
//MAIN.style.paddingTop = '75px';
//MAIN.style.paddingBottom = '100px';
//MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'HOODIES STORE';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
// MAIN_TITLE.classList.add('text-center', 'py-3');

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
                        <div class="container">
                            <a class="navbar-brand" href="index.html">
                                <img src="../../recursos/img/logo_hoodie.avif" alt="" width="50"> Hoodies Store
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.html">Categoria</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="carrito.html"><i class="bi bi-cart"></i>Carrito</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Cuenta: <b>${DATA.username}</b></a>
                                        <ul class="dropdown-menu"> 
                                            <li><a class="dropdown-item" href="#" onclick="logOut()">Cerrar sesión</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="logOut()">Editar perfil</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>
            `);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', `
                <footer>
            <nav class="navbar fixed-bottom bg-secondary-subtle" id="footerColor">
                <div class="container">
                    <div>
                        <h6>Hoodies Store</h6>
                        <p><i class="bi bi-c-square"></i> 2024 - Todos los derechos reservados</p>
                    </div>
                    <div>
                        <h6>Contáctanos</h6>
                        <p><i class="bi bi-envelope"></i> hoodies store@gmail.com</p>
                    </div>
                </div>
            </nav>
        </footer>
            `);
        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }
    }
    else{
        MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
                        <div class="container">
                            <a class="navbar-brand" href="index.html">
                                <img src="../../recursos/img/logo_hoodie.avif" alt="" width="50"> Hoodies Store
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.html">Categoria</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="carrito.html"<i class="bi bi-cart"></i>Carrito</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="Iniciosesion.html"<i class="bi bi-cart"></i>Iniciar Sesión</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>
            `);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', `
                <footer>
            <nav class="navbar fixed-bottom " id="footerColor">
                <div class="container">
                    <div>
                        <h6>Hoodies Store</h6>
                        <p><i class="bi bi-c-square"></i> 2024 - Todos los derechos reservados</p>
                    </div>
                    <div>
                        <h6>Contáctanos</h6>
                        <p><i class="bi bi-envelope"></i> hoodies store@gmail.com</p>
                    </div>
                </div>
            </nav>
        </footer>
            `);
    }
}