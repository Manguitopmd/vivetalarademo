console.log("eventos.js cargado");

let filtros = JSON.parse(localStorage.getItem("filtros")) || {
    busqueda: "",
    distrito: "todos",
    categorias: [],
    fecha: "todos",
    fechaInicio: "",
    fechaFin: ""
};

// Array de meses en español
const meses_es = {
    1: 'enero', 2: 'febrero', 3: 'marzo', 4: 'abril', 5: 'mayo', 6: 'junio',
    7: 'julio', 8: 'agosto', 9: 'septiembre', 10: 'octubre', 11: 'noviembre', 12: 'diciembre'
};

function formatDate(dateStr, includeTime = true) {
    try {
        if (!dateStr || typeof dateStr !== 'string') {
            return "Fecha no disponible";
        }
        const date = new Date(dateStr.replace(' ', 'T') + 'Z');
        if (isNaN(date.getTime())) {
            throw new Error("Fecha inválida");
        }
        const day = date.getDate();
        const month = meses_es[date.getMonth() + 1];
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        if (includeTime) {
            return `${day} de ${month} a las ${hours}:${minutes}`;
        }
        return `${day} de ${month}`;
    } catch (error) {
        console.error("Error al formatear fecha:", dateStr, error);
        return "Fecha no disponible";
    }
}

function saveFiltros() {
    try {
        localStorage.setItem("filtros", JSON.stringify(filtros));
        console.log("Filtros guardados:", filtros);
    } catch (error) {
        console.error("Error al guardar filtros:", error);
    }
}

function validateCustomDates(start, end) {
    if (!start || !end) return false;
    const startDate = new Date(start);
    const endDate = new Date(end);
    return (
        !isNaN(startDate.getTime()) &&
        !isNaN(endDate.getTime()) &&
        startDate <= endDate
    );
}

