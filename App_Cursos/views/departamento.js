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

    $.get("../controllers/departamento.controller.php?op=listar", (listaDepartamentos) => {
        console.log(listaDepartamentos);
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
    });
};