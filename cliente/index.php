<?php
require "vendor/autoload.php";
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
    $sql = "SELECT nombre FROM navidad WHERE nombre = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) 
    {
      
        $client = new GuzzleHttp\Client();
        $response = $client->post('http://cartero', [
            'form_params' => [
                'nombre' => $nombre,
            ],
        ]);
        echo $response->getBody();
    } 
    else 
    {
        echo "El nombre '$nombre' no existe en la base de datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cestas Navidad</title>
</head>
<body>
    <h1>Formulario de Cestas</h1>
    <form method="post" action="">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required><br>

        <button type="submit">Ojala</button>
    </form>
</body>
</html>