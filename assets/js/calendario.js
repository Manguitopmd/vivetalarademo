document.addEventListener('DOMContentLoaded', () => {
  const calendarGrid = document.getElementById('calendario-grid');
  const currentMonthSpan = document.getElementById('calendario-current-month');
  const prevMonthBtn = document.getElementById('calendario-prev-month');
  const nextMonthBtn = document.getElementById('calendario-next-month');
  const festividadesTitle = document.getElementById('festividades-title');
  const festividadesDescription = document.getElementById('festividades-description');
  const festividadesButton = document.getElementById('festividades-button');

  // Usar la fecha actual del sistema
  const today = new Date();
  let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);

  // Frases para días de semana y fines de semana
  const weekdayPhrases = [
    '¡Disfruta de un ceviche fresco en Máncora!',
    'Relájate en la playa de Los Órganos al atardecer.',
    'Visita el mercado de Talara y prueba un majarisco.',
    'Explora la historia petrolera en el Museo de Talara.',
    'Pasea por el malecón de Pariñas con una brisa marina.',
    'Toma un café local en un restaurante de El Alto.',
    'Descubre artesanías únicas en La Brea.',
    'Haz un tour fotográfico por las calles de Lobitos.',
    'Prueba un chifón en un comedor tradicional.',
    'Visita una cevichería en Los Órganos para el almuerzo.',
    'Camina por la playa de Máncora y recoge conchas.',
    'Aprende sobre la fauna marina en un centro local.',
    'Disfruta de un jugo de mango en un puesto de Talara.',
    'Explora los manglares de Los Órganos en un paseo corto.',
    'Visita una iglesia histórica en Pariñas por la mañana.',
    '¡Vive el momento bajo el sol de Talara!',
    'Sonríe y déjate llevar por la brisa marina.',
    '¡Cada día es una nueva aventura en Talara!',
    'Saborea la vida con un plato típico local.',
    '¡Encuentra la felicidad en las pequeñas cosas de Talara!'
  ];

  const weekendPhrases = [
    '¡Surfea las olas perfectas de Máncora!',
    'Baila al ritmo de marinera en un evento en Talara.',
    'Haz un tour de avistamiento de tortugas en Los Órganos.',
    'Disfruta de una noche de música en un bar de Máncora.',
    'Explora las dunas de La Brea en un buggy.',
    'Participa en un festival gastronómico en Pariñas.',
    'Haz kayak en las aguas tranquilas de Lobitos.',
    'Visita un mercado artesanal en El Alto.',
    'Goza de un concierto al aire libre en Talara.',
    'Haz un tour en bote por la costa de Los Órganos.',
    'Prueba un cóctel tropical en una playa de Máncora.',
    'Asiste a una peña criolla en un restaurante local.',
    'Explora cuevas marinas en un tour desde Lobitos.',
    'Disfruta de un picnic en la playa de Pariñas.',
    'Vive una aventura de pesca con locales en El Alto.',
    '¡Celebra la vida con el sol y el mar de Talara!',
    '¡Haz que este fin de semana sea inolvidable!',
    'Baila bajo las estrellas en una playa de Máncora.',
    '¡Vive libre y disfruta cada instante!',
    '¡Talara te espera para brillar este fin de semana!'
  ];

  function getRandomPhrase(isWeekend) {
    const phrases = isWeekend ? weekendPhrases : weekdayPhrases;
    return phrases[Math.floor(Math.random() * phrases.length)];
  }

  function getTodayPhrase() {
    const todayStr = today.toISOString().split('T')[0]; // Formato YYYY-MM-DD
    const storedPhrase = localStorage.getItem('todayPhrase');
    const storedDate = localStorage.getItem('todayPhraseDate');
    const isWeekend = today.getDay() === 0 || today.getDay() === 6;

    if (storedDate === todayStr && storedPhrase) {
      return storedPhrase; // Reutilizar frase si es el mismo día
    } else {
      const newPhrase = getRandomPhrase(isWeekend);
      localStorage.setItem('todayPhrase', newPhrase);
      localStorage.setItem('todayPhraseDate', todayStr);
      return newPhrase;
    }
  }

  function renderCalendar(date) {
    calendarGrid.classList.add('fade');
    setTimeout(() => {
      const month = date.getMonth();
      const year = date.getFullYear();
      currentMonthSpan.textContent = date.toLocaleString('es', { month: 'long' });
      currentMonthSpan.dataset.year = year;

      // Generar días del mes
      const firstDayRaw = new Date(year, month, 1).getDay();
      // Ajustar para que Lunes sea el primer día (0 = Domingo -> 6, Lunes = 1 -> 0, etc.)
      const firstDay = firstDayRaw === 0 ? 6 : firstDayRaw - 1;
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      let html = '';

      // Días vacíos antes del primer día
      for (let i = 0; i < firstDay; i++) {
        html += '<div class="calendario-day empty"></div>';
      }

      // Días del mes
      for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const festividad = festividades.find(f => f.date === dateStr);
        // Verificar si es el día actual
        const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
        html += `<div class="calendario-day${festividad ? ' festividad' : ''}${isToday ? ' today' : ''}" 
                     ${festividad ? `data-id="${festividad.id}" data-category="${festividad.category}"` : ''}>
          ${day}
        </div>`;
      }

      calendarGrid.innerHTML = html;
      calendarGrid.classList.remove('fade');

      // Evento para actualizar sección inferior
      document.querySelectorAll('.calendario-day:not(.empty)').forEach(day => {
        day.addEventListener('click', () => {
          const id = day.dataset.id;
          const isToday = day.classList.contains('today');
          const dayDate = new Date(year, month, parseInt(day.textContent));
          const dayName = dayDate.toLocaleString('es', { weekday: 'long' });

          if (isToday) {
            // Mensaje para el día actual
            festividadesTitle.textContent = `Hoy es ${dayName}`;
            festividadesDescription.textContent = getTodayPhrase();
            festividadesButton.style.display = 'none';
            if (id) {
              // Si hay festividad, mostrarla en lugar del mensaje genérico
              const festividad = festividades.find(f => f.id == id);
              festividadesTitle.textContent = festividad.title;
              festividadesDescription.textContent = festividad.description;
              festividadesButton.href = `?section=festividad&id=${id}`;
              festividadesButton.style.display = 'inline-block';
            }
          } else if (id) {
            // Festividad normal
            const festividad = festividades.find(f => f.id == id);
            festividadesTitle.textContent = festividad.title;
            festividadesDescription.textContent = festividad.description;
            festividadesButton.href = `?section=festividad&id=${id}`;
            festividadesButton.style.display = 'inline-block';
          }
        });
      });

      // Mostrar festividad del día actual si existe
      const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
      const todayFestividad = festividades.find(f => f.date === todayStr);
      if (todayFestividad && today.getFullYear() === year && today.getMonth() === month) {
        festividadesTitle.textContent = todayFestividad.title;
        festividadesDescription.textContent = todayFestividad.description;
        festividadesButton.href = `?section=festividad&id=${todayFestividad.id}`;
        festividadesButton.style.display = 'inline-block';
      } else {
        festividadesTitle.textContent = 'Conoce Nuestras Festividades';
        festividadesDescription.textContent = 'En Talara, cada fiesta es un encuentro de cultura, fe y alegría. Procesiones, danzas y tradiciones que nos unen y encantan a quienes nos visitan. ¡Ven y descubre lo especial que es Talara!';
        festividadesButton.style.display = 'none';
      }
    }, 300);
  }

  // Renderizar calendario inicial
  renderCalendar(currentDate);

  // Navegación de meses
  prevMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  });

  nextMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  });
});