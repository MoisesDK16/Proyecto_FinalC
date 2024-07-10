<!DOCTYPE html>
<html lang='es'>

<head>
    <?php require_once('./html/head.php') ?>
    <link href='../public/lib/calendar/lib/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
    .custom-flatpickr {
        display: flex;
        align-items: center;
    }

    .custom-flatpickr input {
        margin-right: 5px;
        flex: 1;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class='container-xxl position-relative bg-white d-flex p-0'>
        <!-- Spinner Start -->
        <div id='spinner'
            class='show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center'>
            <div class='spinner-border text-primary' style='width: 3rem; height: 3rem;' role='status'>
                <span class='sr-only'>Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php') ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class='content'>
            <!-- Navbar Start -->
            <?php require_once('./html/header.php') ?>
            <!-- Navbar End -->


            <!-- Nuevo Profesor Modal -->
            <div class="modal fade" id="modalProfesor" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Profesor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_profesores">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="ProfesoresId">Indentificacion</label>
                                    <input type="text" name="ProfesoresId" id="ProfesoresId" placeholder="Inserte identificacion del Profesor" class="form-control" required>
                                </div>    

                                <div class="form-group">
                                    <label for="Nombre">Nombre</label>
                                    <input type="text" name="Nombre" id="Nombre" placeholder="Inserte el Nombre del Profesor" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Apellido">Apellido</label>
                                    <input type="text" name="Apellido" id="Apellido" placeholder="Inserte el Apellido del Profesor" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Departamento">Departamento</label>
                                    <input type="text" name="Departamento" id="Departamento" placeholder="Seleccione el Departamento del Profesor" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Nuevo Profesor Modal -->

            <!-- Editar Profesor Modal -->
            <div class="modal fade" id="modalEditarProfesor" tabindex="-1" aria-labelledby="editarProfesorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarProfesorLabel">Editar Profesor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_editar_profesores">
                            <div class="modal-body">
                                <input type="hidden" name="EditarProfesoresId" id="EditarProfesoresId">

                                <div class="form-group">
                                    <label for="Nombre">Nombre</label>
                                    <input type="text" name="EditarNombre" id="EditarNombre" placeholder="Inserte el Nombre del Profesor" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Departamento">Apellido</label>
                                    <input type="text" name="EditarApellido" id="EditarApellido" placeholder="Seleccione el Departamento del Profesor" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Departamento">Departamento</label>
                                    <input type="text" name="EditarDepartamento" id="EditarDepartamento" placeholder="Seleccione el Departamento del Profesor" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Editar Profesor Modal -->

            <!-- Lista de Profesor -->
            <div class='container-fluid pt-4 px-4'>
                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalProfesor">
                    Nuevo Profesor
                </button>
                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <h6 class='mb-0'> Lista de Profesores</h6>
                    <table class="table table-bordered table-striped table-hover table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>Indentificacion</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Departamento</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoprofesores">
                            <!-- Aquí van los datos de los productos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin Lista de Profesor -->


            <!-- Widgets Start -->
            <!-- Aquí podrías agregar widgets relacionados con productos si lo deseas -->
            <!-- Widgets End -->


            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href='#' class='btn btn-lg btn-primary btn-lg-square back-to-top'><i class='bi bi-arrow-up'></i></a>
    </div>


    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script src="profesor.js"></script>

</body>

</html>