// Inicialización
function init() {
    $("#frm_profesores").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de profesores
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/profesor.controller.php?op=listar", (response) => {
        let listaProfesores;
        try {
            listaProfesores = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaProfesores)) {
            $.each(listaProfesores, (indice, unProfesor) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unProfesor.nombre_profesor}</td>
                        <td>${unProfesor.apellido_profesor}</td>
                        <td>${unProfesor.nombre_departamento}</td>
                        <td>
                            <button class="btn btn-primary" onclick="editar(${unProfesor.id_profesor})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminar(${unProfesor.id_profesor})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoprofesores").html(html);
        } else {
            console.error("Expected an array but got:", listaProfesores);
        }
    });
};