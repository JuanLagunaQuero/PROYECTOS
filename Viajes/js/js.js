window.addEventListener("load", function () {

    var btnEntrar = document.getElementById("entrar");
    var txtUsuario = document.getElementById("usuario");
    var txtContrasena = document.getElementById("contrasena");

    btnEntrar.onclick = comprobarUsuario(txtUsuario, txtContrasena);

    var btnTutoriales = document.getElementById("tutoriales");

    btnTutoriales.onclick = muestraVideos;

    comprobarLogueado();

})

function muestraVideos() {
    var videos = document.getElementById("videos");
    videos.style.display = "block";

    document.getElementById("tutoriales").style.display = "none";

    var btnTutorialesNo = document.getElementById("tutorialesNo");

    btnTutorialesNo.onclick = ocultaVideos;


}

function ocultaVideos() {
    var videos = document.getElementById("videos");
    videos.style.display = "none";

    document.getElementById("tutoriales").style.display = "block";



}

function comprobarUsuario(txtUsuario, txtContrasena) {
    return function (ev) {
        ev.preventDefault();

        var datos = "usuario=" + txtUsuario.value + "&contrasena=" + txtContrasena.value;
        //AJAX
        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    procesarDatos(respuesta);
                }
                else {

                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxLogin.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(datos);
    }
}

function comprobarLogueado() {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.sucess) {
                procesarDatos(respuesta);
            }
        }
    }

    ajax.open("POST", "php/API/AjaxIniciado.php");
    ajax.send();
}

function cerrarSesion() {

    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.sucess) {
                //debugger;
                document.querySelector("header").innerHTML = "";
                document.querySelector("main").innerHTML = "";

                document.getElementById("usuario").value = "";
                document.getElementById("contrasena").value = "";
                document.getElementById("login").style.display = "block";

            }
        }
    }

    ajax.open("POST", "php/API/AjaxLogoff.php");
    ajax.send();
}

function traerPlantilla(url) {
    var ajax = new XMLHttpRequest();
    ajax.open("POST", url, false);
    ajax.send();
    var textoPlantilla = ajax.responseText;

    var div = document.createElement("div");

    div.innerHTML = textoPlantilla;

    return div.children[0];

}

