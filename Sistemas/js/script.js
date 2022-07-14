const not = document.querySelector('#notif')

window.onload(controlar());

function controlar(){
    if(valor > 0){
        document.querySelector("#cant").style.color = "red";
    }
    not.addEventListener('click', ()=>{
        if(valor > 0){
            Swal.fire({
                title: `Hay ${valor} incidentes pendientes por cerrar!`,
                icon: 'info',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                        },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                        }
            })
            }else{
            Swal.fire({
                title: 'No existen incidentes pendientes',
                icon: 'success',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                        },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                        }
            })
            }
    })
}

