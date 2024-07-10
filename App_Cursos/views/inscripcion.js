// Inicialización
function init() {
    $("#frm_inscripciones").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de estudiantes
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/inscripcion.controller.php?op=listar", (response) => {
        let listaInscripciones;
        try {
            listaInscripciones = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaInscripciones)) {
            $.each(listaInscripciones, (indice, unInscripcion) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unInscripcion.nombre}</td>
                        <td>${unInscripcion.nombre_curso}</td>
                        <td>${unInscripcion.fecha_inscripcion}</td>
                        <td>
                            <button class="btn btn-primary" onclick="editar(${unInscripcion.id_inscripcion})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unInscripcion.id_inscripcion})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoinscripciones").html(html);
        } else {
            console.error("Expected an array but got:", listaInscripciones);
        }
    });
};