function procesarDatos(respuesta) {

    if (respuesta.cambioContraseña) {
        formContraseñaNueva();
    }
    else {


        document.getElementById("login").style.display = "none";
        document.body.querySelector("footer").style.display = "grid";
        //console.log(respuesta.rol);

        if (respuesta.rol == "administrador") {
            var plantillaNav = traerPlantilla("plantillas/nav.html");
            copiaNav = plantillaNav.cloneNode(true);
            copiaNav.querySelector("#dropdownMenu").innerText = respuesta.user;

            document.body.querySelector("header").appendChild(copiaNav);

            var btnCerrar = document.getElementById("cerrar");
            btnCerrar.onclick = cerrarSesion;

            var btnCambioContraseña = document.getElementById("autoCambio");
            btnCambioContraseña.onclick = formcambiarContraseña;


            var divRes = document.createElement("div");
            divRes.style.margin = "2%";

            var btnRG = document.createElement("button");
            btnRG.innerHTML = "Resetear todas las contraseñas";
            btnRG.onclick = confirmaReseteoGordo;
            btnRG.style.float = "right";
            divRes.appendChild(btnRG);
            document.body.querySelector("main").appendChild(divRes);

            var datosP = respuesta.Profesores;

            for (let x = 0; x < datosP.length; x++) {
                var nombreCompleto = datosP[x]["nombre"] + " " + datosP[x]["apellidos"];
                var profesor = document.createElement("div");
                profesor.setAttribute("class", "profesor")
                var nombreprofesor = document.createElement("h5");
                nombreprofesor.setAttribute("class", "nombreprofesor")
                nombreprofesor.innerHTML = nombreCompleto;
                profesor.appendChild(nombreprofesor);
                console.log(respuesta.id_usuario)
                console.log(datosP[x]["id_usuario"])
                if (respuesta.id_usuario != datosP[x]["id_usuario"]) {
                    var reset = document.createElement("button");
                    reset.setAttribute("id", datosP[x]["id_usuario"]);
                    reset.setAttribute("class", "btnReseteo");
                    reset.innerHTML = "Resetear contraseña";
                    reset.onclick = confirmaReseteo(nombreCompleto, datosP[x]["id_usuario"]);
                    profesor.appendChild(reset);
                }



                var datos = datosP[x]["empresas"];
                //console.log(datos);

                var plantilla = traerPlantilla("plantillas/visitas.html");
                //console.log(plantilla);
                var divAux = document.createElement("div");
                divAux.appendChild(plantilla.querySelector("#visita table tbody tr"))
                var visita = divAux.children[0];

                divAux.appendChild(plantilla.querySelector("#alumnos"))
                var alumnos = divAux.children[1];

                divAux.appendChild(plantilla.querySelector("#detalleConvenio"))
                var detalleConvenio = divAux.children[2];

                divAux.appendChild(plantilla.querySelector("#convenio"))
                var plantillaConvenio = divAux.children[3];

                var Empresa = "";
                var Convenio = "";
                var Sede = "";
                var Alumno = "";

                for (let i = 0; i < datos.length; i++) {
                    if (datos[i].nombre_empresa != Empresa) {
                        Empresa = datos[i].nombre_empresa;
                        var copia = plantilla.cloneNode(true);
                        copia.querySelector(".nombreEmpresa").children[0].innerText = Empresa;
                        copia.querySelector(".nombreEmpresa").children[0].setAttribute("data-bs-target", "#convenio" + datos[i].id_empresa + datosP[x]["id_usuario"]);
                        copia.querySelector(".nombreEmpresa").children[0].setAttribute("aria-controls", "convenio" + datos[i].id_empresa + datosP[x]["id_usuario"]);
                        copia.style.marginBottom = 0;
                        Convenio = "";
                    }

                    if (datos[i].dconvenio != Convenio) {
                        Convenio = datos[i].dconvenio;
                        var copiaConvenio = plantillaConvenio.cloneNode(true);
                        copiaConvenio.querySelector(".descrConvenio").children[0].innerText = Convenio;
                        copiaConvenio.querySelector(".descrConvenio").children[0].setAttribute("data-bs-target", "#detalleConvenio" + datos[i].id_convenio + datosP[x]["id_usuario"]);
                        copiaConvenio.querySelector(".descrConvenio").children[0].setAttribute("aria-controls", "detalleConvenio" + datos[i].id_convenio + datosP[x]["id_usuario"]);
                        copiaConvenio.querySelector(".descrConvenio").parentNode.setAttribute("id", "convenio" + datos[i].id_empresa + datosP[x]["id_usuario"]);
                        copia.appendChild(copiaConvenio);
                        Sede = "";
                    }

                    if (datos[i].dsede != Sede) {
                        Sede = datos[i].dsede;
                        var copiaSede = detalleConvenio.cloneNode(true);
                        copiaSede.querySelector(".sede").children[0].innerText = Sede;
                        copiaSede.querySelector(".sede").children[0].setAttribute("data-bs-target", "#alumnos" + datos[i].id_sede + datosP[x]["id_usuario"]);
                        copiaSede.querySelector(".sede").children[0].setAttribute("aria-controls", "alumnos" + datos[i].id_sede + datosP[x]["id_usuario"]);
                        copiaSede.querySelector(".sede").parentNode.setAttribute("id", "detalleConvenio" + datos[i].id_convenio + datosP[x]["id_usuario"]);
                        copiaConvenio.appendChild(copiaSede);
                        Alumno = "";
                    }

                    if (datos[i].nombre_alumno != Alumno) {
                        Alumno = datos[i].nombre_alumno;
                        var copiaAlumnos = alumnos.cloneNode(true);
                        copiaAlumnos.querySelector(".nombreAlumno").children[0].innerText = Alumno;
                        copiaAlumnos.querySelector(".nombreAlumno").children[0].setAttribute("data-bs-target", "#visita" + datos[i].id_alumno_detalle_convenio + datosP[x]["id_usuario"]);
                        copiaAlumnos.querySelector(".nombreAlumno").children[0].setAttribute("aria-controls", "visita" + datos[i].id_alumno_detalle_convenio + datosP[x]["id_usuario"]);
                        copiaAlumnos.querySelector(".nombreAlumno").parentNode.setAttribute("id", "alumnos" + datos[i].id_sede + datosP[x]["id_usuario"]);
                        var checkAlumno = document.createElement("input");
                        checkAlumno.setAttribute("type", "checkbox")
                        checkAlumno.setAttribute("id", datos[i].id_alumno_detalle_convenio)
                        checkAlumno.addEventListener("change", validaRevisado);
                        if (datos[i].revisado == 1)
                            {
                                checkAlumno.checked= true;
                            }
                        copiaAlumnos.querySelector(".nombreAlumno").after(checkAlumno);
                        copiaSede.appendChild(copiaAlumnos);
                    }

                    var tbody = copiaAlumnos.querySelector("#visita table tbody");
                    if (datos[i].visitas.length > 0) {
                        for (let j = 0; j < datos[i].visitas.length; j++) {
                            var copiaVisita = visita.cloneNode(true);
                            tbody.appendChild(copiaVisita);
                            var inputs = copiaVisita.querySelectorAll("input");
                            var buttons = copiaVisita.querySelectorAll("button");
                            inputs[0].value = datos[i].visitas[j].fecha_inicio;
                            inputs[1].value = datos[i].visitas[j].hora_inicio;
                            inputs[2].value = datos[i].visitas[j].fecha_fin;
                            inputs[3].value = datos[i].visitas[j].hora_fin;
                            buttons[0].onclick = programarGuardar(datos[i].visitas[j].id_visita);
                            buttons[1].onclick = programarBorrar(datos[i].visitas[j].id_visita);
                            var check = document.createElement("input");
                            check.setAttribute("type", "checkbox")
                            check.setAttribute("name", datos[i].id_alumno_detalle_convenio);
                            check.setAttribute("id", datos[i].visitas[j].id_visita)
                            check.addEventListener("change", validaDieta);
                            if (datos[i].visitas[j].dieta == 1)
                            {
                                check.checked= true;
                            }
                            buttons[0].parentElement.appendChild(check);
                            copiaVisita.parentElement.parentElement.parentElement.setAttribute("id", "visita" + datos[i].id_alumno_detalle_convenio + datosP[x]["id_usuario"]);

                        }
                    }
                    var copiaVisita = visita.cloneNode(true);
                    tbody.appendChild(copiaVisita);
                    copiaVisita.parentElement.parentElement.parentElement.setAttribute("id", "visita" + datos[i].id_alumno_detalle_convenio + datosP[x]["id_usuario"]);
                    var buttons = copiaVisita.querySelectorAll("button");
                    buttons[0].innerText = "Añadir";
                    buttons[0].onclick = programarInsertar(datos[i].id_alumno_detalle_convenio, visita);
                    buttons[1].parentNode.removeChild(buttons[1]);

                    profesor.appendChild(copia);

                }
                document.body.querySelector("main").appendChild(profesor);
            }

            ponerBonico();
            document.body.querySelector("main").setAttribute("class", "min-vh-65");

        }
        else {
            var plantillaNav = traerPlantilla("plantillas/nav.html");
            copiaNav = plantillaNav.cloneNode(true);
            copiaNav.querySelector("#dropdownMenu").innerText = respuesta.user;

            //copiaNav.querySelector("#inicio").style.display = "none";

            document.body.querySelector("header").appendChild(copiaNav);

            var btnCerrar = document.getElementById("cerrar");
            btnCerrar.onclick = cerrarSesion;

            var btnCambioContraseña = document.getElementById("autoCambio");
            btnCambioContraseña.onclick = formcambiarContraseña;

            var datos = respuesta.Empresas;

            var plantilla = traerPlantilla("plantillas/visitas.html");
            //console.log(plantilla);
            var divAux = document.createElement("div");
            divAux.appendChild(plantilla.querySelector("#visita table tbody tr"))
            var visita = divAux.children[0];

            divAux.appendChild(plantilla.querySelector("#alumnos"))
            var alumnos = divAux.children[1];

            divAux.appendChild(plantilla.querySelector("#detalleConvenio"))
            var detalleConvenio = divAux.children[2];

            divAux.appendChild(plantilla.querySelector("#convenio"))
            var plantillaConvenio = divAux.children[3];

            var Empresa = "";
            var Convenio = "";
            var Sede = "";
            var Alumno = "";

            for (let i = 0; i < datos.length; i++) {
                if (datos[i].nombre_empresa != Empresa) {
                    Empresa = datos[i].nombre_empresa;
                    var copia = plantilla.cloneNode(true);
                    copia.querySelector(".nombreEmpresa").children[0].innerText = Empresa;
                    copia.querySelector(".nombreEmpresa").children[0].setAttribute("data-bs-target", "#convenio" + datos[i].id_empresa);
                    copia.querySelector(".nombreEmpresa").children[0].setAttribute("aria-controls", "convenio" + datos[i].id_empresa);
                    Convenio = "";
                }

                if (datos[i].dconvenio != Convenio) {
                    Convenio = datos[i].dconvenio;
                    var copiaConvenio = plantillaConvenio.cloneNode(true);
                    copiaConvenio.querySelector(".descrConvenio").children[0].innerText = Convenio;
                    copiaConvenio.querySelector(".descrConvenio").children[0].setAttribute("data-bs-target", "#detalleConvenio" + datos[i].id_convenio);
                    copiaConvenio.querySelector(".descrConvenio").children[0].setAttribute("aria-controls", "detalleConvenio" + datos[i].id_convenio);
                    copiaConvenio.querySelector(".descrConvenio").parentNode.setAttribute("id", "convenio" + datos[i].id_empresa);
                    copia.appendChild(copiaConvenio);
                    Sede = "";
                }

                if (datos[i].dsede != Sede) {
                    Sede = datos[i].dsede;
                    var copiaSede = detalleConvenio.cloneNode(true);
                    copiaSede.querySelector(".sede").children[0].innerText = Sede;
                    copiaSede.querySelector(".sede").children[0].setAttribute("data-bs-target", "#alumnos" + datos[i].id_sede);
                    copiaSede.querySelector(".sede").children[0].setAttribute("aria-controls", "alumnos" + datos[i].id_sede);
                    copiaSede.querySelector(".sede").parentNode.setAttribute("id", "detalleConvenio" + datos[i].id_convenio);
                    copiaConvenio.appendChild(copiaSede);
                    Alumno = "";
                }

                if (datos[i].nombre_alumno != Alumno) {
                    Alumno = datos[i].nombre_alumno;
                    var copiaAlumnos = alumnos.cloneNode(true);
                    copiaAlumnos.querySelector(".nombreAlumno").children[0].innerText = Alumno;
                    copiaAlumnos.querySelector(".nombreAlumno").children[0].setAttribute("data-bs-target", "#visita" + datos[i].id_alumno_detalle_convenio);
                    copiaAlumnos.querySelector(".nombreAlumno").children[0].setAttribute("aria-controls", "visita" + datos[i].id_alumno_detalle_convenio);
                    copiaAlumnos.querySelector(".nombreAlumno").parentNode.setAttribute("id", "alumnos" + datos[i].id_sede);
                    copiaSede.appendChild(copiaAlumnos);
                }

                var tbody = copiaAlumnos.querySelector("#visita table tbody");
                if (datos[i].visitas.length > 0) {
                    for (let j = 0; j < datos[i].visitas.length; j++) {
                        var copiaVisita = visita.cloneNode(true);
                        tbody.appendChild(copiaVisita);
                        var inputs = copiaVisita.querySelectorAll("input");
                        var buttons = copiaVisita.querySelectorAll("button");
                        inputs[0].value = datos[i].visitas[j].fecha_inicio;
                        inputs[1].value = datos[i].visitas[j].hora_inicio;
                        inputs[2].value = datos[i].visitas[j].fecha_fin;
                        inputs[3].value = datos[i].visitas[j].hora_fin;
                        buttons[0].onclick = programarGuardar(datos[i].visitas[j].id_visita);
                        buttons[1].onclick = programarBorrar(datos[i].visitas[j].id_visita);
                        copiaVisita.parentElement.parentElement.parentElement.setAttribute("id", "visita" + datos[i].id_alumno_detalle_convenio);

                    }
                }
                var copiaVisita = visita.cloneNode(true);
                tbody.appendChild(copiaVisita);
                copiaVisita.parentElement.parentElement.parentElement.setAttribute("id", "visita" + datos[i].id_alumno_detalle_convenio);
                var buttons = copiaVisita.querySelectorAll("button");
                buttons[0].innerText = "Añadir";
                buttons[0].onclick = programarInsertar(datos[i].id_alumno_detalle_convenio);
                buttons[1].parentNode.removeChild(buttons[1]);
                document.body.querySelector("main").appendChild(copia);
                document.body.querySelector("main").setAttribute("class", "min-vh-65")
            }
        }
    }
}