function hasActiveFilters() {
    return (
        filtros.busqueda !== "" ||
        filtros.distrito !== "todos" ||
        filtros.categorias.length > 0 ||
        filtros.fecha !== "todos"
    );
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

async function initPage() {
    console.log("initPage iniciado");
    try {
        const eventosGrid = document.getElementById("eventos-grid");
        if (!eventosGrid) throw new Error("Grid de eventos no encontrado");

        // Guardar tarjetas originales
        window.originalEventosCards = Array.from(eventosGrid.querySelectorAll(".evento-card")).map(card => card.cloneNode(true));
        console.log("Tarjetas originales guardadas:", window.originalEventosCards.length);

        // Usar delegación de eventos
        eventosGrid.addEventListener("click", (e) => {
            const card = e.target.closest(".evento-card");
            if (card) {
                mostrarDetalles(card);
                console.log(`Evento clic en tarjeta: ${card.dataset.title}`);
            }
        });

        sortEventos();
        setupBusqueda();
        setupFiltros();
        renderEventos();

        console.log("initPage completado");
    } catch (error) {
        console.error("Error en initPage:", error);
        const eventosGrid = document.getElementById("eventos-grid");
        if (eventosGrid) {
            eventosGrid.innerHTML = `<p class="text-red-500 text-center">Error al cargar eventos: ${error.message}</p>`;
        }
    }
}

function sortEventos() {
    console.log("sortEventos iniciado");
    try {
        const eventosGrid = document.getElementById("eventos-grid");
        const cards = Array.from(eventosGrid.querySelectorAll(".evento-card"));
        cards.sort((a, b) => {
            const isPremiumA = a.dataset.premium === "true";
            const isPremiumB = b.dataset.premium === "true";
            const dateA = a.dataset.fecha ? new Date(a.dataset.fecha.replace(' ', 'T') + 'Z') : new Date(0);
            const dateB = b.dataset.fecha ? new Date(b.dataset.fecha.replace(' ', 'T') + 'Z') : new Date(0);
            if (!hasActiveFilters() && isPremiumA !== isPremiumB) {
                return isPremiumB - isPremiumA;
            }
            return dateA - dateB;
        });
        eventosGrid.innerHTML = "";
        cards.forEach(card => eventosGrid.appendChild(card));
        console.log("Eventos ordenados:", hasActiveFilters() ? "por fecha" : "destacados primero, luego por fecha");
    } catch (error) {
        console.error("Error en sortEventos:", error);
    }
}

function setupBusqueda() {
    console.log("setupBusqueda iniciado");
    try {
        const filtroBusqueda = document.getElementById("filtro-busqueda");
        if (!filtroBusqueda) throw new Error("Elemento de búsqueda no encontrado");

        filtroBusqueda.value = filtros.busqueda;
        const debouncedSearch = debounce(() => {
            filtros.busqueda = filtroBusqueda.value.toLowerCase();
            saveFiltros();
            renderEventos();
            console.log("Filtro búsqueda cambiado:", filtros.busqueda);
        }, 250);

        filtroBusqueda.addEventListener("input", debouncedSearch);
        console.log("Evento input (debounced) asignado a filtro-busqueda");
    } catch (error) {
        console.error("Error en setupBusqueda:", error);
    }
}

function setupFiltros() {
    console.log("setupFiltros iniciado");
    try {
        const elements = {
            filtroDistritoBtn: document.getElementById("filtro-distrito"),
            filtroFechaBtn: document.getElementById("filtro-fecha"),
            filtroCategoriaBtn: document.getElementById("filtro-categoria"),
            borrarFiltrosBtn: document.getElementById("borrar-filtros"),
            modalDistrito: document.getElementById("modal-distrito"),
            modalFecha: document.getElementById("modal-fecha"),
            modalCategoria: document.getElementById("modal-categoria"),
            cerrarModalDistrito: document.getElementById("cerrar-modal-distrito"),
            cerrarModalFecha: document.getElementById("cerrar-modal-fecha"),
            cerrarModalCategoria: document.getElementById("cerrar-modal-categoria"),
            aplicarDistrito: document.getElementById("aplicar-distrito"),
            aplicarFecha: document.getElementById("aplicar-fecha"),
            aplicarCategoria: document.getElementById("aplicar-categoria"),
            rangoFecha: document.getElementById("rango-fecha"),
            fechaCustom: document.getElementById("fecha-custom")
        };

        for (const [key, el] of Object.entries(elements)) {
            if (!el) throw new Error(`Elemento ${key} no encontrado`);
        }

        const {
            filtroDistritoBtn, filtroFechaBtn, filtroCategoriaBtn, borrarFiltrosBtn,
            modalDistrito, modalFecha, modalCategoria, cerrarModalDistrito,
            cerrarModalFecha, cerrarModalCategoria, aplicarDistrito, aplicarFecha,
            aplicarCategoria, rangoFecha, fechaCustom
        } = elements;

        const selectedDistritoRadio = document.querySelector(`input[name="distrito"][value="${filtros.distrito}"]`);
        if (selectedDistritoRadio) selectedDistritoRadio.checked = true;

        const selectedFechaRadio = document.querySelector(`input[name="fecha"][value="${filtros.fecha}"]`);
        if (selectedFechaRadio) selectedFechaRadio.checked = true;
        if (filtros.fecha === "custom") {
            rangoFecha.classList.remove("hidden");
            document.getElementById("fecha-inicio").value = filtros.fechaInicio;
            document.getElementById("fecha-fin").value = filtros.fechaFin;
        }

        filtros.categorias.forEach(cat => {
            const checkbox = document.querySelector(`input[name="categoria"][value="${cat}"]`);
            if (checkbox) checkbox.checked = true;
        });

        filtroDistritoBtn.addEventListener("click", () => {
            modalDistrito.classList.remove("hidden");
            modalDistrito.classList.add("show");
            console.log("Modal distrito abierto");
        });

        filtroFechaBtn.addEventListener("click", () => {
            modalFecha.classList.remove("hidden");
            modalFecha.classList.add("show");
            console.log("Modal fecha abierto");
        });

        filtroCategoriaBtn.addEventListener("click", () => {
            modalCategoria.classList.remove("hidden");
            modalCategoria.classList.add("show");
            console.log("Modal categoría abierto");
        });

        borrarFiltrosBtn.addEventListener("click", () => {
            filtros = {
                busqueda: "",
                distrito: "todos",
                categorias: [],
                fecha: "todos",
                fechaInicio: "",
                fechaFin: ""
            };
            document.getElementById("filtro-busqueda").value = "";
            document.querySelector('input[name="distrito"][value="todos"]').checked = true;
            document.querySelectorAll('input[name="categoria"]').forEach(checkbox => checkbox.checked = false);
            document.querySelector('input[name="fecha"][value="todos"]').checked = true;
            document.getElementById("fecha-inicio").value = "";
            document.getElementById("fecha-fin").value = "";
            rangoFecha.classList.add("hidden");
            saveFiltros();
            resetEventosGrid();
            renderEventos();
            console.log("Filtros reseteados, intentando restaurar grid");
        });

        cerrarModalDistrito.addEventListener("click", () => {
            modalDistrito.classList.remove("show");
            modalDistrito.classList.add("hidden");
            console.log("Modal distrito cerrado");
        }, { once: true });

        cerrarModalFecha.addEventListener("click", () => {
            modalFecha.classList.remove("show");
            modalFecha.classList.add("hidden");
            console.log("Modal fecha cerrado");
        }, { once: true });

        cerrarModalCategoria.addEventListener("click", () => {
            modalCategoria.classList.remove("show");
            modalCategoria.classList.add("hidden");
            console.log("Modal categoría cerrado");
        }, { once: true });

        modalDistrito.addEventListener("click", (e) => {
            if (e.target === modalDistrito) {
                modalDistrito.classList.remove("show");
                modalDistrito.classList.add("hidden");
                console.log("Modal distrito cerrado por clic fuera");
            }
        }, { once: true });

        modalFecha.addEventListener("click", (e) => {
            if (e.target === modalFecha) {
                modalFecha.classList.remove("show");
                modalFecha.classList.add("hidden");
                console.log("Modal fecha cerrado por clic fuera");
            }
        }, { once: true });

        modalCategoria.addEventListener("click", (e) => {
            if (e.target === modalCategoria) {
                modalCategoria.classList.remove("show");
                modalCategoria.classList.add("hidden");
                console.log("Modal categoría cerrado por clic fuera");
            }
        }, { once: true });

        aplicarDistrito.addEventListener("click", () => {
            const selectedDistrito = document.querySelector('input[name="distrito"]:checked')?.value || "todos";
            filtros.distrito = selectedDistrito;
            saveFiltros();
            modalDistrito.classList.remove("show");
            modalDistrito.classList.add("hidden");
            renderEventos();
            console.log("Filtro distrito aplicado:", filtros.distrito);
        });

        aplicarFecha.addEventListener("click", () => {
            const selectedFecha = document.querySelector('input[name="fecha"]:checked')?.value || "todos";
            filtros.fecha = selectedFecha;
            if (selectedFecha === "custom") {
                const fechaInicio = document.getElementById("fecha-inicio").value;
                const fechaFin = document.getElementById("fecha-fin").value;
                if (!validateCustomDates(fechaInicio, fechaFin)) {
                    alert("Por favor, seleccione un rango de fechas válido.");
                    return;
                }
                filtros.fechaInicio = fechaInicio;
                filtros.fechaFin = fechaFin;
            } else {
                filtros.fechaInicio = "";
                filtros.fechaFin = "";
            }
            saveFiltros();
            modalFecha.classList.remove("show");
            modalFecha.classList.add("hidden");
            renderEventos();
            console.log("Filtro fecha aplicado:", filtros.fecha, filtros.fechaInicio, filtros.fechaFin);
        });

        aplicarCategoria.addEventListener("click", () => {
            filtros.categorias = Array.from(document.querySelectorAll('input[name="categoria"]:checked')).map(input => input.value);
            saveFiltros();
            modalCategoria.classList.remove("show");
            modalCategoria.classList.add("hidden");
            renderEventos();
            console.log("Filtro categorías aplicadas:", filtros.categorias);
        });

        fechaCustom.addEventListener("change", () => {
            rangoFecha.classList.toggle("hidden", !fechaCustom.checked);
            console.log("Rango fecha toggled:", !fechaCustom.checked);
        });

        console.log("setupFiltros completado, eventos asignados");
    } catch (error) {
        console.error("Error en setupFiltros:", error);
        throw error;
    }
}

function resetEventosGrid() {
    console.log("resetEventosGrid iniciado");
    try {
        const eventosGrid = document.getElementById("eventos-grid");
        if (!eventosGrid) throw new Error("Grid de eventos no encontrado");

        eventosGrid.innerHTML = "";
        if (window.originalEventosCards && window.originalEventosCards.length > 0) {
            window.originalEventosCards.forEach(card => {
                eventosGrid.appendChild(card.cloneNode(true));
            });
            console.log("Tarjetas originales restauradas:", window.originalEventosCards.length);
        } else {
            console.warn("No hay tarjetas originales, intentando recarga desde servidor");
            reloadEventos();
        }

        console.log("Grid de eventos restaurado");
    } catch (error) {
        console.error("Error en resetEventosGrid:", error);
        reloadEventos();
    }
}

function reloadEventos() {
    console.log("reloadEventos iniciado");
    try {
        const eventosGrid = document.getElementById("eventos-grid");
        if (!eventosGrid) throw new Error("Grid de eventos no encontrado");

        fetch('includes/fetch_eventos.php', { method: 'GET' })
            .then(response => {
                console.log("Estado de la respuesta:", response.status, response.statusText);
                if (!response.ok) throw new Error(`Error HTTP: ${response.status} ${response.statusText}`);
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("text/html")) {
                    throw new Error("La respuesta no es HTML válido");
                }
                return response.text();
            })
            .then(html => {
                if (!html.trim()) throw new Error("Respuesta vacía del servidor");
                eventosGrid.innerHTML = html;
                window.originalEventosCards = Array.from(eventosGrid.querySelectorAll(".evento-card")).map(card => card.cloneNode(true));
                console.log("Eventos recargados desde servidor:", window.originalEventosCards.length);
                renderEventos();
            })
            .catch(error => {
                console.error("Error al recargar eventos:", error.message);
                eventosGrid.innerHTML = `<p class="text-red-500 text-center">Error al recargar eventos: ${error.message}. Por favor, recarga la página.</p>`;
            });
    } catch (error) {
        console.error("Error en reloadEventos:", error);
        const eventosGrid = document.getElementById("eventos-grid");
        if (eventosGrid) {
            eventosGrid.innerHTML = `<p class="text-red-500 text-center">Error al recargar eventos: ${error.message}. Por favor, recarga la página.</p>`;
        }
    }
}

