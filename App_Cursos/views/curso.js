function init() {
    $("#frm_cursos").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de cursos
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/curso.controller.php?op=listar", (response) => {
        let listaCursos;
        try {
            listaCursos = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaCursos)) {
            $.each(listaCursos, (indice, unCurso) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unCurso.nombre_curso}</td>
                        <td>${unCurso.creditos}</td>
                        <td>
                            <button class="btn btn-primary" onclick="editar(${unCurso.id_curso})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unCurso.id_curso})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpocursos").html(html);
        } else {
            console.error("Expected an array but got:", listaCursos);
        }
    });
};

// Guardar y editar curso
var guardaryeditar = (e) => {
    e.preventDefault(); 

    var frm_cursos = new FormData($("#frm_cursos")[0]);
    var CursoIdEdit = $("#CursoId").val();

    var ruta = "";
    if (CursoIdEdit != "") {
        // Actualizar
        ruta = "../controllers/curso.controller.php?op=actualizar";
    } else {
        // Insertar
        ruta = "../controllers/curso.controller.php?op=insertar";
    }

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_cursos,
        contentType: false,
        processData: false,
        
        success: function (datos) {
            console.log(datos);
            location.reload(); // Recargar la página
            $("#modalCurso").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar o editar:", error);
        }
    });
};

// Eliminar curso
var eliminar = (CursoId) => {
    Swal.fire({
        title: "Cursos",
        text: "¿Está seguro que desea eliminar el curso?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/curso.controller.php?op=eliminar",
                type: "POST",
                data: { id_curso: CursoId },
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    if (resultado === "Eliminado exitoso") {
                        Swal.fire({
                            title: "Curso",
                            text: "Se eliminó con éxito",
                            icon: "success",
                        });
                        location.reload(); // Recargar la página
                    } else {
                        Swal.fire({
                            title: "Cursos", 
                            text: "No se pudo eliminar",
                            icon: "error",
                        });
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Cursos", 
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

// Editar curso
var editar = (CursoId) => { 
    $.ajax({
        url: `../controllers/curso.controller.php?op=uno&id=${CursoId}`,
        type: "GET",
        success: function (data) {
            $("#CursoId").val(data.id_curso); 
            $("#nombre").val(data.nombre_curso); 
            $("#creditos").val(data.creditos);
            // Mostrar el modal de edición
            $("#modalCurso").modal("show");
        },
        error: function () {
            Swal.fire({
                title: "Cursos",
                text: "Ocurrió un error al intentar obtener los datos del curso",
                icon: "error",
            });
        },
    });
};

init();