function programarInsertar(id_alumno, pvisita) {
    return function (ev) {
        ev.preventDefault();
        var inputs = this.parentElement.parentElement.querySelectorAll("input");
        var visita = "id_alumno_detalle_convenio=" + id_alumno + "&fecha_inicio=" + inputs[0].value + "&hora_inicio=" + inputs[1].value + "&fecha_fin=" + inputs[2].value + "&hora_fin=" + inputs[3].value;
        var fila = this.parentElement.parentElement;
        
        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {

                    debugger;
                    var tbody = fila.parentElement;

                    var clon = pvisita.cloneNode(true);
                    var buttons = clon.querySelectorAll("button");

                    var inputsclon = clon.querySelectorAll("input");

                    for (let i = 0; i < 4; i++) {
                        inputsclon[i].value = inputs[i].value;
                        inputs[i].value = "";
                    }

                    buttons[0].onclick = programarGuardar(respuesta.id_visita);
                    buttons[1].onclick = programarBorrar(respuesta.id_visita);
                    tbody.insertBefore(clon, fila);

                }
                else {
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxInsertar.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(visita);
    }
}

function programarBorrar(id_visita) {
    return function (ev) {
        ev.preventDefault();
        borrar = "id_visita=" + id_visita;
        var fila = this.parentElement.parentElement;

        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    //comprobarLogueado();
                    fila.parentElement.removeChild(fila);
                } else {
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxBorrar.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(borrar);
    }
}

function programarGuardar(id_visita) {
    return function (ev) {
        ev.preventDefault();
        //alert("guarda valores en " + id_visita)
        var inputs = this.parentElement.parentElement.querySelectorAll("input");
        var span = this.parentElement.querySelectorAll("span");

        var visita = "id_visita=" + id_visita + "&fecha_inicio=" + inputs[0].value + "&hora_inicio=" + inputs[1].value + "&fecha_fin=" + inputs[2].value + "&hora_fin=" + inputs[3].value;

        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    span[0].style.display = "block";
                }
                else {
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxEditar.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(visita);
    }
}

function validaDieta()
{
    if (this.checked)
    {
        añadeDieta(this.id, this.name);
    }
    else
    {
        quitaDieta(this.id);
    }
}

function añadeDieta(id_visita, id_alumno) {

        var datos = "id_visita=" + id_visita + "&id_alumno_detalle_convenio=" + id_alumno;
        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    //span[0].style.display = "block";
                }
                else {
                    document.getElementById(id_visita).checked = false;
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxDieta.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(datos);
    }

    function quitaDieta(id_visita) {

        var datos = "id_visita="+ id_visita;
        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    document.getElementById(id_visita).checked = false;
                }
                else {
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxQuitaDieta.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(datos);
    }

    function validaRevisado()
    {
        if (this.checked)
        {
            alumnoRevisado(this.id);
        }
        else
        {
            alumnoNoRevisado(this.id);
        }
    }
    
    function alumnoRevisado(id_alumno) {

        var datos = "id_alumno_detalle_convenio=" + id_alumno;
        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    //span[0].style.display = "block";
                }
                else {
                    document.getElementById(id_visita).checked = false;
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxAlumnoRevisado.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(datos);
    }

    function alumnoNoRevisado(id_alumno) {

        var datos = "id_alumno_detalle_convenio=" + id_alumno;

        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.sucess) {
                    document.getElementById(id_visita).checked = false;
                }
                else {
                    alert(respuesta.error);
                }
            }
        }

        ajax.open("POST", "php/API/AjaxAlumnoNoRevisado.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(datos);
    }

