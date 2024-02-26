const header = document.querySelector('header')
header.innerHTML =`
<ul class="nav justify-content-center">
<li class="nav-item">
  <a class="nav-link active" aria-current="page" href="#">Active</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">Link</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">Link</a>
</li>
<li class="nav-item">
  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
</li>
</ul>`

const fooder = document.querySelector('fooder')
header.innerHTML =``
function myFunc()  {
	var now = new Date();
	var time = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
	document.getElementById('hora').innerHTML= time;
}
myFunc();
setInterval(myFunc, 1000);