function renderEventos() {
    console.log("renderEventos iniciado");
    try {
        const grid = document.getElementById("eventos-grid");
        const modal = document.getElementById("evento-modal");
        if (!grid || !modal) throw new Error("Grid o modal no encontrados");

        modal.classList.remove("show");
        grid.classList.remove("hidden");

        const filtroDistritoBtn = document.getElementById("filtro-distrito");
        const filtroFechaBtn = document.getElementById("filtro-fecha");
        const filtroCategoriaBtn = document.getElementById("filtro-categoria");
        const borrarFiltrosBtn = document.getElementById("borrar-filtros");

        filtroDistritoBtn.classList.toggle("active", filtros.distrito !== "todos");
        filtroFechaBtn.classList.toggle("active", filtros.fecha !== "todos");
        filtroCategoriaBtn.classList.toggle("active", filtros.categorias.length > 0);
        borrarFiltrosBtn.classList.remove("active");

        if (!grid.querySelector(".evento-card")) {
            resetEventosGrid();
        }

        const cards = document.querySelectorAll(".evento-card");
        console.log("Total de tarjetas encontradas:", cards.length);
        let eventosMostrados = 0;

        const now = new Date();

        cards.forEach(card => {
            let mostrar = true;

            const title = card.dataset.title?.toLowerCase() || "";
            const description = card.dataset.descripcion?.toLowerCase() || "";
            const distrito = card.dataset.distrito?.toLowerCase() || "";
            const categoria = card.dataset.categoria || "";
            const fechaInicio = card.dataset.fecha ? new Date(card.dataset.fecha.replace(' ', 'T') + 'Z') : null;
            const fechaFin = card.dataset.fechaFin ? new Date(card.dataset.fechaFin.replace(' ', 'T') + 'Z') : null;

            const fechaRelevante = fechaFin || fechaInicio;
            if (fechaRelevante && fechaRelevante < now) {
                mostrar = false;
                console.log(`Tarjeta "${title}" oculta por evento pasado: ${fechaRelevante.toISOString()}`);
            }

            if (mostrar && filtros.busqueda) {
                const matchesBusqueda = title.includes(filtros.busqueda) ||
                                       description.includes(filtros.busqueda) ||
                                       distrito.includes(filtros.busqueda) ||
                                       categoria.toLowerCase().includes(filtros.busqueda);
                if (!matchesBusqueda) {
                    mostrar = false;
                    console.log(`Tarjeta "${title}" oculta por búsqueda: ${filtros.busqueda}`);
                }
            }

            if (mostrar && filtros.distrito !== "todos" && distrito !== filtros.distrito.toLowerCase()) {
                mostrar = false;
                console.log(`Tarjeta "${title}" oculta por distrito: ${filtros.distrito}`);
            }

            if (mostrar && filtros.categorias.length > 0 && !filtros.categorias.includes(categoria)) {
                mostrar = false;
                console.log(`Tarjeta "${title}" oculta por categoría: ${filtros.categorias}`);
            }

            if (mostrar && filtros.fecha !== "todos" && fechaInicio) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                let startDate, endDate;
                switch (filtros.fecha) {
                    case "hoy":
                        startDate = today;
                        endDate = new Date(today);
                        endDate.setDate(today.getDate() + 1);
                        break;
                    case "semana":
                        startDate = today;
                        endDate = new Date(today);
                        endDate.setDate(today.getDate() + 7);
                        break;
                    case "mes":
                        startDate = today;
                        endDate = new Date(today);
                        endDate.setMonth(today.getMonth() + 1);
                        break;
                    case "custom":
                        if (!validateCustomDates(filtros.fechaInicio, filtros.fechaFin)) {
                            mostrar = false;
                            console.log(`Tarjeta "${title}" oculta por rango de fechas inválido`);
                            break;
                        }
                        startDate = new Date(filtros.fechaInicio);
                        endDate = new Date(filtros.fechaFin);
                        endDate.setDate(endDate.getDate() + 1);
                        break;
                    default:
                        break;
                }
                if (startDate && endDate) {
                    const eventStart = fechaInicio;
                    const eventEnd = fechaFin || fechaInicio;
                    const rangeStart = startDate;
                    const rangeEnd = endDate;
                    const overlaps = eventStart < rangeEnd && eventEnd > rangeStart;
                    if (!overlaps) {
                        mostrar = false;
                        console.log(`Tarjeta "${title}" oculta por fecha: ${filtros.fecha}`);
                    }
                }
            }

            card.style.display = mostrar ? "block" : "none";
            if (mostrar) eventosMostrados++;
        });

        console.log("Eventos mostrados:", eventosMostrados);
        const noEventosMsg = grid.querySelector("#no-eventos");
        if (eventosMostrados === 0 && cards.length > 0) {
            if (!noEventosMsg) {
                const msg = document.createElement("p");
                msg.id = "no-eventos";
                msg.className = "text-gray-400 text-center";
                msg.textContent = "No se encontraron eventos.";
                grid.appendChild(msg);
            }
        } else if (noEventosMsg) {
            noEventosMsg.remove();
        }

        saveFiltros();
        console.log("renderEventos completado");
    } catch (error) {
        console.error("Error en renderEventos:", error);
        const grid = document.getElementById("eventos-grid");
        if (grid) {
            grid.innerHTML = `<p class="text-red-500 text-center">Error al renderizar eventos: ${error.message}</p>`;
        }
    }
}

