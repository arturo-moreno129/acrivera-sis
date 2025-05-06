<?php
include 'header.php';
$file=$_GET['file'];
?>
<center><h1>Visor de Documento PDF</h1></center>
<iframe src="carpetas/<?php echo htmlspecialchars($file); ?>" width="100%" height="600px"></iframe>
<?php
include 'footer.php';
?>