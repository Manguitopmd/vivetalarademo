document.addEventListener('DOMContentLoaded', () => {
  const sliderContainer = document.querySelector('.slider-container');
  if (!sliderContainer) return;

  const slides = sliderContainer.querySelectorAll('img');
  const prevBtn = document.querySelector('.slider-prev');
  const nextBtn = document.querySelector('.slider-next');
  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove('active');
      if (i === index) {
        slide.classList.add('active');
      }
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  }

  prevBtn.addEventListener('click', prevSlide);
  nextBtn.addEventListener('click', nextSlide);

  // Auto-slide cada 5 segundos
  let autoSlide = setInterval(nextSlide, 5000);

  // Pausar auto-slide al interactuar
  sliderContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
  sliderContainer.addEventListener('mouseleave', () => {
    autoSlide = setInterval(nextSlide, 5000);
  });

  // Mostrar primera imagen
  showSlide(currentIndex);
});