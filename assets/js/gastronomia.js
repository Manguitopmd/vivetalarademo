console.log("gastronomia.js cargado");

let filtros = JSON.parse(localStorage.getItem("filtros_gastronomia")) || {
    busqueda: "",
    tipo: "todos",
    distrito: "todos",
    precio: "todos"
};

function hideLoader() {
    const loader = document.getElementById("loader");
    if (loader) {
        loader.classList.add("hidden");
        console.log("Loader ocultado");
    } else {
        console.warn("Loader no encontrado");
    }
}

function saveFiltros() {
    try {
        localStorage.setItem("filtros_gastronomia", JSON.stringify(filtros));
        console.log("Filtros guardados:", filtros);
    } catch (error) {
        console.error("Error al guardar filtros:", error);
    }
}

async function initPage() {
    console.log("initPage iniciado");
    try {
        const restaurantesLista = document.getElementById("restaurantes-lista");
        if (!restaurantesLista) throw new Error("Lista de gastronomía no encontrada");
        console.log("Total de restaurantes:", restaurantesLista.children.length);

        setupBusqueda();
        setupFiltros();
        setupAcordeones();
        renderRestaurantes();

        console.log("initPage completado");
    } catch (error) {
        console.error("Error en initPage:", error);
        const restaurantesLista = document.getElementById("restaurantes-lista");
        if (restaurantesLista) {
            restaurantesLista.innerHTML = `<p class="text-red-500 text-center">Error al cargar gastronomía: ${error.message}</p>`;
        }
    } finally {
        hideLoader();
    }
}

function setupBusqueda() {
    console.log("setupBusqueda iniciado");
    try {
        const filtroBusqueda = document.getElementById("filtro-busqueda");
        if (!filtroBusqueda) throw new Error("Elemento de búsqueda no encontrado");

        filtroBusqueda.value = filtros.busqueda;
        filtroBusqueda.addEventListener("input", (e) => {
            filtros.busqueda = e.target.value.toLowerCase();
            saveFiltros();
            renderRestaurantes();
            console.log("Filtro búsqueda cambiado:", filtros.busqueda);
        });
        console.log("Evento input asignado a filtro-busqueda");
    } catch (error) {
        console.error("Error en setupBusqueda:", error);
    }
}

