// Inicialización
function init() {
    $("#frm_departamentos").on("submit", function (e) {
        guardaryeditar(e);
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
                            <button class="btn btn-primary" onclick="editar(${unDepartamento.id_departamento})">Editar</button>
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

// Guardar y editar departamento
var guardaryeditar = (e) => {
    e.preventDefault();

    var frm_departamentos = new FormData($("#frm_departamentos")[0]);

    var idDepartamentoEdit = $("#DepartamentoId").val();

    var ruta = "";
    if (idDepartamentoEdit != "") {
        // Actualizar
        ruta = "../controllers/departamento.controller.php?op=actualizar";
    } else {
        // Insertar
        ruta = "../controllers/departamento.controller.php?op=insertar";
    }

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_departamentos,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload(); // Recargar la página
            $("#modalDepartamento").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar o editar:", error);
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
                data: { id_departamento: DepartamentoId},
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    if (resultado === "Eliminado exitoso") {
                        Swal.fire({
                            title: "Departamento",
                            text: "Se eliminó con éxito",
                            icon: "success",
                        });
                        location.reload(); // Recargar la página
                    } else {
                        Swal.fire({
                            title: "Departamentos",
                            text: "No se pudo eliminar",
                            icon: "error",
                        });
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

// Editar departamento
var editar = (DepartamentoId) => {
    $.ajax({
        url: `../controllers/departamento.controller.php?op=uno&id=${DepartamentoId}`,
        type: "GET",
        success: function (data) {
            let departamento;
            try {
                departamento = JSON.parse(data);
            } catch (e) {
                console.error("Error parsing JSON:", e);
                return;
            }

            $("#DepartamentoId").val(departamento.id_departamento);
            $("#Nombre").val(departamento.nombre_departamento);
            // Mostrar el modal de edición
            $("#modalDepartamento").modal("show");
        },
        error: function () {
            Swal.fire({
                title: "Departamentos",
                text: "Ocurrió un error al intentar obtener los datos del departamento",
                icon: "error",
            });
        },
    });
};

init();