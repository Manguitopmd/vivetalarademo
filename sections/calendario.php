<?php
require_once 'includes/conexion.php';


// Obtener festividades desde la base de datos para el año 2025
$year = '2025'; // Año fijo para el calendario
$stmt = $pdo->prepare("
    SELECT fi.id, fi.titulo AS title, CONCAT(?, '-', LPAD(fi.mes, 2, '0'), '-', LPAD(fi.dia, 2, '0')) AS date, 
           fi.descripcion_corta AS description, ac.tipo_recurso AS category
    FROM fechas_importantes fi
    LEFT JOIN articulos_contenido ac ON fi.articulo_id = ac.id
    WHERE fi.mes IS NOT NULL AND fi.dia IS NOT NULL
    ORDER BY fi.mes, fi.dia
");
$stmt->execute([$year]);
$festividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section id="calendario" class="section">
  <!-- Llamadas a CSS y JS -->
  <link rel="stylesheet" href="assets/css/calendario.css">
  
  <!-- HTML del calendario -->
  <h1 class="welcome-title">Calendario Talareño</h1>
  <p class="intro-text">
    ¡Vive la magia de sus festividades y su gente!
  </p>
  <div class="calendario-controls">
    <button id="calendario-prev-month" class="arrow-btn"><i class="fas fa-chevron-left"></i></button>
    <span id="calendario-current-month" class="month-title"></span>
    <button id="calendario-next-month" class="arrow-btn"><i class="fas fa-chevron-right"></i></button>
  </div>
  <div class="calendario-grid-container">
    <!-- Encabezados de días de la semana -->
    <div class="calendario-days-header">
      <div class="day-header">Lun</div>
      <div class="day-header">Mar</div>
      <div class="day-header">Mié</div>
      <div class="day-header">Jue</div>
      <div class="day-header">Vie</div>
      <div class="day-header">Sáb</div>
      <div class="day-header">Dom</div>
    </div>
    <div id="calendario-grid" class="calendario-grid"></div>
  </div>

  <!-- Sección dinámica con contenedor -->
  <div class="festividades-container">
    <div id="calendario-festividades">
      <h2 id="festividades-title" class="festividades-title">Conoce Nuestras Festividades</h2>
      <p id="festividades-description" class="festividades-description">
        En Talara, cada fiesta es un encuentro de cultura, fe y alegría. Procesiones, danzas y tradiciones que nos unen.
      </p>
      <a id="festividades-button" href="#" class="btn-conocer-mas" style="display: none;">Conocer Más</a>
    </div>
  </div>

  <!-- Pasar festividades a JS -->
  <script>
    const festividades = <?php echo json_encode($festividades); ?>;
  </script>
  <script src="assets/js/calendario.js"></script>
</section>