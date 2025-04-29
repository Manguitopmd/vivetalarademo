<?php
/**
 * Sección de Emergencias de Viva Talara
 * Diseño minimalista con Material Design y Glassmorphism
 */
?>

<link rel="stylesheet" href="assets/css/emergencias.css">

<div class="emergencias-container">
    <!-- Barra de búsqueda -->
    <div class="search-bar flex items-center gap-2 mb-4">
        <input type="text" id="filtro-busqueda" list="sugerencias" class="w-full p-2 bg-gray-800 text-white rounded-md shadow-sm" placeholder="Buscar servicios..." aria-label="Buscar servicios por nombre, tipo o distrito">
        <datalist id="sugerencias">
            <option value="Pariñas">
            <option value="El Alto">
            <option value="La Brea">
            <option value="Lobitos">
            <option value="Los Órganos">
            <option value="Máncora">
            <option value="hospital">
            <option value="clínica">
            <option value="farmacia">
            <option value="taxi">
            <option value="policía">
            <option value="bomberos">
            <option value="serenazgo">
        </datalist>
    </div>

    <!-- Botón de filtros -->
    <button class="filter-btn bg-gray-700 text-white p-2 rounded-md mb-4" id="filtro-servicios" aria-label="Filtrar servicios">
        <i class="fas fa-filter"></i> Filtros
    </button>

    <!-- Modal de filtros -->
    <div id="modal-filtros" class="filter-modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="modal-content bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <button id="cerrar-modal-filtros" class="absolute top-2 right-2 text-white text-xl" aria-label="Cerrar modal">×</button>
            <h2 class="text-white text-lg font-semibold mb-4">Filtrar Servicios</h2>
            <div class="filtros-options flex flex-col gap-2">
                <h3>Distrito</h3>
                <label for="dist-todos" class="flex items-center gap-2 text-white">
                    <input id="dist-todos" type="radio" name="distrito" value="todos" checked class="text-cyan-500">
                    Todos
                </label>
                <label for="dist-parinas" class="flex items-center gap-2 text-white">
                    <input id="dist-parinas" type="radio" name="distrito" value="Pariñas" class="text-cyan-500">
                    Pariñas
                </label>
                <label for="dist-el-alto" class="flex items-center gap-2 text-white">
                    <input id="dist-el-alto" type="radio" name="distrito" value="El Alto" class="text-cyan-500">
                    El Alto
                </label>
                <label for="dist-la-brea" class="flex items-center gap-2 text-white">
                    <input id="dist-la-brea" type="radio" name="distrito" value="La Brea" class="text-cyan-500">
                    La Brea
                </label>
                <label for="dist-lobitos" class="flex items-center gap-2 text-white">
                    <input id="dist-lobitos" type="radio" name="distrito" value="Lobitos" class="text-cyan-500">
                    Lobitos
                </label>
                <label for="dist-los-organos" class="flex items-center gap-2 text-white">
                    <input id="dist-los-organos" type="radio" name="distrito" value="Los Órganos" class="text-cyan-500">
                    Los Órganos
                </label>
                <label for="dist-mancora" class="flex items-center gap-2 text-white">
                    <input id="dist-mancora" type="radio" name="distrito" value="Máncora" class="text-cyan-500">
                    Máncora
                </label>
                <h3>Tipo de Servicio</h3>
                <label for="tipo-hospital" class="flex items-center gap-2 text-white">
                    <input id="tipo-hospital" type="checkbox" name="tipo" value="hospital" class="text-cyan-500">
                    Hospital
                </label>
                <label for="tipo-clinica" class="flex items-center gap-2 text-white">
                    <input id="tipo-clinica" type="checkbox" name="tipo" value="clínica" class="text-cyan-500">
                    Clínica
                </label>
                <label for="tipo-farmacia" class="flex items-center gap-2 text-white">
                    <input id="tipo-farmacia" type="checkbox" name="tipo" value="farmacia" class="text-cyan-500">
                    Farmacia
                </label>
                <label for="tipo-taxi" class="flex items-center gap-2 text-white">
                    <input id="tipo-taxi" type="checkbox" name="tipo" value="taxi" class="text-cyan-500">
                    Taxi
                </label>
                <label for="tipo-policia" class="flex items-center gap-2 text-white">
                    <input id="tipo-policia" type="checkbox" name="tipo" value="policía" class="text-cyan-500">
                    Policía
                </label>
                <label for="tipo-bomberos" class="flex items-center gap-2 text-white">
                    <input id="tipo-bomberos" type="checkbox" name="tipo" value="bomberos" class="text-cyan-500">
                    Bomberos
                </label>
                <label for="tipo-serenazgo" class="flex items-center gap-2 text-white">
                    <input id="tipo-serenazgo" type="checkbox" name="tipo" value="serenazgo" class="text-cyan-500">
                    Serenazgo
                </label>
            </div>
            <button id="aplicar-filtros" class="bg-cyan-500 text-white px-4 py-2 rounded-md mt-4 w-full">Aplicar</button>
        </div>
    </div>

    <!-- Panel Interactivo -->
    <div class="emergency-panel">
        <h2 class="panel-title">Emergencias</h2>
        <p class="panel-subtitle">Talara te cuida</p>
        <div class="panel-buttons">
            <button class="panel-btn" data-action="call"><i class="fas fa-phone"></i> Llamar</button>
            <button class="panel-btn" data-action="find"><i class="fas fa-map-marker-alt"></i> Ayuda Cerca</button>
            <button class="panel-btn" data-action="tips"><i class="fas fa-lightbulb"></i> Consejos</button>
        </div>
    </div>

    <!-- Botón de Pánico -->
    <div class="panic-button-container">
        <button id="panic-btn" class="panic-btn"><i class="fas fa-exclamation-circle"></i> Emergencia</button>
        <div id="panic-options" class="panic-options hidden">
            <a href="tel:105" class="panic-option">Policía (105)</a>
            <button class="panic-option" id="share-location">Enviar Ubicación</button>
        </div>
    </div>

    <!-- Mapa Simplificado -->
    <div class="map-section hidden">
        <h3>Ayuda Cerca</h3>
        <div id="map-placeholder" class="map-placeholder">
            <p>Mapa de Talara. Activa tu ubicación.</p>
            <button id="locate-me" class="map-btn">Estoy Aquí</button>
        </div>
        <div id="map-results" class="map-results hidden">
            <p><strong>Hospital II Talara</strong>: Panamericana Norte s/n</p>
            <p><strong>Comisaría Talara Alta</strong>: Avenida A 55, Talara</p>
            <p><strong>Inkafarma</strong>: Avenida Grau 49, Talara</p>
        </div>
    </div>

    <!-- Guía Paso a Paso -->
    <div class="guide-section hidden">
        <h3>¿Qué Hacer?</h3>
        <select id="guide-select" class="guide-select">
            <option value="">Selecciona un problema</option>
            <option value="passport">Perdí mi pasaporte</option>
            <option value="health">Me siento mal</option>
            <option value="theft">Me robaron</option>
            <option value="accident">Tuve un accidente</option>
            <option value="fire">Hay un incendio</option>
            <option value="earthquake">Hay un temblor</option>
            <option value="beach">Problema en la playa</option>
        </select>
        <div id="guide-content" class="guide-content hidden"></div>
    </div>

    <!-- Carrusel de Alertas -->
    <div class="alerts-section">
        <h3>Alertas</h3>
        <div class="alerts-carousel">
            <div class="carousel-track">
                <div class="alert-card"><p>Sin oleajes: Playas seguras.</p></div>
                <div class="alert-card"><p>Carretera despejada: Panamericana libre.</p></div>
                <div class="alert-card"><p>Festival: Evita calle principal.</p></div>
            </div>
            <button class="carousel-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-next"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <!-- Tarjetas de Consejos -->
    <div class="tips-section hidden">
        <h3>Consejos</h3>
        <div class="tips-carousel">
            <div class="tip-card">
                <i class="fas fa-sun"></i>
                <p>Usa bloqueador solar.</p>
                <button class="tip-action" data-action="share">Compartir</button>
            </div>
            <div class="tip-card">
                <i class="fas fa-taxi"></i>
                <p>Taxis autorizados.</p>
                <button class="tip-action" data-action="share">Compartir</button>
            </div>
            <div class="tip-card">
                <i class="fas fa-house-damage"></i>
                <p>En temblores, busca áreas abiertas.</p>
                <button class="tip-action" data-action="share">Compartir</button>
            </div>
        </div>
    </div>

    <!-- Contactos de Confianza -->
    <div class="contacts-section">
        <h3>Contactos</h3>
        <div class="contacts-list" id="contacts-list">
            <div class="contact-card" data-type="hospital" data-district="Pariñas">
                <p><strong>Hospital II Talara</strong>: Panamericana Norte s/n</p>
                <a href="tel:(073)381201" class="contact-btn">Llamar (073) 381201</a>
                <a href="tel:(073)384141" class="contact-btn">Llamar (073) 384141</a>
            </div>
            <div class="contact-card" data-type="clínica" data-district="Pariñas">
                <p><strong>Clínica Tresa</strong>: Avenida A, 108</p>
                <a href="tel:(073)382213" class="contact-btn">Llamar (073) 382213</a>
                <a href="tel:(073)382890" class="contact-btn">Llamar (073) 382890</a>
                <a href="tel:+51941077517" class="contact-btn">Llamar +51 941 077 517</a>
            </div>
            <div class="contact-card" data-type="farmacia" data-district="Pariñas">
                <p><strong>Inkafarma</strong>: Av. Grau 49</p>
            </div>
            <div class="contact-card" data-type="taxi" data-district="Pariñas">
                <p><strong>Taxi Talara Express</strong></p>
                <a href="tel:+51956396843" class="contact-btn">Llamar +51 956 396 843</a>
            </div>
            <div class="contact-card" data-type="policía" data-district="Pariñas">
                <p><strong>Comisaría Talara Alta</strong></p>
                <a href="tel:(073)382281" class="contact-btn">Llamar (073) 382281</a>
            </div>
            <div class="contact-card" data-type="bomberos" data-district="Pariñas">
                <p><strong>Compañía de Bomberos Talara N° 67</strong></p>
                <a href="tel:(073)386600" class="contact-btn">Llamar (073) 386600</a>
                <a href="tel:116" class="contact-btn">Llamar 116</a>
            </div>
            <div class="contact-card" data-type="serenazgo" data-district="Pariñas">
                <p><strong>Serenazgo Municipal</strong></p>
                <a href="tel:(073)381590" class="contact-btn">Llamar (073) 381590</a>
                <a href="tel:929742365" class="contact-btn">Llamar 929 742 365</a>
            </div>
        </div>
    </div>

    <!-- Personalización -->
    <div class="personalization-section">
        <h3>Contacto Personal</h3>
        <input type="text" id="emergency-contact" placeholder="Nombre" class="contact-input">
        <input type="tel" id="emergency-number" placeholder="Teléfono" class="contact-input">
        <button id="save-contact" class="save-btn">Guardar</button>
        <div id="saved-contact" class="saved-contact hidden">
            <p><span id="contact-name"></span></p>
            <a id="contact-call" href="#" class="contact-btn">Llamar</a>
        </div>
    </div>

    <!-- Kit Offline -->
    <div class="offline-section">
        <h3>Kit Offline</h3>
        <button id="download-kit" class="download-btn">Descargar</button>
    </div>

    <!-- Barra fija de emergencia -->
    <div class="emergency-bar fixed bottom-0 left-0 right-0 bg-red-600 text-white p-2 flex justify-around z-50">
        <a href="tel:105" class="flex items-center gap-2">
            <i class="fas fa-phone"></i> Policía 105
        </a>
        <a href="tel:106" class="flex items-center gap-2">
            <i class="fas fa-ambulance"></i> SAMU 106
        </a>
        <a href="tel:116" class="flex items-center gap-2">
            <i class="fas fa-fire"></i> Bomberos 116
        </a>
        <a href="tel:(073)381590" class="flex items-center gap-2">
            <i class="fas fa-shield-alt"></i> Serenazgo (073) 381590
        </a>
        <a href="tel:(073)381201" class="flex items-center gap-2">
            <i class="fas fa-hospital"></i> Hospital (073) 381201
        </a>
    </div>
</div>

<script src="assets/js/emergencias.js"></script>