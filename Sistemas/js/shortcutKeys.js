document.addEventListener("keydown", function(e){
    if(e.key === "Enter"){
        e.preventDefault();
        const btnBuscar = document.getElementById("btnForm");
        if(btnBuscar) btnBuscar.click();
    }

    if(e.key === "Escape"){
        e.preventDefault();
        const btnLimpiar = document.getElementById("btnLimpiar");
        if(btnLimpiar) btnLimpiar.click();
    }
});
