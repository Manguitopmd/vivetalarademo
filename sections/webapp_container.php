<?php
require_once 'includes/conexion.php';

$restaurante = isset($_GET['restaurante']) ? htmlspecialchars(urldecode($_GET['restaurante'])) : '';
$error = '';

if (empty($restaurante)) {
    $error = 'Error: No se especificó un restaurante.';
} else {
    try {
        $stmt = $pdo->prepare("SELECT web_url FROM restaurantes WHERE nombre = ?");
        $stmt->execute([$restaurante]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$resultado || empty($resultado['web_url'])) {
            $error = 'Error: No se encontró la URL del restaurante.';
        } else {
            $web_url = htmlspecialchars($resultado['web_url']);
        }
    } catch (PDOException $e) {
        $error = 'Error al consultar la base de datos: ' . htmlspecialchars($e->getMessage());
    }
}
?>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100dvh;
        }

        iframe {
            width: 100%;
            height: 100dvh;
            border: none;
            display: block;
        }
    </style>
<body>
    <?php if ($error): ?>
        <p style="text-align: center; color: red;"><?php echo $error; ?></p>
    <?php else: ?>
        <iframe 
            id="webapp-content" 
            src="<?php echo $web_url; ?>" 
            title="Webapp de <?php echo htmlspecialchars($restaurante); ?>"
            sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
        ></iframe>
    <?php endif; ?>
