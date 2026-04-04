<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Gestion de Personal</h3>
    </div>
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <div class="card border shadow enlace" data-bs-toggle="modal" data-bs-target="#registro_form">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2">
                                <i class="iconly-boldAdd-User"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                            <h4 class="text-muted font-semibold">
                                Registrar Personal
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
                            <div class="card-header">
                                <h4>Listado Personal</h4>
                            </div>
                            <div class="card-body">
                                <nav class="mb-4">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-general-tab" data-bs-toggle="tab" data-bs-target="#nav-general" type="button" role="tab" aria-controls="nav-general" aria-selected="true">General</button>
                                        <button class="nav-link" id="nav-instructores-tab" data-bs-toggle="tab" data-bs-target="#nav-instructores" type="button" role="tab" aria-controls="nav-instructores" aria-selected="false">Instructores</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                                        <div class="table-responsive-lg">
                                            <?php if (isset($lista_personal) && count($lista_personal) > 0) : ?>
                                                <table class="table" id="lista_personal">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre Completo</th>
                                                            <th>CI</th>
                                                            <th>Dirección</th>
                                                            <th>Teléfono</th>
                                                            <th>Email</th>
                                                            <th>Rol</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($lista_personal as $personal) : ?>
                                                            <tr class="<?php echo $personal["activo"] == 0 ? "table-warning" : "" ?>">
                                                                <td><?php echo $personal["nombre_completo"] ?></td>
                                                                <td><?php echo $personal["ci"] ?></td>
                                                                <td><?php echo $personal["direccion"] ?></td>
                                                                <td><?php echo $personal["telefono"] ?></td>
                                                                <td><?php echo $personal["email"] ?></td>
                                                                <td>
                                                                    <span class="badge bg-success">
                                                                        <?php echo $personal["rol_nombre"] ?>
                                                                    </span>
                                                                </td>
                                                                <td class="d-xxl-flex justify-content-around">
                                                                    <?php if ($personal["activo"] == 1) : ?>
                                                                        <span class="text-primary me-2 enlace" data-bs-toggle="modal" data-bs-target="#editar_form" onclick="EditarPersonal('<?php echo $personal['usuario_id'] ?>')">
                                                                            <i class="bi bi-pen-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Editar
                                                                                </small>
                                                                            </span>
                                                                        </span>
                                                                        <br>
                                                                    <?php endif ?>
                                                                    <?php if ($personal["activo"] == 1) : ?>
                                                                        <a onclick="InactivarPersonal('<?php echo $personal['usuario_id'] ?>')" class="text-warning enlace">
                                                                            <i class="bi bi-x-circle-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Inactivar
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                    <?php else : ?>
                                                                        <a onclick="ReactivarPersonal('<?php echo $personal['usuario_id'] ?>')" class="text-success enlace">
                                                                            <i class="bi bi-check-circle-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Reactivar
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                    <?php endif ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            <?php else : ?>
                                                <div class="alert alert-primary" role="alert">
                                                    <p>
                                                        <i class="bi bi-info-circle-fill"></i>
                                                        Aún no contamos con personal registrado
                                                    </p>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-instructores" role="tabpanel" aria-labelledby="nav-instructores-tab">
                                        <div class="table-responsive-lg">
                                            <?php if (isset($instructores) && count($instructores) > 0) : ?>
                                                <table class="table" id="lista_instructores">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre Completo</th>
                                                            <th>CI</th>
                                                            <th>Dirección</th>
                                                            <th>Teléfono</th>
                                                            <th>Email</th>
                                                            <th>Rol</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($instructores as $personal) : ?>
                                                            <tr class="<?php echo $personal["activo"] == 0 ? "table-warning" : "" ?>">
                                                                <td><?php echo $personal["nombre_completo"] ?></td>
                                                                <td><?php echo $personal["ci"] ?></td>
                                                                <td><?php echo $personal["direccion"] ?></td>
                                                                <td><?php echo $personal["telefono"] ?></td>
                                                                <td><?php echo $personal["email"] ?></td>
                                                                <td>
                                                                    <span class="badge bg-success">
                                                                        <?php echo $personal["rol_nombre"] ?>
                                                                    </span>
                                                                </td>
                                                                <td class="d-xxl-flex justify-content-around">
                                                                    <?php if ($personal["activo"] == 1) : ?>
                                                                        <span class="text-success me-2 enlace" data-bs-toggle="modal" data-bs-target="#detalle_curso" onclick="DetalleCursos('<?php echo $personal['usuario_id'] ?>')">
                                                                            <i class="bi bi-three-dots-vertical"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Detalle Ritmos
                                                                                </small>
                                                                            </span>
                                                                        </span>
                                                                        <br>
                                                                        <span class="text-primary me-2 enlace" data-bs-toggle="modal" data-bs-target="#editar_form" onclick="EditarPersonal('<?php echo $personal['usuario_id'] ?>')">
                                                                            <i class="bi bi-pen-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Editar
                                                                                </small>
                                                                            </span>
                                                                        </span>
                                                                        <br>
                                                                    <?php endif ?>
                                                                    <?php if ($personal["activo"] == 1) : ?>
                                                                        <a onclick="InactivarPersonal('<?php echo $personal['usuario_id'] ?>')" class="text-warning enlace">
                                                                            <i class="bi bi-x-circle-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Inactivar
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                    <?php else : ?>
                                                                        <a onclick="ReactivarPersonal('<?php echo $personal['usuario_id'] ?>')" class="text-success enlace">
                                                                            <i class="bi bi-check-circle-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Reactivar
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                        <a onclick="EliminarPersonal('<?php echo $personal['usuario_id'] ?>')" class="text-danger enlace">
                                                                            <i class="bi bi-trash-fill"></i>
                                                                            <span class="d-none d-lg-inline">
                                                                                <small>
                                                                                    Eliminar
                                                                                </small>
                                                                            </span>
                                                                        </a>
                                                                    <?php endif ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            <?php else : ?>
                                                <div class="alert alert-primary" role="alert">
                                                    <p>
                                                        <i class="bi bi-info-circle-fill"></i>
                                                        Aún no contamos con instructores registrados.
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
            </div>
        </section>
    </div>
