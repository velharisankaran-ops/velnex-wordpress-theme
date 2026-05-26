const header = document.querySelector("[data-header]");
const nav = document.querySelector("[data-nav]");
const navToggle = document.querySelector("[data-nav-toggle]");
const pageLoader = document.querySelector("[data-page-loader]");

const hidePageLoader = () => {
  if (pageLoader) {
    pageLoader.classList.add("is-hidden");
  }
};

window.addEventListener("load", () => {
  window.setTimeout(hidePageLoader, 450);
});

window.setTimeout(hidePageLoader, 2200);

const setHeaderState = () => {
  header.classList.toggle("scrolled", window.scrollY > 18);
};

setHeaderState();
window.addEventListener("scroll", setHeaderState, { passive: true });

navToggle.addEventListener("click", () => {
  const isOpen = nav.classList.toggle("open");
  header.classList.toggle("nav-open", isOpen);
  navToggle.setAttribute("aria-expanded", String(isOpen));
});

nav.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", () => {
    nav.classList.remove("open");
    header.classList.remove("nav-open");
    navToggle.setAttribute("aria-expanded", "false");
  });
});

document.querySelectorAll("[data-tab]").forEach((button) => {
  button.addEventListener("click", () => {
    const target = button.dataset.tab;

    document.querySelectorAll("[data-tab]").forEach((tab) => {
      const isActive = tab === button;
      tab.classList.toggle("active", isActive);
      tab.setAttribute("aria-selected", String(isActive));
    });

    document.querySelectorAll("[data-panel]").forEach((panel) => {
      panel.classList.toggle("active", panel.dataset.panel === target);
    });
  });
});

const revealItems = document.querySelectorAll(
  ".section-kicker, .split, .metric-row, .mandate-strip, .service-tabs, .problem-grid article, .contact-inner"
);

revealItems.forEach((item) => item.classList.add("reveal"));

const revealObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        revealObserver.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.16 }
);

revealItems.forEach((item) => revealObserver.observe(item));

const form = document.querySelector("[data-contact-form]");
const formNote = document.querySelector("[data-form-note]");

if (form) {
  form.addEventListener("submit", (event) => {
    event.preventDefault();
    const data = new FormData(form);
    const submitter = event.submitter;
    const channel = submitter?.value || "email";
    const enquiryText =
      `Name: ${data.get("name")}\n` +
      `Email: ${data.get("email")}\n` +
      `Phone / WhatsApp: ${data.get("phone")}\n` +
      `I am a: ${data.get("profile")}\n` +
      `Enquiry Type: ${data.get("mandate")}\n` +
      `Company / Organization: ${data.get("company") || "Not provided"}\n` +
      `Location: ${data.get("location") || "Not provided"}\n\n` +
      `Message / Requirement:\n${data.get("message")}`;
    const subject = encodeURIComponent(`Velnex enquiry: ${data.get("profile")}`);
    const body = encodeURIComponent(enquiryText);
    const whatsappText = encodeURIComponent(
      `Velnex enquiry\n\n${enquiryText}`
    );

    if (formNote) {
      formNote.textContent =
        channel === "whatsapp"
          ? "Your enquiry has been prepared in WhatsApp."
          : "Your enquiry has been prepared in your email app.";
    }

    if (channel === "whatsapp") {
      window.location.href = `https://wa.me/971555396942?text=${whatsappText}`;
      return;
    }

    window.location.href = `mailto:operations@velnex.in?subject=${subject}&body=${body}`;
  });
}
