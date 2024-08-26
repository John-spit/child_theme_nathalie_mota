document.addEventListener("DOMContentLoaded", function () {
  const lightboxOverlay = document.getElementById("photo-lightbox");
  const lightboxImage = document.getElementById("lightbox-image");
  const lightboxReference = document.getElementById("lightbox-reference");
  const lightboxCategory = document.getElementById("lightbox-category");
  const lightboxClose = document.querySelector(".lightbox-close");
  const lightboxPrev = document.querySelector(".lightbox-prev");
  const lightboxNext = document.querySelector(".lightbox-next");

  let currentIndex = 0;
  let photos = [];

  // Attache des événements via délégation pour les nouvelles icônes ajoutées
  document.addEventListener("click", function (e) {
    if (e.target.closest(".icon-fullscreen")) {
      e.preventDefault();

      const icon = e.target.closest(".icon-fullscreen");
      const imgSrc = icon.getAttribute("href");
      const reference =
        icon.getAttribute("data-reference") || "Référence non disponible";
      const category =
        icon.closest(".related-photo-item").querySelector(".photo-category div")
          .textContent || "Catégorie non disponible";

      photos = [...document.querySelectorAll(".icon-fullscreen")];
      currentIndex = photos.indexOf(icon);

      lightboxImage.src = imgSrc;
      lightboxReference.textContent = reference;
      lightboxCategory.textContent = category;

      lightboxOverlay.style.display = "flex";
    }
  });

  // Ferme la lightbox
  lightboxClose.addEventListener("click", function (e) {
    e.preventDefault();
    lightboxOverlay.style.display = "none";
  });

  // Navigue vers la photo précédente
  lightboxPrev.addEventListener("click", function (e) {
    e.preventDefault();
    currentIndex = currentIndex === 0 ? photos.length - 1 : currentIndex - 1;
    loadLightboxPhoto();
  });

  // Navigue vers la photo suivante
  lightboxNext.addEventListener("click", function (e) {
    e.preventDefault();
    currentIndex = currentIndex === photos.length - 1 ? 0 : currentIndex + 1;
    loadLightboxPhoto();
  });

  // Fonction pour charger les informations de la photo dans la lightbox
  function loadLightboxPhoto() {
    const selectedPhoto = photos[currentIndex];
    const imgSrc = selectedPhoto.getAttribute("href");
    const reference =
      selectedPhoto.getAttribute("data-reference") ||
      "Référence non disponible";
    const category =
      selectedPhoto
        .closest(".related-photo-item")
        .querySelector(".photo-category div").textContent ||
      "Catégorie non disponible";

    lightboxImage.src = imgSrc;
    lightboxReference.textContent = reference;
    lightboxCategory.textContent = category;
  }
});
