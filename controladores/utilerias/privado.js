const header = document.querySelector('header')
header.innerHTML =`<nav class="navbar bg-body-tertiary">
<div class="container-fluid">
  <a class="navbar-brand" href="#">
    <img src="../../recursos/img/Logo_hoodie.avif" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
    Hoodies Store
  </a>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Productos</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Categorias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Usuarios</a>
          </li>
          <li class="nav-item">
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
</nav>`


function myFunc()  {
	var now = new Date();
	var time = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
	document.getElementById('hora').innerHTML= time;
}
myFunc();
setInterval(myFunc, 1000);

