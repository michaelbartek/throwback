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
<script>
function loadGoogleAnalytics() {
  var s = document.createElement('script');
  s.src = "https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX";
  s.async = true;
  document.head.appendChild(s);

  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXX');
}

document.addEventListener("DOMContentLoaded", function () {
  var consent = localStorage.getItem("cookieConsent");
  var banner = document.getElementById("cookie-banner");

  if (!consent) banner.style.display = "block";
  if (consent === "accepted") loadGoogleAnalytics();

  document.getElementById("cookie-accept").onclick = function () {
    localStorage.setItem("cookieConsent", "accepted");
    loadGoogleAnalytics();
    banner.style.display = "none";
  };

  document.getElementById("cookie-decline").onclick = function () {
    localStorage.setItem("cookieConsent", "declined");
    banner.style.display = "none";
  };
});
</script>
