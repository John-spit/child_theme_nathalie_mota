document.addEventListener("DOMContentLoaded", function () {
  const contactBtnPhoto = document.getElementById("photoContactBtn");
  const contactBtn = document.getElementById("contactBtn");
  const contactPopup = document.getElementById("contactPopup");
  const contactForm = contactPopup ? contactPopup.querySelector("form") : null;

  function openPopup() {
    if (contactPopup) {
      contactPopup.style.display = "flex";
      console.log("Popup ouverte");
    }
  }

  function closePopup() {
    if (contactPopup) {
      if (contactForm) {
        contactForm.reset();
      }
      contactPopup.style.display = "none";
      console.log("Popup fermée");
    }
  }

  if (contactBtn) {
    contactBtn.addEventListener("click", function (e) {
      e.preventDefault();
      openPopup();
    });
  }

  if (contactBtnPhoto) {
    contactBtnPhoto.addEventListener("click", function (e) {
      e.preventDefault();
      openPopup();

      const photoReferenceElement = document.getElementById("photoReference");
      if (photoReferenceElement) {
        const photoReference = photoReferenceElement.textContent.trim();
        jQuery("#photo-reference").val(photoReference);
        console.log("Référence photo préremplie: " + photoReference);
      } else {
        console.error("L'élément photoReference est manquant");
      }
    });
  }

  document.addEventListener("click", function (e) {
    if (
      contactPopup &&
      contactPopup.style.display === "flex" &&
      !e.target.closest(".popup-wrapper") &&
      !e.target.closest("#contactBtn") &&
      !e.target.closest("#photoContactBtn")
    ) {
      closePopup();
    }
  });

  if (contactForm) {
    document.addEventListener(
      "wpcf7mailsent",
      function (event) {
        closePopup();
      },
      false
    );
  }

  const navPrevious = document.querySelector(".nav-previous");
  const navNext = document.querySelector(".nav-next");

  if (navPrevious) {
    navPrevious.addEventListener("mouseover", function () {
      navPrevious.querySelector(".thumbnail").style.display = "block";
    });

    navPrevious.addEventListener("mouseout", function () {
      navPrevious.querySelector(".thumbnail").style.display = "none";
    });
  }

  if (navNext) {
    navNext.addEventListener("mouseover", function () {
      navNext.querySelector(".thumbnail").style.display = "block";
    });

    navNext.addEventListener("mouseout", function () {
      navNext.querySelector(".thumbnail").style.display = "none";
    });
  }

  // Fonction pour les filtres
  async function loadFilteredPhotos(page = 1) {
    const category = document.getElementById("filter-category").value;
    const format = document.getElementById("filter-format").value;
    const sort = document.getElementById("sort-date").value;

    const response = await fetch(load_more_photos.ajaxurl, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: new URLSearchParams({
        action: "filter_photos",
        category: category,
        format: format,
        sort: sort,
        nonce: load_more_photos.nonce,
        paged: page,
      }),
    });

    const text = await response.text();
    console.log(text); // Affiche la réponse brute

    try {
      const data = JSON.parse(text);
      console.log(data); // Affiche les données JSON parsées

      const galleryElement = document.getElementById("photo-gallery");
      if (page === 1) {
        // Remplace le contenu uniquement si c'est la première page
        galleryElement.innerHTML = data.html;
      } else {
        // Ajoute les nouvelles photos à la suite
        galleryElement.insertAdjacentHTML("beforeend", data.html);
      }

      // Gérer la visibilité du bouton "Charger plus"
      if (page >= data.total_pages) {
        loadMoreBtn.style.display = "none"; // Masque le bouton si c'est la dernière page
      } else {
        loadMoreBtn.style.display = "block"; // Affiche le bouton sinon
        loadMoreBtn.setAttribute("data-page", page); // Met à jour la page courante
      }
    } catch (e) {
      console.error("Parsing error:", e);
    }
  }

  const filterCategory = document.getElementById("filter-category");
  const filterFormat = document.getElementById("filter-format");
  const sortDate = document.getElementById("sort-date");

  [filterCategory, filterFormat, sortDate].forEach((filter) => {
    filter.addEventListener("change", function () {
      loadMoreBtn.setAttribute("data-page", 1); // Réinitialise la page courante
      loadFilteredPhotos(); // Charge la première page des résultats filtrés
    });
  });

  // Charger plus de photos
  const loadMoreBtn = document.getElementById("load-more");
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function () {
      const nextPage = parseInt(this.getAttribute("data-page")) + 1;
      loadFilteredPhotos(nextPage);
      this.setAttribute("data-page", nextPage);
    });
  }
});
