<?php
require_once 'includes/conexion.php';

// Definir la ruta base del proyecto
define('BASE_PATH', __DIR__ . '/');

try {
    // Consulta para subcategorías
    $stmt_subcategorias = $pdo->query("SELECT nombre FROM subcategorias WHERE rubro_id = 1 ORDER BY nombre");
    $subcategorias = $stmt_subcategorias->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para distritos
    $stmt_distritos = $pdo->query("SELECT nombre FROM distritos ORDER BY nombre");
    $distritos = $stmt_distritos->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para gastronomía
    $stmt_gastronomia = $pdo->prepare("
        SELECT 
            g.id, g.nombre, g.descripcion, g.direccion, g.horarios, g.whatsapp, 
            g.sitio_web, g.app_url, g.latitud, g.longitud, g.foto_perfil_url, 
            g.banner_url, g.es_embajador, g.especialidad_culinaria, g.menu_url,
            g.precio_promedio, g.vendemas_url, g.reservas_url, 
            g.facebook_url, g.instagram_url, g.tiktok_url,
            s.nombre AS subcategoria, COALESCE(d.nombre, 'Sin distrito') AS distrito
        FROM gastronomia g
        INNER JOIN subcategorias s ON g.subcategoria_id = s.id
        LEFT JOIN distritos d ON g.distrito_id = d.id
        WHERE g.rubro_id = 1
        ORDER BY g.nombre
    ");
    $stmt_gastronomia->execute();
    $gastronomia = $stmt_gastronomia->fetchAll(PDO::FETCH_ASSOC);

    if (empty($gastronomia)) {
        $error_message = "No se encontraron restaurantes en la base de datos.";
    }
} catch (PDOException $e) {
    $error_message = "Error al cargar datos: " . htmlspecialchars($e->getMessage());
}
?>

<link rel="stylesheet" href="assets/css/gastronomia.css">
<div class="restaurantes-container bg-gray-900 p-4">
    <div class="header">
        <div class="search-bar relative">
            <input id="filtro-busqueda" type="text" placeholder="Busca un restaurante o comida" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-yellow-400 outline-none" aria-label="Buscar restaurantes por nombre, descripción, subcategoria o especialidad">
            <i class="fas fa-search text-yellow-400 absolute right-3 top-2.5"></i>
        </div>
        <div class="filter-buttons flex justify-center gap-2 py-2">
            <button id="filtro-tipo" class="filter-btn bg-gray-700 text-white px-3 py-1 rounded" aria-label="Filtrar por subcategoria"><i class="fas fa-utensils"></i></button>
            <button id="filtro-distrito" class="filter-btn bg-gray-700 text-white px-3 py-1 rounded" aria-label="Filtrar por distrito"><i class="fas fa-map-marker-alt"></i></button>
            <button id="filtro-precio" class="filter-btn bg-gray-700 text-white px-3 py-1 rounded" aria-label="Filtrar por precio"><i class="fas fa-money-bill"></i></button>
            <button id="borrar-filtros" class="filter-btn bg-gray-700 text-white px-3 py-1 rounded" aria-label="Borrar filtros"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div id="restaurantes-lista" class="restaurantes-lista flex flex-col gap-3" aria-live="polite">
        <?php if (isset($error_message)): ?>
            <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
        <?php else: ?>
            <?php foreach ($gastronomia as $restaurante): ?>
                <?php
                // Generar descripción breve
                $descripcion_breve = strlen($restaurante['descripcion']) > 100 
                    ? substr($restaurante['descripcion'], 0, 100) . '...' 
                    : $restaurante['descripcion'];

                // Usar directamente las URLs de la base de datos
                $logo_src = $restaurante['foto_perfil_url'] ?: '';
                $plato_src = $restaurante['banner_url'] ?: '';

                // Generar maps_url
                $maps_url = $restaurante['latitud'] && $restaurante['longitud']
                    ? "https://www.google.com/maps?q={$restaurante['latitud']},{$restaurante['longitud']}"
                    : '';

                // Generar whatsapp_url
                $whatsapp_url = $restaurante['whatsapp']
                    ? "https://wa.me/" . preg_replace('/[^0-9]/', '', $restaurante['whatsapp'])
                    : '';
                ?>
                <div class="acordeon <?php echo htmlspecialchars(strtolower(str_replace(' ', '-', $restaurante['subcategoria']))); ?>" 
                     data-id="<?php echo htmlspecialchars($restaurante['id']); ?>" 
                     data-tipo="<?php echo htmlspecialchars($restaurante['subcategoria']); ?>" 
                     data-distrito="<?php echo htmlspecialchars($restaurante['distrito']); ?>" 
                     data-title="<?php echo htmlspecialchars($restaurante['nombre']); ?>" 
                     data-descripcion-breve="<?php echo htmlspecialchars($descripcion_breve); ?>" 
                     data-descripcion="<?php echo htmlspecialchars($restaurante['descripcion']); ?>" 
                     data-ubicacion="<?php echo htmlspecialchars($restaurante['direccion']); ?>" 
                     <?php if ($maps_url): ?>data-maps="<?php echo htmlspecialchars($maps_url); ?>"<?php endif; ?>
                     data-horario="<?php echo htmlspecialchars($restaurante['horarios']); ?>" 
                     <?php if ($whatsapp_url): ?>data-whatsapp="<?php echo htmlspecialchars($whatsapp_url); ?>"<?php endif; ?>
                     data-platos="<?php echo htmlspecialchars($restaurante['especialidad_culinaria']); ?>" 
                     data-vendemas="<?php echo $restaurante['es_embajador'] ? 'true' : 'false'; ?>" 
                     <?php if ($restaurante['latitud']): ?>data-lat="<?php echo htmlspecialchars($restaurante['latitud']); ?>"<?php endif; ?>
                     <?php if ($restaurante['longitud']): ?>data-lon="<?php echo htmlspecialchars($restaurante['longitud']); ?>"<?php endif; ?>
                     data-precio-promedio="<?php echo htmlspecialchars($restaurante['precio_promedio'] ?: 0); ?>">
                    <div class="acordeon-header">
                        <?php if ($logo_src): ?>
                            <img class="acordeon-logo" src="<?php echo htmlspecialchars($logo_src); ?>" alt="Logo <?php echo htmlspecialchars($restaurante['nombre']); ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="acordeon-info">
                            <h3 class="acordeon-nombre">
                                <?php echo htmlspecialchars($restaurante['nombre']); ?>
                                <?php if ($restaurante['es_embajador']): ?>
                                    <i class="fas fa-crown premium-icon"></i>
                                <?php endif; ?>
                            </h3>
                            <p class="acordeon-descripcion-breve"><?php echo htmlspecialchars($descripcion_breve); ?></p>
                            <p class="acordeon-direccion"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($restaurante['direccion'] ?: $restaurante['distrito']); ?></p>
                        </div>
                        <i class="fas fa-chevron-down acordeon-flecha"></i>
                    </div>
                    <div class="acordeon-contenido">
                        <?php if ($plato_src): ?>
                            <img class="acordeon-imagen" src="<?php echo htmlspecialchars($plato_src); ?>" alt="<?php echo htmlspecialchars($restaurante['nombre']); ?>" loading="lazy">
                        <?php endif; ?>
                        <p class="acordeon-tipo"><?php echo htmlspecialchars($restaurante['subcategoria']); ?></p>
                        <p class="acordeon-descripcion"><?php echo htmlspecialchars($restaurante['descripcion']); ?></p>
                        <p class="acordeon-ubicacion"><i class="fas fa-map-marked-alt"></i> <a href="<?php echo htmlspecialchars($maps_url); ?>" target="_blank"><?php echo htmlspecialchars($restaurante['direccion'] ?: $restaurante['distrito']); ?></a></p>
                        <p class="acordeon-horario"><i class="fas fa-clock"></i> <?php echo htmlspecialchars($restaurante['horarios']); ?></p>
                        <?php if ($restaurante['especialidad_culinaria']): ?>
                            <ul class="acordeon-platos">
                                <?php 
                                $platos = explode(',', $restaurante['especialidad_culinaria']);
                                foreach ($platos as $plato): ?>
                                    <li><i class="fas fa-utensils"></i> <?php echo htmlspecialchars(trim($plato)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="acordeon-botones">
                            <?php if ($restaurante['reservas_url']): ?>
                                <a href="<?php echo htmlspecialchars($restaurante['reservas_url']); ?>" target="_blank" class="boton-reservas">Reservas</a>
                            <?php endif; ?>
                        </div>
                        <?php if ($restaurante['vendemas_url']): ?>
                            <a href="<?php echo htmlspecialchars($restaurante['vendemas_url']); ?>" target="_blank" class="boton-vendemas"><span class="vendemas-texto">Vende</span><span class="vendemas-plus">+</span></a>
                        <?php endif; ?>
                        <div class="acordeon-iconos">
                            <?php if ($maps_url): ?>
                                <a href="<?php echo htmlspecialchars($maps_url); ?>" target="_blank" class="icono-maps"><i class="fas fa-map"></i></a>
                            <?php endif; ?>
                            <?php if ($whatsapp_url): ?>
                                <a href="<?php echo htmlspecialchars($whatsapp_url); ?>" target="_blank" class="icono-whatsapp"><i class="fab fa-whatsapp"></i></a>
                            <?php endif; ?>
                            <?php if ($restaurante['menu_url']): ?>
                                <a href="<?php echo htmlspecialchars($restaurante['menu_url']); ?>" target="_blank" class="icono-menu"><i class="fas fa-utensils"></i></a>
                            <?php endif; ?>
                            <?php if ($restaurante['facebook_url']): ?>
                                <a href="<?php echo htmlspecialchars($restaurante['facebook_url']); ?>" target="_blank" class="icono-facebook"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($restaurante['instagram_url']): ?>
                                <a href="<?php echo htmlspecialchars($restaurante['instagram_url']); ?>" target="_blank" class="icono-instagram"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ($restaurante['tiktok_url']): ?>
                                <a href="<?php echo htmlspecialchars($restaurante['tiktok_url']); ?>" target="_blank" class="icono-tiktok"><i class="fab fa-tiktok"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Modal para filtro de subcategoria -->
    <div id="modal-tipo" class="filter-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 p-4 rounded-lg max-w-sm w-full">
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por subcategoría</h2>
            <div class="tipo-options flex flex-col gap-2 max-h-[50vh] overflow-y-auto">
                <label class="text-gray-300"><input type="radio" name="tipo" value="todos" checked> Todos</label>
                <?php foreach ($subcategorias as $subcategoria): ?>
                    <label class="text-gray-300"><input type="radio" name="tipo" value="<?php echo htmlspecialchars($subcategoria['nombre']); ?>"> <?php echo htmlspecialchars($subcategoria['nombre']); ?></label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button id="cerrar-modal-tipo" class="text-gray-400 hover:text-yellow-400">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal para filtro de distrito -->
    <div id="modal-distrito" class="filter-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 p-4 rounded-lg max-w-sm w-full">
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por distrito</h2>
            <div class="distrito-options flex flex-col gap-2 max-h-[50vh] overflow-y-auto">
                <label class="text-gray-300"><input type="radio" name="distrito" value="todos" checked> Todos</label>
                <?php foreach ($distritos as $distrito): ?>
                    <label class="text-gray-300"><input type="radio" name="distrito" value="<?php echo htmlspecialchars($distrito['nombre']); ?>"> <?php echo htmlspecialchars($distrito['nombre']); ?></label>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button id="cerrar-modal-distrito" class="text-gray-400 hover:text-yellow-400">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal para filtro de precio -->
    <div id="modal-precio" class="filter-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 p-4 rounded-lg max-w-sm w-full">
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por precio</h2>
            <div class="precio-options flex flex-col gap-2 max-h-[50vh] overflow-y-auto">
                <label class="text-gray-300"><input type="radio" name="precio" value="todos" checked> Todos</label>
                <label class="text-gray-300"><input type="radio" name="precio" value="0-20"> S/ 0 - S/ 20</label>
                <label class="text-gray-300"><input type="radio" name="precio" value="20-40"> S/ 20 - S/ 40</label>
                <label class="text-gray-300"><input type="radio" name="precio" value="40-60"> S/ 40 - S/ 60</label>
                <label class="text-gray-300"><input type="radio" name="precio" value="60+"> S/ 60+</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button id="cerrar-modal-precio" class="text-gray-400 hover:text-yellow-400">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Loader -->
    <div id="loader" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-40">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-yellow-400"></div>
    </div>
</div>
<script src="assets/js/gastronomia.js"></script>