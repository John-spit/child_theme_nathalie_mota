document.addEventListener("DOMContentLoaded", function () {
  //Popup
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

  // Miniatures au survol sur les flèches
  const navPrevious = document.querySelector(".nav-previous");
  const navNext = document.querySelector(".nav-next");

  if (navPrevious) {
    navPrevious.addEventListener("mouseover", function () {
      const thumbnail = navPrevious.querySelector(".thumbnail");
      if (thumbnail) {
        thumbnail.style.display = "block";
      }
    });

    navPrevious.addEventListener("mouseout", function () {
      const thumbnail = navPrevious.querySelector(".thumbnail");
      if (thumbnail) {
        thumbnail.style.display = "none";
      }
    });
  }

  if (navNext) {
    navNext.addEventListener("mouseover", function () {
      const thumbnail = navNext.querySelector(".thumbnail");
      if (thumbnail) {
        thumbnail.style.display = "block";
      }
    });

    navNext.addEventListener("mouseout", function () {
      const thumbnail = navNext.querySelector(".thumbnail");
      if (thumbnail) {
        thumbnail.style.display = "none";
      }
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
      if (galleryElement) {
        if (page === 1) {
          // Remplace le contenu uniquement si c'est la première page
          galleryElement.innerHTML = data.html;
        } else {
          // Ajoute les nouvelles photos à la suite
          galleryElement.insertAdjacentHTML("beforeend", data.html);
        }

        // Gère la visibilité du bouton "Charger plus"
        if (page >= data.total_pages) {
          loadMoreBtn.style.display = "none";
        } else {
          loadMoreBtn.style.display = "block";
          loadMoreBtn.setAttribute("data-page", page);
        }
      } else {
        console.error("L'élément 'photo-gallery' est manquant");
      }
    } catch (e) {
      console.error("Parsing error:", e);
    }
  }

  const filterCategory = document.getElementById("filter-category");
  const filterFormat = document.getElementById("filter-format");
  const sortDate = document.getElementById("sort-date");

  if (filterCategory && filterFormat && sortDate) {
    [filterCategory, filterFormat, sortDate].forEach((filter) => {
      filter.addEventListener("change", function () {
        loadMoreBtn.setAttribute("data-page", 1);
        loadFilteredPhotos();
      });
    });
  }

  // Charge plus de photos
  const loadMoreBtn = document.getElementById("load-more");
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function () {
      const nextPage = parseInt(this.getAttribute("data-page")) + 1;
      loadFilteredPhotos(nextPage);
      this.setAttribute("data-page", nextPage);
    });
  }
});

const titles = document.querySelectorAll(".photo-title");
titles.forEach((title) => {
  title.innerHTML = title.innerHTML.replace(/<br\s*\/?>/gi, " ");
});

// Menu burger
document.addEventListener("DOMContentLoaded", function () {
  const openMenu = document.getElementById("openMenu");
  const closeMenu = document.getElementById("closeMenu");
  const navMenu = document.getElementById("navMenu");

  // Cache l'icône de fermeture au chargement de la page
  closeMenu.style.display = "none";

  openMenu.addEventListener("click", function () {
    navMenu.classList.add("open");
    openMenu.style.display = "none";
    closeMenu.style.display = "block";
  });

  closeMenu.addEventListener("click", function () {
    navMenu.classList.remove("open");
    closeMenu.style.display = "none";
    openMenu.style.display = "block";
  });

  // Ferme le menu burger lorsque le bouton "Contact" est cliqué
  contactBtn.addEventListener("click", function () {
    if (window.innerWidth < 790) {
      navMenu.classList.remove("open");
      closeMenu.style.display = "none";
      openMenu.style.display = "block";
    }
  });

  // Écouteur d'événement pour détecter les changements de taille d'écran
  window.addEventListener("resize", function () {
    if (window.innerWidth > 790) {
      // Masque les icônes et réinitialise l'état du menu si la largeur dépasse 790px
      openMenu.style.display = "none";
      closeMenu.style.display = "none";
      navMenu.classList.remove("open");
      navMenu.style.display = ""; // Réinitialise le display pour le retour à la navigation normale
    } else {
      if (!navMenu.classList.contains("open")) {
        // Si le menu n'est pas ouvert, affiche l'icône d'ouverture
        openMenu.style.display = "block";
        closeMenu.style.display = "none";
      } else {
        // Si le menu est ouvert, garde l'icône de fermeture visible
        openMenu.style.display = "none";
        closeMenu.style.display = "block";
      }
    }
  });
});