</div>

<!-- Modal Edicion -->
<div class="modal fade text-left" id="editar_form">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Editar Personal
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <?php

            $form_attr = [
                "method" => "POST",
                "id" => "form_editar"
            ];

            echo form_open("/Gestion-Personal/Editar", $form_attr);


            ?>
            <div class="modal-body">
                <input type="hidden" id="usuario_id" name="usuario_id" value="">
                <div>

                    <label>Nombre(s): </label>
                    <div class="form-group">
                        <input type="text" id="nombre" placeholder="Nombre(s)" class="form-control" name="nombre" required>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>Apellido Paterno: </label>
                            <div class="form-group">
                                <input type="text" id="app" placeholder="Apellido Paterno" class="form-control" name="app" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>Apellido Materno: </label>
                            <div class="form-group">
                                <input type="text" id="apm" placeholder="Apellido Materno" class="form-control" name="apm" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>CI: </label>
                            <div class="form-group">
                                <input type="text" id="ci" placeholder="Carnet de Identidad" class="form-control" name="ci" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>Email: </label>
                            <div class="form-group">
                                <input type="text" id="email" placeholder="Correo Electrónico" class="form-control" name="email" required>
                            </div>
                        </div>
                    </div>

                    <label>Dirección: </label>
                    <div class="form-group">
                        <input type="text" id="direccion" placeholder="Dirección" class="form-control" name="direccion" required>
                    </div>

                    <label>Teléfono: </label>
                    <div class="form-group">
                        <input type="text" id="telefono" placeholder="Teléfono" class="form-control" name="telefono" required>
                    </div>

                    <h6>Seleccione el Rol</h6>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="rol">Rol</label>
                        <select id="rol" class="form-select" id="rol" name="rol">
                            <option selected disabled>Seleccione...</option>
                            <option value="1">Gerente General</option>
                            <option value="2">Administrador</option>
                            <option value="3">Operador</option>
                            <option value="4">Instructor</option>
                        </select>
                    </div>

                    <h6>Seleccione Sucursal(es)</h6>
                    <p class="d-flex align-items-center">
                        <small><i class="bi bi-check-square"></i></small>
                        <small class="enlace" onclick="ToggleCheck()">Marcar/Desmarcar</small>
                    </p>
                    <div class="row mb-3">
                        <?php if (isset($sucursales) && count($sucursales) > 0) : ?>
                            <?php foreach ($sucursales as $value) : ?>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" name="sucursal_usuario[]" type="checkbox" value="<?php echo $value["sucursal_id"] ?>" id="ssucursal_<?php echo $value["sucursal_id"] ?>">
                                        <label class="form-check-label" for="ssucursal_<?php echo $value["sucursal_id"] ?>">
                                            <?php echo $value["sucursal_nombre"] ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else : ?>
                            <div class="alert alert-primary" role="alert">
                                <p>
                                    <i class="bi bi-info-circle-fill"></i>
                                    Aún no contamos con sucursales registradas.
                                </p>
                            </div>
                        <?php endif ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button class="btn btn-primary ml-1" id="editar_registro">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Guardar</span>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal Registro -->
