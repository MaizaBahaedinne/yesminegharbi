/* =============================================
   yesminegharbi.com — app.js
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.partners-section').forEach((section) => {
    const track = section.querySelector('[data-carousel]');
    if (!track) return;

    section.querySelectorAll('.partner-scroll').forEach((button) => {
      button.addEventListener('click', () => {
        const direction = button.dataset.scroll === 'next' ? 1 : -1;
        track.scrollBy({ left: direction * Math.max(track.clientWidth * 0.8, 220), behavior: 'smooth' });
      });
    });

    track.addEventListener('keydown', (event) => {
      if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
      event.preventDefault();
      track.scrollBy({ left: (event.key === 'ArrowRight' ? 1 : -1) * Math.max(track.clientWidth * 0.8, 220), behavior: 'smooth' });
    });
  });

  /* ─── Burger menu ──────────────────────────── */
  const burger    = document.getElementById('navBurger');
  const mobileNav = document.getElementById('navMobile');
  const mobilePanel = mobileNav?.querySelector('.nav-mobile-panel');
  const userMenuBtn = document.getElementById('userMenuBtn');
  const userMenuPanel = document.getElementById('userMenuPanel');

  if (burger && mobileNav) {
    function setMobileMenu(open) {
      mobileNav.classList.toggle('open', open);
      burger.setAttribute('aria-expanded', String(open));
      burger.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
      mobileNav.setAttribute('aria-hidden', String(!open));
      mobileNav.inert = !open;
      document.body.classList.toggle('nav-drawer-open', open);
      if (open) {
        mobileNav.querySelector('.nav-mobile-close')?.focus();
      } else {
        burger.focus();
      }
    }

    burger.addEventListener('click', () => {
      setMobileMenu(!mobileNav.classList.contains('open'));
    });

    mobileNav.querySelectorAll('[data-close-mobile]').forEach((button) => {
      button.addEventListener('click', () => setMobileMenu(false));
    });
    mobilePanel?.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => setMobileMenu(false));
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && mobileNav.classList.contains('open')) {
        setMobileMenu(false);
      }
    });
  }

  if (userMenuBtn && userMenuPanel) {
    userMenuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = userMenuBtn.getAttribute('aria-expanded') === 'true';
      userMenuPanel.hidden = isOpen;
      userMenuBtn.setAttribute('aria-expanded', String(!isOpen));
    });

    document.addEventListener('click', (e) => {
      if (!userMenuBtn.contains(e.target) && !userMenuPanel.contains(e.target)) {
        userMenuPanel.hidden = true;
        userMenuBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* ─── Download modal (ressources gratuites) ── */
  const modal        = document.getElementById('downloadModal');
  const closeModal   = document.getElementById('closeDownloadModal');
  const resourceIdIn = document.getElementById('downloadResourceId');
  const modalDesc    = document.getElementById('downloadModalDesc');
  const choiceStep   = document.getElementById('downloadChoiceStep');
  const registerForm = document.getElementById('downloadForm');
  const loginForm    = document.getElementById('downloadLoginForm');
  const showLoginBtn = document.getElementById('showLoginStep');
  const showRegBtn   = document.getElementById('showRegisterStep');
  const backFromLoginBtn = document.getElementById('backToChoiceFromLogin');
  const backFromRegBtn   = document.getElementById('backToChoiceFromRegister');

  function setDownloadStep(step, title) {
    const resourceTitle = title || '';

    if (step === 'choice') {
      if (modalDesc) {
        modalDesc.textContent = resourceTitle
          ? ('Avez-vous déjà un compte pour recevoir « ' + resourceTitle + ' » ?')
          : 'Avez-vous déjà un compte ?';
      }
      if (choiceStep) choiceStep.style.display = 'block';
      if (loginForm) loginForm.style.display = 'none';
      if (registerForm) registerForm.style.display = 'none';
      return;
    }

    if (step === 'login') {
      if (modalDesc) {
        modalDesc.textContent = resourceTitle
          ? ('Connectez-vous pour continuer et recevoir « ' + resourceTitle + ' ».')
          : 'Connectez-vous pour continuer.';
      }
      if (choiceStep) choiceStep.style.display = 'none';
      if (loginForm) loginForm.style.display = 'block';
      if (registerForm) registerForm.style.display = 'none';
      return;
    }

    if (modalDesc) {
      modalDesc.textContent = resourceTitle
        ? ('Créez votre compte pour recevoir « ' + resourceTitle + ' ».')
        : 'Créez votre compte pour recevoir la ressource.';
    }
    if (choiceStep) choiceStep.style.display = 'none';
    if (loginForm) loginForm.style.display = 'none';
    if (registerForm) registerForm.style.display = 'block';
  }

  document.querySelectorAll('.open-download').forEach(btn => {
    btn.addEventListener('click', () => {
      const resourceTitle = btn.dataset.titre || '';
      if (resourceIdIn) resourceIdIn.value = btn.dataset.id;
      if (modal) modal.dataset.resourceTitle = resourceTitle;
      setDownloadStep('choice', resourceTitle);
      if (modal) {
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
      }
    });
  });

  if (showLoginBtn) {
    showLoginBtn.addEventListener('click', () => {
      const title = modal ? (modal.dataset.resourceTitle || '') : '';
      setDownloadStep('login', title);
    });
  }

  if (showRegBtn) {
    showRegBtn.addEventListener('click', () => {
      const title = modal ? (modal.dataset.resourceTitle || '') : '';
      setDownloadStep('register', title);
    });
  }

  if (backFromLoginBtn) {
    backFromLoginBtn.addEventListener('click', () => {
      const title = modal ? (modal.dataset.resourceTitle || '') : '';
      setDownloadStep('choice', title);
    });
  }

  if (backFromRegBtn) {
    backFromRegBtn.addEventListener('click', () => {
      const title = modal ? (modal.dataset.resourceTitle || '') : '';
      setDownloadStep('choice', title);
    });
  }

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
      setDownloadStep('choice', '');
      delete modal.dataset.resourceTitle;
    }
  }

  document.querySelectorAll('.resource-claim-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
      const originalText = btn.textContent;
      btn.disabled = true;
      btn.textContent = 'Vérification…';

      try {
        const fd = new FormData();
        fd.append('resource_id', btn.dataset.id);
        fd.append('slug', btn.dataset.slug || '');

        const res = await fetch(BASE_URL + 'api/ressource-access', { method: 'POST', body: fd });
        const json = await res.json();

        if (json.success && json.downloadUrl) {
          window.location.href = json.downloadUrl;
        } else if (json.message && json.message.toLowerCase().includes('activer')) {
          const result = await Swal.fire({
            title: 'Compte non activé',
            text: 'Il faut activer votre compte avant de poursuivre. Vérifiez votre email et vous pouvez demander un nouveau code de vérification.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Renvoyer le code',
            cancelButtonText: 'Fermer'
          });

          if (result.isConfirmed) {
            const resendRes = await fetch(BASE_URL + 'api/account/resend-activation', { method: 'POST' });
            const resendJson = await resendRes.json();
            Swal.fire({
              title: resendJson.success ? 'Code envoyé' : 'Erreur',
              text: resendJson.message || 'Impossible d’envoyer le code.',
              icon: resendJson.success ? 'success' : 'error'
            });
          }
        } else {
          Swal.fire({ title: 'Impossible', text: json.message || 'Impossible de continuer.', icon: 'error' });
        }
      } catch {
        Swal.fire({ title: 'Erreur', text: 'Une erreur est survenue.', icon: 'error' });
      } finally {
        btn.disabled = false;
        btn.textContent = originalText;
      }
    });
  });

  /* ─── Download form submit ─────────────────── */
  if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msgEl  = document.getElementById('downloadMsg');
      const btn    = registerForm.querySelector('button[type="submit"]');
      const data   = new FormData(registerForm);

      btn.disabled = true;
      btn.textContent = 'Envoi en cours…';

      try {
        const res  = await fetch(BASE_URL + 'api/ressource-download', { method: 'POST', body: data });
        const json = await res.json();

        if (json.success) {
          msgEl.className = 'alert alert-success';
          msgEl.textContent = json.debug_code
            ? (json.message + ' Code: ' + json.debug_code)
            : json.message;
          registerForm.reset();
          if (json.verifyUrl) {
            setTimeout(() => { window.location.href = json.verifyUrl; }, 800);
          } else if (json.activationUrl) {
            setTimeout(() => { window.location.href = json.activationUrl; }, 800);
          } else if (json.downloadUrl) {
            setTimeout(() => { window.location.href = json.downloadUrl; }, 1000);
          }
        } else {
          msgEl.className = 'alert alert-error';
          msgEl.textContent = Object.values(json.errors || {}).join(' ') || json.message;
          if (json.redirectUrl) {
            setTimeout(() => { window.location.href = json.redirectUrl; }, 1200);
          }
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
