<?php
require_once('../../helpers/report.php');
require_once('../../models/data/pedidos_data.php');
 
$pdf = new Report;
$pdf->startReport('Pedidos');
$Pedidos = new PedidoData;
 
if ($dataPedidos = $Pedidos->readAllreport()) {
    $pdf->setFillColor(154, 173, 233);
    $pdf->setDrawColor(154, 173, 233);
    $pdf->setFont('Arial', 'B', 11);
    $pdf->cell(36, 15, 'Cliente', 1, 0, 'C', 1);
    $pdf->cell(36, 15, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(26, 15, 'Estado', 1, 0, 'C', 1);
    $pdf->cell(86, 15, 'Direccion', 1, 1, 'C', 1);
 
    $pdf->setFillColor(240);
    $pdf->setFont('Arial', '', 11);
 
    foreach ($dataPedidos as $rowPedidos) {
        // Verifica si se ha creado una nueva página
        if ($pdf->getY() + 15 > 279 - 30) { // Ajusta este valor según el tamaño de tus celdas y la altura de la página
            $pdf->addPage('P', [216, 279]); // Añade una nueva página
            $pdf->setFillColor(154, 173, 233);
            $pdf->setDrawColor(154, 173, 233);
            $pdf->setFont('Arial', 'B', 11);
            // Vuelve a imprimir los encabezados en la nueva página
            $pdf->cell(36, 15, 'Cliente', 1, 0, 'C', 1);
            $pdf->cell(36, 15, 'Fecha', 1, 0, 'C', 1);
            $pdf->cell(26, 15, 'Estado', 1, 0, 'C', 1);
            $pdf->cell(86, 15, 'Direccion', 1, 1, 'C', 1);
        }
 
        $currentY = $pdf->getY(); // Obtén la coordenada Y actual
        $pdf->setFillColor(79, 171, 220);
        $pdf->setDrawColor(130, 196, 250);
        $pdf->setFont('Arial', 'B', 11);
        // Imprime las celdas con los datos y la imagen
        $pdf->setFillColor(255, 255, 255);
        $pdf->cell(36, 15, $pdf->encodeString($rowPedidos['cliente']), 1, 0, 'C');
        $pdf->cell(36, 15, $pdf->encodeString($rowPedidos['fecha']), 1, 0, 'C');
        $pdf->cell(26, 15, $pdf->encodeString($rowPedidos['estado_pedido']), 1, 0, 'C');
        $pdf->cell(86, 15, $pdf->encodeString($rowPedidos['direccion_pedido']), 1, 1, 'C');
    }
} else {
    $pdf->cell(0, 15, $pdf->encodeString('No hay pedidos registros'), 1, 1);
}
 
$pdf->output('I', 'Pedidos.pdf');