<div class="modal fade text-left" id="registro_form">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="myModalLabel33">
                    Registro de Nuevo Personal
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i data-feather="x"></i>
                </button>
            </div>
            <?php

            $form_attr = [
                "method" => "POST",
                "id" => "form_registro"
            ];

            echo form_open("/Gestion-Personal/Registro", $form_attr);


            ?>
            <div class="modal-body">
                <label>Nombre(s): </label>
                <div class="form-group">
                    <input type="text" placeholder="Nombre(s)" class="form-control" name="nombre" required>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label>Apellido Paterno: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Apellido Paterno" class="form-control" name="app" required>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label>Apellido Materno: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Apellido Materno" class="form-control" name="apm" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label>CI: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Carnet de Identidad" class="form-control" name="ci" required>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label>Email: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Correo Electrónico" class="form-control" name="email" required>
                        </div>
                    </div>
                </div>

                <label>Dirección: </label>
                <div class="form-group">
                    <input type="text" placeholder="Dirección" class="form-control" name="direccion" required>
                </div>

                <label>Teléfono: </label>
                <div class="form-group">
                    <input type="text" placeholder="Teléfono" class="form-control" name="telefono" required>
                </div>

                <h6>Seleccione el Rol</h6>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="rol">Rol</label>
                    <select class="form-select" id="rol" name="rol">
                        <option value="" selected disabled>Seleccione...</option>
                        <option value="1">Gerente General</option>
                        <option value="2">Administrador</option>
                        <option value="3">Operador</option>
                        <option value="4">Instructor</option>
                    </select>
                </div>

                <h6>Seleccione Sucursal(es)</h6>
                <p class="d-flex align-items-center">
                    <small><i class="bi bi-check-square"></i></small>
                    <small class="enlace" onclick="ToggleCheck()">Marcar/Desmarcar</small>
                </p>
                <div class="row mb-3">
                    <?php if (isset($sucursales) && count($sucursales) > 0) : ?>
                        <?php foreach ($sucursales as $value) : ?>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="sucursal_usuario[]" type="checkbox" value="<?php echo $value["sucursal_id"] ?>" id="sucursal_<?php echo $value["sucursal_id"] ?>">
                                    <label class="form-check-label" for="sucursal_<?php echo $value["sucursal_id"] ?>">
                                        <?php echo $value["sucursal_nombre"] ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="alert alert-primary" role="alert">
                            <p>
                                <i class="bi bi-info-circle-fill"></i>
                                Aún no contamos con sucursales registradas.
                            </p>
                        </div>
                    <?php endif ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button id="enviar_registro" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="detalle_curso">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Ritmos Asignados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table" id="cursos">
                    <thead>
                        <tr>
                            <th>Ritmo</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Días</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_cursos">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#lista_personal').DataTable({
            dom: "Bfrtip",
            language: lang,
            buttons: [{
                extend: "pdfHtml5",
                text: "Exportar PDF",
                title: "Reporte Generado",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, {
                        column: 6,
                        visible: false
                    }],
                    modifier: {
                        page: "all",
                    },
                    format: {
                        body: function(data, row, column, node) {
                            // Formato personalizado para los datos del cuerpo de la tabla
                            return data.replace(/<.*?>/g, ''); // Elimina las etiquetas HTML de los datos
                        }
                    }
                },
            }, {
                extend: "excel",
                text: "Exportar Excel",
                title: "Reporte Generado",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, {
                        column: 6,
                        visible: false
                    }],
                    modifier: {
                        page: "all",
                    },
                    format: {
                        body: function(data, row, column, node) {
                            // Formato personalizado para los datos del cuerpo de la tabla
                            return data.replace(/<.*?>/g, ''); // Elimina las etiquetas HTML de los datos
                        }
                    }
                },
            }, ],
        });
        $('#lista_instructores').DataTable({
            language: lang
        });
    });

    function ToggleCheck() {
        alternarTodosCheckboxes('sucursal_usuario[]');
    }

    function alternarTodosCheckboxes(nombre) {
        var checkboxes = $('input[type="checkbox"][name="' + nombre + '"]');
        var todosMarcados = checkboxes.length === checkboxes.filter(':checked').length;

        checkboxes.prop('checked', !todosMarcados);
    }

    <?php if (session()->getFlashdata('notificacion') !== NULL) : ?>
        Swal.fire({
            icon: '<?php echo session()->getFlashdata('notificacion')["tipo"] ?>',
            text: '<?php echo session()->getFlashdata('notificacion')["mensaje"] ?>',
        })
    <?php endif ?>
    <?php
    $_SESSION["notificacion"] = NULL;
    unset($_SESSION["notificacion"]);
    ?>

    function obtenerConteoCheckboxes(nombre) {
        var conteo = $('input[type="checkbox"][name="' + nombre + '"]:checked').length;
        return conteo;
    }

    $("#enviar_registro").click(function(e) {
        e.preventDefault()
        const form_values = $("#form_registro").serializeArray()

        const sucursales = obtenerConteoCheckboxes('sucursal_usuario[]')

        if (sucursales <= 0) {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe seleccionar al menos una sucursal para asignar al usuario."
            })
        } else {
            if (validarCampos(form_values)) {
                $("#form_registro").submit()
            } else {
                alert_clone({
                    tipo: "alert",
                    mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
                })
            }
        }


    })

    $("#editar_registro").click(function(e) {
        e.preventDefault()
        const form_values = $("#form_editar").serializeArray()

        const sucursales = obtenerConteoCheckboxes('sucursal_usuario[]')

        if (sucursales <= 0) {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe seleccionar al menos una sucursal para asignar al usuario."
            })
        } else {
            if (validarCampos(form_values)) {
                $("#form_editar").submit()
            } else {
                alert_clone({
                    tipo: "alert",
                    mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
                })
            }
        }


    })

    function EditarPersonal(usuario_id) {
        $("#form_editar").trigger("reset");

        $("#usuario_id").val(usuario_id);

        $.ajax({
            type: "POST",
            url: "Gestion-Personal/Recuperar/Personal",
            data: {
                usuario_id: usuario_id
            },
            dataType: "json",
            success: function(response) {
                $("#nombre").val(response["usuario"].usuario_nombre);
                $("#app").val(response["usuario"].usuario_app);
                $("#apm").val(response["usuario"].usuario_apm);
                $("#ci").val(response["usuario"].usuario_ci);
                $("#email").val(response["usuario"].usuario_email);
                $("#rol").val(response["usuario"].rol_id);
                $("#telefono").val(response["usuario"].usuario_telefono);
                $("#direccion").val(response["usuario"].usuario_direccion);

                response["sucursales"].forEach((item) => {
                    if ($('#ssucursal_' + item.sucursal_id)) {
                        $('#ssucursal_' + item.sucursal_id).prop("checked", true);
                    }
                })
            }
        });
    }

    function DetalleCursos(usuario_id) {
        $.ajax({
            type: "POST",
            url: "Gestion-Personal/Detalle/Cursos",
            data: {
                usuario_id: usuario_id
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 0) {
                    let tmp = "";
                    response.data.forEach(curso => {
                        tmp += `
                            <tr>
                                <td>${curso.curso_nombre}</td>
                                <td>${curso.horario_ini}</td>
                                <td>${curso.horario_fin}</td>
                                <td>${curso.dias}</td>
                            </tr>
                        `
                    })
                    document.getElementById("tbody_cursos").innerHTML = tmp
                } else {
                    Swal.fire({
                        icon: "error",
                        text: response.data,
                    })
                }
            }
        });
    }

    function InactivarPersonal(personal_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de inactivar a este usuario, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Personal/Inactivar",
                    data: {
                        personal_id: personal_id
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

    function ReactivarPersonal(personal_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Desea habilitar nuevamente la cuenta del personal seleccionado?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Personal/Reactivar",
                    data: {
                        personal_id: personal_id
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

    function EliminarPersonal(personal_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de eliminar definitivamente a este usuario, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Personal/Eliminar",
                    data: {
                        personal_id: personal_id
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
</script>