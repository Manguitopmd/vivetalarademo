<?php
// Obtener ID del artículo
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Datos estáticos
$categorias = [
    ['id' => 1, 'nombre' => 'Historia', 'color' => 'history-btn'],
    ['id' => 2, 'nombre' => 'Personajes', 'color' => 'characters-btn'],
    ['id' => 3, 'nombre' => 'Mitos', 'color' => 'myths-btn'],
    ['id' => 4, 'nombre' => 'Naturaleza', 'color' => 'nature-btn'],
    ['id' => 5, 'nombre' => 'Cultura', 'color' => 'culture-btn']
];

$items = [
    [
        'id' => 1, 'categoria_id' => 2, 'titulo' => 'Alejandro Dumas Hidalgo Crisanto', 'descripcion_breve' => 'Mártir petrolero que luchó por los derechos obreros en 1931.',
        'texto_completo' => 'Alejandro Dumas Hidalgo Crisanto (Catacaos, 1910 - Negritos, 1931) fue un obrero pocero en la International Petroleum Company (IPC). Integrante del Sindicato de Obreros Petroleros, participó en la huelga de abril de 1931. En una reunión clandestina en Negritos, fue herido y torturado por la policía. Llevado ante el Teniente Talavera en Talara, discutió valientemente y recibió un disparo mortal, convirtiéndose en un símbolo de lucha obrera.',
        'imagen' => 'assets/img/sabiasque/alejandro_dumas.jpg', 'fuente' => 'Eusebio Arias Vivanco, poeta talareño.', 'fuente_url' => 'https://example.com/eusebio_arias'
    ],
    [
        'id' => 2, 'categoria_id' => 2, 'titulo' => 'Luciano Castillo Colonna', 'descripcion_breve' => 'Político y asesor de obreros petroleros en 1930.',
        'texto_completo' => 'Luciano Castillo Colonna (La Huaca, 1899) fue un abogado, parlamentario y fundador del Partido Socialista del Perú. Asesoró a los obreros petroleros de Talara, logrando el primer Pacto Colectivo en 1930. Elegido diputado por Piura, siempre contó con el apoyo de talareños y paiteños. Fue candidato presidencial y una figura clave en la política peruana.',
        'imagen' => 'assets/img/sabiasque/luciano_castillo.jpg', 'fuente' => 'Archivo Histórico de Piura.', 'fuente_url' => 'https://example.com/archivo_piura'
    ],
    [
        'id' => 3, 'categoria_id' => 3, 'titulo' => 'La Capullana', 'descripcion_breve' => 'Playa misteriosa con cuevas que esconden tesoros piratas.',
        'texto_completo' => 'La Capullana, al norte de Talara, es una playa solitaria rodeada por un cerro. Su nombre evoca las murallas de los pueblos Yungas gobernados por las legendarias Capullanas. Se dice que sus cuevas, usadas por piratas coloniales como escondite, guardan tesoros. Pescadores creen que el lugar tiene una energía especial, atrayendo a grupos esotéricos.',
        'imagen' => 'assets/img/sabiasque/la_capullana.jpg', 'fuente' => 'Tradición oral talareña.', 'fuente_url' => ''
    ],
    [
        'id' => 4, 'categoria_id' => 3, 'titulo' => 'El Farolito', 'descripcion_breve' => 'Un farol encantado persigue a pescadores en Semana Santa.',
        'texto_completo' => 'En la playa Balcones, cerca de Punta Pariñas, se cuenta que una pareja visitaba el lugar en Semana Santa, dejando la playa "encantada". Pescadores que regresan de noche ven un farolito que los sigue, un castigo por bañarse en el mar durante esta festividad sagrada. La leyenda advierte sobre respetar las tradiciones.',
        'imagen' => 'assets/img/sabiasque/el_farolito.jpg', 'fuente' => 'Relatos de pescadores de Pariñas.', 'fuente_url' => ''
    ],
    [
        'id' => 5, 'categoria_id' => 3, 'titulo' => 'El Cerro Encantado', 'descripcion_breve' => 'Un cerro en Los Órganos que se aleja al intentar escalarlo.',
        'texto_completo' => 'En Los Órganos, un cerro pronunciado es conocido como "encantado". Quienes intentan llegar a su cima sienten que se aleja. Algunos escuchan música sutil, atribuida a los fuertes vientos de invierno. La leyenda sugiere que el cerro protege un misterio, fascinando a aventureros y locales.',
        'imagen' => 'assets/img/sabiasque/cerro_encantado.jpg', 'fuente' => 'Tradición oral de Los Órganos.', 'fuente_url' => ''
    ],
    [
        'id' => 6, 'categoria_id' => 1, 'titulo' => 'El Oro Negro', 'descripcion_breve' => 'Talara fue pionera en la extracción de petróleo en Perú.',
        'texto_completo' => 'En 1863, Talara se convirtió en el primer lugar de Perú donde se extrajo petróleo, marcando el inicio de la industria petrolera en el país. La International Petroleum Company (IPC) transformó la región en un centro económico, atrayendo trabajadores y forjando la identidad obrera de Talara.',
        'imagen' => 'assets/img/sabiasque/oro_negro.jpg', 'fuente' => 'Historia de Talara, 1960.', 'fuente_url' => ''
    ],
    [
        'id' => 7, 'categoria_id' => 4, 'titulo' => 'Tortugas de Máncora', 'descripcion_breve' => 'Máncora es hogar de tortugas marinas protegidas.',
        'texto_completo' => 'Las playas de Máncora son un santuario para tortugas marinas, como la tortuga verde. Programas de conservación protegen sus nidos, y los turistas pueden aprender sobre estas especies en visitas guiadas. La biodiversidad marina de Talara es un tesoro natural.',
        'imagen' => 'assets/img/sabiasque/tortugas_mancora.jpg', 'fuente' => 'ONG Conserva Talara.', 'fuente_url' => 'https://example.com/conserva_talara'
    ],
    [
        'id' => 8, 'categoria_id' => 5, 'titulo' => 'Ceviche Talareño', 'descripcion_breve' => 'El ceviche de Talara tiene un toque único.',
        'texto_completo' => 'El ceviche talareño, preparado con pescado fresco como el peje blanco, se distingue por su marinada con limón local y un toque de ají. Es un plato emblemático de la cultura gastronómica de Talara, servido en festividades y restaurantes costeros.',
        'imagen' => 'assets/img/sabiasque/ceviche_talareno.jpg', 'fuente' => 'Gastronomía de Piura, 2020.', 'fuente_url' => ''
    ],
    [
        'id' => 9, 'categoria_id' => 1, 'titulo' => 'Primer Pozo Petrolero', 'descripcion_breve' => 'El pozo Zorritos marcó la historia de Talara.',
        'texto_completo' => 'El pozo Zorritos, perforado en 1863, fue el primero en producir petróleo en Talara, iniciando una era de prosperidad económica. Su legado sigue vivo en los museos locales que exhiben herramientas de la época.',
        'imagen' => 'assets/img/sabiasque/pozo_zorritos.jpg', 'fuente' => 'Museo del Petróleo.', 'fuente_url' => ''
    ],
    [
        'id' => 10, 'categoria_id' => 4, 'titulo' => 'Ballenas de Los Órganos', 'descripcion_breve' => 'Avistamiento de ballenas en temporada.',
        'texto_completo' => 'Entre julio y octubre, Los Órganos se convierte en un punto clave para avistar ballenas jorobadas. Tours ecológicos permiten a los visitantes observar estos majestuosos animales en su hábitat natural.',
        'imagen' => 'assets/img/sabiasque/ballenas_organos.jpg', 'fuente' => 'Turismo Talara.', 'fuente_url' => ''
    ],
    [
        'id' => 11, 'categoria_id' => 5, 'titulo' => 'Danza de la Pava', 'descripcion_breve' => 'Una tradición vibrante en Talara.',
        'texto_completo' => 'La danza de la Pava es una expresión cultural de Talara, donde los bailarines imitan los movimientos de las aves marinas. Se presenta en festividades locales, atrayendo a turistas y locales.',
        'imagen' => 'assets/img/sabiasque/danza_pava.jpg', 'fuente' => 'Cultura Viva Talara.', 'fuente_url' => ''
    ],
    [
        'id' => 12, 'categoria_id' => 3, 'titulo' => 'El Fantasma del Muelle', 'descripcion_breve' => 'Un espíritu ronda el muelle de Talara.',
        'texto_completo' => 'Los pescadores cuentan que un marinero perdido aparece en el muelle de Talara en noches de niebla. Algunos creen que busca su barco, mientras otros lo ven como un guardián del puerto.',
        'imagen' => 'assets/img/sabiasque/fantasma_muelle.jpg', 'fuente' => 'Leyendas de Talara.', 'fuente_url' => ''
    ],
    [
        'id' => 13, 'categoria_id' => 2, 'titulo' => 'Pedro Miguel Arrese', 'descripcion_breve' => 'Líder del sindicato petrolero.',
        'texto_completo' => 'Pedro Miguel Arrese encabezó el Sindicato de Obreros Petroleros en 1931, liderando la histórica huelga que marcó un hito en la lucha laboral de Talara. Su valentía inspiró a generaciones.',
        'imagen' => 'assets/img/sabiasque/pedro_arrese.jpg', 'fuente' => 'Historia Obrera.', 'fuente_url' => ''
    ],
    [
        'id' => 14, 'categoria_id' => 4, 'titulo' => 'Punta Pariñas', 'descripcion_breve' => 'El punto más occidental de Sudamérica.',
        'texto_completo' => 'Punta Pariñas, en Talara, es el punto más occidental del continente sudamericano. Su ubicación estratégica y vistas impresionantes la convierten en un destino imperdible para los viajeros.',
        'imagen' => 'assets/img/sabiasque/punta_parinas.jpg', 'fuente' => 'Guía Turística Talara.', 'fuente_url' => ''
    ],
    [
        'id' => 15, 'categoria_id' => 5, 'titulo' => 'Festival del Peje Blanco', 'descripcion_breve' => 'Celebración gastronómica en Máncora.',
        'texto_completo' => 'El Festival del Peje Blanco en Máncora celebra la pesca local con platos como ceviche y sudado. Es una oportunidad para disfrutar de la cultura y el sabor de Talara.',
        'imagen' => 'assets/img/sabiasque/festival_peje.jpg', 'fuente' => 'Eventos Máncora.', 'fuente_url' => ''
    ]
];

