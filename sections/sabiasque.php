<?php
/**
 * Sección ¿Sabías Que...? de Vive Talara
 * Muestra historias, mitos y curiosidades de Talara dinámicamente desde la base de datos
 */

include 'includes/conexion.php'; // Ruta ajustada para la conexión

$article_id = isset($_GET['article']) ? filter_var($_GET['article'], FILTER_VALIDATE_INT) : null;

// Obtener categorías para los filtros
try {
    $stmt = $pdo->query("SELECT DISTINCT categoria FROM articulos ORDER BY categoria");
    $categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    echo "<p class='text-red-500'>Error al obtener categorías: " . htmlspecialchars($e->getMessage()) . "</p>";
    return;
}

// Función para obtener el color de la categoría
function getCategoryColor($categoria) {
    $colors = [
        'personajes' => '#FFB300',
        'mitos' => '#F4511E',
        'curiosidades' => '#78909C',
        'tradiciones' => '#6D4C41',
        'naturaleza' => '#388E3C',
        'historia' => '#5E35B1',
        'gastronomia' => '#D81B60',
        'lugares' => '#0288D1'
    ];
    return $colors[$categoria] ?? '#00BCD4';
}
?>
<link rel="stylesheet" href="assets/css/sabiasque.css">
<div class="container mx-auto px-4 py-8">
    <?php if ($article_id): ?>
        <?php
        // Obtener el artículo seleccionado
        try {
            $stmt = $pdo->prepare("SELECT * FROM articulos WHERE id = ?");
            $stmt->execute([$article_id]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($article) {
                $slider_fotos = json_decode($article['slider_fotos'], true);
                $quiz = json_decode($article['quiz'], true);

                // Obtener artículos relacionados (mismos de la misma categoría, excluyendo el actual)
                $stmt = $pdo->prepare("SELECT id, titulo, foto_principal, categoria FROM articulos WHERE categoria = ? AND id != ? LIMIT 2");
                $stmt->execute([$article['categoria'], $article_id]);
                $related_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $article = null;
            $error = "Error al obtener el artículo: " . $e->getMessage();
        }
        ?>

        <?php if ($article): ?>
            <div class="flex justify-start mb-4">
                <a href="?section=sabiasque" class="text-white hover:text-amber-300 back-btn">
                    <i class="fas fa-chevron-left text-2xl"></i>
                    <span class="text-sm">Volver</span>
                </a>
            </div>
            <h1 class="text-3xl font-bold mb-4 text-white text-center"><?php echo htmlspecialchars($article['titulo']); ?></h1>
            <img src="<?php echo htmlspecialchars($article['foto_principal']); ?>" alt="<?php echo htmlspecialchars($article['titulo']); ?>" class="w-full h-80 object-cover mb-4 rounded-lg">
            <div class="prose mb-4 text-gray-300"><?php echo htmlspecialchars($article['parrafo1']); ?></div>
            <div class="slider mb-4 relative">
                <?php foreach ($slider_fotos as $index => $img): ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="Slider <?php echo $index + 1; ?>" class="slider-img w-full h-64 object-cover rounded-lg <?php echo $index === 0 ? 'active' : ''; ?>">
                <?php endforeach; ?>
                <button class="slider-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-amber-400 text-gray-900 p-2 rounded-full hover:bg-amber-300"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-amber-400 text-gray-900 p-2 rounded-full hover:bg-amber-300"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="prose mb-4 text-gray-300"><?php echo htmlspecialchars($article['parrafo2']); ?></div>
            <div class="source mb-4 text-gray-300">Fuente: <?php echo htmlspecialchars($article['fuente']); ?></div>
            <div class="quiz mb-4 bg-orange-400 p-4 rounded-lg">
                <h2 class="text-xl font-semibold mb-2 text-white"><i class="fas fa-star mr-2"></i>Quiz: ¿Cuánto sabes?</h2>
                <p class="mb-2 text-gray-900 font-bold"><?php echo htmlspecialchars($quiz['question']); ?></p>
                <?php foreach ($quiz['options'] as $option): ?>
                    <label class="block mb-1 text-gray-900 font-bold">
                        <input type="radio" name="quiz" value="<?php echo htmlspecialchars($option); ?>" class="mr-2 accent-amber-400">
                        <?php echo htmlspecialchars($option); ?>
                    </label>
                <?php endforeach; ?>
                <button class="quiz-submit bg-white text-orange-400 px-4 py-2 rounded mt-2 hover:bg-gray-100"><i class="fas fa-check mr-1"></i>Enviar</button>
                <p class="quiz-result text-amber-400 hidden mt-2">¡Correcto!</p>
                <p class="quiz-result text-red-500 hidden mt-2">Incorrecto, la respuesta es: <?php echo htmlspecialchars($quiz['correct']); ?></p>
            </div>
            <h2 class="text-xl font-semibold mb-2 text-white"><i class="fas fa-heart mr-2"></i>Historias similares</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($related_articles as $related): ?>
                    <div class="card rounded-lg overflow-hidden" style="background-color: <?php echo getCategoryColor($related['categoria']); ?>; border-left: 4px solid <?php echo getCategoryColor($related['categoria']); ?>;">
                        <img src="<?php echo htmlspecialchars($related['foto_principal']); ?>" alt="<?php echo htmlspecialchars($related['titulo']); ?>" class="w-full h-32 object-cover">
                        <div class="p-3 flex justify-between items-center">
                            <h3 class="text-base font-semibold text-white"><?php echo htmlspecialchars($related['titulo']); ?></h3>
                            <a href="?section=sabiasque&article=<?php echo $related['id']; ?>" class="text-white hover:text-amber-300"><i class="fas fa-chevron-right text-2xl"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="flex justify-start mb-4">
                <a href="?section=sabiasque" class="text-white hover:text-amber-300 back-btn">
                    <i class="fas fa-chevron-left text-2xl"></i>
                    <span class="text-sm">Volver</span>
                </a>
            </div>
            <p class="text-red-500"><?php echo isset($error) ? htmlspecialchars($error) : 'Artículo no encontrado.'; ?></p>
        <?php endif; ?>
    <?php else: ?>
        <h1 class="text-3xl font-bold text-center mb-6 text-white">¿Sabías Que...?</h1>
        <div class="filter-btn-container flex overflow-x-auto mb-6 whitespace-nowrap">
            <button class="filter-btn px-4 py-2 mx-2 rounded-lg text-white bg-cyan-400 hover:bg-cyan-300" data-filter="all">Todos</button>
            <?php foreach ($categorias as $categoria): ?>
                <button class="filter-btn px-4 py-2 mx-2 rounded-lg text-white" data-filter="<?php echo htmlspecialchars($categoria); ?>" style="background-color: <?php echo getCategoryColor($categoria); ?>;">
                    <?php echo ucfirst(htmlspecialchars($categoria)); ?>
                </button>
            <?php endforeach; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
            try {
                $stmt = $pdo->query("SELECT id, titulo, categoria, foto_principal FROM articulos ORDER BY created_at DESC");
                $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($articles as $item):
            ?>
                <div class="card rounded-lg overflow-hidden" data-category="<?php echo htmlspecialchars($item['categoria']); ?>" style="background-color: <?php echo getCategoryColor($item['categoria']); ?>; border-left: 4px solid <?php echo getCategoryColor($item['categoria']); ?>;">
                    <img src="<?php echo htmlspecialchars($item['foto_principal']); ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>" class="w-full h-32 object-cover">
                    <div class="p-3 flex justify-between items-center">
                        <h3 class="text-base font-semibold text-white"><?php echo htmlspecialchars($item['titulo']); ?></h3>
                        <a href="?section=sabiasque&article=<?php echo $item['id']; ?>" class="text-white hover:text-amber-300"><i class="fas fa-chevron-right text-2xl"></i></a>
                    </div>
                </div>
            <?php
                endforeach;
            } catch (PDOException $e) {
                echo '<p class="text-red-500">Error al cargar artículos: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
    <?php endif; ?>
</div>

<script src="assets/js/sabiasque.js"></script>