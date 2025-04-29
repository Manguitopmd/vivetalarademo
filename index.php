<?php
/**
 * Página principal de TravelTalara
 * Carga secciones dinámicamente según URL
 */
$section = isset($_GET['section']) ? $_GET['section'] : 'home';
$subsection = isset($_GET['subsection']) ? $_GET['subsection'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viva Talara</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Indie+Flower&family=Lobster&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <button class="menu-btn" id="menu-btn">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo-section">
            <span class="vive">Vive</span>  <span class="talara">Talara</span>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidenav-container">
        <div id="sidenav" class="sidenav">
            <div class="logo-section">
                <span class="vive">Vive</span>  <span class="talara">Talara</span>
            </div>
            <div class="menu-section">
                <a href="?section=home"><i class="fas fa-home"></i> Inicio</a>
                <a href="?section=quehacer"><i class="fas fa-compass"></i> Qué Hacer</a>
                <a href="?section=turismo"><i class="fas fa-map-marked-alt"></i> Turismo</a>
                <a href="?section=eventos"><i class="fas fa-calendar-alt"></i> Eventos</a>
                <a href="?section=calendario"><i class="fas fa-calendar-day"></i> Calendario</a>
                <a href="?section=sabiasque"><i class="fas fa-lightbulb"></i> Sabías Qué</a>
                <a href="?section=shop&subsection=catalogo"><i class="fas fa-shopping-cart"></i> Shop</a>
                <a href="?section=promos"><i class="fas fa-tag"></i> Promos</a>
                <a href="?section=vip"><i class="fas fa-crown"></i> VIP</a>
                <a href="?section=emergencias"><i class="fas fa-exclamation-triangle"></i> Emergencias</a>
            </div>
            <div class="bottom-section">
                <a href="?section=configuracion"><i class="fas fa-cog"></i> Configuración</a>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="sidenav-overlay" class="sidenav-overlay"></div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="main-content">
            <?php
            $file = '';

            switch ($section) {
                case 'home':
                    $file = 'sections/home.php';
                    break;
                case 'quehacer':
                    $file = 'sections/que-hacer.php';
                    break;
                case 'turismo':
                    $file = 'sections/turismo.php';
                    break;
                case 'eventos':
                    $file = 'sections/eventos.php';
                    break;
                case 'sabiasque':
                    $file = 'sections/sabiasque.php';
                    break;
                case 'favoritos':
                    $file = 'sections/favoritos.php';
                    break;
                case 'shop':
                    $file = 'sections/shop.php';
                    break;
                case 'calendario':
                    $file = 'sections/calendario.php';
                    break;
                case 'promos':
                    $file = 'sections/promos.php';
                    break;
                case 'vip':
                    $file = 'sections/vip.php';
                    break;
                case 'emergencias':
                    $file = 'sections/emergencias.php';
                    break;
                case 'configuracion':
                    $file = 'sections/configuracion.php';
                    break;
                case 'gastronomia':
                    $file = 'sections/gastronomia.php';
                    break;
                case 'festividad':
                    $file = 'sections/calendario/festividad.php';
                    break;
                default:
                    $file = 'sections/home.php';
            }

            if (file_exists($file)) {
                include $file;
            } else {
                echo '<p style="color: red;">Sección no encontrada.</p>';
            }
            ?>
        </div>
    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidenav = document.getElementById('sidenav');
        const overlay = document.getElementById('sidenav-overlay');

        menuBtn.addEventListener('click', () => {
            sidenav.classList.toggle('open');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidenav.classList.remove('open');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>