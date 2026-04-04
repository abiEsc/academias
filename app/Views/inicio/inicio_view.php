<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>

<div id="main">
  <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>

  <div class="page-heading">
    <h3>SISTEMA DE GESTIÓN - ACADEMIA DE ZUMBA LEO EL CUBANO</h3>
  </div>
  <div class="page-content">
    <section class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <div class="card shadow">
              <div class="card-header">
                <h4>Dashboard Principal</h4>
              </div>
              <div class="card-body">
                <p>
                  Bienvenido <br>
                  <?php echo getNombreRol($_SESSION["usuario"]["rol_id"]) . " " . $_SESSION["usuario"]["nombre_completo"] ?>
                </p>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <?php if ($_SESSION["usuario"]["rol_id"] == 5) : ?>
                      <button class="nav-link" id="nav-personal-tab" data-bs-toggle="tab" data-bs-target="#nav-personal" type="button" role="tab" aria-controls="nav-personal" aria-selected="true">Información Personal</button>
                    <?php endif ?>
                    <button class="nav-link" id="nav-horario-tab" data-bs-toggle="tab" data-bs-target="#nav-horario" type="button" role="tab" aria-controls="nav-horario" aria-selected="true">Horario Vigente</button>
                    <?php if ($_SESSION["usuario"]["rol_id"] == 1 || $_SESSION["usuario"]["rol_id"] == 2 || $_SESSION["usuario"]["rol_id"] == 3) : ?>
                      <button class="nav-link" id="nav-venta-tab" data-bs-toggle="tab" data-bs-target="#nav-venta" type="button" role="tab" aria-controls="nav-venta" aria-selected="false">Venta de Articulos</button>
                      <button class="nav-link" id="nav-clientes-tab" data-bs-toggle="tab" data-bs-target="#nav-clientes" type="button" role="tab" aria-controls="nav-clientes" aria-selected="false">Clientes</button>
                    <?php endif ?>
                    <button class="nav-link active" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Galeria</button>
                  </div>
                </nav>
                <div class="tab-content mt-4" id="nav-tabContent">
                  <?php if ($_SESSION["usuario"]["rol_id"] == 5) : ?>
                    <div class="tab-pane fade" id="nav-personal" role="tabpanel" aria-labelledby="nav-personal-tab">
                      <h5>Datos Personales</h5>
                      <div id="datos_personales"></div>

                      <hr>

                      <h5>Inscripciones</h5>
                      <div id="datos_inscripcion"></div>
                    </div>
                  <?php endif ?>
                  <div class="tab-pane fade" id="nav-horario" role="tabpanel" aria-labelledby="nav-horario-tab">
                    <div id="calendar"></div>
                  </div>
                  <?php if ($_SESSION["usuario"]["rol_id"] == 1 || $_SESSION["usuario"]["rol_id"] == 2 || $_SESSION["usuario"]["rol_id"] == 3) : ?>
                    <div class="tab-pane fade" id="nav-venta" role="tabpanel" aria-labelledby="nav-venta-tab">
                      <?php if (isset($lista_productos) && count($lista_productos) > 0) : ?>
                        <table class="table" id="lista_productos">
                          <thead>
                            <tr>
                              <th>Articulo</th>
                              <th>Precio Unitario</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($lista_productos as $key => $producto) : ?>
                              <tr class="<?php echo $producto["articulo_cantidad"] == 0 ? "table-warning" : "" ?>">
                                <td class="d-xxl-flex justify-content-between">
                                  <?php echo $producto["articulo_nombre"] ?>
                                </td>
                                <td><?php echo $producto["articulo_precio"] ?> Bs.</td>
                                <td class="d-xxl-flex justify-content-between">
                                  <?php if (true) : ?>
                                    <a data-bs-toggle="modal" data-bs-target="#registro_venta" onclick="VentaProducto('<?php echo $producto['articulo_id'] ?>')" class="text-success enlace">
                                      <i class="bi bi-cart-check-fill"></i>
                                      <span class="d-none d-lg-inline">
                                        <small>
                                          Registrar Venta
                                        </small>
                                      </span>
                                    </a>
                                  <?php else : ?>
                                    -
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
                    <div class="tab-pane fade" id="nav-clientes" role="tabpanel" aria-labelledby="nav-clientes-tab">
                      <?php if (isset($lista_cliente) && count($lista_cliente) > 0) : ?>
                        <table class="table" id="lista_cliente">
                          <thead>
                            <tr>
                              <th>Nombre Completo</th>
                              <th>CI</th>
                              <th>Teléfono</th>
                              <th>Email</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($lista_cliente as $cliente) : ?>
                              <tr class="<?php echo $cliente["activo"] == 0 ? "table-warning" : "" ?>">
                                <td><?php echo $cliente["nombre_completo"] ?></td>
                                <td><?php echo $cliente["ci"] ?></td>
                                <td><?php echo $cliente["telefono"] ?></td>
                                <td><?php echo $cliente["email"] ?></td>
                                <td>
                                  <a href="#!" onclick="RecuperarCliente('<?php echo $cliente['usuario_id'] ?>')">
                                    Ver detalle
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
                            Aún no contamos con clientes registrados.
                          </p>
                        </div>
                      <?php endif ?>
                    </div>
                  <?php endif ?>
                  <div class="tab-pane show active fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                    <?php if (isset($lista_galeria) && count($lista_galeria) > 0) : ?>
                      <ul class="controls d-flex justify-content-between" id="customize-controls" aria-label="Carousel Navigation" tabindex="0">
                        <li class="prev" data-controls="prev" aria-controls="customize" tabindex="-1">
                          <i class="bi bi-caret-left-fill"></i>
                        </li>
                        <li class="next" data-controls="next" aria-controls="customize" tabindex="-1">
                          <i class="bi bi-caret-right-fill"></i>
                        </li>
                      </ul>
                      <div class="my-slider" style="width: 450px; height: 550px;">
                        <?php foreach ($lista_galeria as $key => $item) : ?>
                          <div>
                            <?php if ($item["tipo"] == 1) : ?>
                              <video src="<?php echo $item["url"] ?>" height="400px" controls></video>
                            <?php else : ?>
                              <img src="<?php echo $item["url"] ?>" alt="<?php echo $item["url"] ?>" class="d-block w-100">
                            <?php endif ?>
                            <?php if ($_SESSION["usuario"]["rol_id"] == 1 || $_SESSION["usuario"]["rol_id"] == 4) : ?>
                              <div class="text-center my-2">
                                <button class="btn btn-danger" onclick="RemoverGaleria('<?php echo $item['galeria_id'] ?>')">Remover</button>
                              </div>
                            <?php endif ?>
                          </div>
                        <?php endforeach ?>
                      </div>
                    <?php else : ?>
                      <div class="alert alert-primary" role="alert">
                        <p>
                          <i class="bi bi-info-circle-fill"></i>
                          Galeria vacía
                        </p>
                      </div>
                    <?php endif ?>

                    <?php if ($_SESSION["usuario"]["rol_id"] == 1 || $_SESSION["usuario"]["rol_id"] == 4) : ?>
                      <hr>
                      <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                          <div class="card">
                            <div class="card-content">
                              <div class="card-body">
                                <h5 class="card-title">Cargar Video o Imagen</h5>
                                <form id="form_galeria" enctype="multipart/form-data" method="POST">
                                  <div class="my-3">
                                    <input type="file" name="image">
                                  </div>
                                  <button class="btn btn-primary" type="submit">Guardar</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
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


