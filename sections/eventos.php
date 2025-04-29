<?php
require_once 'includes/conexion.php';

try {
    // Consulta para distritos
    $stmt_distritos = $pdo->query("SELECT id, nombre FROM distritos ORDER BY nombre");
    $distritos = $stmt_distritos->fetchAll(PDO::FETCH_ASSOC);

    // Definir categorías basadas en el ENUM tipo_evento
    $categorias = [
        ['nombre' => 'Celebración'],
        ['nombre' => 'Comercial'],
        ['nombre' => 'Cultural'],
        ['nombre' => 'Deportivo'],
        ['nombre' => 'Educativo'],
        ['nombre' => 'Familiar'],
        ['nombre' => 'Festival'],
        ['nombre' => 'Gastronómico'],
        ['nombre' => 'Musical']
    ];

    // Consulta para eventos
    $stmt_eventos = $pdo->prepare("
        SELECT 
            e.id, e.nombre AS titulo, e.descripcion, e.fecha_inicio AS fecha, e.fecha_fin,
            e.latitud, e.longitud, e.organizador, e.web_url, e.fotos_url AS imagen_url,
            e.videos_url AS video_url, e.whatsapp AS whatsapp_url, e.ubicacion_url AS maps_url,
            e.tickets_url, e.es_destacado AS es_premium, d.id AS distrito_id, d.nombre AS distrito,
            e.tipo_evento AS categoria
        FROM eventos e
        INNER JOIN distritos d ON e.distrito_id = d.id
        ORDER BY e.es_destacado DESC, e.fecha_inicio ASC
    ");
    $stmt_eventos->execute();
    $eventos = $stmt_eventos->fetchAll(PDO::FETCH_ASSOC);

    // Normalizar categorías para el frontend
    foreach ($eventos as &$evento) {
        $evento['categoria'] = strtolower(str_replace('ó', 'o', $evento['categoria']));
    }
} catch (PDOException $e) {
    $error_message = "Error al cargar datos: " . htmlspecialchars($e->getMessage());
}

// Array para traducir meses al español
$meses_es = [
    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
    7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
];
?>

<link rel="stylesheet" href="assets/css/eventos.css">
<div class="eventos-container p-4 bg-gray-900 min-h-[calc(100vh-3.5rem)]">
    <!-- Búsqueda -->
    <div class="search-bar flex items-center gap-2 mb-4">
        <input type="text" id="filtro-busqueda" list="sugerencias" class="w-full p-2 bg-gray-800 text-white rounded-md shadow-sm" placeholder="Buscar eventos..." aria-label="Buscar eventos por nombre, descripción, distrito o categoría">
        <datalist id="sugerencias">
            <?php foreach ($distritos as $distrito): ?>
                <option value="<?php echo htmlspecialchars($distrito['nombre']); ?>">
            <?php endforeach; ?>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo htmlspecialchars($categoria['nombre']); ?>">
            <?php endforeach; ?>
        </datalist>
    </div>

    <!-- Botones de filtros -->
    <div class="filter-buttons flex justify-center gap-4 mb-4">
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="filtro-distrito" aria-label="Filtrar por distrito">
            <i class="fas fa-map-marker-alt text-xl"></i>
        </button>
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="filtro-fecha" aria-label="Filtrar por fecha">
            <i class="fas fa-calendar-alt text-xl"></i>
        </button>
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="filtro-categoria" aria-label="Filtrar por categoría">
            <i class="fas fa-tags text-xl"></i>
        </button>
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="borrar-filtros" aria-label="Borrar todos los filtros">
            <i class="fas fa-times-circle text-xl"></i>
        </button>
    </div>

    <!-- Modal de filtro por distrito -->
    <div id="modal-distrito" class="filter-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <button id="cerrar-modal-distrito" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por Distrito</h2>
            <div class="distrito-options flex flex-col gap-2">
                <label for="dist-todos" class="flex items-center gap-2 text-white">
                    <input id="dist-todos" type="radio" name="distrito" value="todos" checked class="text-cyan-500">
                    Todos
                </label>
                <?php foreach ($distritos as $distrito): ?>
                    <label for="dist-<?php echo htmlspecialchars($distrito['id']); ?>" class="flex items-center gap-2 text-white">
                        <input id="dist-<?php echo htmlspecialchars($distrito['id']); ?>" type="radio" name="distrito" value="<?php echo htmlspecialchars($distrito['nombre']); ?>" class="text-cyan-500">
                        <?php echo htmlspecialchars($distrito['nombre']); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <button id="aplicar-distrito" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
    </div>

    <!-- Modal de filtro por fecha -->
    <div id="modal-fecha" class="filter-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <button id="cerrar-modal-fecha" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por Fecha</h2>
            <div class="fecha-options flex flex-col gap-2">
                <label for="fecha-todos" class="flex items-center gap-2 text-white">
                    <input id="fecha-todos" type="radio" name="fecha" value="todos" checked class="text-cyan-500">
                    Todas las fechas
                </label>
                <label for="fecha-hoy" class="flex items-center gap-2 text-white">
                    <input id="fecha-hoy" type="radio" name="fecha" value="hoy" class="text-cyan-500">
                    Hoy
                </label>
                <label for="fecha-semana" class="flex items-center gap-2 text-white">
                    <input id="fecha-semana" type="radio" name="fecha" value="semana" class="text-cyan-500">
                    Esta semana
                </label>
                <label for="fecha-mes" class="flex items-center gap-2 text-white">
                    <input id="fecha-mes" type="radio" name="fecha" value="mes" class="text-cyan-500">
                    Este mes
                </label>
                <label for="fecha-custom" class="flex items-center gap-2 text-white">
                    <input id="fecha-custom" type="radio" name="fecha" value="custom" class="text-cyan-500">
                    Rango personalizado
                </label>
                <div id="rango-fecha" class="hidden flex flex-col gap-2 mt-2">
                    <input type="date" id="fecha-inicio" class="p-2 bg-gray-700 text-white rounded-md" aria-label="Fecha de inicio">
                    <input type="date" id="fecha-fin" class="p-2 bg-gray-700 text-white rounded-md" aria-label="Fecha de fin">
                </div>
            </div>
            <button id="aplicar-fecha" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
    </div>

    <!-- Modal de filtro por categoría -->
    <div id="modal-categoria" class="filter-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <button id="cerrar-modal-categoria" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por Categoría</h2>
            <div class="categoria-options flex flex-col gap-2">
                <?php foreach ($categorias as $index => $categoria): ?>
                    <label for="cat-<?php echo $index; ?>" class="flex items-center gap-2 text-white">
                        <input id="cat-<?php echo $index; ?>" type="checkbox" name="categoria" value="<?php echo htmlspecialchars(strtolower(str_replace('ó', 'o', $categoria['nombre']))); ?>" class="text-cyan-500">
                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <button id="aplicar-categoria" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
    </div>

    <!-- Cuadrícula de eventos -->
    <div id="eventos-grid" class="eventos-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" aria-live="polite">
        <?php if (isset($error_message)): ?>
            <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
        <?php else: ?>
            <?php foreach ($eventos as $evento): ?>
                <div class="evento-card <?php echo htmlspecialchars($evento['categoria']); ?> <?php echo $evento['es_premium'] ? 'featured' : ''; ?>" 
                     data-distrito="<?php echo htmlspecialchars($evento['distrito']); ?>" 
                     data-categoria="<?php echo htmlspecialchars($evento['categoria']); ?>" 
                     data-fecha="<?php echo htmlspecialchars($evento['fecha']); ?>" 
                     data-fecha-fin="<?php echo htmlspecialchars($evento['fecha_fin'] ?? ''); ?>" 
                     data-id="<?php echo htmlspecialchars($evento['id']); ?>" 
                     data-title="<?php echo htmlspecialchars($evento['titulo']); ?>" 
                     data-descripcion="<?php echo htmlspecialchars($evento['descripcion']); ?>" 
                     <?php if ($evento['imagen_url']): ?>data-image="<?php echo htmlspecialchars($evento['imagen_url']); ?>"<?php endif; ?>
                     <?php if ($evento['video_url']): ?>data-video="<?php echo htmlspecialchars($evento['video_url']); ?>"<?php endif; ?>
                     <?php if ($evento['whatsapp_url']): ?>data-whatsapp="<?php echo htmlspecialchars($evento['whatsapp_url']); ?>"<?php endif; ?>
                     <?php if ($evento['maps_url']): ?>data-maps="<?php echo htmlspecialchars($evento['maps_url']); ?>"<?php endif; ?>
                     <?php if ($evento['tickets_url']): ?>data-tickets="<?php echo htmlspecialchars($evento['tickets_url']); ?>"<?php endif; ?>
                     <?php if ($evento['organizador']): ?>data-organizador="<?php echo htmlspecialchars($evento['organizador']); ?>"<?php endif; ?>
                     <?php if ($evento['web_url']): ?>data-web-url="<?php echo htmlspecialchars($evento['web_url']); ?>"<?php endif; ?>
                     <?php if ($evento['latitud']): ?>data-latitud="<?php echo htmlspecialchars($evento['latitud']); ?>"<?php endif; ?>
                     <?php if ($evento['longitud']): ?>data-longitud="<?php echo htmlspecialchars($evento['longitud']); ?>"<?php endif; ?>
                     data-premium="<?php echo $evento['es_premium'] ? 'true' : 'false'; ?>">
                    <div class="ribbon-distrito ribbon-distrito-<?php echo htmlspecialchars($evento['distrito_id']); ?>">
                        <?php echo htmlspecialchars($evento['distrito']); ?>
                    </div>
                    <?php if ($evento['es_premium']): ?>
                        <span class="destacado">Destacado</span>
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                    <p class="fecha">
                        <?php 
                        $fecha = new DateTime($evento['fecha']);
                        $dia = $fecha->format('d');
                        $mes = $meses_es[(int)$fecha->format('n')];
                        $anio = $fecha->format('Y');
                        echo "$dia de $mes de $anio";
                        ?>
                    </p>
                    <p class="descripcion-breve"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                    <p class="organizador"><?php echo htmlspecialchars($evento['organizador'] ?: 'No especificado'); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Modal de detalles del evento -->
    <div id="evento-modal" class="evento-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content rounded-lg p-6 max-w-lg w-full max-h-[90vh] overflow-y-auto relative">
            <button id="cerrar-modal" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <div id="modal-body"></div>
        </div>
    </div>
</div>
<script src="assets/js/eventos.js"></script>