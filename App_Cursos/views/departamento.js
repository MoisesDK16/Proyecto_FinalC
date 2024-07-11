// Inicialización
function init() {
    $("#frm_departamentos").on("submit", function (e) {
        guardarDepartamento(e);
    });

    $("#frm_editar_departamento").on("submit", function (e) {
        editarDepartamento(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de departamentos
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/departamento.controller.php?op=listar", (response) => {
        let listaDepartamentos;
        try {
            listaDepartamentos = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaDepartamentos)) {
            $.each(listaDepartamentos, (indice, unDepartamento) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unDepartamento.nombre_departamento}</td>
                        <td>
                            <button class="btn btn-primary" onclick="cargarDepartamento(${unDepartamento.id_departamento})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unDepartamento.id_departamento})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpodepartamentos").html(html);
        } else {
            console.error("Expected an array but got:", listaDepartamentos);
        }
    });
};

// var cargarDepartamento = (id) => {
//     $.get("../controllers/departamento.controller.php?op=uno&id=" + id, (Departamento) => {
//         console.log(Departamento);
//         $("#EditarDepartamentoId").val(Departamento.id_departamento);
//         $("#EditarNombre").val(Departamento.nombre_departamento);
//         $("#modalEditarDepartamento").modal("show");
//     });
// };

var cargarDepartamento = (id_departamento) => {
    console.log("ID del departamento:", id_departamento);
    $.get("../controllers/departamento.controller.php?op=uno&id=" + id_departamento, (data) => {
        var Departamento = JSON.parse(data); 
        console.log("Departamento encontrado:", Departamento);
        $("#EditarDepartamentoId").val(Departamento.id_departamento);
        $("#EditarNombre").val(Departamento.nombre_departamento);
        $("#modalEditarDepartamento").modal("show");
    }).fail(function() {
        Swal.fire({
            title: "Departamento",
            text: "Ocurrió un error al intentar obtener los datos del Departamento",
            icon: "error",
        });
    });
};

// Función para Guardar un Departamento
var guardarDepartamento = (e) => {
    e.preventDefault();

    var frm_departamentos = new FormData($("#frm_departamentos")[0]);
    frm_departamentos.delete("DepartamentoId");

    var ruta = "../controllers/departamento.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_departamentos,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalDepartamento").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
};

// Eliminar departamento
var eliminar = (DepartamentoId) => {
    Swal.fire({
        title: "Departamentos",
        text: "¿Está seguro que desea eliminar el departamento?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/departamento.controller.php?op=eliminar",
                type: "POST",
                data: { id_departamento: DepartamentoId },
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response.message === "Eliminado correctamente") {
                            Swal.fire({
                                title: "Departamento",
                                text: "Se eliminó con éxito",
                                icon: "success",
                            });
                            cargaTabla();
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Departamentos",
                            text: "No se pudo eliminar el departamento debido a que ya está registrado en otra tabla",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Departamentos",
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

// Función para Editar un Departamento
var editarDepartamento = (e) => {
    e.preventDefault();

    var frm_editar_departamento = new FormData($("#frm_editar_departamento")[0]);
    console.log("Datos del formulario:", frm_editar_departamento);
    var ruta = "../controllers/departamento.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_departamento,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalEditarDepartamento").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

init();