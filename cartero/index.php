<?php

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use GuzzleHttp\Client;

try 
{
    $pdo = new PDO("mysql:host=datos;dbname=cesta", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
    echo "Error de conexión a la base de datos: ";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $nombre = $_POST['nombre'];
    $sql = "SELECT direccion FROM navidad WHERE nombre = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) 
    {
        $to = $resultado['direccion'];
        $contenido = "";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://generarpdf');
        $contenido = $response->getBody();

        $filename = "ejemplo.pdf";
        file_put_contents($filename, $contenido);

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;
        $mail->Username   = "aaljcas1808@g.educaand.es";
        $mail->Password   = "ocsn wfvx biip cotb";
        $mail->SetFrom('aaljcas1808@g.educaand.es', 'Test');
        $mail->Subject    = "Cesta de Navidad ";
        $mail->MsgHTML('Las mejores cestas');

        $mail->addAttachment($filename, 'Cesta');

        $mail->AddAddress($to, "Navidad");

        $resul = $mail->Send();

        if (!$resul) 
        {
            echo "Error" . $mail->ErrorInfo;
        } else 
        {
            echo "Enviado";
        }
    } 
    else 
    {
        echo "No se encontró un correo asociado al nombre proporcionado.";
    }
}