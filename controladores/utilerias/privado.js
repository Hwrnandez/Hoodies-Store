const header = document.querySelector('header')
header.innerHTML =`
<ul class="nav justify-content-center">
<li class="nav-item">
  <a class="nav-link active" aria-current="page" href="#">Productos</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">Categorias</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">Usuarios</a>
</li>
<li class="nav-item">
  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
</li>
</ul>`


function myFunc()  {
	var now = new Date();
	var time = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
	document.getElementById('hora').innerHTML= time;
}
myFunc();
setInterval(myFunc, 1000);