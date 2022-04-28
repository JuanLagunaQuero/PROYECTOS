window.addEventListener("load", function(){
    var tabla = document.getElementById("tabla");

    

        fetch("../php/ajax/listaUsuarios.php",{
            method:"GET"
        }).then(response => response.json())
          .catch(error=>alert("Error"+error))
          .then(response => {
              pintarUsuarios(response);
          })
    
        function pintarUsuarios(objJavascript){
            for (let i=0;i<objJavascript.length;i++){
                var spanBorrar = document.createElement("span");
                var spanEditar = document.createElement("span");
                spanBorrar.innerHTML="Borrar";
                spanEditar.innerHTML="Editar";

                var fila=document.createElement("tr");
                var tdUSUARIO=document.createElement("td");
                var tdROL=document.createElement("td");
                var tdFECHANAC=document.createElement("td");
                var tdEXAMHECHOS=document.createElement("td");
                var tdACC=document.createElement("td");

                tdUSUARIO.innerHTML=objJavascript[i].nombre+" "+objJavascript[i].apellidos;
                tdROL.innerHTML=objJavascript[i].rol;
                tdFECHANAC.innerHTML=objJavascript[i].fecha_nacimiento;
                tdEXAMHECHOS.innerHTML=objJavascript[i].exameneshechos;
                tdACC.appendChild(spanBorrar);
                tdACC.appendChild(spanEditar);
        
                tabla.appendChild(fila);
                fila.appendChild(tdUSUARIO);
                fila.appendChild(tdROL);
                fila.appendChild(tdFECHANAC);
                fila.appendChild(tdEXAMHECHOS);
                fila.appendChild(tdACC);
            }
        }


       
})