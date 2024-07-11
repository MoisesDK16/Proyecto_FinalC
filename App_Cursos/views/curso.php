<!DOCTYPE html>
<html lang='es'>

<head>
    <?php require_once('./html/head.php') ?>
    <link href='../public/lib/calendar/lib/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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


            <!-- Nuevo Curso Modal -->
            <div class="modal fade" id="modalCurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Curso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_cursos">
                            <div class="modal-body">
                                <input type="hidden" name="CursoId" id="CursoId">
                                <div class="form-group">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre_curso" id="nombre_curso"
                                        placeholder="Ingrese el nombre del Curso">
                                </div>
                                <div class="form-group">
                                    <label for="creditos" class="col-form-label">Créditos:</label>
                                    <input type="number" class="form-control" name="creditos" id="creditos"
                                        placeholder="Ingrese el Crédito del Curso">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" >Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Nuevo Curso Modal -->
            <div class="modal fade" id="modalCurso_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Curso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="frm_cursos_Edit">
                            <div class="modal-body">
                                <input type="hidden" name="EditCursoId" id="EditCursoId">
                                <div class="form-group">
                                    <label for="nombre" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" name="Editnombre" id="Editnombre"
                                        placeholder="Ingrese el nombre del Curso">
                                </div>
                                <div class="form-group">
                                    <label for="creditos" class="col-form-label">Créditos:</label>
                                    <input type="number" class="form-control" name="Editcreditos" id="Editcreditos"
                                        placeholder="Ingrese el Crédito del Curso">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="EditguardarCurso">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            

            <!-- Lista de Cursos -->
            <div class='container-fluid pt-4 px-4'>
                <button id="btnGuardarCurso" type="button" class="btn btn-success mb-5" data-bs-toggle="modal" data-bs-target="#modalCurso">
                    <i class="bi bi-bag-plus-fill mx-2"></i> Añadir Curso
                </button>
                
                <h6 style="text-align: center;" class='mb-3'> Lista de Cursos</h6>

                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <table class="table table-bordered table-striped table-hover table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Creditos</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpocursos">
                            <!-- Aquí van los datos de los cursos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin Lista de Cursos -->


            <!-- Widgets Start -->
            <!-- Aquí podrías agregar widgets relacionados con cursos si lo deseas -->
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
    <script src="curso.js"></script>

</body>

</html>