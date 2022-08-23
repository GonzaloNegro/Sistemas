/* const stec = document.querySelector('#sumtec');
const rtec = document.querySelector('#restec');
const vtec = document.querySelector('#valtec'); */

/* ------------------------------------------ */

const sram = document.querySelector('#sumram');
const rram = document.querySelector('#resram');
const vram = document.querySelector('#valram');

const sdis = document.querySelector('#sumdis');
const rdis = document.querySelector('#resdis');
const vdis = document.querySelector('#valdis');

const sfue = document.querySelector('#sumfue');
const rfue = document.querySelector('#resfue');
const vfue = document.querySelector('#valfue');

const ston = document.querySelector('#sumton');
const rton = document.querySelector('#reston');
const vton = document.querySelector('#valton');

/* ------------------------------------------ */

const shdmi = document.querySelector('#sumhdmi');
const rhdmi = document.querySelector('#reshdmi');
const vhdmi = document.querySelector('#valhdmi');

const svga = document.querySelector('#sumvga');
const rvga = document.querySelector('#resvga');
const vvga = document.querySelector('#valvga');

const sdvi = document.querySelector('#sumdvi');
const rdvi = document.querySelector('#resdvi');
const vdvi = document.querySelector('#valdvi');

const susbi = document.querySelector('#sumusbi');
const rusbi = document.querySelector('#resusbi');
const vusbi = document.querySelector('#valusbi');

/* ------------------------------------------ */

const sdh = document.querySelector('#sumdh');
const rdh = document.querySelector('#resdh');
const vdh = document.querySelector('#valdh');

const sdv = document.querySelector('#sumdv');
const rdv = document.querySelector('#resdv');
const vdv = document.querySelector('#valdv');

const shv = document.querySelector('#sumhv');
const rhv = document.querySelector('#reshv');
const vhv = document.querySelector('#valhv');

/* let numerotec =  */

let numeroram = 0;
let numerodis = 0;
let numerofue = 0;
let numeroton = 0;

let numerohdmi = 0;
let numerovga = 0;
let numerodvi = 0;
let numerousbi = 0;

let numerodh = 0;
let numerodv = 0;
let numerohv = 0;

/* function sumar(val1, val2){
    val2++;
    val1.innerHTML = val2;
}

function restar(val1, val2){
    if(val2 == 0){}
    else{
        val2--;
        val1.innerHTML = val2;
    }
} */

/* RAM */
sram.addEventListener("click", ()=>{
    numeroram++;
    vram.innerHTML = numeroram;
})
rram.addEventListener("click", ()=>{
    if(numeroram == 0){}
    else{
        numeroram--;
        vram.innerHTML = numeroram;
    }
})

/* DISCO */
sdis.addEventListener("click", ()=>{
    numerodis++;
    vdis.innerHTML = numerodis;
})
rdis.addEventListener("click", ()=>{
    if(numerodis == 0){}
    else{
        numerodis--;
        vdis.innerHTML = numerodis;
    }
})

/* FUENTE */
sfue.addEventListener("click", ()=>{
    numerofue++;
    vfue.innerHTML = numerofue;
})
rfue.addEventListener("click", ()=>{
    if(numerofue == 0){}
    else{
        numerofue--;
        vfue.innerHTML = numerofue;
    }
})

/* TONER */
ston.addEventListener("click", ()=>{
    numeroton++;
    vton.innerHTML = numeroton;
})
rton.addEventListener("click", ()=>{
    if(numeroton == 0){}
    else{
        numeroton--;
        vton.innerHTML = numeroton;
    }
})

/* --------------------------------- */

/* HDMI */
shdmi.addEventListener("click", ()=>{
    numerohdmi++;
    vhdmi.innerHTML = numerohdmi;
})
rhdmi.addEventListener("click", ()=>{
    if(numerohdmi == 0){}
    else{
        numerohdmi--;
        vhdmi.innerHTML = numerohdmi;
    }
})

/* VGA */
svga.addEventListener("click", ()=>{
    numerovga++;
    vvga.innerHTML = numerovga;
})
rvga.addEventListener("click", ()=>{
    if(numerovga == 0){}
    else{
        numerovga--;
        vvga.innerHTML = numerovga;
    }
})

/* DVI */
sdvi.addEventListener("click", ()=>{
    numerodvi++;
    vdvi.innerHTML = numerodvi;
})
rdvi.addEventListener("click", ()=>{
    if(numerodvi == 0){}
    else{
        numerodvi--;
        vdvi.innerHTML = numerodvi;
    }
})

/* USB IMPRESORA */
susbi.addEventListener("click", ()=>{
    numerousbi++;
    vusbi.innerHTML = numerousbi;
})
rusbi.addEventListener("click", ()=>{
    if(numerousbi == 0){}
    else{
        numerousbi--;
        vusbi.innerHTML = numerousbi;
    }
})

/* --------------------------------- */

/* DVI/HDMI */
sdh.addEventListener("click", ()=>{
    numerodh++;
    vdh.innerHTML = numerodh;
})
rdh.addEventListener("click", ()=>{
    if(numerodh == 0){}
    else{
        numerodh--;
        vdh.innerHTML = numerodh;
    }
})

/* DVI/VGA */
sdv.addEventListener("click", ()=>{
    numerodv++;
    vdv.innerHTML = numerodv;
})
rdv.addEventListener("click", ()=>{
    if(numerodv == 0){}
    else{
        numerodv--;
        vdv.innerHTML = numerodv;
    }
})

/* HDMI/VGA */
shv.addEventListener("click", ()=>{
    numerohv++;
    vhv.innerHTML = numerohv;
})
rhv.addEventListener("click", ()=>{
    if(numerohv == 0){}
    else{
        numerohv--;
        vhv.innerHTML = numerohv;
    }
})
