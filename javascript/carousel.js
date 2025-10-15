const slides = document.querySelectorAll('.carousel-slide');
const nextBtn = document.querySelector('.carousel-btn.next');
const prevBtn = document.querySelector('.carousel-btn.prev');

let current = 0;

function updateSlides() {
  slides.forEach((slide, i) => {
    slide.classList.remove('active', 'prev', 'next');
  });

  slides[current].classList.add('active');

  const prev = (current - 1 + slides.length) % slides.length;
  const next = (current + 1) % slides.length;

  slides[prev].classList.add('prev');
  slides[next].classList.add('next');
}

nextBtn.addEventListener('click', () => {
  current = (current + 1) % slides.length;
  updateSlides();
});

prevBtn.addEventListener('click', () => {
  current = (current - 1 + slides.length) % slides.length;
  updateSlides();
});

updateSlides();
