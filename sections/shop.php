<?php
/**
 * Contenedor principal para la sección Shop de TravelTalara
 * Menú inferior con solo Catálogo y Carrito, diseño notorio con nueva paleta
 */
$subsection = isset($_GET['subsection']) ? $_GET['subsection'] : 'catalogo';
?>

<link rel="stylesheet" href="assets/css/shop.css">

<main id="content" class="flex-1">
    <?php
    $file = '';
    switch ($subsection) {
        case 'catalogo':
            $file = 'sections/catalogo.php';
            break;
        case 'carrito':
            $file = 'sections/carrito.php';
            break;
        default:
            $file = 'sections/catalogo.php';
    }

    if (file_exists($file)) {
        include $file;
    } else {
        echo '<div class="error-message"><h3>Error</h3><p>Sección no encontrada.</p></div>';
    }
    ?>
</main>

<!-- Barra inferior de navegación -->
<nav class="bottom-nav">
    <button class="nav-btn <?php echo $subsection === 'catalogo' ? 'active' : ''; ?>" onclick="window.location.href='?section=shop&subsection=catalogo'" aria-label="Ver el catálogo de ropa">
        <i class="fas fa-tshirt"></i>
        <span>Catálogo</span>
    </button>
    <button class="nav-btn <?php echo $subsection === 'carrito' ? 'active' : ''; ?>" onclick="window.location.href='?section=shop&subsection=carrito'" aria-label="Ver el carrito de compras">
        <i class="fas fa-shopping-cart" id="cart-icon"></i>
        <span>Carrito</span>
        <span id="cart-count" class="cart-count hidden">0</span>
    </button>
</nav>

<script src="assets/js/shop.js"></script>