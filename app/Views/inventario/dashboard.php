<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Gestion de Inventario</h3>
    </div>
    <?php if ($_SESSION["usuario"]["rol_id"] == 1) : ?>
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card border shadow enlace" data-bs-toggle="modal" data-bs-target="#registro_form_producto" onclick="VaciarFormProducto()">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                                <h4 class="text-muted font-semibold">
                                    Registrar Articulo
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header">
                                <h4>Listado de Articulos</h4>
                            </div>
                            <div class="card-body table-responsive-lg">
                                <?php if (isset($lista_productos) && count($lista_productos) > 0) : ?>
                                    <table class="table" id="lista_productos">
                                        <thead>
                                            <tr>
                                                <th>Articulo</th>
                                                <th>Cantidad Disponible</th>
                                                <th>Precio Unitario</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lista_productos as $key => $producto) : ?>
                                                <tr>
                                                    <td><?php echo $producto["articulo_nombre"] ?></td>
                                                    <td><?php echo $producto["articulo_cantidad"] ?></td>
                                                    <td><?php echo $producto["articulo_precio"] ?> Bs.</td>
                                                    <td class="d-xxl-flex justify-content-around">
                                                        <?php if ($_SESSION["usuario"]["rol_id"] == 1) :
                                                        ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#registro_form_producto" onclick="EditarProducto('<?php echo $producto['articulo_id'] ?>')" class="text-primary enlace">
                                                                <i class="bi bi-pen-fill"></i>
                                                                <span class="d-none d-lg-inline">
                                                                    <small>
                                                                        Editar Articulo
                                                                    </small>
                                                                </span>
                                                            </a>
                                                            <br>
                                                            <?php if ($producto["articulo_activo"] == 1) : ?>
                                                                <a onclick="RemoverProducto('<?php echo $producto['articulo_id'] ?>')" class="text-warning enlace">
                                                                    <i class="bi bi-trash-fill"></i>
                                                                    <span class="d-none d-lg-inline">
                                                                        <small>
                                                                            Inactivar Articulo
                                                                        </small>
                                                                    </span>
                                                                </a>
                                                            <?php else : ?>
                                                                <a onclick="ReactivarProducto('<?php echo $producto['articulo_id'] ?>')" class="text-success enlace">
                                                                    <i class="bi bi-trash-fill"></i>
                                                                    <span class="d-none d-lg-inline">
                                                                        <small>
                                                                            Reactivar Articulo
                                                                        </small>
                                                                    </span>
                                                                </a>
                                                            <?php endif ?>

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
                                            Aún no contamos con productos registrados
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

<div class="modal fade" id="registro_form_producto">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="titulo_registro_articulo">
                    Registro de Nuevo Articulo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_registro_articulo">
                <input type="hidden" name="producto_id" id="producto_id" value="">
                <div class="modal-body">
                    <label>Nombre del Articulo: </label>
                    <div class="form-group">
                        <input type="text" id="producto" placeholder="Nombre y descripción del articulo" class="form-control" name="producto" required>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>Cantidad de Items: </label>
                            <div class="form-group">
                                <input type="text" id="cantidad" min="0" placeholder="Cantidad de Articulos" class="form-control" name="cantidad" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>Precio Unitario (bs.): </label>
                            <div class="form-group">
                                <input type="number" value="0.1" step="0.1" min="0" id="precio" placeholder="Precio del articulo" class="form-control" name="precio" required>
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
                <button type="button" onclick="RegistrarProducto()" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Registrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#lista_productos').DataTable({
            language: lang,
        });
    });
</script>

<script>
    function VaciarFormProducto() {
        $("#producto_id").val("");
        $("#form_registro_articulo").trigger("reset")
        $("#titulo_registro_articulo").html("Registro de Nuevo Articulo")
    }

    function RegistrarProducto() {
        const form_values = $("#form_registro_articulo").serialize()

        if (/^[0-9]+$/.test($("#cantidad").val()) && $("#cantidad").val() > 0 && $("#precio").val() > 0) {
            $.ajax({
                type: "POST",
                url: "Gestion-Inventario/Registro/Producto",
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
                mensaje: "Verifique que los campos tengan el tipo de dato correcto"
            })
        }

    }

    function EditarProducto(producto_id) {
        $("#producto_id").val(producto_id);
        $("#titulo_registro_articulo").html("Edición de Articulo")

        $.ajax({
            type: "POST",
            url: "Gestion-Inventario/Recuperar/Producto",
            data: {
                producto_id: producto_id
            },
            dataType: "json",
            success: function(response) {
                $("#producto").val(response.articulo_nombre);
                $("#precio").val(response.articulo_precio);
                $("#cantidad").val(response.articulo_cantidad);
            }
        });
    }

    function ReactivarProducto(producto_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de reactivar este articulo, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Inventario/Reactivar/Producto",
                    data: {
                        producto_id: producto_id
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

    function RemoverProducto(producto_id) {
        alert_clone({
            tipo: "confirm",
            mensaje: "Esta a punto de inactivar este articulo, desea continuar?",
            on_ok: function() {
                $.ajax({
                    type: "POST",
                    url: "Gestion-Inventario/Eliminar/Producto",
                    data: {
                        producto_id: producto_id
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