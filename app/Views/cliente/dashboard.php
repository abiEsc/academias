<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Gestion de Clientes</h3>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
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
                                Registrar Cliente
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
                                <h4>Clientes Registrados</h4>
                            </div>
                            <div class="card-body table-responsive-lg">
                                <?php if (isset($lista_cliente) && count($lista_cliente) > 0) : ?>
                                    <table class="table" id="lista_cliente">
                                        <thead>
                                            <tr>
                                                <th>Nombre Completo</th>
                                                <th>CI</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Estado</th>
                                                <th>Tipo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lista_cliente as $cliente) : ?>
                                                <tr class="<?php echo $cliente["activo"] == 0 ? "table-warning" : "" ?>">
                                                    <td>
                                                        <a href="#!" data-bs-toggle="modal" data-bs-target="#detalle_cliente" onclick="RecuperarCliente('<?php echo $cliente['usuario_id'] ?>')">
                                                            <?php echo $cliente["nombre_completo"] ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $cliente["ci"] ?></td>
                                                    <td><?php echo $cliente["telefono"] ?></td>
                                                    <td><?php echo $cliente["email"] ?></td>
                                                    <td><?php echo $cliente["activo_detalle"] ?></td>
                                                    <td><?php echo $cliente["tipo_detalle"] ?></td>
                                                    <td class="d-xxl-flex justify-content-around">
                                                        <?php if ($cliente["activo"] == 1) : ?>
                                                            <?php if ($cliente["tipo"] == 1) : ?>
                                                                <span class="text-success me-2 enlace" data-bs-toggle="modal" data-bs-target="#modal_inscripcion" onclick="InscripcionCliente('<?php echo $cliente['usuario_id'] ?>')">
                                                                    <i class="bi bi-plus-circle"></i>
                                                                    <span class="d-none d-lg-inline">
                                                                        <small>
                                                                            Inscripción
                                                                        </small>
                                                                    </span>
                                                                </span>
                                                                <br>
                                                            <?php endif ?>
                                                            <span class="text-primary me-2 enlace" data-bs-toggle="modal" data-bs-target="#editar_form" onclick="EditarCliente('<?php echo $cliente['usuario_id'] ?>')">
                                                                <i class="bi bi-pen-fill"></i>
                                                                <span class="d-none d-lg-inline">
                                                                    <small>
                                                                        Editar
                                                                    </small>
                                                                </span>
                                                            </span>
                                                            <br>
                                                        <?php endif ?>
                                                        <?php if ($cliente["activo"] == 1) : ?>
                                                            <a onclick="InactivarCliente('<?php echo $cliente['usuario_id'] ?>')" class="text-warning enlace">
                                                                <i class="bi bi-x-circle-fill"></i>
                                                                <span class="d-none d-lg-inline">
                                                                    <small>
                                                                        Inactivar
                                                                    </small>
                                                                </span>
                                                            </a>
                                                            <br>
                                                        <?php else : ?>
                                                            <a onclick="ReactivarCliente('<?php echo $cliente['usuario_id'] ?>')" class="text-success enlace">
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
                                            Aún no contamos con clientes registrados.
                                        </p>
                                    </div>
                                <?php endif ?>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Editar Cliente
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <form id="form_editar_cliente">
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
                        <div class="input-group my-3">
                            <label class="input-group-text" for="tipo">Tipo de Cliente</label>
                            <select class="form-select" id="tipo" name="tipo">
                                <option value="1" selected>Regular</option>
                                <option value="2">Temporal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>


            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button class="btn btn-primary ml-1" onclick="GuardarCliente()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registro -->
<div class="modal fade text-left" id="registro_form">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo_registro">
                    Registro de Nuevo Cliente
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="form_registro_cliente">
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
                    <div class="input-group my-3">
                        <label class="input-group-text" for="tipo">Tipo de Cliente</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="1" selected>Regular</option>
                            <option value="2">Temporal</option>
                        </select>
                    </div>

                    <div>
                        <i>
                            Tipo Regular: Tiene acceso al sistema
                            <br>
                            Tipo Temporal: No tiene acceso al sistema
                        </i>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button onclick="RegistrarCliente()" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Inscripcion -->
