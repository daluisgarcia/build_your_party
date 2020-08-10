<?php


$inicio = $_POST["inicio"];
$fin = $_POST["fin"];


require('fpdf17/fpdf.php'); 
include_once 'model/Reportes.php';
$connect = new ReportManagement();
$reportes = $connect->get_ingresos_egresos($inicio,$fin);




  //A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();


//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(0, 173, 179);

//Cell(width , height , text , border , end line , [align] )
$ahora= date('Y-m-d H:i:s');



$pdf->Cell(115	,6,'ARMA TU FIESTA',0,0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(75	,5,'REPORTE - Ingresos - Egresos',0,1);//end of line
$pdf->SetFont('Arial','',8);
$pdf->Cell(142	,5,'',0,0);
$pdf->Cell(48	,5,'desde '.$inicio.' hasta '.$fin,0,1);//end of line
$pdf->Cell(148	,5,'',0,0);
$pdf->Cell(42	,5,'generado: '.$ahora,0,1);//end of line



$pdf->SetFont('Arial','',8);
$pdf->Cell(92	,5,'RIF: J-945925F34942',0,1);
$pdf->Cell(92	,5,'Caracas, Venezuela',0,1);


// Salto
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190	,30,'',0,1);//end of line
$pdf->SetTextColor(0, 173, 179);
//set font to arial, regular, 12pt
$pdf->Cell(25	,5,'FECHA',0,0);
$pdf->Cell(125	,5,'MOTIVO',0,0);
$pdf->Cell(20	,5,'INGRESO',0,0);
$pdf->Cell(20	,5,'EGRESO',0,1);//end of line

$pdf->SetTextColor(0, 0, 0);
$total=0;

$pdf->SetFont('Arial','',8);

$ingreso=0;
$egreso=0;

foreach ($reportes as $reporte){
    $pdf->Cell(25	,6,$reporte['fecha'],1,0);
    $pdf->Cell(125	,6,$reporte['motivo'],1,0);
    $pdf->Cell(20	,6,$reporte['ingreso'],1,0);
    $pdf->Cell(20	,6,$reporte['egreso'],1,1);//end of line
    $ingreso+=$reporte['ingreso'];
    $egreso+=$reporte['egreso'];
}
$pdf->Cell(25	,6,'',0,0);
    $pdf->Cell(125	,6,'SUMATORIA',1,0);
    $pdf->Cell(20	,6,$ingreso,1,0);
    $pdf->Cell(20	,6,$egreso,1,1);//end of line

$pdf->Cell(190	,10,'',0,1);//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(30	,5,'TOTAL',1,0);
$pdf->Cell(30	,5,$ingreso-$egreso,1,1);//end of line




$pdf->Output();
?>

