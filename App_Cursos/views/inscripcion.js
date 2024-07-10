// Inicialización
function init() {
    $("#frm_inscripciones").on("submit", function (e) {
        guardarInscripcion(e);
    });

    $("#frm_editar_inscripciones").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de estudiantes
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/inscripcion.controller.php?op=listar", (response) => {
        let listaInscripciones;
        try {
            listaInscripciones = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaInscripciones)) {
            $.each(listaInscripciones, (indice, unInscripcion) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unInscripcion.id_estudiante}</td>
                        <td>${unInscripcion.nombre}</td>
                        <td>${unInscripcion.apellido}</td>
                        <td>${unInscripcion.nombre_curso}</td>
                        <td>${unInscripcion.fecha_inscripcion}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarInscripcion(${unInscripcion.id_inscripcion})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unInscripcion.id_inscripcion})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoinscripciones").html(html);
        } else {
            console.error("Expected an array but got:", listaInscripciones);
        }
    });
};


var cargarInscripcion = (id) => {
    $.get("../controllers/inscripcion.controller.php?op=uno&id=" + id, (data) => {
        var Inscripcion = JSON.parse(data);
        console.log("ID de la inscripción:", id);
        console.log("Datos de la inscripción:", Inscripcion);

        $("#EditarInscripcionesId").val(Inscripcion.id_inscripcion);
        $("#EditarCedula_Estudiante").val(Inscripcion.id_estudiante);
        $("#EditarNombre").val(Inscripcion.nombre);
        $("#EditarApellido").val(Inscripcion.apellido);
        $("#EditarCurso").val(Inscripcion.nombre_curso);
        $("#EditarFechaInscripcion").val(Inscripcion.fecha_inscripcion);
        $("#modalEditarInscripcion").modal("show");
    }).fail(function() {
        Swal.fire({
            title: "Inscripción",
            text: "Ocurrió un error al intentar obtener los datos de la inscripción",
            icon: "error",
        });
    });
}


var guardarInscripcion = (e) =>{
    e.preventDefault();
    var frm_inscripciones = new FormData($("#frm_inscripciones")[0]);
    var ruta = "../controllers/inscripcion.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_inscripciones,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalInscripcion").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
    
}

var editar = (e) => {
    e.preventDefault();

    var frm_editar_inscripciones = new FormData($("#frm_editar_inscripciones")[0]);
    var ruta = "../controllers/inscripcion.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_inscripciones,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarInscripcion").modal("hide");
            cargaTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

init();
