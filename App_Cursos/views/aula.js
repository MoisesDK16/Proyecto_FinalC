// Inicialización
function init() {
    $("#frm_aulas").on("submit", function (e) {
        guardarAula(e);
    });

    $("#frm_editar_aula").on("submit", function (e) {
        editar(e);
    });

}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de estudiantes
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/aula.controller.php?op=listar", (response) => {
        let listaAulas;
        try {
            listaAulas = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaAulas)) {
            $.each(listaAulas, (indice, unAula) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unAula.numero_aula}</td>
                        <td>${unAula.capacidad}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarAula(${unAula.id_aula})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unAula.id_aula})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoaulas").html(html);
        } else {
            console.error("Expected an array but got:", listaAulas);
        }
    });
};

var cargarAula = (id_aula) => {
    $("#modalEditarAula").modal("show");

    $.get("../controllers/aula.controller.php?op=uno&id=" + id_aula, (data) => {
        var Aula = JSON.parse(data);
        console.log("Aula encontrado:", Aula);
        $("#EditarAulaId").val(Aula.id_aula);
        $("#NumAulaE").val(Aula.numero_aula);
        $("#CapacidadE").val(Aula.capacidad);
    });
};

var guardarAula = (e) => {
    e.preventDefault();

    var frm_aulas = new FormData($("#frm_aulas")[0]);
    console.log("Datos del formulario:", frm_aulas);
    
    var ruta = "../controllers/aula.controller.php?op=insertar";
    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_aulas,
        contentType: false,
        processData: false,

        success: function (datos) {
            console.log(datos);
            $("#modalAula").modal("hide");
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        },
    });
};

var editar = (e) => {
    e.preventDefault();
    var frm_editar_aula = new FormData($("#frm_editar_aula")[0]);
    console.log("Datos del formulario:", frm_editar_aula);
    var ruta = "../controllers/aula.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_aula,
        contentType: false,
        processData: false,

        success: function (datos) {
            console.log(datos);
            $("#modalEditarAula").modal("hide");
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        },
    });
};

var eliminar = (AulasId) => {
    Swal.fire({
        title: "Aulas",
        text: "¿Está seguro que desea eliminar el Aula?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/aula.controller.php?op=eliminar",
                type: "POST",
                data: { id_aula: AulasId },
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response.message === "Error al eliminar aula") {
                            Swal.fire({
                                title: "Aulas",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Aulas",
                            text: "No se pudo eliminar el aula debido a que ya está en uso en CLASES",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Aulas",
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                },
            });
        }
    });
};

init();