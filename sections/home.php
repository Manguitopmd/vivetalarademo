<style>
    .slider-container {
        position: relative;
        width: 100%;
        height: calc(100vh - 60px);
        overflow: hidden;
    }
    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transform: translateY(100%);
        transition: transform 0.5s ease-in-out;
    }
    .slide.active {
        transform: translateY(0);
    }
    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    .slide-title {
        font-size: 48px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    .dots-container {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
    }
    .dot {
        width: 12px;
        height: 12px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s;
    }
    .dot.active {
        background: rgba(255, 255, 255, 1);
    }
    .content-section {
        max-width: 1200px;
        margin: 40px auto;
        padding: 24px;
        text-align: center;
    }
    .content-title {
        font-size: 32px;
        font-weight: 600;
        color: #1e3a8a;
        margin-bottom: 16px;
    }
    @media (max-width: 640px) {
        .slide-title {
            font-size: 32px;
        }
        .dots-container {
            bottom: 16px;
        }
        .dot {
            width: 10px;
            height: 10px;
        }
        .content-section {
            padding: 16px;
        }
        .content-title {
            font-size: 24px;
        }
    }
</style>

<!-- Slider Vertical -->
<div class="slider-container">
    <!-- Slides -->
    <div class="slide" style="background-image: url('assets/img/home/1.jpg');">
        <div class="slide-overlay">
            <h2 class="slide-title">Bienvenido</h2>
        </div>
    </div>
    <div class="slide" style="background-image: url('assets/img/home/2.jpg');">
        <div class="slide-overlay">
            <h2 class="slide-title">Descubre Nuestra Gastronomía</h2>
        </div>
    </div>
    <div class="slide" style="background-image: url('assets/img/home/3.jpg');">
        <div class="slide-overlay">
            <h2 class="slide-title">Experiencias Inolvidables</h2>
        </div>
    </div>
    <!-- Dots -->
    <div class="dots-container">
        <span class="dot active" onclick="goToSlide(0)"></span>
        <span class="dot" onclick="goToSlide(1)"></span>
        <span class="dot" onclick="goToSlide(2)"></span>
    </div>
</div>

<script>
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
            slide.style.transform = `translateY(${i < index ? -100 : i > index ? 100 : 0}%)`;
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        currentSlide = index;
    }

    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    function goToSlide(index) {
        showSlide(index);
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }

    // Inicializar slider
    showSlide(0);
    slideInterval = setInterval(nextSlide, 5000);

    // Pausar auto-avance en hover
    const sliderContainer = document.querySelector('.slider-container');
    sliderContainer.addEventListener('mouseenter', () => clearInterval(slideInterval));
    sliderContainer.addEventListener('mouseleave', () => {
        slideInterval = setInterval(nextSlide, 5000);
    });
</script>