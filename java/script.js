function loadGoogleAnalytics() {
  var s = document.createElement('script');
  s.src = "https://www.googletagmanager.com/gtag/js?id=G-7W8D30NSH8";
  s.async = true;
  document.head.appendChild(s);

  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-7W8D30NSH8'); // Tu vložte vaše reálne ID
}

document.addEventListener("DOMContentLoaded", function () {
  var banner = document.getElementById("cookie-banner");
  var consent = localStorage.getItem("cookieConsent");

  if (!banner) return;

  if (!consent) {
    banner.style.display = "block";
  } else if (consent === "accepted") {
    loadGoogleAnalytics();
  }

  document.getElementById("cookie-accept")?.addEventListener("click", function () {
    localStorage.setItem("cookieConsent", "accepted");
    loadGoogleAnalytics();
    banner.style.display = "none";
  });

  document.getElementById("cookie-decline")?.addEventListener("click", function () {
    localStorage.setItem("cookieConsent", "declined");
    banner.style.display = "none";
  });
});
window.addEventListener('scroll', function() {
    const scrollThreshold = 600; // Počet pixelov, kedy má byť stmavenie na 50%
    const currentScroll = window.pageYOffset;
    
    // Výpočet opacity: (scroll / prah) * 0.5
    // Math.min zabezpečí, že to nepresiahne 0.5
    let opacity = Math.min((currentScroll / scrollThreshold) * 0.8, 0.85);
    
    // Nastavenie CSS premennej priamo na body
    document.body.style.setProperty('--bg-overlay', opacity);
});
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.table-card.service-link');
    const selectMenu = document.querySelector('select[name="balik"]');
    const contactSection = document.getElementById('contact-form');
    const header = document.querySelector('.site-header'); // Tvoje fixné menu

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const service = this.getAttribute('data-service');

            if (selectMenu) {
                selectMenu.value = service;
            }

            if (contactSection) {
                // Výpočet pozície: pozícia formulára - výška menu - extra rezerva (napr. 20px)
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = contactSection.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});