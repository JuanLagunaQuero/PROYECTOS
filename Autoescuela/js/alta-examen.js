window.addEventListener("load", function(){

    var preguntas = document.getElementById("preguntas");
    var seleccionadas = document.getElementById("seleccionadas");
    var crear = document.getElementById("crear");

    crear.onclick = crearExamen;


    fetch("php/ajax/pedirPreguntas.php",{
        method:"GET"
    }).then(response => response.json())
      .catch(error=>alert("Error"+error))
      .then(response => {
          pintarPreguntas(response);
      })

    function pintarPreguntas(objJavascript){
        for (let i=0;i<objJavascript.length;i++){
            var div=document.createElement("div");
            div.innerHTML=objJavascript[i].enunciado+" - "+objJavascript[i].id_tematica;
            div.id="preg_"+objJavascript[i].id_pregunta;
            div.className="pregunta";
            div.draggable=true;
            div.ondragstart=function(ev){
                ev.dataTransfer.setData("text",this.id)
            };
            div.ondragover=function(ev){
                ev.preventDefault();
            }
            div.onclick=function(){
                this.classList.toggle("marcado")
            }
            preguntas.appendChild(div);

        }
    }


    const filtro=document.getElementById("texto");
    filtro.onkeyup=function(){
        const divs=preguntas.getElementsByTagName("div");
        for(let i=0;i<divs.length;i++){
            divs[i].classList.remove("marcado");
            if(divs[i].innerHTML.indexOf(filtro.value)<0)
                divs[i].classList.add("oculto")
            else
                divs[i].classList.remove("oculto")
         }
    }
    const boton=document.getElementById("boton");
    boton.onclick=function(){
        const divs=preguntas.getElementsByTagName("div");
        for(let i=0;i<divs.length;i++){
            if(divs[i].innerHTML.indexOf(filtro.value)<0)
                divs[i].classList.add("oculto")
            else
                divs[i].classList.remove("oculto")
         }
    }


    /* for (let i=0;i<divs.length;i++){
        divs[i].ondragstart=function(ev){
            ev.dataTransfer.setData("text",this.id)
        };
        divs[i].ondragover=function(ev){
            ev.preventDefault();
        }
        divs[i].ondrop=function(ev){
            ev.preventDefault();
            debugger;
            const id=ev.dataTransfer.getData("text");
            ev.target.parentNode.appendChild(document.getElementById(id));
            if (ev.target.parentNode.id="seleccionadas"){
                const marcados=seleccionadas.getElementsByClassName("marcado");
                for (let j=0;i<marcados.length;j++)
                  preguntas.appendChild(marcados[j]);
            }
            ev.stopPropagation();
        }
        divs[i].onclick=function(){
            this.classList.toggle("marcado")
        }
    } */
    seleccionadas.ondragover=function(ev){
        ev.preventDefault();
    }
    
    preguntas.ondragover=function(ev){
        ev.preventDefault();
    }
    seleccionadas.ondrop=function(ev){
        ev.preventDefault();
        const id=ev.dataTransfer.getData("text");
        this.appendChild(document.getElementById(id));
        const marcados=preguntas.getElementsByClassName("marcado");
        debugger;
        for (let j=marcados.length-1;j>=0;j--)
                  seleccionadas.appendChild(marcados[j]);
        ev.stopPropagation();
    }
    
    preguntas.ondrop=function(ev){
        ev.preventDefault();
        const id=ev.dataTransfer.getData("text");
        this.appendChild(document.getElementById(id));
        const marcados=seleccionadas.getElementsByClassName("marcado");
        for (let j=marcados.length-1;j>=0;j--)
                  preguntas.appendChild(marcados[j]);
        ev.stopPropagation();
    }

    function crearExamen(ev)
    {
        ev.preventDefault();

        
    }

})