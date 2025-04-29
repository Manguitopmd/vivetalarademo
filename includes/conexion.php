<?php
// Leer variables de entorno
$host = getenv('MYSQLHOST') ?: 'localhost';
$dbname = getenv('MYSQLDATABASE') ?: 'vive_talara';
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';

// Para puerto diferente si es necesario (Railway puede dar otro puerto)
$port = getenv('MYSQLPORT') ?: '3306';

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurar PDO para manejar errores y usar modo de excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar codificación UTF-8
    $pdo->exec("SET NAMES 'utf8'");
    
    // Opcional: Desactivar emulación de consultas preparadas
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    // Manejo de errores en la conexión
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
