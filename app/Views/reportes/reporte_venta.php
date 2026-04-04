<button onclick="exportarTablaAPDF()" class="btn btn-secondary">Exportar a PDF</button>

<div class="table-responsive">
    <table class="table" id="reporte_venta">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reporte as $key => $item) : ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $item["producto"] ?></td>
                    <td><?php echo $item["cantidad"] ?></td>
                    <td><?php echo $item["precio"] ?> Bs.</td>
                    <td><?php echo $item["total"] ?> Bs.</td>
                    <td><?php echo $item["usuario"] ?></td>
                    <td><?php echo $item["fecha"] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
    function exportarTablaAPDF() {
        var tabla = document.getElementById('reporte_venta');
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
        var filename = 'reporte_ventas_' + timestamp + '.pdf'; // Nombre del archivo con el timestamp


        // Definir la estructura del documento PDF
        var docDefinition = {
            content: [{
                text: 'Reporte de Ventas', // Título de la tabla
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
                    widths: [20, '*', '*', '*', '*', 'auto', 'auto'],
                    body: [
                        ['ID', 'Producto', 'Cantidad', 'Precio', 'Total', 'Usuario', 'Fecha'], // Cabecera de la tabla
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