<div class="modal fade" id="modal_inscripcion">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Inscribir Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-warning d-none" role="alert" id="alert">
                <h4 class="alert-heading">Atención</h4>
                <p>El saldo no puede sobrepasar el costo total del curso, verifique por favor.</p>
            </div>
            <form id="form_registro_inscripcion" name="form_registro_inscripcion">
                <div class="modal-body">
                    <input type="hidden" id="usuario_id_ins" name="usuario_id_ins" value="">

                    <h6>Seleccione tipo de Paquete</h6>
                    <?php if ((isset($paquetes) && count($paquetes) > 0) || (isset($promociones) && count($promociones) > 0)) : ?>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="sel_paquete">Paquete</label>
                            <select class="form-select" id="sel_paquete" name="sel_paquete">
                                <option selected disabled>Seleccione...</option>
                                <optgroup label="Paquetes Regulares" id="regulares">
                                    <?php foreach ($paquetes as $paquete) : ?>
                                        <option value="<?php echo $paquete["paquete_id"] ?>"><?php echo $paquete["paquete_nombre"] ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <?php if (count($promociones) > 0) : ?>
                                    <optgroup label="Paquetes en Promoción" id="promocion">
                                        <?php foreach ($promociones as $promo) : ?>
                                            <option value="<?php echo $promo["promocion_id"] ?>"><?php echo $promo["promocion_nombre"] ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endif ?>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-3"></i>
                            <p>
                                Para realizar la inscripción es necesario registrar al menos
                                un paquete. <br>
                            </p>
                        </div>
                    <?php endif ?>

                    <label>Costo Inscripción (Bs): </label>
                    <div class="form-group">
                        <input type="text" placeholder="Costo Inscripción" class="form-control" id="costo" name="costo" disabled>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>A cuenta (Bs): </label>
                            <div class="form-group">
                                <input type="text" placeholder="Saldo" name="saldo" id="saldo" class="form-control" value="0.0" onkeyup="calcular_saldo()" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>Saldo (Bs): </label>
                            <div class="form-group">
                                <input type="text" name="cuenta" value="0.0" placeholder="A cuenta" id="cuenta" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <h6>Seleccione Sucursal</h6>
                    <div class="input-group mb-3">
                        <?php if (isset($sucursales) && count($sucursales) > 0) : ?>
                            <label class="input-group-text" for="sucursal">Sucursal</label>
                            <select class="form-select" id="sucursal" name="sucursal">
                                <option value="" selected disabled>Seleccione...</option>
                                <?php foreach ($sucursales as $value) : ?>
                                    <option value="<?php echo $value["sucursal_id"] ?>"><?php echo $value["sucursal_nombre"] ?></option>
                                <?php endforeach ?>
                            </select>
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
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button onclick="GuardarInscripcion()" class="btn btn-primary ml-1" id="btn_registrar">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#lista_cliente').DataTable({
            language: lang
        });
    });
