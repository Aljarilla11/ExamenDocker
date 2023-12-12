<?php
require "vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
}

try 
{
    $pdo = new PDO("mysql:host=datos;dbname=cesta", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT cesta FROM navidad WHERE nombre = :nombre");
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $cesta = isset($resultado['cesta']) ? $resultado['cesta'] : '';
} 
catch (PDOException $e) 
{
    echo "Error de conexión a la base de datos: ";
}

$htmlContent = '
<html>
<body>
<dl>
<h1>Cesta de Navidad</h1>
<p>Aqui está tu cesta</p>
<img src="jamon.jpg"></img>
</dl>
</body>
</html>';


$pdfFileName = "output.pdf";

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($htmlContent);

$dompdf->setPaper('A4', 'portrait');

$dompdf->getOptions()->setChroot('jamon.jpg');

$dompdf->render();

$output = $dompdf->output();

echo $output;
exit();
?>