function setupFiltros() {
    console.log("setupFiltros iniciado");
    try {
        const elements = {
            filtroTipoBtn: document.getElementById("filtro-tipo"),
            filtroDistritoBtn: document.getElementById("filtro-distrito"),
            filtroPrecioBtn: document.getElementById("filtro-precio"),
            borrarFiltrosBtn: document.getElementById("borrar-filtros"),
            modalTipo: document.getElementById("modal-tipo"),
            modalDistrito: document.getElementById("modal-distrito"),
            modalPrecio: document.getElementById("modal-precio"),
            cerrarModalTipo: document.getElementById("cerrar-modal-tipo"),
            cerrarModalDistrito: document.getElementById("cerrar-modal-distrito"),
            cerrarModalPrecio: document.getElementById("cerrar-modal-precio")
        };

        for (const [key, el] of Object.entries(elements)) {
            if (!el) throw new Error(`Elemento ${key} no encontrado`);
        }

        const {
            filtroTipoBtn, filtroDistritoBtn, filtroPrecioBtn, borrarFiltrosBtn,
            modalTipo, modalDistrito, modalPrecio, cerrarModalTipo, cerrarModalDistrito, cerrarModalPrecio
        } = elements;

        const selectedTipoRadio = document.querySelector(`input[name="tipo"][value="${filtros.tipo}"]`);
        if (selectedTipoRadio) selectedTipoRadio.checked = true;

        const selectedDistritoRadio = document.querySelector(`input[name="distrito"][value="${filtros.distrito}"]`);
        if (selectedDistritoRadio) selectedDistritoRadio.checked = true;

        const selectedPrecioRadio = document.querySelector(`input[name="precio"][value="${filtros.precio}"]`);
        if (selectedPrecioRadio) selectedPrecioRadio.checked = true;

        filtroTipoBtn.addEventListener("click", () => {
            modalTipo.classList.remove("hidden");
            modalTipo.classList.add("show");
            console.log("Modal tipo de comida abierto");
        });

        filtroDistritoBtn.addEventListener("click", () => {
            modalDistrito.classList.remove("hidden");
            modalDistrito.classList.add("show");
            console.log("Modal distrito abierto");
        });

        filtroPrecioBtn.addEventListener("click", () => {
            modalPrecio.classList.remove("hidden");
            modalPrecio.classList.add("show");
            console.log("Modal precio abierto");
        });

        borrarFiltrosBtn.addEventListener("click", () => {
            filtros = {
                busqueda: "",
                tipo: "todos",
                distrito: "todos",
                precio: "todos"
            };
            document.getElementById("filtro-busqueda").value = "";
            const defaultTipoRadio = document.querySelector('input[name="tipo"][value="todos"]');
            if (defaultTipoRadio) defaultTipoRadio.checked = true;
            const defaultDistritoRadio = document.querySelector('input[name="distrito"][value="todos"]');
            if (defaultDistritoRadio) defaultDistritoRadio.checked = true;
            const defaultPrecioRadio = document.querySelector('input[name="precio"][value="todos"]');
            if (defaultPrecioRadio) defaultPrecioRadio.checked = true;
            saveFiltros();
            renderRestaurantes();
            console.log("Filtros reseteados completamente:", filtros);
        });

        cerrarModalTipo.addEventListener("click", () => {
            modalTipo.classList.remove("show");
            modalTipo.classList.add("hidden");
            const selectedTipo = document.querySelector('input[name="tipo"]:checked')?.value || "todos";
            filtros.tipo = selectedTipo;
            saveFiltros();
            renderRestaurantes();
            console.log("Modal tipo de comida cerrado, filtro aplicado:", filtros.tipo);
        });

        cerrarModalDistrito.addEventListener("click", () => {
            modalDistrito.classList.remove("show");
            modalDistrito.classList.add("hidden");
            const selectedDistrito = document.querySelector('input[name="distrito"]:checked')?.value || "todos";
            filtros.distrito = selectedDistrito;
            saveFiltros();
            renderRestaurantes();
            console.log("Modal distrito cerrado, filtro aplicado:", filtros.distrito);
        });

        cerrarModalPrecio.addEventListener("click", () => {
            modalPrecio.classList.remove("show");
            modalPrecio.classList.add("hidden");
            const selectedPrecio = document.querySelector('input[name="precio"]:checked')?.value || "todos";
            filtros.precio = selectedPrecio;
            saveFiltros();
            renderRestaurantes();
            console.log("Modal precio cerrado, filtro aplicado:", filtros.precio);
        });

        modalTipo.addEventListener("click", (e) => {
            if (e.target === modalTipo) {
                modalTipo.classList.remove("show");
                modalTipo.classList.add("hidden");
                const selectedTipo = document.querySelector('input[name="tipo"]:checked')?.value || "todos";
                filtros.tipo = selectedTipo;
                saveFiltros();
                renderRestaurantes();
                console.log("Modal tipo de comida cerrado por clic fuera, filtro aplicado:", filtros.tipo);
            }
        });

        modalDistrito.addEventListener("click", (e) => {
            if (e.target === modalDistrito) {
                modalDistrito.classList.remove("show");
                modalDistrito.classList.add("hidden");
                const selectedDistrito = document.querySelector('input[name="distrito"]:checked')?.value || "todos";
                filtros.distrito = selectedDistrito;
                saveFiltros();
                renderRestaurantes();
                console.log("Modal distrito cerrado por clic fuera, filtro aplicado:", filtros.distrito);
            }
        });

        modalPrecio.addEventListener("click", (e) => {
            if (e.target === modalPrecio) {
                modalPrecio.classList.remove("show");
                modalPrecio.classList.add("hidden");
                const selectedPrecio = document.querySelector('input[name="precio"]:checked')?.value || "todos";
                filtros.precio = selectedPrecio;
                saveFiltros();
                renderRestaurantes();
                console.log("Modal precio cerrado por clic fuera, filtro aplicado:", filtros.precio);
            }
        });

        console.log("setupFiltros completado, eventos asignados");
    } catch (error) {
        console.error("Error en setupFiltros:", error);
        throw error;
    }
}

function setupAcordeones() {
    console.log("setupAcordeones iniciado");
    try {
        const acordeones = document.querySelectorAll(".acordeon");
        acordeones.forEach(acordeon => {
            const header = acordeon.querySelector(".acordeon-header");
            const contenido = acordeon.querySelector(".acordeon-contenido");
            const flecha = acordeon.querySelector(".acordeon-flecha");

            header.addEventListener("click", () => {
                const isActive = contenido?.classList.contains("active");

                document.querySelectorAll(".acordeon-contenido.active").forEach(otherContenido => {
                    otherContenido.classList.remove("active");
                    otherContenido.style.maxHeight = null;
                    const otherFlecha = otherContenido.parentElement.querySelector(".acordeon-flecha");
                    if (otherFlecha) otherFlecha.classList.remove("active");
                });

                if (!isActive && contenido) {
                    contenido.classList.add("active");
                    contenido.style.maxHeight = contenido.scrollHeight + "px";
                    flecha?.classList.add("active");
                    console.log(`Acordeón abierto: ${acordeon.dataset.title}`);
                } else if (contenido) {
                    contenido.classList.remove("active");
                    contenido.style.maxHeight = null;
                    flecha?.classList.remove("active");
                    console.log(`Acordeón cerrado: ${acordeon.dataset.title}`);
                }
            });
        });
        console.log("Eventos de acordeones asignados");
    } catch (error) {
        console.error("Error en setupAcordeones:", error);
    }
}

