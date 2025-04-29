<?php
require_once 'includes/conexion.php';

// Obtener ID de la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consultar datos de la festividad
$stmt = $pdo->prepare("
    SELECT fi.id, fi.titulo AS title, CONCAT(?, '-', LPAD(fi.mes, 2, '0'), '-', LPAD(fi.dia, 2, '0')) AS date, 
           ac.tipo_recurso AS category, ac.foto_principal, ac.parrafo_inicial,
           ac.latitud, ac.longitud, ac.informacion_vital
    FROM fechas_importantes fi
    LEFT JOIN articulos_contenido ac ON fi.articulo_id = ac.id
    WHERE fi.id = ?
");
$stmt->execute([date('Y'), $id]);
$festividad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$festividad) {
    echo '<p style="color: red;">Festividad no encontrada.</p>';
    return;
}

// Consultar elementos de contenido (párrafos, imágenes, videos, etc.)
$stmt = $pdo->prepare("
    SELECT tipo, contenido, orden
    FROM articulo_contenido_elementos
    WHERE articulo_id = (SELECT articulo_id FROM fechas_importantes WHERE id = ?)
    ORDER BY orden
");
$stmt->execute([$id]);
$elementos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar elementos
$contenido = [];
$images = [$festividad['foto_principal']]; // Iniciar con la foto principal
$album = [];
$video = '';
$location = null;
$venue = null;

foreach ($elementos as $elem) {
    switch ($elem['tipo']) {
        case 'parrafo':
            $contenido[] = '<p>' . htmlspecialchars($elem['contenido']) . '</p>';
            break;
        case 'imagen':
            $images[] = $elem['contenido'];
            $album[] = $elem['contenido'];
            break;
        case 'video':
            $video = $elem['contenido'];
            break;
        case 'boton_mapa':
            $map_data = json_decode($elem['contenido'], true);
            if ($map_data) {
                if (!$location) {
                    $location = ['name' => $map_data['name'], 'maps' => $map_data['url']];
                } else {
                    $venue = ['name' => $map_data['name'], 'maps' => $map_data['url']];
                }
            }
            break;
    }
}

// Agregar párrafo inicial
array_unshift($contenido, '<p>' . htmlspecialchars($festividad['parrafo_inicial']) . '</p>');

$festividad['images'] = $images;
$festividad['album'] = $album;
$festividad['video'] = $video;
$festividad['location'] = $location;
$festividad['venue'] = $venue;
$festividad['content'] = implode('', $contenido);

?>

<link rel="stylesheet" href="assets/css/festividad.css">
<section id="festividad" class="section">
  <!-- Hero Section -->
  <div class="festividad-hero" style="background-image: url('<?php echo htmlspecialchars($festividad['images'][0]); ?>');">
    <div class="hero-overlay">
      <h1 class="festividad-title"><?php echo htmlspecialchars($festividad['title']); ?></h1>
      <p class="festividad-meta">Fecha: <?php echo date('d/m/Y', strtotime($festividad['date'])); ?> | Categoría: <?php echo htmlspecialchars($festividad['category']); ?></p>
    </div>
  </div>

  <main class="festividad-main">
    <!-- Contenido mezclado -->
    <div class="festividad-contenido">
      <?php
        $paragraphs = explode('</p>', $festividad['content']);
        $paragraphCount = count(array_filter($paragraphs, 'trim'));
        $imageIndex = 0;
        $sliderInserted = false;
        $videoInserted = false;

        foreach ($paragraphs as $index => $p) {
            if (trim($p)) {
                echo '<div class="contenido-paragraph">' . $p . '</p></div>';

                // Insertar elementos visuales después de cada párrafo
                if ($index < $paragraphCount - 1) {
                    if (!$videoInserted && $festividad['video'] && $index == 1) {
                        echo '<div class="festividad-video">';
                        echo '<h2 class="section-title">Vive la Magia con Nosotros</h2>';
                        echo '<div class="video-container">';
                        echo '<iframe src="' . htmlspecialchars($festividad['video']) . '" frameborder="0" allowfullscreen></iframe>';
                        echo '</div>';
                        echo '</div>';
                        $videoInserted = true;
                    } elseif ($imageIndex < count($festividad['images']) && !$sliderInserted && $index == 0) {
                        echo '<div class="festividad-image">';
                        echo '<img src="' . htmlspecialchars($festividad['images'][$imageIndex]) . '" alt="' . htmlspecialchars($festividad['title']) . '">';
                        echo '</div>';
                        $imageIndex++;
                    } elseif (!$sliderInserted && $index == 2 && !empty($festividad['images'])) {
                        echo '<div class="festividad-slider">';
                        echo '<h2 class="section-title">Siente el Ritmo de Talara</h2>';
                        echo '<div class="slider-container">';
                        foreach ($festividad['images'] as $imgIndex => $img) {
                            echo '<img src="' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($festividad['title']) . '" class="' . ($imgIndex === 0 ? 'active' : '') . '">';
                        }
                        echo '</div>';
                        echo '<button class="slider-prev"><i class="fas fa-chevron-left"></i></button>';
                        echo '<button class="slider-next"><i class="fas fa-chevron-right"></i></button>';
                        echo '</div>';
                        $sliderInserted = true;
                    } elseif ($imageIndex < count($festividad['images'])) {
                        echo '<div class="festividad-image">';
                        echo '<img src="' . htmlspecialchars($festividad['images'][$imageIndex]) . '" alt="' . htmlspecialchars($festividad['title']) . '">';
                        echo '</div>';
                        $imageIndex++;
                    }
                }
            }
        }
      ?>
    </div>

    <!-- Álbum -->
    <?php if (!empty($festividad['album'])) { ?>
      <div class="festividad-album">
        <h2 class="section-title">Recuerdos que Inspiran</h2>
        <div class="album-grid">
          <?php foreach ($festividad['album'] as $img) { ?>
            <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($festividad['title']); ?>">
          <?php } ?>
        </div>
      </div>
    <?php } ?>

    <!-- Ubicaciones -->
    <?php if ($festividad['location'] || $festividad['venue']) { ?>
      <div class="festividad-locations">
        <h2 class="section-title">Únete a la Fiesta</h2>
        <div class="locations-grid">
          <?php if ($festividad['location']) { ?>
            <a href="<?php echo htmlspecialchars($festividad['location']['maps']); ?>" target="_blank" class="location-card">
              <i class="fas fa-map-marker-alt"></i>
              <span><?php echo htmlspecialchars($festividad['location']['name']); ?></span>
            </a>
          <?php } ?>
          <?php if ($festividad['venue']) { ?>
            <a href="<?php echo htmlspecialchars($festividad['venue']['maps']); ?>" target="_blank" class="location-card">
              <i class="fas fa-map-marker-alt"></i>
              <span><?php echo htmlspecialchars($festividad['venue']['name']); ?></span>
            </a>
          <?php } ?>
        </div>
      </div>
    <?php } ?>

    <!-- Botones sociales -->
    <div class="festividad-sociales">
      <h2 class="section-title">Lleva Talara al Mundo</h2>
      <div class="social-buttons">
        <a href="https://wa.me/?text=<?php echo urlencode('Mira esta festividad: ' . $festividad['title'] . ' en TravelTalara!'); ?>" target="_blank" class="btn-social whatsapp" title="Compartir en WhatsApp"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="btn-social facebook" title="Compartir en Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="btn-social instagram" title="Compartir en Instagram"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </main>
  <script src="assets/js/festividad.js"></script>
</section>