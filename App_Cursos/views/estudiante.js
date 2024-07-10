// Inicialización
function init() {
    $("#frm_estudiantes").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de estudiantes
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/estudiante.controller.php?op=listar", (response) => {
        let listaEstudiantes;
        try {
            listaEstudiantes = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaEstudiantes)) {
            $.each(listaEstudiantes, (indice, unEstudiante) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unEstudiante.nombre}</td>
                        <td>${unEstudiante.apellido}</td>
                        <td>${unEstudiante.fecha_nacimiento}</td>
                        <td>
                            <button class="btn btn-primary" onclick="editar(${unEstudiante.id_estudiante})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unEstudiante.id_estudiante})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoestudiantes").html(html);
        } else {
            console.error("Expected an array but got:", listaEstudiantes);
        }
    });
};