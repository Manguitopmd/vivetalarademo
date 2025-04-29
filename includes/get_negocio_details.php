<?php
header('Content-Type: application/json');
require_once 'conexion.php';

try {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id <= 0) {
        throw new Exception("ID inválido");
    }

    $stmt = $pdo->prepare("
        SELECT 
            g.nombre, g.descripcion, g.direccion, g.horarios, g.whatsapp, 
            g.sitio_web, g.app_url, g.latitud, g.longitud, g.foto_perfil_url, 
            g.banner_url, g.es_embajador, g.especialidad_culinaria, g.menu_url,
            g.vendemas_url, g.reservas_url, g.servicios, g.facebook_url, 
            g.instagram_url, g.tiktok_url, s.nombre AS subcategoria,
            COALESCE(d.nombre, 'Sin distrito') AS distrito
        FROM gastronomia g
        INNER JOIN subcategorias s ON g.subcategoria_id = s.id
        LEFT JOIN distritos d ON g.distrito_id = d.id
        WHERE g.id = ? AND g.rubro_id = 1
    ");
    $stmt->execute([$id]);
    $negocio = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$negocio) {
        throw new Exception("Negocio no encontrado");
    }

    // Procesar servicios (JSON a array)
    $negocio['servicios'] = $negocio['servicios'] ? json_decode($negocio['servicios'], true) : [];

    // Generar URLs
    $negocio['maps_url'] = $negocio['latitud'] && $negocio['longitud']
        ? "https://www.google.com/maps?q={$negocio['latitud']},{$negocio['longitud']}"
        : '';
    $negocio['whatsapp_url'] = $negocio['whatsapp']
        ? "https://wa.me/" . preg_replace('/[^0-9]/', '', $negocio['whatsapp'])
        : '';

    // Verificar imágenes
    $negocio['banner_url'] = $negocio['banner_url'] 
        ? $negocio['banner_url']
        : 'assets/img/default-plato.webp';

    echo json_encode($negocio);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}