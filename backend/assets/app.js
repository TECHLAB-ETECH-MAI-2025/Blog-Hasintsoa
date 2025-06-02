import "./styles/app.scss";
import "bootstrap";
import { Tooltip } from "bootstrap";

document.addEventListener("DOMContentLoaded", () => {
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
});

window.addEventListener("scroll", () => {
  document.querySelector(".scroll-top").classList.toggle("active", window.scrollY > 300);
});

document.querySelector("#scroll-top-btn").addEventListener("click", (event) => {
  event.preventDefault();
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
});