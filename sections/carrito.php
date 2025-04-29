<?php
/**
 * Sección Carrito de TravelTalara
 * Gestión de ítems en el carrito y detalles del pedido
 */
?>

<link rel="stylesheet" href="assets/css/shop.css">

<section class="carrito-section">
    <!-- Mensaje de urgencia -->
    <div class="urgency-message">¡CONFIRMA PRONTO, EL STOCK ES LIMITADO!</div>

    <!-- Paso 1: Ítems -->
    <div id="step-items" class="carrito-step">
        <h2 class="section-title"><i class="fas fa-shopping-cart"></i> Tu Carrito</h2>
        <ul id="cart-items" class="cart-items"></ul>
        <p id="cart-total" class="cart-total hidden">Total: S/ 0.00</p>
        <div id="cart-empty" class="empty-cart-message hidden">
            <h3>¡No dejes pasar la oportunidad!</h3>
            <p>Explora nuestra ropa ahora.</p>
            <a href="?section=shop&subsection=catalogo" class="btn" aria-label="Ver catálogo de ropa">Ver Catálogo</a>
        </div>
        <div class="carrito-actions">
            <button id="clear-cart-btn" class="btn btn-secondary hidden" aria-label="Vaciar el carrito">Vaciar Carrito</button>
            <button id="checkout-btn" class="btn hidden" aria-label="Continuar al formulario de pedido">Continuar</button>
        </div>
    </div>

    <!-- Paso 2: Detalles -->
    <div id="step-details" class="carrito-step hidden">
        <h2 class="section-title"><i class="fas fa-shopping-cart"></i> Detalles del Pedido</h2>
        <div id="prep-message-container"></div>
        <form id="order-form" class="order-form">
            <div class="form-group">
                <label for="order-name">Nombre <span class="text-red-500">*</span></label>
                <input type="text" id="order-name" placeholder="Tu nombre completo" required aria-required="true" aria-label="Ingresa tu nombre">
            </div>
            <div class="form-group">
                <label for="order-date">Fecha de Entrega <span class="text-red-500">*</span></label>
                <input type="date" id="order-date" required aria-required="true" aria-label="Selecciona la fecha de entrega" min="2025-04-29">
            </div>
            <div class="form-group">
                <label for="order-time">Horario de Entrega <span class="text-red-500">*</span></label>
                <select id="order-time" required aria-required="true" aria-label="Selecciona el horario de entrega">
                    <option value="">Selecciona un horario</option>
                    <option value="09:00-12:00">09:00 - 12:00</option>
                    <option value="12:00-15:00">12:00 - 15:00</option>
                    <option value="15:00-18:00">15:00 - 18:00</option>
                </select>
            </div>
            <div class="form-group">
                <label for="order-delivery">Tipo de Entrega <span class="text-red-500">*</span></label>
                <select id="order-delivery" required aria-required="true" aria-label="Selecciona el tipo de entrega">
                    <option value="">Selecciona una opción</option>
                    <option value="recojo">Recojo en tienda</option>
                    <option value="delivery">Delivery</option>
                </select>
            </div>
            <div id="address-group" class="form-group hidden">
                <label for="order-address">Dirección de Entrega <span class="text-red-500">*</span></label>
                <input type="text" id="order-address" placeholder="Ej: Av. Talara 123, Talara" aria-label="Ingresa la dirección de entrega">
            </div>
            <div class="form-group">
                <label for="order-message">Comentarios (opcional)</label>
                <textarea id="order-message" placeholder="Escribe comentarios adicionales (máx. 200 caracteres)" rows="4" maxlength="200" aria-label="Escribe comentarios opcionales"></textarea>
                <p class="text-sm text-[#333333]" id="char-count">0/200</p>
            </div>
            <div class="form-group">
                <label for="order-payment">Método de Pago <span class="text-red-500">*</span></label>
                <select id="order-payment" required aria-required="true" aria-label="Selecciona el método de pago">
                    <option value="">Selecciona un método</option>
                    <option value="yape">Yape</option>
                    <option value="plin">Plin</option>
                </select>
            </div>
            <div id="payment-qr" class="payment-qr hidden">
                <p id="qr-instruction"></p>
                <img id="qr-image" data-src="" alt="Código QR para pago" class="qr-image">
            </div>
            <div class="form-actions">
                <button type="button" id="details-back" class="btn btn-secondary" aria-label="Volver a la lista de ítems">Volver</button>
                <button type="button" id="confirm-order-btn" class="btn" aria-label="Confirmar el pedido">Confirmar Pedido</button>
            </div>
        </form>
    </div>

    <!-- Modal de confirmación -->
    <div id="confirmation-modal" class="modal hidden">
        <div class="modal-content">
            <h3 id="modal-title" class="modal-title">Confirmar Pedido</h3>
            <div id="modal-message"></div>
            <div class="modal-buttons">
                <button id="modal-cancel" class="btn btn-secondary" aria-label="Cancelar el pedido">Cancelar</button>
                <button id="modal-confirm" class="btn" aria-label="Enviar el pedido por WhatsApp">Enviar Pedido</button>
            </div>
        </div>
    </div>

<script src="assets/js/shop.js"></script>