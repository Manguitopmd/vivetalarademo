<?php
// Configuración de la conexión a la base de datos usando variables de entorno
$host = getenv('DB_HOST') ?: 'localhost'; // Host de la base de datos
$dbname = getenv('DB_NAME') ?: 'vive_talara'; // Nombre de la base de datos
$username = getenv('DB_USER') ?: 'root'; // Usuario de la base de datos
$password = getenv('DB_PASS') ?: ''; // Contraseña de la base de datos

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurar PDO para manejar errores y usar modo de excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar codificación UTF-8
    $pdo->exec("SET NAMES 'utf8'");
    
    // Opcional: Desactivar emulación de consultas preparadas para mayor seguridad
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch (PDOException $e) {
    // Manejo de errores en la conexión
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>