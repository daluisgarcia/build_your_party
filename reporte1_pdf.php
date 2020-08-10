<?php

require('fpdf17/fpdf.php'); 
include_once 'model/Reportes.php';
$connect = new ReportManagement();
$reportes = $connect->get_fiestas_por_mes();


  //A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(0, 173, 179);
$ahora= date('Y-m-d H:i:s');

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(92	,6,'ARMA TU FIESTA',0,0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(98	,5,'REPORTE - Cantidad de fiestas por mes',0,1);//end of line
$pdf->SetFont('Arial','',8);
$pdf->Cell(148	,5,'',0,0);
$pdf->Cell(42	,5,'generado: '.$ahora,0,1);//end of line

$pdf->SetFont('Arial','',8);
$pdf->Cell(92	,5,'RIF: J-945925F34942',0,1);
$pdf->Cell(92	,5,'Caracas, Venezuela',0,1);


// Salto
$pdf->Cell(190	,30,'',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0, 173, 179);
$pdf->Cell(160	,5,'MES',0,0);
$pdf->Cell(30	,5,'CANTIDAD',0,1);//end of line
$pdf->SetTextColor(0, 0, 0);
$total=0;

$pdf->SetFont('Arial','',9);

foreach ($reportes as $reporte){
    if ($reporte['mes']==1)
      $pdf->Cell(160	,5,'Enero',1,0);
      if ($reporte['mes']==2)
      $pdf->Cell(160	,5,'Febrero',1,0);
      if ($reporte['mes']==3)
      $pdf->Cell(160	,5,'Marzo',1,0);
      if ($reporte['mes']==4)
      $pdf->Cell(160	,5,'Abril',1,0);
      if ($reporte['mes']==5)
      $pdf->Cell(160	,5,'Mayo',1,0);
      if ($reporte['mes']==6)
      $pdf->Cell(160	,5,'Junio',1,0);
      if ($reporte['mes']==7)
      $pdf->Cell(160	,5,'Julio',1,0);
      if ($reporte['mes']==8)
      $pdf->Cell(160	,5,'Agosto',1,0);
      if ($reporte['mes']==9)
      $pdf->Cell(160	,5,'Septiembre',1,0);
      if ($reporte['mes']==10)
      $pdf->Cell(160	,5,'Octubre',1,0);
      if ($reporte['mes']==11)
      $pdf->Cell(160	,5,'Noviembre',1,0);
      if ($reporte['mes']==12)
      $pdf->Cell(160	,5,'Diciembre',1,0);
    $pdf->Cell(30	,5,$reporte['cantidad'],1,1);//end of line
    $total+=$reporte['cantidad'];
}

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(30	,5,'Total',1,0);
$pdf->Cell(30	,5,$total,1,1);//end of line


$pdf->Output();
?>