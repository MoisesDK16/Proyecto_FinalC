// Inicialización
function init() {
    $("#frm_clases").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
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
                        <td>${unClase.nombre_departamento}</td>
                        <td>${unClase.numero_aula}</td>
                        <td>${unClase.horario}</td>
                        <td>
                            <button class="btn btn-primary" onclick="editar(${unClase.id_clase})">Editar</button>
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