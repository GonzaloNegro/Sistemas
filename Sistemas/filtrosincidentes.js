function mostrarFiltros(){
  var selector = document.getElementById("tipo").value;
  if (selector == "Estado") {
    document.getElementById("repotodos").style.display = "block";
    document.getElementById("principal").style.display = "none";
    document.getElementById("vlv").style.display = "none";
  }
  if (selector == "Tipificacion") {
    document.getElementById("reportipi").style.display = "block";
    document.getElementById("principal").style.display = "none";
    document.getElementById("vlv").style.display = "none";
  }
  if (selector == "Usuario") {
    document.getElementById("repoUsuario").style.display = "block";
    document.getElementById("principal").style.display = "none";
    document.getElementById("vlv").style.display = "none";
  }
  if (selector == "Resolutor") {
    document.getElementById("reporeso").style.display = "block";
    document.getElementById("principal").style.display = "none";
    document.getElementById("vlv").style.display = "none";
  }



}

function volver() {
  document.getElementById("repotodos").style.display = "none";
  document.getElementById("principal").style.display = "block";
  document.getElementById("reportipi").style.display = "none";
  document.getElementById("repoUsuario").style.display = "none";
  document.getElementById("reporeso").style.display = "none";
  document.getElementById("vlv").style.display = "block";
  document.getElementById("tipo").value = "0";
}

function ocultarPag() {
  document.getElementById("paginador").style.display = "none";
      } 
  

  

