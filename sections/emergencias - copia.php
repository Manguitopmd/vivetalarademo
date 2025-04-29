<?php
/**
 * Sección de Emergencias de Travel Talara
 * Divide en Números de Emergencia, Ubicaciones Clave, Consejos y Kit (acordeón)
 */

// Datos estáticos (emulando la base de datos de eventos)
$distritos = [
    ['id' => 1, 'nombre' => 'Nacional'],
    ['id' => 2, 'nombre' => 'Pariñas'],
    ['id' => 3, 'nombre' => 'Máncora'],
    ['id' => 4, 'nombre' => 'Los Órganos']
];

$servicios = [
    ['nombre' => 'Policía'],
    ['nombre' => 'Ambulancia'],
    ['nombre' => 'Bomberos'],
    ['nombre' => 'Serenazgo'],
    ['nombre' => 'Farmacia'],
    ['nombre' => 'Hospital'],
    ['nombre' => 'Turista'],
    ['nombre' => 'General']
];

$numeros_emergencia = [
    [
        'id' => 1, 'titulo' => 'Policía Nacional', 'descripcion' => 'Emergencias nacionales', 
        'telefono' => '105', 'whatsapp_url' => 'https://wa.me/+51964605570', 'distrito_id' => 1, 'servicio' => 'Policía', 'icono' => 'fa-siren'
    ],
    [
        'id' => 2, 'titulo' => 'Ambulancia (SAMU)', 'descripcion' => 'Atención médica urgente', 
        'telefono' => '106', 'distrito_id' => 1, 'servicio' => 'Ambulancia', 'icono' => 'fa-ambulance'
    ],
    [
        'id' => 3, 'titulo' => 'Bomberos', 'descripcion' => 'Emergencias de incendios', 
        'telefono' => '116', 'distrito_id' => 1, 'servicio' => 'Bomberos', 'icono' => 'fa-fire'
    ],
    [
        'id' => 4, 'titulo' => 'iPerú (Turistas)', 'descripcion' => 'Asistencia para turistas', 
        'telefono' => '0800-4-8383', 'distrito_id' => 1, 'servicio' => 'Turista', 'icono' => 'fa-info-circle'
    ],
    [
        'id' => 5, 'titulo' => 'Serenazgo Pariñas', 'descripcion' => 'Seguridad local en Pariñas', 
        'telefono' => '+5173382151', 'distrito_id' => 2, 'servicio' => 'Serenazgo', 'icono' => 'fa-shield-alt'
    ]
];

$ubicaciones = [
    [
        'id' => 6, 'titulo' => 'Hospital II Talara', 'descripcion' => 'Av. Bolognesi 123, frente a Plaza Grau', 
        'telefono' => '+5173382141', 'maps_url' => 'https://maps.google.com/?q=-4.579,-81.271', 'distrito_id' => 2, 'servicio' => 'Hospital', 'horario' => '24h', 'icono' => 'fa-hospital'
    ],
    [
        'id' => 7, 'titulo' => 'Comisaría Talara', 'descripcion' => 'Av. Grau 321, al lado del municipio', 
        'telefono' => '+5173382151', 'maps_url' => 'https://maps.google.com/?q=-4.580,-81.270', 'distrito_id' => 2, 'servicio' => 'Policía', 'horario' => '24h', 'icono' => 'fa-siren'
    ],
    [
        'id' => 8, 'titulo' => 'Inkafarma Talara', 'descripcion' => 'Av. Bolognesi 456, a 1 cuadra de Plaza Grau', 
        'telefono' => '+5173382300', 'maps_url' => 'https://maps.google.com/?q=-4.579,-81.272', 'distrito_id' => 2, 'servicio' => 'Farmacia', 'horario' => '24h', 'icono' => 'fa-prescription-bottle'
    ]
];

$consejos_y_kit = [
    [
        'id' => 1, 'titulo' => 'Quemaduras Solares', 'descripcion' => 'Aloe vera, sombra, SPF 50+. Tip: Usa manga larga.', 
        'servicio' => 'Farmacia', 'tipo' => 'consejo', 'icono' => 'fa-sun'
    ],
    [
        'id' => 2, 'titulo' => 'Pérdida de Documentos', 'descripcion' => 'Denuncia en comisaría, contacta iPerú. Tip: Copias digitales.', 
        'servicio' => 'Policía', 'tipo' => 'consejo', 'icono' => 'fa-id-card'
    ],
    [
        'id' => 3, 'titulo' => 'Bloqueador Solar', 'descripcion' => 'SPF 50+ para el sol intenso.', 
        'servicio' => 'Farmacia', 'tipo' => 'kit', 'icono' => 'fa-sun'
    ],
    [
        'id' => 4, 'titulo' => 'Botella de Agua', 'descripcion' => 'Mantente hidratado.', 
        'servicio' => 'General', 'tipo' => 'kit', 'icono' => 'fa-water'
    ]
];
?>

