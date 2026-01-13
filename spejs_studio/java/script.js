let currentSlide = 0;

function showSlide(index) {
	const slides = document.querySelectorAll('.slide');

	slides.forEach((slide, i) => {
		slide.style.display = i === index ? 'flex' : 'none';
	});
}

function nextSlide() {
	currentSlide = (currentSlide + 1) % 6;
	showSlide(currentSlide);
}

setInterval(nextSlide, 2000);