document.addEventListener('DOMContentLoaded', () => {
    // Cache DOM elements
    const panelButtons = document.querySelectorAll('.panel-btn');
    const panicBtn = document.getElementById('panic-btn');
    const panicOptions = document.getElementById('panic-options');
    const shareLocationBtn = document.getElementById('share-location');
    const locateMeBtn = document.getElementById('locate-me');
    const mapResults = document.getElementById('map-results');
    const mapPlaceholder = document.getElementById('map-placeholder');
    const guideSelect = document.getElementById('guide-select');
    const guideContent = document.getElementById('guide-content');
    const carouselTrack = document.querySelector('.carousel-track');
    const carouselCards = document.querySelectorAll('.alert-card');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const tipActions = document.querySelectorAll('.tip-action');
    const saveContactBtn = document.getElementById('save-contact');
    const downloadKitBtn = document.getElementById('download-kit');
    const filtroBusqueda = document.getElementById('filtro-busqueda');
    const filtroServicios = document.getElementById('filtro-servicios');
    const modalFiltros = document.getElementById('modal-filtros');
    const cerrarModalFiltros = document.getElementById('cerrar-modal-filtros');
    const aplicarFiltros = document.getElementById('aplicar-filtros');
    const contactsList = document.getElementById('contacts-list');

    let currentIndex = 0;

    // Panel Buttons
    panelButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.dataset.action;
            const sections = {
                call: '.contacts-section',
                find: '.map-section',
                tips: '.tips-section'
            };
            document.querySelectorAll('.map-section, .guide-section, .tips-section').forEach(section => {
                section.classList.toggle('hidden', section.matches(sections[action]) ? false : true);
            });
        });
    });

    // Panic Button
    panicBtn.addEventListener('click', () => {
        panicOptions.classList.toggle('hidden');
    });

    // Share Location
    shareLocationBtn.addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const { latitude, longitude } = position.coords;
                    const message = `Emergencia en Talara: https://maps.google.com/?q=${latitude},${longitude}`;
                    if (navigator.share) {
                        navigator.share({
                            title: 'Emergencia en Talara',
                            text: message
                        }).catch(() => alert('Ubicación compartida: ' + message));
                    } else {
                        alert('Ubicación compartida: ' + message);
                    }
                },
                () => alert('No se pudo obtener la ubicación.')
            );
        } else {
            alert('Geolocalización no soportada.');
        }
    });

    // Map Location
    locateMeBtn.addEventListener('click', () => {
        mapResults.classList.remove('hidden');
        mapPlaceholder.innerHTML = '<p>¡Ubicación detectada!</p>';
    });

    // Guide Selector
    guideSelect.addEventListener('change', () => {
        const value = guideSelect.value;
        const guides = {
            passport: `
                <p>1. Ve a Comisaría Talara Alta (Avenida A 55).</p>
                <p>2. Llama a tu embajada (+51 1 1234567).</p>
                <p>3. Descarga este consejo.</p>
                <button class="download-btn">Descargar</button>`,
            health: `
                <p>1. Dirígete a Hospital II Talara (Panamericana Norte).</p>
                <p>2. Llama al 106 (SAMU).</p>
                <p>3. Lleva tu seguro médico.</p>
                <button class="download-btn">Descargar</button>`,
            theft: `
                <p>1. Llama al 105 (Policía).</p>
                <p>2. Denuncia en la comisaría.</p>
                <p>3. Contacta a tu banco.</p>
                <button class="download-btn">Descargar</button>`,
            accident: `
                <p>1. Llama al 106 (SAMU).</p>
                <p>2. No muevas a la persona herida a menos que sea necesario.</p>
                <p>3. Reporta a la Policía (105).</p>
                <button class="download-btn">Descargar</button>`,
            fire: `
                <p>1. Llama a los Bomberos (116).</p>
                <p>2. Evacúa el área y evita el humo.</p>
                <p>3. No uses ascensores.</p>
                <button class="download-btn">Descargar</button>`,
            earthquake: `
                <p>1. Busca un área abierta, lejos de edificios.</p>
                <p>2. Si estás dentro, métete bajo un mueble sólido.</p>
                <p>3. Llama a Serenazgo (073) 381590 si necesitas ayuda.</p>
                <button class="download-btn">Descargar</button>`,
            beach: `
                <p>1. Contacta a Serenazgo (073) 381590.</p>
                <p>2. Evita nadar si hay oleaje fuerte.</p>
                <p>3. Busca ayuda en los puestos de salvavidas.</p>
                <button class="download-btn">Descargar</button>`
        };
        guideContent.innerHTML = guides[value] || '';
        guideContent.classList.toggle('hidden', !guides[value]);
    });

    // Alerts Carousel
    function updateCarousel() {
        carouselTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % carouselCards.length;
        updateCarousel();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + carouselCards.length) % carouselCards.length;
        updateCarousel();
    });

    // Auto-rotate carousel every 5 seconds
    setInterval(() => {
        currentIndex = (currentIndex + 1) % carouselCards.length;
        updateCarousel();
    }, 5000);

    // Tip Sharing
    tipActions.forEach(btn => {
        btn.addEventListener('click', () => {
            const tip = btn.parentElement.querySelector('p').textContent;
            if (navigator.share) {
                navigator.share({
                    title: 'Consejo de Emergencia',
                    text: tip
                }).catch(() => alert('Compartir: ' + tip));
            } else {
                alert('Compartir: ' + tip);
            }
        });
    });

    // Save Emergency Contact
    saveContactBtn.addEventListener('click', () => {
        const name = document.getElementById('emergency-contact').value.trim();
        const number = document.getElementById('emergency-number').value.trim();
        if (name && number) {
            document.getElementById('contact-name').textContent = name;
            document.getElementById('contact-call').href = `tel:${number}`;
            document.getElementById('saved-contact').classList.remove('hidden');
            // Save to localStorage
            localStorage.setItem('emergencyContact', JSON.stringify({ name, number }));
        } else {
            alert('Por favor, completa ambos campos.');
        }
    });

    // Load saved contact
    const savedContact = JSON.parse(localStorage.getItem('emergencyContact'));
    if (savedContact) {
        document.getElementById('contact-name').textContent = savedContact.name;
        document.getElementById('contact-call').href = `tel:${savedContact.number}`;
        document.getElementById('saved-contact').classList.remove('hidden');
    }

    // Download Kit
    downloadKitBtn.addEventListener('click', () => {
        const kitContent = `
Emergencias en Talara:
- Policía: 105 o (073) 382281
- Bomberos: 116 o (073) 386600
- SAMU: 106
- Serenazgo: (073) 381590
- Hospital II Talara: Panamericana Norte, Talara 20811
Consejos:
- Usa bloqueador solar.
- Toma taxis autorizados.
- En temblores, busca áreas abiertas.`;
        const blob = new Blob([kitContent], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'Kit_Emergencia_Talara.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    // Search and Filter
    filtroBusqueda.addEventListener('input', () => {
        const query = filtroBusqueda.value.toLowerCase();
        const contactCards = contactsList.querySelectorAll('.contact-card');
        contactCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(query) ? '' : 'none';
        });
    });

    filtroServicios.addEventListener('click', () => {
        modalFiltros.classList.remove('hidden');
    });

    cerrarModalFiltros.addEventListener('click', () => {
        modalFiltros.classList.add('hidden');
    });

    aplicarFiltros.addEventListener('click', () => {
        const selectedDistrito = document.querySelector('input[name="distrito"]:checked').value;
        const selectedTipos = Array.from(document.querySelectorAll('input[name="tipo"]:checked')).map(input => input.value);
        const contactCards = contactsList.querySelectorAll('.contact-card');

        contactCards.forEach(card => {
            const distrito = card.dataset.district;
            const tipo = card.dataset.type;
            const matchesDistrito = selectedDistrito === 'todos' || selectedDistrito === distrito;
            const matchesTipo = selectedTipos.length === 0 || selectedTipos.includes(tipo);
            card.style.display = matchesDistrito && matchesTipo ? '' : 'none';
        });

        modalFiltros.classList.add('hidden');
    });
});