// Inicialización
function init() {
    $("#frm_profesores").on("submit", function (e) {
        guardarProfesor(e);
    });
    $("#frm_editar_profesores").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de profesores
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/profesor.controller.php?op=listar", (response) => {
        let listaProfesores;
        try {
            listaProfesores = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaProfesores)) {
            $.each(listaProfesores, (indice, unProfesor) => {
                html += `
                    <tr>
                        <td>${unProfesor.id_profesor}</td>
                        <td>${unProfesor.nombre_profesor}</td>
                        <td>${unProfesor.apellido_profesor}</td>
                        <td>${unProfesor.nombre_departamento}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarProfesor(${unProfesor.id_profesor})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unProfesor.id_profesor})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoprofesores").html(html);
        } else {
            console.error("Expected an array but got:", listaProfesores);
        }
    });
}



var cargarProfesor = (id_profesor) =>{
    console.log(id_profesor);
    $.get("../controllers/profesor.controller.php?op=uno&id="+ id_profesor, (data) => {
        var Profesor = JSON.parse(data);
        console.log("Clase encontrada:", Profesor);

        $("#EditarProfesoresId").val(Profesor.id_profesor);
        $("#EditarNombre").val(Profesor.nombre_profesor);
        $("#EditarApellido").val(Profesor.apellido_profesor);
        $("#EditarDepartamento").val(Profesor.nombre_departamento);
        $("#modalEditarProfesor").modal("show");
    });
}

var guardarProfesor = (e) => {
    e.preventDefault();
    var frm_profesores= new FormData($("#frm_profesores")[0]);
    var ruta = "../controllers/profesor.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_profesores,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalProfesor").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });

}


var editar = (e) => {
    e.preventDefault();

    var frm_editar_profesores = new FormData($("#frm_editar_profesores")[0]);
    var ruta = "../controllers/profesor.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_profesores,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarProfesor").modal("hide");
            cargaTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};
init();