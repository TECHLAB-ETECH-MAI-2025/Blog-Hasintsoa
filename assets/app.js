import "./styles/app.scss";
import "bootstrap";

// Initialisation globale
document.addEventListener("DOMContentLoaded", () => {
  // Activer les tooltips Bootstrap
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
