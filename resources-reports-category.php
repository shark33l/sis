<?php
include_once 'common_functions.php';
include_once 'ClassStaff.php';
include_once 'ResourceManager.php';
$session = new SessionManager();
$resourceLoad = new Resource;
$resources = $resourceLoad->loadAllResources_Category($_GET['resCategory']);

include_once 'libs/fpdf181/fpdf.php';

class PDF extends FPDF {
	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',7);
		$this->Cell(0 ,5,'Note : This is a computer generated sheet, no signature is required.',1,1,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(0,5,'Page '.$this->PageNo()." / {nb}",0,0,'C');
	}
}

$pdf = new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetTitle("Success Internation School - Resource Report Category");
$pdf->AddPage();

$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(230,230,230);
$pdf->Cell(15 ,15,'SIS',1,0,'C', TRUE);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(115 ,15,' SUCCESS INTERNATIONAL SCHOOL',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,15,'Report: ',0,0);
$pdf->Cell(50,15,$_GET['resCategory'].' Resource Log',0,1);

$pdf->Cell(195 ,5,'',0,1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(30 ,5,'Head Office        :',0,0);
$pdf->Cell(100 ,5,'No 13/B, Colombo Road,',0,0);
$pdf->Cell(15 ,5,'Tel      :',0,0);
$pdf->Cell(50 ,5,'011-2345678',0,1);

$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(100 ,5,'Wattala.',0,0);
$pdf->Cell(15 ,5,'Email  :',0,0);
$pdf->Cell(50 ,5,'info@sis.edu',0,1);

$pdf->Cell(195 ,5,'',0,1);

$pdf->Cell(30 ,5,'Generated By     :',0,0);
$pdf->Cell(35, 5, $session->get_session('fname') . ' ' . $session->get_session('lname') . ' (' . $session->get_session('userid') . ')', 0, 0);
$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(35 ,5,'',0,0);
$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(35 ,5,'',0,1);

$pdf->Cell(0 ,15,'__________________________________________________________________________________________________',0,1);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(5, 5,'#',0,0);
$pdf->Cell(5, 5,'ID',0,0);
$pdf->Cell(38, 5,'Resource Name',0,0);
$pdf->Cell(32, 5,'Resource Version',0,0);
$pdf->Cell(45, 5,'Supplier Name',0,0);
$pdf->Cell(20, 5,'Price (LKR)',0,0);
$pdf->Cell(20, 5,'Purchased',0,0);
$pdf->Cell(10, 5,'Qty',0,0);
$pdf->Cell(30, 5,'Status',0,1);

$resource_count = 1;
foreach ($resources as $resource) {
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(5, 5, $resource_count++, 0, 0);
	$pdf->Cell(5, 5, $resource['resID'], 0, 0);
	$pdf->Cell(38, 5, $resource['resName'], 0, 0);
	$pdf->Cell(32, 5, $resource['resVersion'], 0, 0);
	$pdf->Cell(45, 5, $resource['resSupplier'], 0, 0);
	$pdf->Cell(20, 5, $resource['resPrice'], 0, 0);
	$pdf->Cell(20, 5, $resource['dateofp'], 0, 0);
	$pdf->Cell(10, 5, $resource['resQty'], 0, 0);
	$pdf->Cell(30, 5, ($resource['resStatus'] == 1)?'Available':'Not Available', 0, 1);
}

$pdf->Close();
$pdf->Output();

?>