function ponerBonico() {
    var collapses = document.getElementsByClassName("collapse");
    for (let i = 0; i < collapses.length; i++)
        collapses[i].classList.add("show")

    var h = document.querySelectorAll(" h1, .collapse h2, .collapse h3")

    for (let i = 0; i < h.length; i++) h[i].style.display = "none"
}

function confirmaReseteo(nombre, id_usuario) {
    return function (ev) {
        ev.preventDefault();

        if (confirm("Va a resetear la contraseña del profesor " + nombre + "\n¿Estás seguro?")) {

            resetearContraseña(id_usuario);
        }

    }
}

function resetearContraseña(id_usuario) {

    var usuario = "id_usuario=" + id_usuario;

    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.sucess) {
                //comprobarLogueado();
                alert("reset" + id_usuario)
            }
        }
    }

    ajax.open("POST", "php/API/AjaxReset.php");
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(usuario);


}

function confirmaReseteoGordo(ev) {
    ev.preventDefault();

    if (confirm("Vas a resetear todas las contraseñas \n¿Estás seguro?")) {

        reseteoTotal();
    }

}

function reseteoTotal() {

    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.sucess) {
                //comprobarLogueado();
                alert("reset" + id_usuario)
            }
        }
    }

    ajax.open("POST", "php/API/AjaxReset.php");
    ajax.send();

}

