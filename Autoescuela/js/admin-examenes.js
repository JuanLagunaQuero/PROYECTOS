window.addEventListener("load", function(){
    var tabla = document.getElementById("tabla");

        fetch("../php/ajax/listaExamenes.php",{
            method:"GET"
        }).then(response => response.json())
          .catch(error=>alert("Error"+error))
          .then(response => {
              pintarExamenes(response);
          })
    
        function pintarExamenes(objJavascript){
            for (let i=0;i<objJavascript.length;i++){
                var spanBorrar = document.createElement("span");
                var spanEditar = document.createElement("span");
                spanBorrar.innerHTML="Borrar";
                spanEditar.innerHTML="Editar";

                var fila=document.createElement("tr");
                var tdID=document.createElement("td");
                var tdDESCRIP=document.createElement("td");
                var tdNUMPREG=document.createElement("td");
                var tdDUR=document.createElement("td");
                var tdACC=document.createElement("td");

                tdID.innerHTML=objJavascript[i].id_examen;
                tdDESCRIP.innerHTML=objJavascript[i].descripcion;
                tdNUMPREG.innerHTML=objJavascript[i].numero_preguntas;
                tdDUR.innerHTML="00:"+objJavascript[i].duracion+":00";
                tdACC.appendChild(spanBorrar);
                tdACC.appendChild(spanEditar);
        
                tabla.appendChild(fila);
                fila.appendChild(tdID);
                fila.appendChild(tdDESCRIP);
                fila.appendChild(tdNUMPREG);
                fila.appendChild(tdDUR);
                fila.appendChild(tdACC);
            }
        }

       

       
})