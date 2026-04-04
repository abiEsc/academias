<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Reportes</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-content">
                                <div class="card-body">
                                    <p>
                                        Busque y seleccione el tipo de reporte que desea generar
                                    </p>

                                    <div class="container">
                                        <form id="form_reportes">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-10">
                                                    <h6>Seleccione Sucursal</h6>
                                                    <div class="input-group mb-3">
                                                        <?php if (isset($sucursales) && count($sucursales) > 0) : ?>
                                                            <label class="input-group-text" for="sucursal">Sucursal</label>
                                                            <select class="form-select" id="sucursal" name="sucursal">
                                                                <option value="" selected disabled>Seleccione...</option>
                                                                <option value="-100">Todas</option>
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
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-10">
                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="tipo_reporte">Tipo de Reporte</label>
                                                        <select class="form-select" id="tipo_reporte" name="tipo_reporte" required>
                                                            <option selected disabled>Seleccione...</option>
                                                            <option value="1">Reporte de Ventas</option>
                                                            <option value="2">Reporte de Clientes</option>
                                                            <option value="3">Reporte de Promociones</option>
                                                            <option value="4">Reporte de Instructor</option>
                                                            <option value="5">Reporte de Ritmos</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="contenedor_ventas">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-5">
                                                        <label for="fecha_ini_1">Fecha Inicial</label>
                                                        <input type="date" name="fecha_ini[]" id="fecha_ini_1" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label for="fecha_fin_1">Fecha Final</label>
                                                        <input type="date" name="fecha_fin[]" id="fecha_fin_1" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="contenedor_clientes">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-5">
                                                        <label for="fecha_ini_2">Fecha Inicial</label>
                                                        <input type="date" name="fecha_ini[]" id="fecha_ini_2" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label for="fecha_fin_2">Fecha Final</label>
                                                        <input type="date" name="fecha_fin[]" id="fecha_fin_2" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-10 mt-3">
                                                        <div class="input-group mb-3">
                                                            <label class="input-group-text" for="cliente_id">Cliente</label>
                                                            <select class="form-select" id="cliente_id" name="cliente_id">
                                                                <option selected disabled>Seleccione...</option>
                                                                <?php foreach ($lista_clientes as $cliente) : ?>
                                                                    <option value="<?php echo $cliente["usuario_id"] ?>"><?php echo $cliente["nombre_completo"] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <label class="mb-2">Seleccione una opción</label>
                                                        <br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="asistencia" value="1" name="tipo_reporte_cliente">
                                                            <label class="form-check-label" for="asistencia">Asistencia</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="pagos" value="2" name="tipo_reporte_cliente">
                                                            <label class="form-check-label" for="pagos">Pagos</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="contenedor_promociones">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-5">
                                                        <label for="fecha_ini_5">Fecha Inicial</label>
                                                        <input type="date" name="fecha_ini[]" id="fecha_ini_5" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label for="fecha_fin_5">Fecha Final</label>
                                                        <input type="date" name="fecha_fin[]" id="fecha_fin_5" class="form-control" required>
                                                    </div>

                                                    <div class="col-lg-10 mt-2">
                                                        <label class="mb-2">Seleccione una opción</label>
                                                        <br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="promos" value="1" name="tipo_reporte_promo">
                                                            <label class="form-check-label" for="promos">Listado de Promociones</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="promo_inscritos" value="2" name="tipo_reporte_promo">
                                                            <label class="form-check-label" for="promo_inscritos">Inscritos</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-10 mt-3" id="selector_promociones">
                                                        <?php if (isset($promociones) && count($promociones) > 0) : ?>
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="sel_promo">Promociones</label>
                                                                <select class="form-select" id="sel_promo" name="sel_promo">
                                                                    <option selected disabled>Seleccione...</option>
                                                                    <?php foreach ($promociones as $promo) : ?>
                                                                        <option value="<?php echo $promo["promocion_id"] ?>"><?php echo $promo["promocion_nombre"] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                                                <i class="bi bi-info-circle-fill me-3"></i>
                                                                <p>
                                                                    No existen paquetes registrados
                                                                </p>
                                                            </div>
                                                        <?php endif ?>
                                                    </div>

                                                </div>
                                            </div>

                                            <div id="contenedor_inscripciones">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-5">
                                                        <label for="fecha_ini_3">Fecha Inicial</label>
                                                        <input type="date" name="fecha_ini[]" id="fecha_ini_3" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label for="fecha_fin_3">Fecha Final</label>
                                                        <input type="date" name="fecha_fin[]" id="fecha_fin_3" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="contenedor_instructor">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-10">
                                                        <h6>Seleccione el instructor</h6>
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
                                                                    Aun no existen instructores registrados
                                                                </p>
                                                            </div>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="contenedor_ritmos">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-10">
                                                        <h6>Seleccione tipo de Paquete</h6>
                                                        <?php if (isset($paquetes) && count($paquetes) > 0) : ?>
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="sel_paquete">Paquete</label>
                                                                <select class="form-select" id="sel_paquete" name="sel_paquete">
                                                                    <option selected disabled>Seleccione...</option>
                                                                    <?php foreach ($paquetes as $paquete) : ?>
                                                                        <option value="<?php echo $paquete["paquete_id"] ?>"><?php echo $paquete["paquete_nombre"] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                                                <i class="bi bi-info-circle-fill me-3"></i>
                                                                <p>
                                                                    No existen paquetes registrados
                                                                </p>
                                                            </div>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row justify-content-center mt-5">
                                                <div class="col-lg-5">
                                                    <div class="text-center">
                                                        <button class="btn btn-primary w-100" onclick="GenerarReporte()" type="button">
                                                            Generar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                    <hr class="my-5">

                                    <div id="resultado"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<script>
    function hide_all() {
        $("#contenedor_ventas").hide();
        $("#contenedor_clientes").hide();
        $("#contenedor_promociones").hide();
        $("#contenedor_inscripciones").hide();
        $("#contenedor_instructor").hide();
        $("#contenedor_ritmos").hide();
    }

    hide_all()


    $("#tipo_reporte").change(function(e) {
        let selector = $(this).val()
        switch (selector) {
            case "1":
                hide_all()
                $("#contenedor_ventas").fadeIn(500);
                break;
            case "2":
                hide_all()
                $("#contenedor_clientes").fadeIn(500);
                break;
            case "3":
                hide_all()
                $("#contenedor_promociones").fadeIn(500);
                break;
            case "4":
                hide_all()
                $("#contenedor_instructor").fadeIn(500);
                break;
            case "5":
                hide_all()
                $("#contenedor_ritmos").fadeIn(500);
                break;
            default:
                alert_clone({
                    tipo: "alert",
                    mensaje: "Seleccione una opción válida."
                })
                break;
        }
    });

    $("[name='tipo_reporte_promo']").change(function() {
        if ($("[name='tipo_reporte_promo']:checked").val() == 1) {
            $("#selector_promociones").fadeOut(500)
        } else {
            $("#selector_promociones").fadeIn(500)
        }
    })

    function GenerarReporte() {

        switch ($("#tipo_reporte").val()) {
            case "1":
                if ($("#fecha_ini_1").val() == "" || $("#fecha_fin_1").val() == "") {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Debe seleccionar un rango de fechas para generar el reporte"
                    })
                    return;
                }

                if ($("#fecha_ini_1").val() > $("#fecha_fin_1").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "La fecha inicial no puede ser posterior a la fecha final"
                    })
                    return;
                }

                break;
            case "2":
                if ($("#fecha_ini_2").val() == "" || $("#fecha_fin_2").val() == "") {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Debe seleccionar un rango de fechas para generar el reporte"
                    })
                    return;
                }

                if ($("#fecha_ini_2").val() > $("#fecha_fin_2").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "La fecha inicial no puede ser posterior a la fecha final"
                    })
                    return;
                }

                if ($("#cliente_id").val() == null || $("#cliente_id").val() == "") {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Seleccione un cliente para generar el reporte"
                    })
                    return;
                }

                if (!$("[name='tipo_reporte_cliente']:checked").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Seleccione el tipo de reporte."
                    })
                    return;
                }

                break;
            case "3":
                if ($("#fecha_ini_5").val() == "" || $("#fecha_fin_5").val() == "") {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Debe seleccionar un rango de fechas para generar el reporte"
                    })
                    return;
                }

                if ($("#fecha_ini_5").val() > $("#fecha_fin_5").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "La fecha inicial no puede ser posterior a la fecha final"
                    })
                    return;
                }

                if (!$("[name='tipo_reporte_promo']:checked").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Seleccione el tipo de reporte."
                    })
                    return;
                }

                if ($("[name='tipo_reporte_promo']:checked").val() == 2) {
                    if ($("#sel_promo").val() == "" || !$("#sel_promo").val()) {
                        alert_clone({
                            tipo: "alert",
                            mensaje: "Seleccione la promoción para generar el reporte."
                        })
                        return;
                    }
                }




                break;
            case "4":
                if ($("#instructor").val() == "" || !$("#instructor").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Seleccione el instructor para generar el reporte."
                    })
                    return;
                }
                break;
            case "5":
                if ($("#sel_paquete").val() == "" || !$("#sel_paquete").val()) {
                    alert_clone({
                        tipo: "alert",
                        mensaje: "Seleccione el paquete para generar el reporte."
                    })
                    return;
                }
                break;
            default:
                alert_clone({
                    tipo: "alert",
                    mensaje: "Debe seleccionar un tipo valido para generar el reporte"
                })
                return;
                break;
        }

        if (!$("#sucursal").val()) {
            alert_clone({
                tipo: "alert",
                mensaje: "Debe seleccionar la sucursal para generar el reporte"
            })
            return;
        }

        const form_values = $("#form_reportes").serialize()
        Ajax_CargadoGeneralPagina('Reportes/Generar', 'resultado', "divErrorBusqueda", '', form_values);
    }
</script>