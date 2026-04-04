<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia de Zumba - LEO el Cubano</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url("assets/css/main/app.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main/app-dark.css") ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/logo/favicon.svg") ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/logo/favicon.png") ?>" type="image/png">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/shared/iconly.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/extensions/sweetalert2/sweetalert2.min.css") ?>">

    <script src="<?php echo base_url("assets/extensions/sweetalert2/sweetalert2.min.js") ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/js/evo-calendar.min.js "></script>
    <link href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css " rel="stylesheet">

    <script src="<?php echo base_url("assets/extensions/toastify-js/src/toastify.js") ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url("assets/extensions/toastify-js/src/toastify.css") ?>">

    <!-- <link href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.0/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.0/vfs_fonts.js"></script>


    <script>
        const lang = {
            lengthMenu: "Mostrando _MENU_ registros por pagina",
            zeroRecords: "No existen registros",
            info: "Página _PAGE_ de _PAGES_",
            infoEmpty: "No existen registros",
            infoFiltered: "(filtrado de _MAX_ registros)",
            search: "Búsqueda:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior",
            },
        };

        function validarFormulario(cadenaDatos) {
            const campos = cadenaDatos.split('&');

            for (const campo of campos) {
                const [nombre, valor] = campo.split('=');
                if (valor === '') {
                    return false;
                }
            }

            return true;
        }

        function validarNumero(valor) {
            var regex = /^[1-9]\d*$/;

            if (regex.test(valor)) {
                return true
            } else {
                return false
            }
        }
    </script>

</head>