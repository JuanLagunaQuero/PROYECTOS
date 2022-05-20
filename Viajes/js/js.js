window.addEventListener("load", function () {

    var btnEntrar = document.getElementById("entrar");
    var txtUsuario = document.getElementById("usuario");
    var txtContrasena = document.getElementById("contrasena");

    btnEntrar.onclick = comprobarUsuario(txtUsuario, txtContrasena);

    comprobarLogueado();

})

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

        ajax.open("POST", "php/ajax/AjaxLogin.php");
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

    ajax.open("POST", "php/ajax/AjaxIniciado.php");
    ajax.send();
}

function cerrarSesion() {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.sucess) {
                document.getElementById("x").style.display = "none";
                var divEmpresas = document.getElementsByClassName("empresa");
                let tamano = divEmpresas.length;
                for (let i = 0; i < tamano; i++) {
                    divEmpresas[0].parentNode.removeChild(divEmpresas[0]);
                }
                document.getElementById("login").style.display = "block";

            }
        }
    }

    ajax.open("GET", "php/ajax/AjaxLogoff.php");
    ajax.send();
}

function traerPlantilla(url) {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", url, false);
    ajax.send();
    var textoPlantilla = ajax.responseText;

    var div = document.createElement("div");

    div.innerHTML = textoPlantilla;

    return div.children[0];

}

function procesarDatos(respuesta) {
    document.getElementById("login").style.display = "none";
    var datos = respuesta.Empresas;
    console.log(datos);

    var plantillaNav = traerPlantilla("plantillas/nav.html");

    document.body.appendChild(plantillaNav);
    var btnCerrar = document.getElementById("cerrar");
    btnCerrar.onclick = cerrarSesion;

    var plantilla = traerPlantilla("plantillas/visitas.html");
    //console.log(plantilla);
    var divAux = document.createElement("div");
    divAux.appendChild(plantilla.querySelector("#visita"))
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

        if (datos[i].visitas.length > 0) {
            for (let j = 0; j < datos[i].visitas.length; j++) {
                var copiaVisita = visita.cloneNode(true);
                copiaAlumnos.appendChild(copiaVisita);
                var inputs = copiaVisita.querySelectorAll("input");
                var buttons = copiaVisita.querySelectorAll("button");
                inputs[0].value = datos[i].visitas[j].fecha_inicio;
                inputs[1].value = datos[i].visitas[j].hora_inicio;
                inputs[2].value = datos[i].visitas[j].fecha_fin;
                inputs[3].value = datos[i].visitas[j].hora_fin;
                buttons[0].onclick= programarGuardar(datos[i].visitas[j].id_visita);
                buttons[1].onclick= programarBorrar(datos[i].visitas[j].id_visita);
                copiaVisita.setAttribute("id", "visita" + datos[i].id_alumno_detalle_convenio);

            }
        }
        var copiaVisita = visita.cloneNode(true);
        copiaAlumnos.appendChild(copiaVisita);
        copiaVisita.setAttribute("id", "visita" + datos[i].id_alumno_detalle_convenio);
        var buttons = copiaVisita.querySelectorAll("button");
        buttons[0].innerText="Añadir";
        buttons[0].onclick= programarInsertar(datos[i].id_alumno_detalle_convenio);
        buttons[1].parentNode.removeChild(buttons[1]);
        document.body.appendChild(copia);
    }

}

function programarInsertar(id_alumno)
{
    return function(ev)
    {
        ev.preventDefault();
        var inputs = this.parentElement.parentElement.querySelectorAll("input");
        console.log(this);
        alert ("Insertar valores en " +id_alumno + inputs[0].value + "," +inputs[1].value + "."+ inputs[2].value +"."+ inputs[3].value)
    }
}

function programarBorrar(id_visita)
{
    return function(ev)
    {
        ev.preventDefault();
        alert ("bor valores en " +id_visita)
    }
}

function programarGuardar(id_visita)
{
    return function(ev)
    {
        ev.preventDefault();
        alert ("guarda valores en " +id_visita)
    }
}