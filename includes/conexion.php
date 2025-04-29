<?php
// Configuración de la conexión a la base de datos
$host = 'localhost'; // Servidor de la base de datos (localhost para WAMP)
$dbname = 'vive_talara'; // Nombre de la base de datos
$username = 'root'; // Usuario de la base de datos (por defecto en WAMP)
$password = ''; // Contraseña (por defecto vacía en WAMP)

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