function formContraseñaNueva() {
    document.getElementById("usuario").value = "";
    document.getElementById("contrasena").value = "";
    var cc = document.querySelector(".cnuevas");
    cc.style.display = "block";

    var btnEntrar = document.getElementById("entrar");

    btnEntrar.onclick = cambioContraseña;

}

function cambioContraseña(ev) {

    ev.preventDefault();
    var txtUsuario = document.getElementById("usuario");
    var txtContrasena = document.getElementById("contrasena");
    var txtContrasenaNueva = document.getElementById("contrasenaNueva");
    var txtContrasenaNueva1 = document.getElementById("contrasenaNueva1");

    if (txtContrasenaNueva.value != "" || txtContrasenaNueva1.value != "") {
        if (txtContrasenaNueva.value == txtContrasenaNueva1.value) {

            var datos = "usuario=" + txtUsuario.value + "&contrasena=" + txtContrasena.value + "&contrasenaNueva=" + txtContrasenaNueva.value;

            var ajax = new XMLHttpRequest();

            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var respuesta = JSON.parse(this.responseText);
                    if (respuesta.sucess) {
                        document.getElementById("usuario").value = "";
                        document.getElementById("contrasena").value = "";
                        var cc = document.querySelector(".cnuevas");
                        cc.style.display = "none";
                        var btnEntrar = document.getElementById("entrar");

                        btnEntrar.onclick = comprobarUsuario(document.getElementById("usuario"), document.getElementById("contrasena"));
                    }
                }
            }

            ajax.open("POST", "php/API/AjaxCambioContraseña.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(datos);
        }
        else {
            alert("Las nuevas contraseñas deben ser iguales");
        }
    } else {
        alert("Introduzca la nueva contraseña");

    }
}