<link rel="stylesheet" href="assets/css/emergencias.css">
<div class="emergencias-container p-4 bg-gray-900 min-h-[calc(100vh-3.5rem)]">
    <!-- Búsqueda -->
    <div class="search-bar flex items-center gap-2 mb-4">
        <input type="text" id="filtro-busqueda" list="sugerencias" class="w-full p-2 bg-gray-800 text-white rounded-md shadow-sm" placeholder="Buscar emergencias..." aria-label="Buscar emergencias por servicio o distrito">
        <datalist id="sugerencias">
            <?php foreach ($distritos as $distrito): ?>
                <option value="<?php echo htmlspecialchars($distrito['nombre']); ?>">
            <?php endforeach; ?>
            <?php foreach ($servicios as $servicio): ?>
                <option value="<?php echo htmlspecialchars($servicio['nombre']); ?>">
            <?php endforeach; ?>
        </datalist>
    </div>

    <!-- Botones de filtros -->
    <div class="filter-buttons flex justify-center gap-4 mb-4">
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="filtro-servicio" aria-label="Filtrar por servicio">
            <i class="fas fa-concierge-bell text-xl"></i>
        </button>
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="filtro-distrito" aria-label="Filtrar por distrito">
            <i class="fas fa-map-marker-alt text-xl"></i>
        </button>
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="filtro-horario" aria-label="Filtrar por horario">
            <i class="fas fa-clock text-xl"></i>
        </button>
        <button class="filter-btn bg-gray-700 text-white p-2 rounded-md" id="borrar-filtros" aria-label="Borrar todos los filtros">
            <i class="fas fa-times-circle text-xl"></i>
        </button>
    </div>

    <!-- Modal de filtro por servicio -->
    <div id="modal-servicio" class="filter-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <button id="cerrar-modal-servicio" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por Servicio</h2>
            <div class="servicio-options flex flex-col gap-2">
                <label for="serv-todos" class="flex items-center gap-2 text-white">
                    <input id="serv-todos" type="checkbox" name="servicio" value="todos" checked class="text-cyan-500">
                    Todos
                </label>
                <?php foreach ($servicios as $index => $servicio): ?>
                    <label for="serv-<?php echo $index; ?>" class="flex items-center gap-2 text-white">
                        <input id="serv-<?php echo $index; ?>" type="checkbox" name="servicio" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" class="text-cyan-500">
                        <?php echo htmlspecialchars($servicio['nombre']); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <button id="aplicar-servicio" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
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
                <?php foreach ($distritos as $index => $distrito): ?>
                    <label for="dist-<?php echo $index; ?>" class="flex items-center gap-2 text-white">
                        <input id="dist-<?php echo $index; ?>" type="radio" name="distrito" value="<?php echo htmlspecialchars($distrito['nombre']); ?>" class="text-cyan-500">
                        <?php echo htmlspecialchars($distrito['nombre']); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <button id="aplicar-distrito" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
    </div>

    <!-- Modal de filtro por horario -->
    <div id="modal-horario" class="filter-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <button id="cerrar-modal-horario" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar por Horario</h2>
            <div class="horario-options flex flex-col gap-2">
                <label for="horario-todos" class="flex items-center gap-2 text-white">
                    <input id="horario-todos" type="radio" name="horario" value="todos" checked class="text-cyan-500">
                    Todos
                </label>
                <label for="horario-24h" class="flex items-center gap-2 text-white">
                    <input id="horario-24h" type="radio" name="horario" value="24h" class="text-cyan-500">
                    24/7
                </label>
                <label for="horario-dia" class="flex items-center gap-2 text-white">
                    <input id="horario-dia" type="radio" name="horario" value="dia" class="text-cyan-500">
                    Diurno
                </label>
            </div>
            <button id="aplicar-horario" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
    </div>

    <!-- Números de Emergencia -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-200 mb-4">Números de Emergencia</h2>
        <div id="numeros-grid" class="emergencias-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" aria-live="polite">
            <?php foreach ($numeros_emergencia as $emergencia): ?>
                <div class="emergency-card <?php echo htmlspecialchars(strtolower($emergencia['servicio'])); ?>" 
                     data-distrito="<?php echo htmlspecialchars($distritos[array_search($emergencia['distrito_id'], array_column($distritos, 'id'))]['nombre']); ?>" 
                     data-servicio="<?php echo htmlspecialchars($emergencia['servicio']); ?>" 
                     data-horario="todos" 
                     data-id="<?php echo htmlspecialchars($emergencia['id']); ?>">
                    <div class="ribbon-distrito ribbon-distrito-<?php echo htmlspecialchars($emergencia['distrito_id']); ?>">
                        <?php echo htmlspecialchars($distritos[array_search($emergencia['distrito_id'], array_column($distritos, 'id'))]['nombre']); ?>
                    </div>
                    <h3><i class="fas <?php echo htmlspecialchars($emergencia['icono']); ?> mr-2"></i><?php echo htmlspecialchars($emergencia['titulo']); ?></h3>
                    <p class="descripcion-breve"><?php echo htmlspecialchars($emergencia['descripcion']); ?></p>
                    <div class="botones flex gap-2 mt-2">
                        <?php if ($emergencia['telefono']): ?>
                            <a href="tel:<?php echo htmlspecialchars($emergencia['telefono']); ?>" class="btn-telefono"><i class="fas fa-phone"></i> Llamar</a>
                        <?php endif; ?>
                        <?php if (isset($emergencia['whatsapp_url'])): ?>
                            <a href="<?php echo htmlspecialchars($emergencia['whatsapp_url']); ?>" target="_blank" class="btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Ubicaciones Clave -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-200 mb-4">Ubicaciones Clave</h2>
        <div id="ubicaciones-grid" class="emergencias-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" aria-live="polite">
            <?php foreach ($ubicaciones as $ubicacion): ?>
                <div class="emergency-card <?php echo htmlspecialchars(strtolower($ubicacion['servicio'])); ?>" 
                     data-distrito="<?php echo htmlspecialchars($distritos[array_search($ubicacion['distrito_id'], array_column($distritos, 'id'))]['nombre']); ?>" 
                     data-servicio="<?php echo htmlspecialchars($ubicacion['servicio']); ?>" 
                     data-horario="<?php echo isset($ubicacion['horario']) ? htmlspecialchars($ubicacion['horario']) : 'todos'; ?>" 
                     data-id="<?php echo htmlspecialchars($ubicacion['id']); ?>">
                    <div class="ribbon-distrito ribbon-distrito-<?php echo htmlspecialchars($ubicacion['distrito_id']); ?>">
                        <?php echo htmlspecialchars($distritos[array_search($ubicacion['distrito_id'], array_column($distritos, 'id'))]['nombre']); ?>
                    </div>
                    <h3><i class="fas <?php echo htmlspecialchars($ubicacion['icono']); ?> mr-2"></i><?php echo htmlspecialchars($ubicacion['titulo']); ?></h3>
                    <p class="descripcion-breve"><?php echo htmlspecialchars($ubicacion['descripcion']); ?></p>
                    <div class="botones flex gap-2 mt-2">
                        <?php if ($ubicacion['telefono']): ?>
                            <a href="tel:<?php echo htmlspecialchars($ubicacion['telefono']); ?>" class="btn-telefono"><i class="fas fa-phone"></i> Llamar</a>
                        <?php endif; ?>
                        <?php if (isset($ubicacion['maps_url'])): ?>
                            <a href="<?php echo htmlspecialchars($ubicacion['maps_url']); ?>" target="_blank" class="btn-maps"><i class="fas fa-map"></i> Mapa</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Consejos y Kit (Acordeón) -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-200 mb-4">Consejos y Kit</h2>
        <div id="consejos-grid" class="emergencias-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" aria-live="polite">
            <?php foreach ($consejos_y_kit as $item): ?>
                <div class="emergency-card <?php echo htmlspecialchars(strtolower($item['servicio'])); ?> accordion-item" 
                     data-servicio="<?php echo htmlspecialchars($item['servicio']); ?>" 
                     data-id="<?php echo htmlspecialchars($item['id']); ?>">
                    <div class="accordion-header">
                        <h3><i class="fas <?php echo htmlspecialchars($item['icono']); ?> mr-2"></i><?php echo htmlspecialchars($item['titulo']); ?></h3>
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p><?php echo htmlspecialchars($item['descripcion']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
<script src="assets/js/emergencias.js"></script>
<?php
// Fin del archivo
?>