<div class="modal fade" id="registro_venta">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title">
          Detalle de Articulo
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="alert alert-danger d-none" role="alert" id="no_items">
        <p>
          <i class="bi bi-info-circle-fill"></i>
          No exiten unidades disponibles.
        </p>
      </div>

      <div class="alert alert-warning d-none" role="alert" id="no_much">
        <p>
          <i class="bi bi-info-circle-fill"></i>
          No se cuenta con las unidades suficientes.
        </p>
      </div>


      <form name="form_venta" id="form_venta">
        <input type="hidden" name="producto_id" id="producto_id" value="">
        <input type="hidden" name="precio" id="precio" value="">
        <input type="hidden" name="form_cantidad" id="form_cantidad" value="">
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span id="nombre_articulo"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Precio Unitario</span>
            <span class="badge bg-primary badge-pill badge-round ml-1" id="resumen_precio"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Cantidad Disponible</span>
            <span class="badge bg-primary badge-pill badge-round ml-1" id="resumen_cantidad"></span>
          </li>
          <li class="list-group-item align-items-center">
            <label>Cantidad Venta: </label>
            <div class="form-group">
              <input type="text" placeholder="Registre la cantidad de items" class="form-control" name="cantidad" required id="cantidad" onkeyup="calcular()">
            </div>
          </li>
          <li class="list-group-item align-items-center">
            <label>Total: </label>
            <div class="form-group">
              <input type="text" placeholder="0.0 Bs." class="form-control" name="total" required readonly id="form_total">
            </div>
          </li>
        </ul>
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
          <i class="bx bx-x d-block d-sm-none"></i>
          <span class="d-none d-sm-block">Cancelar</span>
        </button>
        <button id="btn_venta" type="button" onclick="RegistrarVenta()" class="btn btn-primary ml-1">
          <i class="bx bx-check d-block d-sm-none"></i>
          <span class="d-none d-sm-block">Aceptar</span>
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
    $('#lista_productos').DataTable({
      language: lang
    });
  });
