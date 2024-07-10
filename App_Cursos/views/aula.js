// Inicialización
function init() {
    $("#frm_aulas").on("submit", function (e) {
        guardaryeditar(e);
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
                            <button class="btn btn-primary" onclick="editar(${unAula.id_aula})">Editar</button>
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