function mostrarDetalles(card) {
    console.log("mostrarDetalles iniciado para:", card.dataset.title);
    try {
        const grid = document.getElementById("eventos-grid");
        const modal = document.getElementById("evento-modal");
        const modalBody = document.getElementById("modal-body");
        const cerrarModal = document.getElementById("cerrar-modal");
        if (!grid || !modal || !modalBody || !cerrarModal) {
            throw new Error("Grid, modal o elementos no encontrados");
        }

        const categoria = card.dataset.categoria.toLowerCase();
        const categoriasValidas = [
            'celebracion', 'comercial', 'cultural', 'deportivo', 'educativo',
            'familiar', 'festival', 'gastronomico', 'musical'
        ];
        categoriasValidas.forEach(cat => modal.classList.remove(cat));
        if (categoriasValidas.includes(categoria)) {
            modal.classList.add(categoria);
        } else {
            console.warn(`Categoría no válida: ${categoria}`);
        }

        const title = card.dataset.title || "Sin título";
        const fecha = card.dataset.fecha;
        const fechaFin = card.dataset.fechaFin;
        const image = card.dataset.image;
        const video = card.dataset.video;
        const whatsapp = card.dataset.whatsapp;
        const maps = card.dataset.maps;
        const tickets = card.dataset.tickets;
        const webUrl = card.dataset.webUrl;
        const latitud = card.dataset.latitud;
        const longitud = card.dataset.longitud;

        const fechaValida = fecha && !isNaN(new Date(fecha.replace(' ', 'T') + 'Z').getTime());
        const fechaFinValida = fechaFin && !isNaN(new Date(fechaFin.replace(' ', 'T') + 'Z').getTime());

        const locationUrl = maps || (latitud && longitud ? `https://www.google.com/maps?q=${latitud},${longitud}` : null);

        let fechasTexto = "Fecha no disponible";
        if (fechaValida) {
            if (fechaFinValida) {
                fechasTexto = `<i class="fas fa-calendar-alt mr-2"></i> Del ${formatDate(fecha)} al ${formatDate(fechaFin, false)}`;
            } else {
                fechasTexto = `<i class="fas fa-calendar-alt mr-2"></i> El evento se realizará este ${formatDate(fecha)}`;
            }
        }

        grid.classList.add("hidden");
        modal.classList.remove("hidden");
        modal.classList.add("show");

        let mediaContent = "";
        if (video) {
            const videoIdMatch = video.match(/(?:v=)([^&]+)/) || video.match(/(?:embed\/)([^?]+)/);
            const videoId = videoIdMatch ? videoIdMatch[1] : null;
            if (videoId) {
                mediaContent = `<iframe id="youtube-iframe" src="https://www.youtube.com/embed/${videoId}?enablejsapi=1" title="Video de ${title}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-[300px] rounded-md mb-6"></iframe>`;
            }
        } else if (image) {
            mediaContent = `<img src="${image}" alt="${title}" class="w-full h-[250px] object-cover rounded-md mb-6">`;
        } else {
            mediaContent = `<div class="no-media w-full h-[250px] rounded-md mb-6 flex items-center justify-center"><p class="text-gray-400">Sin imagen o video</p></div>`;
        }

        modalBody.innerHTML = `
            <h2 class="text-xl font-semibold text-white mb-4 text-center">${title}</h2>
            <p class="fecha text-gray-300 mb-4 text-center">${fechasTexto}</p>
            ${mediaContent}
            <div class="botones flex gap-4 justify-center flex-wrap">
                ${whatsapp ? `<a href="https://wa.me/${whatsapp.replace('+', '')}" target="_blank" class="btn-whatsapp bg-[#25d366] text-white p-3 rounded-md" aria-label="Contactar por WhatsApp"><i class="fab fa-whatsapp text-lg"></i></a>` : ""}
                ${locationUrl ? `<a href="${locationUrl}" target="_blank" class="btn-maps bg-[#00ddeb] text-white p-3 rounded-md" aria-label="Ver ubicación en Maps"><i class="fas fa-map-marked-alt text-lg"></i></a>` : ""}
                ${tickets ? `<a href="${tickets}" target="_blank" class="btn-tickets bg-[#facc15] text-white p-3 rounded-md" aria-label="Comprar entradas"><i class="fas fa-ticket-alt text-lg"></i></a>` : ""}
                ${webUrl ? `<a href="${webUrl}" target="_blank" class="btn-web bg-[#f97316] text-white p-3 rounded-md" aria-label="Más información"><i class="fas fa-info-circle text-lg"></i></a>` : ""}
            </div>
        `;

        cerrarModal.addEventListener("click", () => {
            modal.classList.remove("show");
            modal.classList.add("hidden");
            grid.classList.remove("hidden");
            categoriasValidas.forEach(cat => modal.classList.remove(cat));
            const iframe = document.getElementById("youtube-iframe");
            if (iframe) {
                iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            }
            console.log("Modal cerrado");
        }, { once: true });

        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.remove("show");
                modal.classList.add("hidden");
                grid.classList.remove("hidden");
                categoriasValidas.forEach(cat => modal.classList.remove(cat));
                const iframe = document.getElementById("youtube-iframe");
                if (iframe) {
                    iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                }
                console.log("Modal cerrado por clic fuera");
            }
        }, { once: true });

        console.log("mostrarDetalles completado");
    } catch (error) {
        console.error("Error en mostrarDetalles:", error);
        const modalBody = document.getElementById("modal-body");
        if (modalBody) {
            modalBody.innerHTML = `<p class="text-red-500 text-center">Error al cargar detalles: ${error.message}</p>`;
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM cargado, inicializando eventos");
    initPage();
});