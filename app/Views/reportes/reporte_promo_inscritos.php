<button onclick="exportarTablaAPDF()" class="btn btn-secondary">Exportar a PDF</button>

<div class="table-responsive">
    <table class="table" id="reporte_inscritos_promo">
        <thead>
            <tr>
                <th>Promoción</th>
                <th>Sesiones</th>
                <th>Precio</th>
                <th>Nombre Inscrito</th>
                <th>Saldo Pendiente</th>
                <th>Fecha Inscripción</th>
                <th>Usuario Inscripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reporte as $item) : ?>
                <tr>
                    <td><?php echo $item["promocion_nombre"] ?></td>
                    <td><?php echo $item["promocion_clases"] ?></td>
                    <td><?php echo $item["promocion_precio"] ?>Bs.</td>
                    <td><?php echo $item["cliente_nombre"] ?></td>
                    <td><?php echo $item["saldo_pendiente"] ?>Bs.</td>
                    <td><?php echo $item["fecha_inscrito"] ?></td>
                    <td><?php echo $item["usuario_inscripcion"] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
    function exportarTablaAPDF() {
        var tabla = document.getElementById('reporte_inscritos_promo');
        var tablaData = [];

        // Obtener los datos de la tabla y agregarlos a un array
        var filas = tabla.getElementsByTagName('tr');
        for (var i = 1; i < filas.length; i++) { // Comenzar desde la segunda fila para omitir la cabecera
            var celdas = filas[i].getElementsByTagName('td');
            var filaData = [];
            for (var j = 0; j < celdas.length; j++) {
                filaData.push(celdas[j].innerText);
            }
            tablaData.push(filaData);
        }

        var currentDate = new Date();
        var timestamp = `${currentDate.getDate()}${currentDate.getMonth()+1}${currentDate.getFullYear()}${currentDate.getHours()}${currentDate.getMinutes()}`;
        var filename = 'reporte_inscritos_' + timestamp + '.pdf'; // Nombre del archivo con el timestamp


        // Definir la estructura del documento PDF
        var docDefinition = {
            content: [{
                text: 'Reporte de Inscritos - Promociones', // Título de la tabla
                style: 'header', // Estilo del título
                alignment: 'center', // Alineación del título en el centro
                width: '*'
            }, {
                layout: 'lightHorizontalLines',
                style: {
                    fontSize: 10,
                },
                table: {
                    headerRows: 1,
                    widths: ['*', '*', '*', '*', '*', '*', '*'],
                    body: [
                        ['Promoción', 'Sesiones', 'Precio', 'Inscrito', "Saldo", "Fecha Inscripción", "Usuario Inscripción"], // Cabecera de la tabla
                        ...tablaData // Datos de la tabla
                    ],
                },
            }],
            styles: {
                header: {
                    fontSize: 16,
                    bold: true,
                    margin: [0, 0, 0, 10] // Margen inferior del título
                },
            }
        };

        // Generar el documento PDF
        pdfMake.createPdf(docDefinition).download(filename);
        // Descargar el archivo PDF generado
    }
</script>