</script>


<script>
  const myModalEl = document.getElementById('registro_venta')
  myModalEl.addEventListener('hidden.bs.modal', event => {
    $("#producto_id").val("");
    $("#form_venta").trigger("reset")
  })


  function VentaProducto(producto_id) {
    $("#producto_id").val(producto_id);

    $.ajax({
      type: "POST",
      url: "Gestion-Inventario/Recuperar/Producto",
      data: {
        producto_id: producto_id
      },
      dataType: "json",
      success: function(response) {
        $("#nombre_articulo").html(response.articulo_nombre);
        $("#resumen_precio").html(response.articulo_precio + " Bs.");
        $("#resumen_cantidad").html(response.articulo_cantidad + " Unidades");
        $("#precio").val(response.articulo_precio);
        $("#form_cantidad").val(response.articulo_cantidad);

        if (response.articulo_cantidad == 0) {
          $("#btn_venta").addClass("disabled")
          $("#no_items").removeClass("d-none")
        } else {
          $("#btn_venta").removeClass("disabled")
          $("#no_items").addClass("d-none")
        }
      }
    });
  }


  function calcular() {
    let precio = parseFloat(document.form_venta.precio.value),
      cantidad = parseFloat(document.form_venta.cantidad.value);


    if (cantidad >= 0) {
      if (cantidad > $("#form_cantidad").val()) {
        $("#no_much").removeClass("d-none")
        $("#btn_venta").addClass("disabled")
        document.form_venta.form_total.value = "No se cuenta con unidades suficientes";
      } else {
        $("#no_much").addClass("d-none")
        $("#btn_venta").removeClass("disabled")
        document.form_venta.form_total.value = "0.0";
        if (isNaN(precio)) {
          precio = 0;
        }
        if (isNaN(cantidad)) {
          cantidad = 0;
        }
        document.form_venta.form_total.value = precio * cantidad;
      }
    } else {
      document.form_venta.form_total.value = "Valor incorrecto";
    }

  }


  function RegistrarVenta() {

    const body = {
      producto_id: $("#producto_id").val(),
      cantidad: $("#cantidad").val()
    }

    if (/^[0-9]+$/.test(body.cantidad) && body.cantidad > 0) {
      alert_clone({
        tipo: "confirm",
        mensaje: "Esta a punto de registrar la venta, desea continuar?",
        on_ok: function() {
          $.ajax({
            type: "POST",
            url: "Gestion-Inventario/Registro/Venta",
            data: body,
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
        mensaje: "Verifique que los campos tengan el tipo de dato correcto"
      })
    }


  }

  $('input[type=file]').change(async function() {
    const fileUpload = $('input[type=file]').prop('files')[0]
    const fileHeader = await getFileHeader(fileUpload)
    var val = $(this).val().toLowerCase();
    var regex = new RegExp("(.*?)\.(jpg|jpeg|png|mp4)$");
    if (!(regex.test(val)) || !verifyType(fileHeader)) {
      $(this).val('');
      alert_clone({
        tipo: "alert",
        mensaje: "Por favor seleccione un archivo válido"
      })
    } else {
      Toastify({
        text: "Archivo cargado correctamente, listo para guardar!",
        gravity: "bottom",
        duration: 3000,
        style: {
          background: "#4bb543",
        },
      }).showToast();

    }
  });


  $("#form_galeria").submit(function(event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "Guardar/Media",
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      success: function(response) {
        Swal.fire({
          icon: response.icono,
          title: response.data,
        }).then(() => {
          window.location.reload()
        })
      }
    })
  });

  $(document).ready(function() {
    const siderbar_calendar = document.getElementById("calendar"),
      btnToggleEvents = document.getElementById("eventListToggler")


    btnToggleEvents.addEventListener("click", function() {
      siderbar_calendar.classList.add("sidebar-hide")
    })
  });


  $("#calendar").evoCalendar({
    language: "es",
    eventDisplayDefault: false,
    eventHeaderFormat: 'MM dd, yyyy',
    calendarEvents: [<?php foreach ($cursos as $key => $curso) : ?>
        <?php foreach ($curso["curso_dias"] as $key_dias => $dias) : ?> {
            id: "<?php echo $key . "-" . $key_dias ?>",
            name: "<?php echo $curso["curso_nombre"] ?>",
            date: "<?php echo $dias ?>",
            badge: "<?php echo $curso["horario_ini"] . " - " . $curso["horario_fin"] ?>",
            description: "<?php echo $curso["nombre_instructor"] ?>",
            type: "event",
            color: '#837bdb'
          },
        <?php endforeach ?>
      <?php endforeach ?>
    ]
  });

  function RemoverGaleria(galeria_id) {

    alert_clone({
      tipo: "confirm",
      mensaje: "Esta a punto de remover este elemento, desea continuar?",
      on_ok: function() {
        $.ajax({
          type: "POST",
          url: "Remover/Media",
          data: {
            galeria_id: galeria_id
          },
          dataType: "json",
          success: function(response) {
            Swal.fire({
              icon: response.icono,
              title: response.data,
            }).then(() => {
              window.location.reload()
            })
          }
        });
      }
    })


  }

  const slider = tns({
    container: '.my-slider',
    items: <?php echo count($lista_galeria) ?>,
    mouseDrag: true,
    autoWidth: true,
    swipeAngle: false,
    gutter: 10,
    speed: 400,
    autoplay: true,
    prevButton: '.prev',
    nextButton: '.next',
    nav: false,
  });

  function DetalleClienteHome() {
    $.ajax({
      type: "POST",
      url: "Gestion-Cliente/Detalle",
      data: {
        usuario_id: '<?php echo $_SESSION["usuario"]["usuario_id"] ?>'
      },
      dataType: "json",
      success: function(response) {
        if (response.error == 0) {

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
              cursos_tpl += `<tr class="${color_td}">
                                <td>${curso.paquete_nombre}</td>
                                <td class="text-center">${curso.paquete_cantidad_clases}</td>
                                <td class="text-center table-info">${curso.sesiones} </td>
                                <td>${curso.paquete_precio} Bs.</td>
                                <td>${curso.inscripcion_saldo} Bs.</td>
                                <td class="table-info">${curso.paquete_precio - curso.inscripcion_saldo} Bs.</td>
                            </tr>
                        `;
            })

            table = `<table class="table">
                        <thead>
                            <th>Paquete</th>
                            <th>Total Sesiones</th>
                            <th>Sesiones Registradas</th>
                            <th>Costo Curso</th>
                            <th>A cuenta</th>
                            <th>Saldo</th>
                        </thead>
                        <tbody>
                            ${cursos_tpl}
                        </tbody>
                    </table>`;
          } else {
            table = `<div class="alert alert-primary" role="alert">
                        <p>
                        <i class="bi bi-info-circle-fill"></i>
                        Sin Registros.
                        </p>
                    </div>`;
          }

          $("#datos_personales").html(personal_tpl)
          $("#datos_inscripcion").html(table)
        }
      }
    })
  }

  <?php if ($_SESSION["usuario"]["rol_id"] == 5) : ?>
    DetalleClienteHome()
  <?php endif ?>
</script>