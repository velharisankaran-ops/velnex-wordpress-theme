(function () {
  document.querySelectorAll("[data-vx-redirect]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      window.location.href = form.dataset.vxRedirect;
    });
  });
})();
