/* =============================================
   yesminegharbi.com — app.js
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

  /* ─── Burger menu ──────────────────────────── */
  const burger    = document.getElementById('navBurger');
  const mobileNav = document.getElementById('navMobile');
  const userMenuBtn = document.getElementById('userMenuBtn');
  const userMenuPanel = document.getElementById('userMenuPanel');

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

  if (userMenuBtn && userMenuPanel) {
    userMenuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = userMenuPanel.style.display === 'block';
      userMenuPanel.style.display = isOpen ? 'none' : 'block';
      userMenuBtn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
    });

    document.addEventListener('click', (e) => {
      if (!userMenuBtn.contains(e.target) && !userMenuPanel.contains(e.target)) {
        userMenuPanel.style.display = 'none';
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
