const header = document.querySelector('header')
header.innerHTML = `
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../../resources/img/logo.png" alt="" width="160" height="60">
    </a>
    <div class="collapse navbar-collapse justify-content-center menu" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="../../views/public/hombresec.html">Hombre</a>
        <a class="nav-link active" href="../../views/public/mujeressec.html">Mujer</a>
        <a class="nav-link active" href="../../views/public/index.html">Destacado</a>
        <a class="nav-link active" href="../../views/public/carrito.html"><i class="bi bi-bag-fill"></i></a>
      </div>
    </div>
  </div>
</nav>` 
