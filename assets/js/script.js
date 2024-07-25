document.addEventListener("DOMContentLoaded", function () {
  console.log("Script chargé");

  const contactBtn = document.getElementById("contactBtn");
  const contactPopup = document.getElementById("contactPopup");
  const contactForm = contactPopup.querySelector("form");

  contactBtn.addEventListener("click", function (e) {
    e.preventDefault();
    contactPopup.style.display = "flex";
    console.log("Popup ouverte");
  });

  document.addEventListener("click", function (e) {
    if (
      contactPopup.style.display === "flex" &&
      !e.target.closest(".popup-wrapper") &&
      e.target.id !== "contactBtn"
    ) {
      contactForm.reset();
      contactPopup.style.display = "none";
      console.log("Popup fermée");
    }
  });

  document.addEventListener("wpcf7invalid", function (event) {
    console.log("Erreur de validation du formulaire");
    // Empêcher l'agrandissement de la popup en plein écran
    contactPopup.style.display = "flex";
  });

  document.addEventListener(
    "wpcf7mailsent",
    function (event) {
      contactPopup.style.display = "none";
      contactForm.reset();
      console.log("Popup fermée après soumission du formulaire");
    },
    false
  );
});
