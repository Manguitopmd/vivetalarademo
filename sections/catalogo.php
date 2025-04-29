<?php
/**
 * Sección Catálogo de TravelTalara
 * Catálogo de ropa con categorías, selección de talla/color, modal de detalles y fotos
 */
?>

<link rel="stylesheet" href="assets/css/shop.css">

<section class="carta-section">
    <!-- Mensaje de urgencia -->
    <div class="urgency-message">¡PIDE AHORA, STOCK LIMITADO!</div>

    <!-- Pestañas de categorías -->
    <div class="category-tabs-section">
        <button class="tab-btn active" data-category="todos" aria-label="Mostrar todos los productos">Todos</button>
        <button class="tab-btn" data-category="playas" aria-label="Mostrar playas">Playas</button>
        <button class="tab-btn" data-category="gorras" aria-label="Mostrar gorras">Gorras</button>
        <button class="tab-btn" data-category="crops" aria-label="Mostrar crops">Crops</button>
        <button class="tab-btn" data-category="bolsos" aria-label="Mostrar bolsos">Bolsos</button>
    </div>

    <!-- Categoría: Todos -->
    <div class="category" data-category="todos">
        <h3 class="category-title"><i class="fas fa-tshirt"></i> Todos</h3>
        <div class="items">
            <!-- Playa Talara Azul -->
            <div class="item" data-id="playa-talara-azul">
                <img src="assets/img/catalogo/playa-talara-azul.jpg" alt="Playa Talara Azul" class="item-image">
                <div class="item-info">
                    <h4>Playa Talara Azul</h4>
                    <p class="price">S/ 45.00</p>
                    <p class="stock">Quedan 20</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Azul">Azul</option>
                            <option value="Blanco">Blanco</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Playa Talara Azul" data-description="Camiseta de algodón 100% con estampado inspirado en las playas de Talara. Cómoda y fresca para el verano." data-tallas="S, M, L" data-colores="Azul, Blanco" data-sexo="Unisex" aria-label="Ver detalles de Playa Talara Azul">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/playa-talara-azul.jpg" aria-label="Ver foto de Playa Talara Azul en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Playa Talara Azul" data-price="45.00" data-image="assets/img/catalogo/playa-talara-azul.jpg" data-stock="20" aria-label="Añadir Playa Talara Azul al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <!-- Gorra Sol Negro -->
            <div class="item" data-id="gorra-sol-negro">
                <img src="assets/img/catalogo/gorra-sol-negro.jpg" alt="Gorra Sol Negro" class="item-image">
                <div class="item-info">
                    <h4>Gorra Sol Negro</h4>
                    <p class="price">S/ 30.00</p>
                    <p class="stock">Quedan 15</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="Única">Única</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Negro">Negro</option>
                            <option value="Gris">Gris</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Gorra Sol Negro" data-description="Gorra de lona resistente con bordado de logo Talara. Ideal para protegerte del sol con estilo." data-tallas="Única" data-colores="Negro, Gris" data-sexo="Unisex" aria-label="Ver detalles de Gorra Sol Negro">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/gorra-sol-negro.jpg" aria-label="Ver foto de Gorra Sol Negro en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Gorra Sol Negro" data-price="30.00" data-image="assets/img/catalogo/gorra-sol-negro.jpg" data-stock="15" aria-label="Añadir Gorra Sol Negro al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <!-- Crop Talara Vibes -->
            <div class="item promo-item" data-id="crop-talara-vibes">
                <span class="promo-badge">¡Oferta!</span>
                <img src="assets/img/catalogo/crop-talara-vibes.jpg" alt="Crop Talara Vibes" class="item-image">
                <div class="item-info">
                    <h4>Crop Talara Vibes</h4>
                    <p class="price">S/ 35.00</p>
                    <p class="stock">Quedan 10</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Rosa">Rosa</option>
                            <option value="Verde">Verde</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Crop Talara Vibes" data-description="Crop top de algodón con estampado veraniego. Perfecto para un look casual y fresco." data-tallas="S, M" data-colores="Rosa, Verde" data-sexo="Femenino" aria-label="Ver detalles de Crop Talara Vibes">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/crop-talara-vibes.jpg" aria-label="Ver foto de Crop Talara Vibes en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Crop Talara Vibes" data-price="35.00" data-image="assets/img/catalogo/crop-talara-vibes.jpg" data-stock="10" aria-label="Añadir Crop Talara Vibes al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
            <!-- Bolso Playa Boho -->
            <div class="item" data-id="bolso-playa-boho">
                <img src="assets/img/catalogo/bolso-playa-boho.jpg" alt="Bolso Playa Boho" class="item-image">
                <div class="item-info">
                    <h4>Bolso Playa Boho</h4>
                    <p class="price">S/ 60.00</p>
                    <p class="stock">Quedan 8</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="Única">Única</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Beige">Beige</option>
                            <option value="Marrón">Marrón</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Bolso Playa Boho" data-description="Bolso tejido a mano con detalles bohemios. Espacioso y elegante para tus días de playa." data-tallas="Única" data-colores="Beige, Marrón" data-sexo="Femenino" aria-label="Ver detalles de Bolso Playa Boho">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/bolso-playa-boho.jpg" aria-label="Ver foto de Bolso Playa Boho en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Bolso Playa Boho" data-price="60.00" data-image="assets/img/catalogo/bolso-playa-boho.jpg" data-stock="8" aria-label="Añadir Bolso Playa Boho al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categoría: Playas -->
    <div class="category hidden" data-category="playas">
        <h3 class="category-title"><i class="fas fa-tshirt"></i> Playas</h3>
        <div class="items">
            <div class="item" data-id="playa-talara-azul">
                <img src="assets/img/catalogo/playa-talara-azul.jpg" alt="Playa Talara Azul" class="item-image">
                <div class="item-info">
                    <h4>Playa Talara Azul</h4>
                    <p class="price">S/ 45.00</p>
                    <p class="stock">Quedan 20</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Azul">Azul</option>
                            <option value="Blanco">Blanco</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Playa Talara Azul" data-description="Camiseta de algodón 100% con estampado inspirado en las playas de Talara. Cómoda y fresca para el verano." data-tallas="S, M, L" data-colores="Azul, Blanco" data-sexo="Unisex" aria-label="Ver detalles de Playa Talara Azul">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/playa-talara-azul.jpg" aria-label="Ver foto de Playa Talara Azul en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Playa Talara Azul" data-price="45.00" data-image="assets/img/catalogo/playa-talara-azul.jpg" data-stock="20" aria-label="Añadir Playa Talara Azul al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categoría: Gorras -->
    <div class="category hidden" data-category="gorras">
        <h3 class="category-title"><i class="fas fa-cap"></i> Gorras</h3>
        <div class="items">
            <div class="item" data-id="gorra-sol-negro">
                <img src="assets/img/catalogo/gorra-sol-negro.jpg" alt="Gorra Sol Negro" class="item-image">
                <div class="item-info">
                    <h4>Gorra Sol Negro</h4>
                    <p class="price">S/ 30.00</p>
                    <p class="stock">Quedan 15</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="Única">Única</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Negro">Negro</option>
                            <option value="Gris">Gris</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Gorra Sol Negro" data-description="Gorra de lona resistente con bordado de logo Talara. Ideal para protegerte del sol con estilo." data-tallas="Única" data-colores="Negro, Gris" data-sexo="Unisex" aria-label="Ver detalles de Gorra Sol Negro">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/gorra-sol-negro.jpg" aria-label="Ver foto de Gorra Sol Negro en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Gorra Sol Negro" data-price="30.00" data-image="assets/img/catalogo/gorra-sol-negro.jpg" data-stock="15" aria-label="Añadir Gorra Sol Negro al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categoría: Crops -->
    <div class="category hidden" data-category="crops">
        <h3 class="category-title"><i class="fas fa-tshirt"></i> Crops</h3>
        <div class="items">
            <div class="item promo-item" data-id="crop-talara-vibes">
                <span class="promo-badge">¡Oferta!</span>
                <img src="assets/img/catalogo/crop-talara-vibes.jpg" alt="Crop Talara Vibes" class="item-image">
                <div class="item-info">
                    <h4>Crop Talara Vibes</h4>
                    <p class="price">S/ 35.00</p>
                    <p class="stock">Quedan 10</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Rosa">Rosa</option>
                            <option value="Verde">Verde</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Crop Talara Vibes" data-description="Crop top de algodón con estampado veraniego. Perfecto para un look casual y fresco." data-tallas="S, M" data-colores="Rosa, Verde" data-sexo="Femenino" aria-label="Ver detalles de Crop Talara Vibes">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/crop-talara-vibes.jpg" aria-label="Ver foto de Crop Talara Vibes en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Crop Talara Vibes" data-price="35.00" data-image="assets/img/catalogo/crop-talara-vibes.jpg" data-stock="10" aria-label="Añadir Crop Talara Vibes al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categoría: Bolsos -->
    <div class="category hidden" data-category="bolsos">
        <h3 class="category-title"><i class="fas fa-shopping-bag"></i> Bolsos</h3>
        <div class="items">
            <div class="item" data-id="bolso-playa-boho">
                <img src="assets/img/catalogo/bolso-playa-boho.jpg" alt="Bolso Playa Boho" class="item-image">
                <div class="item-info">
                    <h4>Bolso Playa Boho</h4>
                    <p class="price">S/ 60.00</p>
                    <p class="stock">Quedan 8</p>
                    <div class="item-options">
                        <select class="talla-select" aria-label="Seleccionar talla">
                            <option value="" disabled selected>Talla</option>
                            <option value="Única">Única</option>
                        </select>
                        <select class="color-select" aria-label="Seleccionar color">
                            <option value="" disabled selected>Color</option>
                            <option value="Beige">Beige</option>
                            <option value="Marrón">Marrón</option>
                        </select>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="view-details-btn" data-name="Bolso Playa Boho" data-description="Bolso tejido a mano con detalles bohemios. Espacioso y elegante para tus días de playa." data-tallas="Única" data-colores="Beige, Marrón" data-sexo="Femenino" aria-label="Ver detalles de Bolso Playa Boho">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="view-photo-btn" data-image="assets/img/catalogo/bolso-playa-boho.jpg" aria-label="Ver foto de Bolso Playa Boho en grande">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="add-to-cart-btn" data-name="Bolso Playa Boho" data-price="60.00" data-image="assets/img/catalogo/bolso-playa-boho.jpg" data-stock="8" aria-label="Añadir Bolso Playa Boho al carrito">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para detalles -->
<div id="service-modal" class="modal hidden">
    <div class="modal-content">
        <button id="modal-close" class="modal-close-btn" aria-label="Cerrar modal de detalles"><i class="fas fa-times"></i></button>
        <h3 id="modal-title" class="modal-title"></h3>
        <p id="modal-description" class="modal-description"></p>
        <p id="modal-tallas" class="modal-tallas"></p>
        <p id="modal-colores" class="modal-colores"></p>
        <p id="modal-sexo" class="modal-sexo"></p>
    </div>
</div>

<!-- Modal para fotos -->
<div id="photo-modal" class="photo-modal hidden">
    <div class="photo-modal-content">
        <button id="photo-modal-close" class="modal-close-btn" aria-label="Cerrar modal de foto"><i class="fas fa-times"></i></button>
        <img id="photo-modal-image" src="" alt="Imagen del producto en grande" class="photo-modal-image">
    </div>
</div>

<script src="assets/js/shop.js"></script>