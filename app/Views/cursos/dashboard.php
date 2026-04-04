<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Ritmos</h3>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card border shadow enlace" data-bs-toggle="modal" data-bs-target="#registro_curso" onclick="VaciarFormCurso()">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2">
                                <i class="iconly-boldWork"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                            <h4 class="text-muted font-semibold">
                                Registrar Ritmo
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card border shadow enlace" data-bs-toggle="modal" data-bs-target="#registro_paquete" onclick="VaciarFormPaquete()">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldWallet"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                            <h4 class="text-muted font-semibold">
                                Registrar Paquete
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card border shadow enlace" data-bs-toggle="modal" data-bs-target="#registro_promocion" onclick="VaciarFormPromocion()">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                            <div class="stats-icon red mb-2">
                                <i class="iconly-boldDiscount"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                            <h4 class="text-muted font-semibold">
                                Registrar Promoción
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <nav class="mb-3">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav_lista_curso" data-bs-toggle="tab" data-bs-target="#nav_cursos" type="button" role="tab" aria-controls="nav_cursos" aria-selected="true">Listado de Ritmos</button>
                                        <button class="nav-link" id="nav_lista_paquetes" data-bs-toggle="tab" data-bs-target="#nav_paquetes" type="button" role="tab" aria-controls="nav_paquetes" aria-selected="false">Listado de Paquetes</button>
                                        <button class="nav-link" id="nav_lista_promociones" data-bs-toggle="tab" data-bs-target="#nav_promociones" type="button" role="tab" aria-controls="nav_promociones" aria-selected="false">Listado de Promociones</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav_cursos" role="tabpanel" aria-labelledby="nav_lista_curso">
                                        <?php if (isset($cursos) && count($cursos) > 0) : ?>
                                            <div class="table-responsive-lg">
                                                <table class="table" id="cursos">
                                                    <thead>
                                                        <tr>
                                                            <th>Ritmo</th>
                                                            <th>Instructor</th>
                                                            <th>Horario</th>
                                                            <th>Días</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($cursos as $curso) : ?>
                                                            <tr>
                                                                <td><?php echo $curso["curso_nombre"] ?></td>
                                                                <td><?php echo $curso["nombre_instructor"] ?></td>
                                                                <td><?php echo $curso["horario_ini"] . " - " . $curso["horario_fin"] ?></td>
                                                                <td><?php echo $curso["dias"] ?></td>
                                                                <td class="d-xxl-flex justify-content-around">
                                                                    <a data-bs-toggle="modal" data-bs-target="#registro_curso" onclick="EditarCurso('<?php echo $curso['curso_id'] ?>')" class="text-primary enlace">
                                                                        <i class="bi bi-pen-fill"></i>
                                                                        <span class="d-none d-lg-inline">
                                                                            <small>
                                                                                Editar Ritmo
                                                                            </small>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else : ?>
                                            <div class="alert alert-primary" role="alert">
                                                <p>
                                                    <i class="bi bi-info-circle-fill"></i>
                                                    Aún no contamos con cursos registrados
                                                </p>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="tab-pane fade" id="nav_paquetes" role="tabpanel" aria-labelledby="nav_lista_paquetes">
                                        <?php if (isset($paquetes) && count($paquetes) > 0) : ?>
                                            <div class="table-responsive-lg">
                                                <table class="table" id="lista_paquetes">
                                                    <thead>
                                                        <tr>
                                                            <th>Paquete</th>
                                                            <th>Cantidad de Clases</th>
                                                            <th>Precio</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($paquetes as $paquete) : ?>
                                                            <tr>
                                                                <td><?php echo $paquete["paquete_nombre"] ?></td>
                                                                <td><?php echo $paquete["paquete_cantidad_clases"] ?></td>
                                                                <td><?php echo $paquete["paquete_precio"] ?></td>
                                                                <td class="d-xxl-flex justify-content-around">
                                                                    <a data-bs-toggle="modal" data-bs-target="#registro_paquete" onclick="EditarPaquete('<?php echo $paquete['paquete_id'] ?>')" class="text-primary enlace">
                                                                        <i class="bi bi-pen-fill"></i>
                                                                        <span class="d-none d-lg-inline">
                                                                            <small>
                                                                                Editar Paquete
                                                                            </small>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else : ?>
                                            <div class="alert alert-primary" role="alert">
                                                <p>
                                                    <i class="bi bi-info-circle-fill"></i>
                                                    Aún no contamos con paquetes registrados
                                                </p>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="tab-pane fade" id="nav_promociones" role="tabpanel" aria-labelledby="nav_lista_promociones">
                                        <?php if (isset($promociones) && count($promociones) > 0) : ?>
                                            <div class="table-responsive-lg">
                                                <table class="table" id="lista_promocion">
                                                    <thead>
                                                        <tr>
                                                            <th>Promoción</th>
                                                            <th>Cantidad de Clases</th>
                                                            <th>Precio</th>
                                                            <th>Vigencia - Inicio</th>
                                                            <th>Vigencia - Fin</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($promociones as $promocion) : ?>
                                                            <tr class="<?php echo $promocion["promocion_activo"] == 0 ? "table-warning" : "" ?>">
                                                                <td><?php echo $promocion["promocion_nombre"] ?></td>
                                                                <td><?php echo $promocion["promocion_clases"] ?></td>
                                                                <td><?php echo $promocion["promocion_precio"] ?> Bs.</td>
                                                                <td><?php echo $promocion["promocion_inicio"] ?></td>
                                                                <td><?php echo $promocion["promocion_fin"] ?></td>
                                                                <td class="d-xxl-flex justify-content-around">
                                                                    <a data-bs-toggle="modal" data-bs-target="#registro_promocion" onclick="EditarPromocion('<?php echo $promocion['promocion_id'] ?>')" class="text-primary enlace">
                                                                        <i class="bi bi-pen-fill"></i>
                                                                        <span class="d-none d-lg-inline">
                                                                            <small>
                                                                                Editar Promoción
                                                                            </small>
                                                                        </span>
                                                                    </a>

                                                                    <br>

                                                                    <?php if ($promocion["promocion_activo"] == 1) : ?>
                                                                        <a onclick="InactivarPromocion('<?php echo $promocion['promocion_id'] ?>')" class="text-warning enlace">
                                                                            <i class="bi bi-x-circle-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Inactivar Promoción
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                    <?php else :  ?>
                                                                        <a onclick="ReactivarPromocion('<?php echo $promocion['promocion_id'] ?>')" class="text-success enlace">
                                                                            <i class="bi bi-check-circle-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Reactivar Promoción
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                    <?php endif ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else : ?>
                                            <div class="alert alert-primary" role="alert">
                                                <p>
                                                    <i class="bi bi-info-circle-fill"></i>
                                                    Aún no contamos con promociones registrados
                                                </p>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<!-- Modal Registro Curso -->
