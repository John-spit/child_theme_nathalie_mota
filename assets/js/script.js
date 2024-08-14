document.addEventListener("DOMContentLoaded", function () {
  const contactBtnPhoto = document.getElementById("photoContactBtn");
  const contactBtn = document.getElementById("contactBtn");
  const contactPopup = document.getElementById("contactPopup");
  const contactForm = contactPopup ? contactPopup.querySelector("form") : null;

  // Fonction pour ouvrir la popup
  function openPopup() {
    if (contactPopup) {
      contactPopup.style.display = "flex";
      console.log("Popup ouverte");
    }
  }

  // Fonction pour fermer la popup
  function closePopup() {
    if (contactPopup) {
      if (contactForm) {
        contactForm.reset();
      }
      contactPopup.style.display = "none";
      console.log("Popup fermée");
    }
  }

  // Événements de clic pour ouvrir la popup
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

      // Utilisation de jQuery pour préremplir le champ de référence
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

  // Fermer la popup lorsque l'utilisateur clique en dehors de la popup, sauf si c'est le bouton Contact
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

  // Fermer la popup lorsque le formulaire est soumis avec succès
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

  // Fonctionnalité AJAX pour le bouton "Charger plus"
  const loadMoreButton = document.getElementById("load-more");

  if (loadMoreButton) {
    loadMoreButton.addEventListener("click", function () {
      const button = this;
      let paged = parseInt(button.getAttribute("data-page")) + 1;
      const maxPages = parseInt(button.getAttribute("data-max-pages"));

      jQuery.ajax({
        url: load_more_photos.ajaxurl, // Utiliser load_more_photos.ajaxurl au lieu de ajaxurl
        type: "post",
        data: {
          action: "load_more_photos",
          paged: paged,
          nonce: load_more_photos.nonce, // Utiliser load_more_photos.nonce pour le nonce
        },
        beforeSend: function () {
          button.textContent = "Chargement...";
        },
        success: function (response) {
          const newPhotosContainer = document.getElementById("new-photos");
          if (newPhotosContainer) {
            newPhotosContainer.insertAdjacentHTML("beforeend", response);
          }

          button.setAttribute("data-page", paged);

          if (paged >= maxPages) {
            button.remove(); // Retirer le bouton si on atteint la dernière page
          } else {
            button.textContent = "Charger plus";
          }
        },
      });
    });
  }
});
