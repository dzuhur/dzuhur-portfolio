const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-menu]');

if (menuToggle && mobileMenu) {
    const setMenu = (open) => {
        menuToggle.setAttribute('aria-expanded', String(open));
        mobileMenu.classList.toggle('hidden', !open);
    };

    menuToggle.addEventListener('click', () => {
        const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
        setMenu(!isOpen);
    });

    mobileMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenu(false));
    });
}

const contactForm = document.querySelector('[data-contact-form]');

if (contactForm) {
    contactForm.addEventListener('submit', () => {
        const button = contactForm.querySelector('[data-submit-button]');

        if (button) {
            button.disabled = true;
            button.textContent = 'Sending…';
        }
    });
}

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (! window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});