<div class="modal fade text-left" id="registro_curso">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo_registro_curso">
                    Registro de Nuevo Ritmo
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="form_registro_curso">
                <input type="hidden" name="curso_id" id="curso_edit_id" value="">
                <div class="modal-body">
                    <h6>Nombre del Ritmo: </h6>
                    <div class="form-group">
                        <input type="text" placeholder="Nombre del Ritmo" class="form-control" name="curso" id="curso" required>
                    </div>

                    <h6>Seleccione el instructor para asignar</h6>
                    <?php if (isset($instructores) && count($instructores) > 0) : ?>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="instructor">Instructor</label>
                            <select class="form-select" id="instructor" name="instructor">
                                <option selected disabled>Seleccione...</option>
                                <?php foreach ($instructores as $instructor) : ?>
                                    <option value="<?php echo $instructor["usuario_id"] ?>"><?php echo $instructor["nombre_completo"] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-3"></i>
                            <p>
                                Aun no existen usuarios con el Rol de Instructor registrado
                            </p>
                        </div>
                    <?php endif ?>

                    <h6>Seleccione el horario</h6>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="inicio">Inicio</label>
                            <input type='time' id="inicio" name="inicio" class="form-control" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fin">Fin</label>
                            <input type="time" id="fin" name="fin" class="form-control" required />
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6>Días de la Semana</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="1" id="1">
                                    <label class="form-check-label" for="1">
                                        Lunes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="2" id="2">
                                    <label class="form-check-label" for="2">
                                        Martes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="3" id="3">
                                    <label class="form-check-label" for="3">
                                        Miercoles
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="4" id="4">
                                    <label class="form-check-label" for="4">
                                        Jueves
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="5" id="5">
                                    <label class="form-check-label" for="5">
                                        Viernes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="6" id="6">
                                    <label class="form-check-label" for="6">
                                        Sábado
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="semana[]" type="checkbox" value="7" id="7">
                                    <label class="form-check-label" for="7">
                                        Domingo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                    Cancelar
                </button>
                <button type="button" onclick="RegistrarCurso()" class="btn btn-primary ml-1">
                    <i class="bx bx-check"></i>
                    Registrar
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Registro Paquete -->
<div class="modal fade text-left" id="registro_paquete">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo_registro_paquete">
                    Registro de Paquete
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i data-feather="x"></i>
                </button>
            </div>

            <form id="form_registro_paquete">
                <input type="hidden" name="paquete_id" id="paquete_id" value="">
                <div class="modal-body">
                    <h6>Nombre del Paquete: </h6>
                    <div class="form-group">
                        <input type="text" id="paquete_nombre" placeholder="Nombre del paquete" class="form-control" name="paquete" required>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <h6>Cantidad de Clases: </h6>
                            <div class="form-group">
                                <input type="text" id="paquete_cnt_clases" placeholder="Cantidad de Clases" class="form-control" name="cantidad_clases" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <h6>Precio: </h6>
                            <div class="form-group">
                                <input type="text" id="paquete_precio" placeholder="Precio del paquete" class="form-control" name="paquete_precio" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" onclick="RegistrarPaquete()" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registro Promocion -->