$tests = [
    1 => [
        'nivel' => 'Fácil', 'preguntas' => [
            ['texto' => '¿En qué año comenzó la extracción de petróleo en Talara?', 'opciones' => ['1863', '1900', '1920'], 'correcta' => '1863'],
            ['texto' => '¿Qué playa es conocida por el mito del farolito?', 'opciones' => ['Balcones', 'Máncora', 'La Capullana'], 'correcta' => 'Balcones'],
            ['texto' => '¿Qué animal es protegido en Máncora?', 'opciones' => ['Tortuga', 'Lobo marino', 'Pelícano'], 'correcta' => 'Tortuga']
        ]
    ],
    2 => [
        'nivel' => 'Intermedio', 'preguntas' => [
            ['texto' => '¿Quién fue asesinado en 1931 por defender a los obreros?', 'opciones' => ['Alejandro Dumas', 'Luciano Castillo', 'Pedro Arrese'], 'correcta' => 'Alejandro Dumas'],
            ['texto' => '¿Qué cerro es considerado "encantado" en Los Órganos?', 'opciones' => ['Cerro Encantado', 'La Capullana', 'Punta Pariñas'], 'correcta' => 'Cerro Encantado'],
            ['texto' => '¿Qué ingrediente distingue al ceviche talareño?', 'opciones' => ['Limón local', 'Cilantro', 'Cebolla'], 'correcta' => 'Limón local']
        ]
    ],
    3 => [
        'nivel' => 'Avanzado', 'preguntas' => [
            ['texto' => '¿Qué partido fundó Luciano Castillo?', 'opciones' => ['Partido Socialista', 'APRA', 'Partido Comunista'], 'correcta' => 'Partido Socialista'],
            ['texto' => '¿Qué escondían los piratas en La Capullana?', 'opciones' => ['Tesoros', 'Armas', 'Comida'], 'correcta' => 'Tesoros'],
            ['texto' => '¿Qué fenómeno explica la música en el Cerro Encantado?', 'opciones' => ['Vientos', 'Olas', 'Aves'], 'correcta' => 'Vientos']
        ]
    ]
];