function formcambiarContraseña(ev) {

    ev.preventDefault();
    document.querySelector("header").innerHTML = "";
    document.querySelector("main").innerHTML = "";

    document.getElementById("usuario").value = "";
    document.getElementById("contrasena").value = "";
    var cc = document.querySelector(".cnuevas");
    cc.style.display = "block";

    var btnEntrar = document.getElementById("entrar");

    btnEntrar.onclick = cambiarContraseña;

    document.getElementById("login").style.display = "block";
}


function cambiarContraseña(ev) {

    ev.preventDefault();
    var txtUsuario = document.getElementById("usuario");
    var txtContrasena = document.getElementById("contrasena");
    var txtContrasenaNueva = document.getElementById("contrasenaNueva");
    var txtContrasenaNueva1 = document.getElementById("contrasenaNueva1");

    if (txtContrasenaNueva.value != "" || txtContrasenaNueva1.value != "") {
        if (txtContrasenaNueva.value == txtContrasenaNueva1.value) {

            var datos = "usuario=" + txtUsuario.value + "&contrasena=" + txtContrasena.value + "&contrasenaNueva=" + txtContrasenaNueva.value;

            var ajax = new XMLHttpRequest();

            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var respuesta = JSON.parse(this.responseText);
                    if (respuesta.sucess) {
                        var cc = document.querySelector(".cnuevas");
                        cc.style.display = "none";
                        debugger;
                        cerrarSesion();
                    }
                }
            }

            ajax.open("POST", "php/API/AjaxCambioContraseña.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(datos);
        }
        else {
            alert("Las nuevas contraseñas deben ser iguales");
        }
    } else {
        alert("Introduzca la nueva contraseña");

    }
}