<div class="modal fade text-left" id="registro_promocion">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo_registro_promocion">
                    Registro de Promoción
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i data-feather="x"></i>
                </button>
            </div>

            <form id="form_registro_promocion">
                <input type="hidden" name="promocion_id" id="promocion_id" value="">
                <div class="modal-body">
                    <h6>Nombre de la Promoción: </h6>
                    <div class="form-group">
                        <input type="text" id="promocion_nombre" placeholder="Nombre de la promocion" class="form-control" name="promocion" required>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <h6>Cantidad de Clases: </h6>
                            <div class="form-group">
                                <input type="text" id="promocion_cnt_clases" placeholder="Cantidad de Clases" class="form-control" name="cantidad_clases" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <h6>Precio: </h6>
                            <div class="form-group">
                                <input type="text" id="promocion_precio" placeholder="Precio de la promocion" class="form-control" name="promocion_precio" required>
                            </div>
                        </div>
                    </div>

                    <h6>Vigencia de la promoción</h6>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>Fecha de inicio: </label>
                            <div class="form-group">
                                <input type="date" id="promo_ini" class="form-control" name="promo_ini" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>Fecha de finalización: </label>
                            <div class="form-group">
                                <input type="date" id="promo_fin" class="form-control" name="promo_fin" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" onclick="RegistrarPromocion()" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cursos').DataTable({
            language: lang
        });
        $('#lista_paquetes').DataTable({
            language: lang
        });
        $('#lista_promocion').DataTable({
            language: lang
        });
    });
