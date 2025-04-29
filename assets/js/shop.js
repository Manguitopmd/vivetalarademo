document.addEventListener('DOMContentLoaded', () => {
    // Gestión del carrito
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Mostrar notificaciones dinámicas
    const showNotification = (title, message, showCartButton = false) => {
        // Eliminar cualquier notificación existente para evitar duplicados
        const existingModal = document.querySelector('.notification-modal');
        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement('div');
        modal.classList.add('notification-modal');
        let buttons = `
            <button class="modal-close-btn" aria-label="Cerrar notificación"><i class="fas fa-times"></i></button>
        `;
        if (showCartButton) {
            buttons += `
                <button class="go-to-cart-btn btn">Ir al Carrito</button>
            `;
        }
        modal.innerHTML = `
            <div class="notification-modal-content">
                ${buttons}
                <h3>${title}</h3>
                <p>${message}</p>
            </div>
        `;
        document.body.appendChild(modal);

        const closeBtn = modal.querySelector('.modal-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => modal.remove());
        }

        if (showCartButton) {
            const cartBtn = modal.querySelector('.go-to-cart-btn');
            if (cartBtn) {
                cartBtn.addEventListener('click', () => {
                    modal.remove();
                    window.location.href = '?section=shop&subsection=carrito';
                });
            }
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.remove();
        });

        setTimeout(() => modal.remove(), 5000);
    };

    // Animar ícono del carrito
    const triggerCartJump = () => {
        const cartIcon = document.getElementById('cart-icon');
        if (cartIcon) {
            cartIcon.classList.add('cart-jump');
            setTimeout(() => cartIcon.classList.remove('cart-jump'), 300);
        }
    };

    // Actualizar contador del carrito
    const updateCartCount = () => {
        const cartCount = document.getElementById('cart-count');
        if (!cartCount) {
            console.warn('Elemento #cart-count no encontrado en el DOM');
            return;
        }
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
        cartCount.classList.toggle('hidden', totalItems === 0);
        if (totalItems > 0) {
            triggerCartJump();
        }
    };

    // Actualizar visualización del carrito
    const updateCartDisplay = () => {
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartEmpty = document.getElementById('cart-empty');
        const clearCartBtn = document.getElementById('clear-cart-btn');
        const checkoutBtn = document.getElementById('checkout-btn');

        if (!cartItems || !cartTotal || !cartEmpty) {
            console.warn('Elementos del carrito (#cart-items, #cart-total, #cart-empty) no encontrados');
            return;
        }

        if (cart.length === 0) {
            cartItems.innerHTML = '';
            cartTotal.classList.add('hidden');
            cartEmpty.classList.remove('hidden');
            clearCartBtn.classList.add('hidden');
            checkoutBtn.classList.add('hidden');
            return;
        }

        cartItems.innerHTML = cart.map((item, index) => `
            <li class="cart-item">
                <div class="cart-item-info">
                    <span class="cart-item-name">${item.name} - S/ ${item.price.toFixed(2)}</span>
                    <span class="cart-item-details">Talla: ${item.talla}, Color: ${item.color}, Cantidad: ${item.quantity}</span>
                </div>
                <div class="cart-item-actions">
                    <button class="decrease-qty-btn" data-index="${index}" aria-label="Reducir cantidad">-</button>
                    <span>${item.quantity}</span>
                    <button class="increase-qty-btn" data-index="${index}" aria-label="Aumentar cantidad">+</button>
                    <button class="remove-btn" data-index="${index}" aria-label="Eliminar ítem"><i class="fas fa-trash"></i></button>
                </div>
            </li>
        `).join('');

        const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        cartTotal.textContent = `Total: S/ ${total.toFixed(2)}`;
        cartTotal.classList.remove('hidden');
        cartEmpty.classList.add('hidden');
        clearCartBtn.classList.remove('hidden');
        checkoutBtn.classList.remove('hidden');

        // Configurar eventos para botones de cantidad
        document.querySelectorAll('.decrease-qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.getAttribute('data-index');
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                } else {
                    cart.splice(index, 1);
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                updateCartCount();
            });
        });

        document.querySelectorAll('.increase-qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.getAttribute('data-index');
                cart[index].quantity++;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                updateCartCount();
            });
        });

        // Configurar eventos para botones de eliminación
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.getAttribute('data-index');
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                updateCartCount();
                showNotification('Ítem eliminado', 'El producto ha sido eliminado del carrito.');
            });
        });
    };

    // Catálogo: Manejo de pestañas
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            document.querySelectorAll('.category').forEach(cat => {
                if (cat.getAttribute('data-category') === category || category === 'todos') {
                    cat.classList.remove('hidden');
                } else {
                    cat.classList.add('hidden');
                }
            });
        });
    });

    // Catálogo: Modal de detalles
    const modal = document.getElementById('service-modal');
    if (modal) {
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const modalTallas = document.getElementById('modal-tallas');
        const modalColores = document.getElementById('modal-colores');
        const modalSexo = document.getElementById('modal-sexo');
        const modalClose = document.getElementById('modal-close');

        document.querySelectorAll('.view-details-btn').forEach(button => {
            button.addEventListener('click', () => {
                modalTitle.textContent = button.getAttribute('data-name');
                modalDescription.textContent = button.getAttribute('data-description');
                modalTallas.textContent = button.getAttribute('data-tallas');
                modalColores.textContent = button.getAttribute('data-colores');
                modalSexo.textContent = button.getAttribute('data-sexo');
                modal.classList.remove('hidden');
            });
        });

        modalClose.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }

    // Catálogo: Modal de fotos
    const photoModal = document.getElementById('photo-modal');
    const photoModalImage = document.getElementById('photo-modal-image');
    const photoModalClose = document.getElementById('photo-modal-close');
    if (photoModal && photoModalImage && photoModalClose) {
        document.querySelectorAll('.view-photo-btn').forEach(button => {
            button.addEventListener('click', () => {
                const imageSrc = button.getAttribute('data-image');
                photoModalImage.src = imageSrc;
                photoModal.classList.remove('hidden');
            });
        });

        photoModalClose.addEventListener('click', () => {
            photoModal.classList.add('hidden');
            photoModalImage.src = '';
        });

        photoModal.addEventListener('click', (e) => {
            if (e.target === photoModal) {
                photoModal.classList.add('hidden');
                photoModalImage.src = '';
            }
        });
    }

    // Catálogo: Añadir al carrito
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        // Limpiar eventos previos para evitar duplicados
        button.removeEventListener('click', handleAddToCart);
        button.addEventListener('click', handleAddToCart);
    });

    function handleAddToCart(event) {
        const button = event.currentTarget;
        const name = button.getAttribute('data-name');
        const price = parseFloat(button.getAttribute('data-price'));
        const image = button.getAttribute('data-image');
        const stock = parseInt(button.getAttribute('data-stock') || 10);
        const item = button.closest('.item');
        const talla = item.querySelector('.talla-select').value;
        const color = item.querySelector('.color-select').value;

        if (!talla || !color) {
            showNotification('Error', 'Por favor, selecciona una talla y un color.');
            return;
        }

        const existingItem = cart.find(i => i.name === name && i.talla === talla && i.color === color);
        if (existingItem) {
            if (existingItem.quantity >= stock) {
                showNotification('Sin stock', `No hay más ${name} (${talla}, ${color}) disponibles.`);
                return;
            }
            existingItem.quantity++;
        } else {
            if (stock < 1) {
                showNotification('Sin stock', `${name} está agotado.`);
                return;
            }
            cart.push({ name, price, image, talla, color, quantity: 1, stock });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        updateCartDisplay();
        showNotification('Éxito', `${name} (${talla}, ${color}) añadido al carrito!`, true);
    }

    // Carrito: Limpiar carrito
    const clearCartBtn = document.getElementById('clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', () => {
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
            updateCartCount();
            showNotification('Carrito vacío', 'Todos los productos han sido eliminados.');
        });
    }

    // Carrito: Continuar al formulario
    const checkoutBtn = document.getElementById('checkout-btn');
    const stepItems = document.getElementById('step-items');
    const stepDetails = document.getElementById('step-details');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (cart.length === 0) {
                showNotification('Carrito vacío', 'Explora nuestro catálogo ahora.');
                return;
            }
            stepItems.classList.add('hidden');
            stepDetails.classList.remove('hidden');
        });
    }

    // Carrito: Volver a ítems
    const detailsBack = document.getElementById('details-back');
    if (detailsBack) {
        detailsBack.addEventListener('click', () => {
            stepItems.classList.remove('hidden');
            stepDetails.classList.add('hidden');
        });
    }

    // Carrito: Formulario
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        const orderDelivery = document.getElementById('order-delivery');
        const addressGroup = document.getElementById('address-group');
        const orderMessage = document.getElementById('order-message');
        const charCount = document.getElementById('char-count');
        const paymentQr = document.getElementById('payment-qr');
        const qrImage = document.getElementById('qr-image');
        const qrInstruction = document.getElementById('qr-instruction');
        const confirmationModal = document.getElementById('confirmation-modal');
        const modalMessage = document.getElementById('modal-message');
        const modalConfirm = document.getElementById('modal-confirm');
        const modalCancel = document.getElementById('modal-cancel');

        if (orderDelivery) {
            orderDelivery.addEventListener('change', () => {
                addressGroup.classList.toggle('hidden', orderDelivery.value !== 'delivery');
                if (orderDelivery.value === 'delivery') {
                    document.getElementById('order-address').required = true;
                } else {
                    document.getElementById('order-address').required = false;
                }
            });
        }

        if (orderMessage) {
            orderMessage.addEventListener('input', () => {
                charCount.textContent = `${orderMessage.value.length}/200`;
            });
        }

        const confirmOrderBtn = document.getElementById('confirm-order-btn');
        if (confirmOrderBtn) {
            confirmOrderBtn.addEventListener('click', () => {
                const name = document.getElementById('order-name').value;
                const date = document.getElementById('order-date').value;
                const time = document.getElementById('order-time').value;
                const delivery = document.getElementById('order-delivery').value;
                const address = document.getElementById('order-address').value;
                const message = document.getElementById('order-message').value;
                const payment = document.getElementById('order-payment').value;

                if (!name || !date || !time || !delivery || (delivery === 'delivery' && !address) || !payment) {
                    showNotification('Error', 'Por favor, completa todos los campos requeridos.');
                    return;
                }

                const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const orderDetails = cart.map(item => `${item.name} (Talla: ${item.talla}, Color: ${item.color}, Cantidad: ${item.quantity})`).join(', ');
                modalMessage.innerHTML = `
                    <p><strong>Nombre:</strong> ${name}</p>
                    <p><strong>Productos:</strong> ${orderDetails}</p>
                    <p><strong>Total:</strong> S/ ${total.toFixed(2)}</p>
                    <p><strong>Fecha de Entrega:</strong> ${date}</p>
                    <p><strong>Horario:</strong> ${time}</p>
                    <p><strong>Tipo de Entrega:</strong> ${delivery === 'recojo' ? 'Recojo en tienda' : 'Delivery'}</p>
                    ${delivery === 'delivery' ? `<p><strong>Dirección:</strong> ${address}</p>` : ''}
                    ${message ? `<p><strong>Comentarios:</strong> ${message}</p>` : ''}
                    <p><strong>Método de Pago:</strong> ${payment}</p>
                `;
                confirmationModal.classList.remove('hidden');
            });
        }

        if (modalConfirm) {
            modalConfirm.addEventListener('click', () => {
                const name = document.getElementById('order-name').value;
                const date = document.getElementById('order-date').value;
                const time = document.getElementById('order-time').value;
                const delivery = document.getElementById('order-delivery').value;
                const address = document.getElementById('order-address').value;
                const message = document.getElementById('order-message').value;
                const payment = document.getElementById('order-payment').value;
                const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const orderDetails = cart.map(item => `${item.name} (Talla: ${item.talla}, Color: ${item.color}, Cantidad: ${item.quantity})`).join(', ');

                const whatsappMessage = encodeURIComponent(`Nuevo pedido de ${name}\nProductos: ${orderDetails}\nTotal: S/ ${total.toFixed(2)}\nFecha: ${date}\nHorario: ${time}\nEntrega: ${delivery === 'recojo' ? 'Recojo en tienda' : `Delivery - ${address}`}\n${message ? `Comentarios: ${message}\n` : ''}Pago: ${payment}`);
                window.open(`https://wa.me/+51987654321?text=${whatsappMessage}`, '_blank');

                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                updateCartCount();
                confirmationModal.classList.add('hidden');
                stepDetails.classList.add('hidden');
                stepItems.classList.remove('hidden');
                showNotification('¡Gracias por tu pedido!', 'Tu pedido ha sido enviado por WhatsApp. Te contactaremos pronto.');
            });
        }

        if (modalCancel) {
            modalCancel.addEventListener('click', () => {
                confirmationModal.classList.add('hidden');
            });
        }

        // Carrito: QR para pago
        const orderPayment = document.getElementById('order-payment');
        if (orderPayment) {
            orderPayment.addEventListener('change', () => {
                if (orderPayment.value === 'yape' || orderPayment.value === 'plin') {
                    qrImage.src = orderPayment.value === 'yape' ? 'assets/img/yape-qr.jpg' : 'assets/img/plin-qr.jpg';
                    qrInstruction.textContent = `Escanea este QR con ${orderPayment.value === 'yape' ? 'Yape' : 'Plin'} para realizar el pago.`;
                    paymentQr.classList.remove('hidden');
                } else {
                    paymentQr.classList.add('hidden');
                }
            });
        }
    }

    // Inicializar
    updateCartDisplay();
    updateCartCount();
});