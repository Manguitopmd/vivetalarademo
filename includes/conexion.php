<?php
// Configuración de la conexión a la base de datos usando variables de entorno de Railway
$host = getenv('MYSQLHOST') ?: 'localhost'; // Host de la base de datos
$dbname = getenv('MYSQLDATABASE') ?: 'vive_talara'; // Nombre de la base de datos
$username = getenv('MYSQLUSER') ?: 'root'; // Usuario de la base de datos
$password = getenv('MYSQLPASSWORD') ?: ''; // Contraseña de la base de datos
$port = getenv('MYSQLPORT') ?: '3306'; // Puerto de la base de datos (por defecto 3306 para MySQL)

try {
    // Crear conexión PDO con el puerto incluido
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    
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