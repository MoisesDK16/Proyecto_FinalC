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


            <!-- Nuevo Inscripcion Modal -->
            <div class="modal fade" id="modalInscripcion" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva Inscripcion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_inscripciones">
                            <div class="modal-body">
                                <input type="hidden" name="InscripcionesId" id="InscripcionesId">

                                <div class="form-group">
                                    <label for="Estudiante">Estudiante</label>
                                    <input type="text" name="Estudiante" id="Estudiante" placeholder="Seleccione el Nombre del Estudiante" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Curso">Curso</label>
                                    <input type="text" name="Curso" id="Curso" placeholder="Seleccione el Curso del Estudiante" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="FechaInscripcion">Fecha Inscripcion</label>
                                    <input type="text" name="FechaInscripcion" id="FechaInscripcion" placeholder="Escriba la fecha de inscripcion" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Nuevo Inscripcion Modal -->

            <!-- Editar Inscripcion Modal -->
            <div class="modal fade" id="modalEditarInscripcion" tabindex="-1" aria-labelledby="editarInscripcionLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarInscripcionLabel">Editar Inscripcion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_editar_inscripciones">
                            <div class="modal-body">
                                <input type="hidden" name="EditarInscripcionesId" id="EditarInscripcionesId">

                                <div class="form-group">
                                    <label for="Estudiante">Estudiante</label>
                                    <input type="text" name="Estudiante" id="Estudiante" placeholder="Seleccione el Nombre del Estudiante" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="Curso">Curso</label>
                                    <input type="text" name="Curso" id="Curso" placeholder="Seleccione el Curso del Estudiante" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="FechaInscripcion">Fecha Inscripcion</label>
                                    <input type="text" name="FechaInscripcion" id="FechaInscripcion" placeholder="Escriba la fecha de inscripcion" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Editar Inscripcion Modal -->

            <!-- Lista de Inscripcion -->
            <div class='container-fluid pt-4 px-4'>
                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalInscripcion">
                    Nueva Inscripción
                </button>
                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <h6 class='mb-0'> Lista de Inscripciones</h6>
                    <table class="table table-bordered table-striped table-hover table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Estudiante</th>
                                <th>Curso</th>
                                <th>Fecha Inscripcion</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoinscripciones">
                            <!-- Aquí van los datos de los productos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin Lista de Inscripcion -->


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
    <script src="inscripcion.js"></script>

</body>

</html>