// Buscar el artículo
$item = array_filter($items, fn($i) => $i['id'] === $id);
$item = !empty($item) ? reset($item) : null;

if (!$item) {
    header('Location: ../index.php?section=sabiasque');
    exit;
}

// Obtener sugerencias (3 items aleatorios de la misma categoría, excluyendo el actual)
$sameCategoria = array_filter($items, fn($i) => $i['categoria_id'] === $item['categoria_id'] && $i['id'] !== $id);
shuffle($sameCategoria);
$sugerencias = array_slice($sameCategoria, 0, 3);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viva Talara - <?php echo htmlspecialchars($item['titulo']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/sabiasque.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Indie+Flower&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <button class="menu-btn" id="menu-btn">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo-section">
            <span class="vive">Vive</span> <span class="talara">Talara</span>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidenav-container">
        <div id="sidenav" class="sidenav">
            <div class="logo-section">
                <span class="vive">Vive</span> <span class="talara">Talara</span>
            </div>
            <div class="menu-section">
                <a href="../index.php?section=home"><i class="fas fa-home"></i> Inicio</a>
                <a href="../index.php?section=quehacer"><i class="fas fa-compass"></i> Qué Hacer</a>
                <a href="../index.php?section=turismo"><i class="fas fa-map-marked-alt"></i> Turismo</a>
                <a href="../index.php?section=eventos"><i class="fas fa-calendar-alt"></i> Eventos</a>
                <a href="../index.php?section=calendario"><i class="fas fa-calendar-day"></i> Calendario</a>
                <a href="../index.php?section=sabiasque"><i class="fas fa-lightbulb"></i> Sabías Qué</a>
                <a href="../index.php?section=favoritos"><i class="fas fa-heart"></i> Favoritos</a>
                <a href="../index.php?section=shop"><i class="fas fa-shopping-cart"></i> Shop</a>                
                <a href="../index.php?section=promos"><i class="fas fa-tag"></i> Promos</a>
                <a href="../index.php?section=vip"><i class="fas fa-crown"></i> VIP</a>
                <a href="../index.php?section=emergencias"><i class="fas fa-exclamation-triangle"></i> Emergencias</a>
            </div>
            <div class="bottom-section">
                <a href="../index.php?section=configuracion"><i class="fas fa-cog"></i> Configuración</a>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="sidenav-overlay" class="sidenav-overlay"></div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="main-content">
            <div class="articulossq-container p-4">
                <div class="max-w-2xl mx-auto bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4"><?php echo htmlspecialchars($item['titulo']); ?></h2>
                    <img src="../<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>" 
                         class="w-24 h-24 object-cover rounded-lg mb-4">
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($item['texto_completo']); ?></p>
                    <p class="text-sm text-gray-500 italic mb-4">
                        <?php echo $item['fuente_url'] ? 
                            'Fuente: <a href="' . htmlspecialchars($item['fuente_url']) . '" target="_blank" class="text-cyan-500">' . htmlspecialchars($item['fuente']) . '</a>' : 
                            'Fuente: ' . htmlspecialchars($item['fuente']); ?>
                    </p>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Explora Más</h3>
                    <div class="grid grid-cols-1 gap-2 mb-4">
                        <?php foreach ($sugerencias as $sug): ?>
                            <div class="sugerencia-card flex items-center bg-gray-50 p-2 rounded-lg border border-gray-200">
                                <img src="../<?php echo htmlspecialchars($sug['imagen']); ?>" alt="<?php echo htmlspecialchars($sug['titulo']); ?>" 
                                     class="w-10 h-10 object-cover rounded-lg mr-2">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($sug['titulo']); ?></h4>
                                    <p class="text-xs text-gray-600"><?php echo htmlspecialchars($sug['descripcion_breve']); ?></p>
                                    <a href="articulossq.php?id=<?php echo htmlspecialchars($sug['id']); ?>" 
                                       class="ver-mas-btn text-white text-xs mt-1 inline-block">Ver Más</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">¡Cuánto aprendiste hoy? ¡Haz el test!</h3>
                    <div id="test-niveles" class="flex gap-2 mb-4">
                        <button class="test-nivel easy-btn text-white px-4 py-2 rounded-lg" data-nivel="Fácil">Fácil</button>
                        <button class="test-nivel medium-btn text-white px-4 py-2 rounded-lg" data-nivel="Intermedio">Intermedio</button>
                        <button class="test-nivel hard-btn text-white px-4 py-2 rounded-lg" data-nivel="Avanzado">Avanzado</button>
                    </div>
                    <div id="test-preguntas" class="hidden mb-4"></div>
                    <div id="test-resultado" class="hidden text-center mb-4"></div>
                    <a href="../index.php?section=sabiasque" class="volver-btn text-white px-4 py-2 rounded-lg w-full block text-center">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/sabiasque.js"></script>
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