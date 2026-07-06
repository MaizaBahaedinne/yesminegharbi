/* =============================================
   yesminegharbi.com — app.js
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

  /* ─── Burger menu ──────────────────────────── */
  const burger    = document.getElementById('navBurger');
  const mobileNav = document.getElementById('navMobile');

  if (burger && mobileNav) {
    burger.addEventListener('click', () => {
      const isOpen = mobileNav.classList.toggle('open');
      burger.setAttribute('aria-expanded', isOpen);
      mobileNav.setAttribute('aria-hidden', !isOpen);
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!burger.contains(e.target) && !mobileNav.contains(e.target)) {
        mobileNav.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
        mobileNav.setAttribute('aria-hidden', 'true');
      }
    });
  }

  /* ─── Download modal (ressources gratuites) ── */
  const modal        = document.getElementById('downloadModal');
  const closeModal   = document.getElementById('closeDownloadModal');
  const resourceIdIn = document.getElementById('downloadResourceId');
  const modalDesc    = document.getElementById('downloadModalDesc');

  document.querySelectorAll('.open-download').forEach(btn => {
    btn.addEventListener('click', () => {
      if (resourceIdIn) resourceIdIn.value = btn.dataset.id;
      if (modalDesc)    modalDesc.textContent = 'Créez votre compte pour recevoir « ' + btn.dataset.titre + ' ». ';
      if (modal) {
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
      }
    });
  });

  if (closeModal) {
    closeModal.addEventListener('click', closeDownloadModal);
  }
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeDownloadModal();
    });
  }

  function closeDownloadModal() {
    if (modal) {
      modal.classList.remove('open');
      modal.setAttribute('aria-hidden', 'true');
    }
  }

  /* ─── Download form submit ─────────────────── */
  const downloadForm = document.getElementById('downloadForm');
  if (downloadForm) {
    downloadForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msgEl  = document.getElementById('downloadMsg');
      const btn    = downloadForm.querySelector('button[type="submit"]');
      const data   = new FormData(downloadForm);

      btn.disabled = true;
      btn.textContent = 'Envoi en cours…';

      try {
        const res  = await fetch(BASE_URL + 'api/ressource-download', { method: 'POST', body: data });
        const json = await res.json();

        if (json.success) {
          msgEl.className = 'alert alert-success';
          msgEl.textContent = json.message;
          downloadForm.reset();
          if (json.activationUrl) {
            setTimeout(() => { window.location.href = json.activationUrl; }, 800);
          } else if (json.downloadUrl) {
            setTimeout(() => { window.location.href = json.downloadUrl; }, 1000);
          }
        } else {
          msgEl.className = 'alert alert-error';
          msgEl.textContent = Object.values(json.errors || {}).join(' ') || json.message;
        }
      } catch {
        msgEl.className = 'alert alert-error';
        msgEl.textContent = 'Une erreur est survenue. Réessayez.';
      } finally {
        btn.disabled = false;
        btn.textContent = 'Recevoir le lien →';
      }
    });
  }

  /* ─── Newsletter form(s) ───────────────────── */
  document.querySelectorAll('#newsletterForm').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msgEl = form.querySelector('#newsletterMsg') || form.nextElementSibling;
      const btn   = form.querySelector('button[type="submit"]');
      const data  = new FormData(form);

      if (btn) { btn.disabled = true; btn.textContent = '…'; }

      try {
        const res  = await fetch(BASE_URL + 'api/newsletter', { method: 'POST', body: data });
        const json = await res.json();

        if (msgEl) {
          msgEl.className   = 'alert ' + (json.success ? 'alert-success' : 'alert-error');
          msgEl.textContent = json.message;
        }
        if (json.success) form.reset();
      } catch {
        if (msgEl) { msgEl.className = 'alert alert-error'; msgEl.textContent = 'Erreur réseau.'; }
      } finally {
        if (btn) { btn.disabled = false; btn.textContent = 'Je m\'abonne'; }
      }
    });
  });

  /* ─── Contact form ─────────────────────────── */
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msgEl = document.getElementById('contactMsg');
      const btn   = contactForm.querySelector('button[type="submit"]');
      const data  = new FormData(contactForm);

      btn.disabled = true;
      btn.textContent = 'Envoi en cours…';

      try {
        const res  = await fetch(BASE_URL + 'api/contact', { method: 'POST', body: data });
        const json = await res.json();

        msgEl.className   = 'alert ' + (json.success ? 'alert-success' : 'alert-error');
        msgEl.textContent = json.success
          ? json.message
          : Object.values(json.errors || {}).join(' ') || json.message;

        if (json.success) contactForm.reset();
      } catch {
        msgEl.className   = 'alert alert-error';
        msgEl.textContent = 'Erreur réseau. Réessayez.';
      } finally {
        btn.disabled    = false;
        btn.textContent = 'Envoyer le message →';
      }
    });
  }

  /* ─── Sticky nav shadow on scroll ─────────── */
  const nav = document.querySelector('nav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.style.boxShadow = window.scrollY > 10
        ? '0 2px 20px rgba(0,0,0,.08)'
        : 'none';
    }, { passive: true });
  }
});