</script>
<script>
    function VaciarFormPaquete() {
        $("#paquete_id").val("");
        $("#form_registro_paquete").trigger("reset")
        $("#titulo_registro_paquete").html("Registro de Nuevo Paquete")
    }

    function VaciarFormCurso() {
        $("#curso_edit_id").val("");
        $("#form_registro_curso").trigger("reset")
        $("#titulo_registro_curso").html("Registro de Nuevo Ritmo")
    }

    function VaciarFormPromocion() {
        $("#promocion_id").val("");
        $("#form_registro_promocion").trigger("reset")
        $("#titulo_registro_promocion").html("Registro de Nueva Promoción")
    }

    function RegistrarCurso() {
        const form_values = $("#form_registro_curso").serialize()

        if ($("#curso").val() == "" || $("#inicio").val() == "" || $("#fin").val() == "" || $("#instructor").val() == null) {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
            })
            return;
        }


        var checkboxes = document.getElementsByName("semana[]");
        var alMenosUnSeleccionado = false;

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                alMenosUnSeleccionado = true;
                break;
            }
        }

        if (alMenosUnSeleccionado) {
            $.ajax({
                type: "POST",
                url: "Gestion-Cursos/Registro/Curso",
                data: form_values,
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        icon: response.icono,
                        text: response.mensaje,
                    }).then(() => {
                        location.reload();
                    })
                }
            });
        } else {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe marcar al menos un dia para el ritmo."
            })
        }

    }

    function EditarCurso(curso_id) {
        $("#curso_edit_id").val(curso_id);
        $("#titulo_registro_curso").html("Edición de Ritmo")

        var checkboxes = document.getElementsByName("semana[]");

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }

        $.ajax({
            type: "POST",
            url: "Gestion-Cursos/Recuperar/Curso",
            data: {
                curso_id: curso_id
            },
            dataType: "json",
            success: function(response) {

                if (response.error == 1) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: response.data,
                        on_ok: function() {
                            $("#registro_curso").modal("hide")
                        }
                    })
                    return;
                }

                $("#curso").val(response.data.curso_nombre);
                $("#sel_paquete").val(response.data.paquete_id);
                $("#instructor").val(response.data.instructor_id);
                $("#inicio").val(response.data.horario_ini);
                $("#fin").val(response.data.horario_fin);
                var curso_dias = response.data.curso_dias.split(",")
                curso_dias.forEach(function(dia) {
                    var item = document.querySelector("[id='" + dia + "']")
                    if (item) {
                        item.checked = true
                    }
                })

            }
        });
    }

    function RegistrarPaquete() {
        const form_values = $("#form_registro_paquete").serialize()

        if ($("#paquete_nombre").val() == "" || !validarNumero($("#paquete_cnt_clases").val()) || !validarNumero($("#paquete_precio").val())) {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
            })
            return;
        }


        $.ajax({
            type: "POST",
            url: "Gestion-Cursos/Registro/Paquete",
            data: form_values,
            dataType: "json",
            success: function(response) {
                Swal.fire({
                    icon: response.icono,
                    text: response.mensaje,
                }).then(() => {
                    location.reload();
                })
            }
        });
    }

    function EditarPaquete(paquete_id) {
        $("#paquete_id").val(paquete_id);
        $("#titulo_registro_paquete").html("Edición de Paquete")

        $.ajax({
            type: "POST",
            url: "Gestion-Cursos/Recuperar/Paquete",
            data: {
                paquete_id: paquete_id,
                tipo: "regulares"
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 1) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: response.data,
                        on_ok: function() {
                            $("#registro_paquete").modal("hide")
                        }
                    })
                    return;
                }

                $("#paquete_nombre").val(response.data.paquete_nombre);
                $("#paquete_cnt_clases").val(response.data.paquete_cantidad_clases);
                $("#paquete_precio").val(response.data.paquete_precio);
            }
        });
    }

    function EliminarPaquete(paquete_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de eliminar definitivamente este paquete, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Cursos/Eliminar/Paquete",
                    data: {
                        paquete_id: paquete_id
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: response.icono,
                            text: response.mensaje,
                        }).then(() => {
                            location.reload();
                        })
                    }
                });
            }
        })
    }

    function RegistrarPromocion() {
        const form_values = $("#form_registro_promocion").serialize()

        if ($("#promocion_nombre").val() == "" || $("#promo_ini").val() == "" || $("#promo_fin").val() == "" || !validarNumero($("#promocion_cnt_clases").val()) || !validarNumero($("#promocion_precio").val())) {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
            })
            return;
        }

        if ($("#promo_ini").val() > $("#promo_fin").val()) {
            alert_clone({
                tipo: "alert",
                mensaje: "La fecha de finalización no puede ser mayor a la fecha de inicio."
            })
            return;
        }

        $.ajax({
            type: "POST",
            url: "Gestion-Cursos/Registro/Promocion",
            data: form_values,
            dataType: "json",
            success: function(response) {
                Swal.fire({
                    icon: response.icono,
                    text: response.mensaje,
                }).then(() => {
                    location.reload();
                })
            }
        });
    }

    function EditarPromocion(promocion_id) {
        $("#promocion_id").val(promocion_id);
        $("#titulo_registro_paquete").html("Edición de Promoción")

        $.ajax({
            type: "POST",
            url: "Gestion-Cursos/Recuperar/Promocion",
            data: {
                promocion_id: promocion_id
            },
            dataType: "json",
            success: function(response) {

                if (response.error == 1) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: response.data,
                        on_ok: function() {
                            $("#registro_promocion").modal("hide")
                        }
                    })
                    return;
                }

                $("#promocion_nombre").val(response.data.promocion_nombre);
                $("#promocion_cnt_clases").val(response.data.promocion_clases);
                $("#promocion_precio").val(response.data.promocion_precio);
                $("#promo_ini").val(response.data.promocion_inicio);
                $("#promo_fin").val(response.data.promocion_fin);
            }
        });
    }

    function ReactivarPromocion(promocion_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de reactivar esta promoción, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Cursos/Editar/Promocion",
                    data: {
                        promocion_id: promocion_id,
                        estado: 1
                    },
                    dataType: "json",
                    success: function(response) {

                        if (response.error == 1) {
                            alert_clone({
                                tipo: "alert",
                                mensaje: response.data
                            })
                            return;
                        }


                        Swal.fire({
                            icon: response.icono,
                            text: response.mensaje,
                        }).then(() => {
                            location.reload();
                        })
                    }
                });
            }
        })
    }

    function InactivarPromocion(promocion_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de inactivar esta promoción, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Cursos/Editar/Promocion",
                    data: {
                        promocion_id: promocion_id,
                        estado: 0
                    },
                    dataType: "json",
                    success: function(response) {

                        if (response.error == 1) {
                            alert_clone({
                                tipo: "alert",
                                mensaje: response.data
                            })
                            return;
                        }

                        Swal.fire({
                            icon: response.icono,
                            text: response.mensaje,
                        }).then(() => {
                            location.reload();
                        })
                    }
                });
            }
        })
    }
</script>