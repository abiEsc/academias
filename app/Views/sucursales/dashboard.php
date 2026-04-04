<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Gestion de Sucursales</h3>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card border shadow enlace" data-bs-toggle="modal" data-bs-target="#modal_registro">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldCategory"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                            <h4 class="text-muted font-semibold">
                                Registrar Sucursal
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
                                <h4>Sucursales Registradas</h4>
                            </div>
                            <div class="card-body table-responsive-lg">
                                <?php if (isset($sucursales) && count($sucursales) > 0) : ?>
                                    <table class="table" id="sucursales">
                                        <thead>
                                            <tr>
                                                <th>Nro</th>
                                                <th>Sucursal</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sucursales as $key => $value) : ?>
                                                <tr class="<?php echo $value["sucursal_activo"] == 2 ? "table-warning" : "" ?>">
                                                    <td><?php echo $key + 1 ?></td>
                                                    <td><?php echo $value["sucursal_nombre"] ?></td>
                                                    <td><?php echo $value["estado"] ?></td>
                                                    <td class="d-xxl-flex justify-content-around">
                                                        <a data-bs-toggle="modal" data-bs-target="#modal_registro" onclick="EditarForm('<?php echo $value['sucursal_id'] ?>')" class="text-success enlace">
                                                            <i class="bi bi-pen-fill"></i>
                                                            <span class="d-none d-lg-inline">
                                                                <small>
                                                                    Editar
                                                                </small>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
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
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="modal_registro">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Registrar Sucursal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_registro_sucursal" name="form_registro_sucursal">
                <input type="hidden" name="sucursal_id" id="sucursal_id" value="">
                <div class="modal-body">

                    <label for="sucursal_nombre">Nombre Sucursal: </label>
                    <div class="form-group">
                        <input type="text" id="sucursal_nombre" placeholder="Nombre Sucursal" class="form-control" name="sucursal_nombre" required>
                    </div>

                    <label class="mb-2">Estado</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="activo" value="1" name="sucursal_activo" checked>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inactivo" value="2" name="sucursal_activo">
                        <label class="form-check-label" for="inactivo">Inactivo</label>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button onclick="GuardarSucursal()" class="btn btn-primary ml-1" id="btn_registrar">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sucursales').DataTable({
            language: lang,
        });
    });

    $('#modal_registro').on('hidden.bs.modal', function() {
        $("#form_registro_sucursal").trigger("reset");
        $("#sucursal_id").val("");
    });

    function EditarForm(sucursal_id) {
        $("#sucursal_id").val(sucursal_id);

        $.ajax({
            type: "POST",
            url: "Gestion-Sucursal/Recuperar/Sucursal",
            data: {
                sucursal_id: sucursal_id
            },
            dataType: "json",
            success: function(response) {
                $("#sucursal_nombre").val(response[0].sucursal_nombre);
                if (response[0].sucursal_activo == 1) {
                    $("#activo").prop("checked", true);
                } else {
                    $("#inactivo").prop("checked", true);
                }
            }
        });
    }

    function GuardarSucursal() {
        if ($("#sucursal_nombre").val() == "" || ($('[name="sucursal_activo"]:checked').val() != 1 && $('[name="sucursal_activo"]:checked').val() != 2)) {
            alert_clone({
                tipo: "alert",
                mensaje: "Verifique que los campos tengan el tipo de dato correcto"
            })
            return;
        }

        const form_values = $("#form_registro_sucursal").serialize()

        $.ajax({
            type: "POST",
            url: "Gestion-Sucursal/Registrar/Sucursal",
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
</script>