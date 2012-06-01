<?
require('html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("invoice_gen.html","r");
$strContent = fread($fp, filesize("invoice_gen.html"));
fclose($fp);
$pdf->WriteHTML($strContent);
$pdf->Output("invoice_gen.pdf");
echo "PDF file is generated successfully!";
?>
