// Inicialización
function init() {
    $("#frm_clases").on("submit", function (e) {
        guardar(e);
    });

    $("#frm_editar_clase").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
    cargarCursos();
    cargarProfesores();
    cargarAulas();
    cargarHorarios();
});

// Cargar la tabla de clases
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/clase.controller.php?op=listar", (response) => {
        let listaClases;
        try {
            listaClases = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaClases)) {
            $.each(listaClases, (indice, unClase) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unClase.nombre_curso}</td>
                        <td>${unClase.id_profesor}</td>
                        <td>${unClase.nombre_profesor}</td>
                        <td>${unClase.apellido_profesor}</td>
                        <td>${unClase.numero_aula}</td>
                        <td>${unClase.horario}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarClase(${unClase.id_clase})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unClase.id_clase})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoclases").html(html);
        } else {
            console.error("Expected an array but got:", listaClases);
        }
    });
};


var cargarClase = (id_clase) => {
    $.get("../controllers/clase.controller.php?op=uno&id=" + id_clase, (data) => {
        var Clase = JSON.parse(data);
        console.log("Clase encontrada:", Clase);
        $("#EditarClaseId").val(Clase.id_clase);
        $("#EditarClaseCurso").val(Clase.nombre_curso);
        $("#EditarClaseProfesor").val(Clase.id_profesor);
        $("#EditarClaseAula").val(Clase.numero_aula);
        $("#EditarClaseHorario").val(Clase.horario);
        $("#modalEditarClase").modal("show");
    });
}

function cargarCursos() {
    $.get("../controllers/curso.controller.php?op=listarCursos", (response) => {
        let listaCursos = JSON.parse(response);
        let html = "<option value=''>Seleccione un Curso</option>";
        $.each(listaCursos, (index, curso) => {
            html += `<option value='${curso.nombre_curso}'>${curso.nombre_curso}</option>`;
        });
        $("#Curso").html(html);
        $("#EditarClaseCurso").html(html);
    });
}

function cargarProfesores(){
    $.get("../controllers/profesor.controller.php?op=listarComboProfesores", (response) => {
        let listaProfesores = JSON.parse(response);
        let html = "<option value=''>Seleccione un Profesor</option>";
        $.each(listaProfesores, (index, profesor) => {
            html += `<option value='${profesor.id_profesor}'>${profesor.id_profesor} - ${profesor.nombre_profesor} ${profesor.apellido_profesor}</option>`;
        });
        $("#ID_Profesor").html(html);
        $("#EditarClaseProfesor").html(html);
    });
}

function cargarAulas(){
    $.get("../controllers/aula.controller.php?op=listarComboAulas", (response) => {
        let listaAulas = JSON.parse(response);
        let html = "<option value=''>Seleccione un Aula</option>";
        $.each(listaAulas, (index, aula) => {
            html += `<option value='${aula.numero_aula}'>${aula.numero_aula}</option>`;
        });
        $("#Aula").html(html);
        $("#EditarClaseAula").html(html);
    });
}

function cargarHorarios(){
    let horarios = ["7:00 - 8:30",
         "8:45 - 10:15", 
         "10:30 - 12:00", 
         "12:15 - 13:45", 
         "14:00 - 15:30"];
    
    let html = "<option value=''>Seleccione un Horario</option>";
    $.each(horarios, (index, horario) => {
        html += `<option value='${horario}'>${horario}</option>`;
    });

    $("#Horario").html(html);
    $("#EditarClaseHorario").html(html);
}


var guardar = (e) => {
    
    e.preventDefault();

    var frm_clases= new FormData($("#frm_clases")[0]);
    console.log("Datos del formulario:", frm_clases);

    var ruta = "../controllers/clase.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_clases,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalClase").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
}


var editar = (e) => {
    e.preventDefault();

    var frm_editar_clase = new FormData($("#frm_editar_clase")[0]);
    var ruta = "../controllers/clase.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_clase,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#modalEditarClase").modal("hide");
            cargaTabla();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

// Eliminar una Clase
var eliminar = (ClasesId) => {
    Swal.fire({
        title: "Clase",
        text: "¿Está seguro que desea eliminar la Clase?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/clase.controller.php?op=eliminar",
                type: "POST",
                data: { id_clase: ClasesId },
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response === "Clase eliminado") {
                            Swal.fire({
                                title: "Clase",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Clase",
                            text: "No se pudo eliminar la clase debido a que ya está registrado en otra tabla",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Clase", 
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

init();