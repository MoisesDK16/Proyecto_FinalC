function init() {
    $("#frm_cursos").on("submit", function (e) {
        guardarCurso(e);
    });
    $("#frm_cursos_Edit").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});


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
                            <button class="btn btn-primary" onclick="cargarCurso(${unCurso.id_curso})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarCurso(${unCurso.id_curso})">Eliminar</button>
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


var cargarCurso = (id_curso) => {
    console.log("ID del curso:", id_curso);
    $.get("../controllers/curso.controller.php?op=uno&id=" + id_curso, (data) => {
        var Curso = JSON.parse(data); 
        console.log("Curso encontrado:", Curso);
        $("#EditCursoId").val(Curso.id_curso);
        $("#Editnombre").val(Curso.nombre_curso);
        $("#Editcreditos").val(Curso.creditos);
        $("#modalCurso_Edit").modal("show"); 
    }).fail(function() {
        Swal.fire({
            title: "Cursos",
            text: "Ocurrió un error al intentar obtener los datos del curso",
            icon: "error",
        });
    });
};

var guardarCurso = (e) => {
    e.preventDefault(); 

    var frm_cursos = new FormData($("#frm_cursos")[0]);
    console.log("Datos del formulario:", frm_cursos);

    var ruta = "../controllers/curso.controller.php?op=insertar";
    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_cursos,
        contentType: false,
        processData: false,
        
        success: function (datos) {
            console.log(datos);
            $("#modalCurso").modal("hide");
            location.reload(); // Recargar la página después de ocultar el modal
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar el curso:", error);
        }
    });
};

var eliminarCurso = (CursoId) => {
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
                    try {
                        let response = JSON.parse(resultado);
                        if (response === "Eliminado correctamente") {
                            Swal.fire({
                                title: "Cursos",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();   
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Cursos",
                            text: "No se pudo eliminar el curso debido a que ya está registrado en otra tabla",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
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

var editar = (e) => {
    e.preventDefault();
    var frm_cursos_Edit = new FormData($("#frm_cursos_Edit")[0]);
    console.log("Datos del formulario:", frm_cursos_Edit);
    var ruta = "../controllers/curso.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_cursos_Edit,
        processData: false,
        contentType: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalCurso_Edit").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        },
    });
};


init();