</script>
<script>
    const myModalEl = document.getElementById('modal_inscripcion')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        $("#usuario_id_ins").val("");
        $("#form_registro_inscripcion").trigger("reset");
        $("#alert").addClass("d-none");
    })

    $("#sel_paquete").change(function() {

        const paquete_id = $("#sel_paquete").val()

        var miSelect = $("#sel_paquete")[0];
        var opcionSeleccionada = miSelect.options[miSelect.selectedIndex];
        var grupoSeleccionado = $(opcionSeleccionada).parent();
        var idGrupo = grupoSeleccionado.attr("id");

        if (idGrupo != "regulares" && idGrupo != "promocion") {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe seleccionar una opcion válida"
            })
            return;
        }

        $.ajax({
            type: "POST",
            url: "Gestion-Cursos/Recuperar/Paquete",
            data: {
                paquete_id: paquete_id,
                tipo: idGrupo
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 0) {
                    if (idGrupo == "regulares") {
                        $("#costo").val(response.data.paquete_precio);
                    } else {
                        $("#costo").val(response.data.promocion_precio);
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        text: response.data,
                    })
                }
            }
        });
    })

    function RegistrarCliente() {
        const form_values = $("#form_registro_cliente").serialize()

        const formvalidate = $("#form_registro_cliente").serializeArray()

        if (validarCampos(formvalidate)) {
            alert_clone({
                tipo: "confirm",
                titular: "Atención",
                mensaje: "Esta a punto de registrar al cliente, verifique que los datos sean correctos",
                btn_ok: "Registrar",
                btn_cancel: "Verificar",
                on_ok: function() {
                    $.ajax({
                        type: "POST",
                        url: "Gestion-Cliente/Registro",
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
            })
        } else {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
            })
        }



    }

    function EditarCliente(usuario_id) {
        $("#usuario_id").val(usuario_id);

        $.ajax({
            type: "POST",
            url: "Gestion-Cliente/Recuperar/Cliente",
            data: {
                usuario_id: usuario_id
            },
            dataType: "json",
            success: function(response) {
                $("#nombre").val(response.usuario_nombre);
                $("#app").val(response.usuario_app);
                $("#apm").val(response.usuario_apm);
                $("#ci").val(response.usuario_ci);
                $("#email").val(response.usuario_email);
                $("#direccion").val(response.usuario_direccion);
                $("#telefono").val(response.usuario_telefono);
                $("#tipo").val(response.cliente_tipo);
            }
        });
    }

    function GuardarCliente() {
        const form_values = $("#form_editar_cliente").serialize()
        const formvalidate = $("#form_editar_cliente").serializeArray()

        if (validarCampos(formvalidate)) {
            alert_clone({
                tipo: "confirm",
                titular: "Atención",
                mensaje: "La información es correcta?",
                btn_ok: "Registrar",
                btn_cancel: "Verificar",
                on_ok: function() {
                    $.ajax({
                        type: "POST",
                        url: "Gestion-Cliente/Editar",
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
            })
        } else {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe completar todos los campos y con el tipo de dato correcto para realizar el registro."
            })
        }


    }

    function InactivarCliente(usuario_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de inactivar a este usuario, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Cliente/Inactivar",
                    data: {
                        usuario_id: usuario_id
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

    function ReactivarCliente(usuario_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Desea habilitar nuevamente la cuenta del cliente seleccionado?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Cliente/Reactivar",
                    data: {
                        usuario_id: usuario_id
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

    function EliminarCliente(usuario_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de eliminar definitivamente a este cliente, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Cliente/Eliminar",
                    data: {
                        usuario_id: usuario_id
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

    function InscripcionCliente(usuario_id) {
        $("#usuario_id_ins").val(usuario_id);
    }

    function GuardarInscripcion() {
        var form_values = $("#form_registro_inscripcion").serialize()

        var miSelect = $("#sel_paquete")[0];
        var opcionSeleccionada = miSelect.options[miSelect.selectedIndex];
        var grupoSeleccionado = $(opcionSeleccionada).parent();
        var idGrupo = grupoSeleccionado.attr("id");

        form_values += "&tipo=" + idGrupo;

        if (parseFloat($("#saldo").val()) == 0 || $("#ritmo").val() == "") {
            alert_clone({
                tipo: "alert",
                mensaje: "Existen datos incorrectos, verifique antes de realizar la inscripción."
            })
        } else {
            alert_clone({
                tipo: "confirm",
                titular: "Atención",
                mensaje: "Esta a punto de registrar la inscripción. ¿Continuar?",
                btn_ok: "Registrar",
                btn_cancel: "Verificar Datos",
                on_ok: function() {
                    $.ajax({
                        type: "POST",
                        url: "Gestion-Cliente/Inscripcion",
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
            })
        }


    }

    function calcular_saldo() {
        let costo = parseFloat(document.form_registro_inscripcion.costo.value),
            saldo = parseFloat(document.form_registro_inscripcion.saldo.value);

        if (saldo > costo) {
            $("#alert").removeClass("d-none");
            $("#btn_registrar").addClass("disabled");
        } else {
            $("#alert").addClass("d-none");
            $("#btn_registrar").removeClass("disabled");
            if (isNaN(costo)) {
                costo = 0;
            }
            if (isNaN(saldo)) {
                saldo = 0;
            }
            document.form_registro_inscripcion.cuenta.value = costo - saldo;
        }

    }
</script>