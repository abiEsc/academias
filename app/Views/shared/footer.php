<script src="<?php echo base_url("assets/js/bootstrap.js") ?>"></script>
<script src="<?php echo base_url("assets/js/app.js") ?>"></script>

<div class="modal fade" id="detalle_cliente">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">
                    Detalle de Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personales-tab" data-bs-toggle="pill" data-bs-target="#personales" type="button" role="tab" aria-controls="personales" aria-selected="true">Datos Personales</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ritmos-tab" data-bs-toggle="pill" data-bs-target="#ritmos" type="button" role="tab" aria-controls="ritmos" aria-selected="false">Inscripciones</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="personales" role="tabpanel" aria-labelledby="personales-tab"></div>
                    <div class="tab-pane fade" id="ritmos" role="tabpanel" aria-labelledby="ritmos-tab"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="saldo_modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">Cancelar Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-warning d-none" role="alert" id="alert">
                <h4 class="alert-heading">Atención</h4>
                <p>El deposito no puede sobrepasar el saldo restante del curso, verifique por favor.</p>
            </div>
            <form id="form_cancelar" name="f">
                <div class="modal-body">
                    <input type="hidden" id="usuario_id_s" name="usuario_id_s" value="">
                    <input type="hidden" id="curso_id_s" name="curso_id_s" value="">
                    <input type="hidden" id="categoria" name="categoria" value="">

                    <label>Saldo Pendiente (Bs): </label>
                    <div class="form-group">
                        <input type="text" placeholder="Saldo Pendiente" class="form-control" id="saldo_pendiente" name="saldo" disabled>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>Deposito (Bs): </label>
                            <div class="form-group">
                                <input type="text" placeholder="Deposito" name="deposito" id="deposito" class="form-control" value="0.0" onkeyup="actualizar_saldo()" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>A cuenta (Bs): </label>
                            <div class="form-group">
                                <input type="text" name="cuenta" value="0.0" placeholder="A cuenta" id="cuenta" class="form-control" disabled>
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
                <button onclick="CancelarSaldo()" class="btn btn-primary ml-1" id="btn_registrar">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const myModalElSaldo = document.getElementById('saldo_modal')
    myModalElSaldo.addEventListener('hidden.bs.modal', event => {
        $("#usuario_id_s").val("");
        $("#curso_id_s").val("");
        $("#categoria").val("");
        $("#form_cancelar").trigger("reset");
        $("#alert").addClass("d-none");
    })

    function RecuperarCliente(usuario_id) {
        $.ajax({
            type: "POST",
            url: "Gestion-Cliente/Detalle",
            data: {
                usuario_id: usuario_id
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 0) {
                    $('#detalle_cliente').modal('show');

                    const personal_tpl = `
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre Completo: </strong>${response.cliente.nombre_completo}</li>
                        <li class="list-group-item"><strong>CI: </strong>${response.cliente.usuario_ci}</li>
                        <li class="list-group-item"><strong>Dirección: </strong>${response.cliente.usuario_direccion}</li>
                        <li class="list-group-item"><strong>Email: </strong>${response.cliente.usuario_email}</li>
                        <li class="list-group-item"><strong>Teléfono: </strong>${response.cliente.usuario_telefono}</li>
                    </ul>
                    `;

                    let cursos_tpl = "",
                        table = "";

                    if (response.cursos.length > 0) {
                        let color_td = "";
                        response.cursos.forEach((curso) => {
                            cursos_tpl += `
                                <tr class="${color_td}">
                                    <td>${curso.paquete_nombre}</td>
                                    <td class="text-center">${curso.paquete_cantidad_clases}</td>
                                    <td class="text-center table-info">${curso.sesiones} </td>
                                    <td>${curso.paquete_precio} Bs.</td>
                                    <td>${curso.inscripcion_saldo} Bs.</td>
                                    <td class="table-info">${curso.paquete_precio - curso.inscripcion_saldo} Bs.</td>
                                    <td class="d-xxl-flex justify-content-around">
                                        <span class="text-primary me-2 enlace" data-bs-toggle="modal" data-bs-target="#sesion_modal" onclick="RegistrarSesion('${response.cliente.usuario_id}', '${curso.paquete_id}', '${curso.inscripcion_categoria}')">
                                            <i class="bi bi-pen-fill"></i>
                                            <span class="d-none d-lg-inline">
                                                <small>
                                                    Registrar Sesión
                                                </small>
                                            </span>
                                        </span>
                                        <span class="text-primary me-2 enlace" data-bs-toggle="modal" data-bs-target="#saldo_modal" onclick="DetalleInscripcion('${response.cliente.usuario_id}', '${curso.paquete_id}', '${curso.inscripcion_categoria}')">
                                            <i class="bi bi-credit-card"></i>
                                            <span class="d-none d-lg-inline">
                                                <small>
                                                    Cancelar Saldo
                                                </small>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                            `;
                        })

                        table = `
                            <table class="table">
                                <thead>
                                    <th>Paquete</th>
                                    <th>Total Sesiones</th>
                                    <th>Sesiones Registradas</th>
                                    <th>Costo Curso</th>
                                    <th>A cuenta</th>
                                    <th>Saldo</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    ${cursos_tpl}
                                </tbody>
                            </table>
                        `;
                    } else {
                        table = `
                        <div class="alert alert-primary" role="alert">
                            <p>
                            <i class="bi bi-info-circle-fill"></i>
                            Sin Registros.
                            </p>
                        </div>
                        `;
                    }



                    $("#personales").html(personal_tpl)
                    $("#ritmos").html(table)

                } else {
                    alert_clone({
                        tipo: "alert",
                        mensaje: response.data
                    })
                }
            }
        });
    }

    function DetalleInscripcion(usuario_id, curso_id, categoria) {
        
        $("#usuario_id_s").val(usuario_id);
        $("#curso_id_s").val(curso_id);
        $("#categoria").val(categoria);

        $.ajax({
            type: "POST",
            url: "Gestion-Cliente/Detalle/Inscripcion",
            data: {
                usuario_id: usuario_id,
                curso_id: curso_id,
                categoria: categoria
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 0) {
                    const saldo = response.data.paquete_precio - response.data.inscripcion_saldo;
                    $("#saldo_pendiente").val(saldo);
                } else {
                    Swal.fire({
                        icon: "error",
                        text: response.data,
                    })
                }
            }
        });
    }

    function CancelarSaldo() {
        const form_cancelar = $("#form_cancelar").serialize()
        $.ajax({
            type: "POST",
            url: "Gestion-Cliente/Actualizar/Saldo",
            data: form_cancelar,
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

    function RegistrarSesion(usuario_id, curso_id, categoria) {
        $.ajax({
            type: "POST",
            url: "Gestion-Cliente/Detalle/Sesion",
            data: {
                usuario_id: usuario_id,
                curso_id: curso_id,
                categoria: categoria
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 1) {
                    Swal.fire({
                        icon: response.icono,
                        text: response.mensaje,
                    })
                } else {
                    alert_clone({
                        tipo: "confirm",
                        mensaje: "¿Desea registrar sesión?",
                        on_ok: function() {
                            $.ajax({
                                type: "POST",
                                url: "Gestion-Cliente/Registrar/Sesion",
                                data: {
                                    usuario_id: usuario_id,
                                    curso_id: curso_id,
                                    categoria: categoria
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
            }
        });
    }

    function actualizar_saldo() {
        let saldo = parseFloat(document.f.saldo.value),
            deposito = parseFloat(document.f.deposito.value);

        if (deposito > saldo) {
            $("#alert").removeClass("d-none");
            $("#btn_registrar").addClass("disabled");
            document.f.cuenta.value = "0.0";
        } else {
            $("#alert").addClass("d-none");
            $("#btn_registrar").removeClass("disabled");
            if (isNaN(saldo)) {
                saldo = 0;
            }
            if (isNaN(deposito)) {
                deposito = 0;
            }
            document.f.cuenta.value = saldo - deposito;
        }

    }

    function validarCampos(formData) {
        for (var i = 0; i < formData.length; i++) {
            var campo = formData[i];

            switch (campo.name) {
                case "ci":
                case "telefono":
                    if (!/^\d+$/.test(campo.value)) {
                        return false;
                    }
                    break;

                case "email":
                    if (!/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(campo.value)) {
                        return false;
                    }
                    break;

                default:
                    if (campo.value.trim() === "") {
                        return false;
                    }
            }
        }
        return true;
    }
</script>

</body>

</html>