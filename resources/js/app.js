// Polar Catalyst Motion & Scroll Reveal System

function initScrollReveal() {
    const reveals = document.querySelectorAll('.reveal-on-scroll:not(.is-revealed)');
    if (!reveals.length) return;

    if (!('IntersectionObserver' in window)) {
        reveals.forEach(el => el.classList.add('is-revealed'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
    });

    reveals.forEach(el => observer.observe(el));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollReveal);
} else {
    initScrollReveal();
}

// Support Livewire SPA Navigation & dynamic DOM updates
document.addEventListener('livewire:navigated', initScrollReveal);
document.addEventListener('livewire:initialized', () => {
    if (window.Livewire) {
        Livewire.hook('morph.updated', () => {
            setTimeout(initScrollReveal, 60);
        });
    }
});