function renderRestaurantes() {
    console.log("renderRestaurantes iniciado");
    try {
        const lista = document.getElementById("restaurantes-lista");
        if (!lista) throw new Error("Lista de gastronomía no encontrada");

        const acordeones = document.querySelectorAll(".acordeon");
        console.log("Total de acordeones encontrados:", acordeones.length);
        let restaurantesMostrados = 0;

        // Ocultar el mensaje de error previo, pero preservar los acordeones
        const errorMessage = lista.querySelector(".text-gray-400, .text-red-500");
        if (errorMessage) {
            errorMessage.remove();
        }

        acordeones.forEach(acordeon => {
            const title = (acordeon.dataset.title || "").toLowerCase();
            const descripcionBreve = (acordeon.dataset.descripcionBreve || "").toLowerCase();
            const descripcion = (acordeon.dataset.descripcion || "").toLowerCase();
            const tipo = acordeon.dataset.tipo || "";
            const distrito = acordeon.dataset.distrito || "";
            const platos = (acordeon.dataset.platos || "").toLowerCase();
            const precioPromedio = parseFloat(acordeon.dataset.precioPromedio) || 0;

            let mostrar = true;

            console.log(`Evaluando restaurante: ${title}, tipo: ${tipo}, distrito: ${distrito}, precio: ${precioPromedio}`);

            if (filtros.busqueda) {
                const matchesBusqueda = title.includes(filtros.busqueda) ||
                                       descripcionBreve.includes(filtros.busqueda) ||
                                       descripcion.includes(filtros.busqueda) ||
                                       tipo.toLowerCase().includes(filtros.busqueda) ||
                                       platos.includes(filtros.busqueda);
                if (!matchesBusqueda) {
                    mostrar = false;
                    console.log(`Restaurante "${title}" oculto por búsqueda: ${filtros.busqueda}`);
                }
            }

            if (filtros.tipo !== "todos" && tipo !== filtros.tipo) {
                mostrar = false;
                console.log(`Restaurante "${title}" oculto por tipo: ${filtros.tipo}`);
            }

            if (filtros.distrito !== "todos" && distrito !== filtros.distrito) {
                mostrar = false;
                console.log(`Restaurante "${title}" oculto por distrito: ${filtros.distrito} (esperado: ${distrito})`);
            }

            if (filtros.precio && filtros.precio !== "todos") {
                let min = 0, max = Infinity;
                if (filtros.precio === "60+") {
                    min = 60;
                } else if (filtros.precio.includes("-")) {
                    [min, max] = filtros.precio.split('-').map(val => parseFloat(val));
                }
                if (precioPromedio < min || precioPromedio > max) {
                    mostrar = false;
                    console.log(`Restaurante "${title}" oculto por precio: ${filtros.precio} (promedio: ${precioPromedio})`);
                }
            }

            acordeon.style.display = mostrar ? "block" : "none";
            if (mostrar) restaurantesMostrados++;
        });

        console.log("Restaurantes mostrados:", restaurantesMostrados);
        console.log("Filtros aplicados:", filtros);

        // Mostrar mensaje solo si no hay restaurantes visibles y hay acordeones
        if (restaurantesMostrados === 0 && acordeones.length > 0) {
            const message = document.createElement("p");
            message.className = "text-gray-400 text-center";
            message.textContent = "No se encontraron restaurantes que coincidan con los filtros.";
            lista.appendChild(message);
        } else if (acordeones.length === 0) {
            const message = document.createElement("p");
            message.className = "text-gray-400 text-center";
            message.textContent = "No hay restaurantes disponibles en la base de datos.";
            lista.appendChild(message);
        }

        saveFiltros();
        console.log("renderRestaurantes completado");
    } catch (error) {
        console.error("Error en renderRestaurantes:", error);
        const lista = document.getElementById("restaurantes-lista");
        if (lista) {
            const message = document.createElement("p");
            message.className = "text-red-500 text-center";
            message.textContent = `Error al renderizar gastronomía: ${error.message}`;
            lista.appendChild(message);
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM cargado, inicializando gastronomía");
    initPage();
});