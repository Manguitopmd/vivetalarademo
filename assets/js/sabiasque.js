const filterButtons = document.querySelectorAll('.filter-btn');
const cards = document.querySelectorAll('.card');

// Filtros
filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        const filter = button.getAttribute('data-filter');
        cards.forEach(card => {
            if (filter === 'all' || card.getAttribute('data-category') === filter) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// Slider
const slider = document.querySelector('.slider');
if (slider) {
    const images = document.querySelectorAll('.slider-img');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((img, i) => {
            img.classList.toggle('active', i === index);
        });
    }

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    });
}

// Quiz
const quizSubmit = document.querySelector('.quiz-submit');
if (quizSubmit) {
    const correctAnswer = document.querySelector('.quiz-result.text-red-500').textContent.split(': ')[1];
    quizSubmit.addEventListener('click', () => {
        const selected = document.querySelector('input[name="quiz"]:checked');
        const resultCorrect = document.querySelector('.quiz-result.text-amber-400');
        const resultIncorrect = document.querySelector('.quiz-result.text-red-500');

        if (selected) {
            if (selected.value === correctAnswer) {
                resultCorrect.classList.remove('hidden');
                resultIncorrect.classList.add('hidden');
            } else {
                resultCorrect.classList.add('hidden');
                resultIncorrect.classList.remove('hidden');
            }
        }
    });
}