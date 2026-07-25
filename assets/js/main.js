/**
 * Ripper Sports — Main interactive script
 *
 * Handles:
 *  - Mobile off-canvas navigation + Sports accordion
 *  - Live score ticker micro-updates
 *  - Search overlay
 *  - Reading progress bar on article/blog pages
 *  - Contact form validation + simulated submission
 *  - Cookie consent banner
 *  - Newsletter signup feedback
 *  - Accessible keyboard interactions
 *
 * Built with vanilla JS so it can be cleanly enqueued in WordPress later.
 */

(function () {
  'use strict';

  /* ───────────────────────────────────────────────────────────────────────────
     DOM helpers
     ─────────────────────────────────────────────────────────────────────────── */
  const $ = (selector, context = document) => context.querySelector(selector);
  const $$ = (selector, context = document) => Array.from(context.querySelectorAll(selector));

  /* ───────────────────────────────────────────────────────────────────────────
     Mobile navigation
     ─────────────────────────────────────────────────────────────────────────── */
  const mobileMenuBtn = $('.js-mobile-menu-open');
  const mobileNav = $('.js-mobile-nav');
  const mobileMenuClose = $('.js-mobile-menu-close');
  const overlay = $('.js-overlay');
  const mobileSubmenuToggle = $('.js-mobile-submenu-toggle');
  const mobileSubmenu = $('.js-mobile-submenu');

  function openMobileMenu() {
    if (!mobileNav) return;
    mobileNav.classList.add('is-open');
    if (overlay) overlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'true');
    // Move focus to close button for accessibility
    if (mobileMenuClose) mobileMenuClose.focus();
  }

  function closeMobileMenu() {
    if (!mobileNav) return;
    mobileNav.classList.remove('is-open');
    if (overlay) overlay.classList.remove('is-open');
    document.body.style.overflow = '';
    if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'false');
    if (mobileMenuBtn) mobileMenuBtn.focus();
  }

  function toggleMobileSubmenu() {
    if (!mobileSubmenu || !mobileSubmenuToggle) return;
    const isOpen = mobileSubmenu.classList.toggle('is-open');
    mobileSubmenuToggle.classList.toggle('is-open', isOpen);
    mobileSubmenuToggle.setAttribute('aria-expanded', String(isOpen));
  }

  if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileMenu);
  if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMobileMenu);
  if (overlay) overlay.addEventListener('click', closeMobileMenu);
  if (mobileSubmenuToggle) mobileSubmenuToggle.addEventListener('click', toggleMobileSubmenu);

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    if (mobileNav && mobileNav.classList.contains('is-open')) {
      closeMobileMenu();
    }
    if (searchOverlay && searchOverlay.classList.contains('is-open')) {
      closeSearch();
    }
  });

  /* ───────────────────────────────────────────────────────────────────────────
     Search overlay
     ─────────────────────────────────────────────────────────────────────────── */
  const searchTriggers = $$('.js-search-trigger');
  const searchOverlay = $('.js-search-overlay');
  const searchClose = $('.js-search-close');
  const searchInput = $('.js-search-overlay-input');

  function openSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    searchTriggers.forEach((trigger) => trigger.setAttribute('aria-expanded', 'true'));
    if (searchInput) searchInput.focus();
  }

  function closeSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.remove('is-open');
    document.body.style.overflow = '';
    searchTriggers.forEach((trigger) => trigger.setAttribute('aria-expanded', 'false'));
  }

  searchTriggers.forEach((trigger) => trigger.addEventListener('click', openSearch));
  if (searchClose) searchClose.addEventListener('click', closeSearch);
  if (searchOverlay) {
    searchOverlay.addEventListener('click', (event) => {
      if (event.target === searchOverlay) closeSearch();
    });
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Live score ticker micro-interaction
     ─────────────────────────────────────────────────────────────────────────── */
  function initLiveScores() {
    const scoreValues = $$('.js-live-score');
    if (!scoreValues.length) return;

    setInterval(() => {
      // Randomly highlight one score every ~6 seconds to simulate live data
      const target = scoreValues[Math.floor(Math.random() * scoreValues.length)];
      if (target) {
        target.classList.add('score-flash');
        setTimeout(() => target.classList.remove('score-flash'), 800);
      }
    }, 6000);
  }

  // Add flash animation style if not present
  const flashStyle = document.createElement('style');
  flashStyle.textContent = `
    .score-flash {
      color: var(--rs-gold) !important;
      text-shadow: 0 0 8px rgba(255, 217, 150, 0.6);
      transition: color 0.3s ease, text-shadow 0.3s ease;
    }
  `;
  document.head.appendChild(flashStyle);

  initLiveScores();

  /* ───────────────────────────────────────────────────────────────────────────
     Reading progress bar
     ─────────────────────────────────────────────────────────────────────────── */
  const progressBar = $('.js-reading-progress');
  if (progressBar) {
    window.addEventListener('scroll', () => {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;
      const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      progressBar.style.width = `${progress}%`;
    });
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Cookie consent banner
     ─────────────────────────────────────────────────────────────────────────── */
  const cookieBanner = $('.js-cookie-banner');
  const cookieAccept = $('.js-cookie-accept');

  function initCookieBanner() {
    if (!cookieBanner) return;
    const consent = localStorage.getItem('rs_cookie_consent');
    if (!consent) {
      // Delay slightly so it doesn't block first paint
      setTimeout(() => cookieBanner.classList.add('is-visible'), 1200);
    }
  }

  if (cookieAccept) {
    cookieAccept.addEventListener('click', () => {
      localStorage.setItem('rs_cookie_consent', 'accepted');
      cookieBanner.classList.remove('is-visible');
    });
  }

  initCookieBanner();

  /* ───────────────────────────────────────────────────────────────────────────
     Contact form
     ─────────────────────────────────────────────────────────────────────────── */
  const contactForm = $('.js-contact-form');

  function validateContactForm(form) {
    let isValid = true;
    const name = form.querySelector('[name="name"]');
    const email = form.querySelector('[name="email"]');
    const message = form.querySelector('[name="message"]');
    const consent = form.querySelector('[name="consent"]');

    const fields = [name, email, message, consent];
    fields.forEach((field) => {
      const error = field.parentElement.querySelector('.form-error');
      if (error) error.classList.remove('is-visible');
    });

    if (!name || !name.value.trim()) {
      isValid = false;
      const error = name.parentElement.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    if (!email || !email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
      isValid = false;
      const error = email.parentElement.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    if (!message || !message.value.trim()) {
      isValid = false;
      const error = message.parentElement.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    if (!consent || !consent.checked) {
      isValid = false;
      const error = consent.parentElement.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    return isValid;
  }

  if (contactForm) {
    contactForm.addEventListener('submit', (event) => {
      event.preventDefault();
      if (!validateContactForm(contactForm)) return;

      const button = contactForm.querySelector('button[type="submit"]');
      const originalText = button ? button.textContent : '';

      if (button) {
        button.disabled = true;
        button.textContent = 'Dispatching…';
      }

      // Simulate network request
      setTimeout(() => {
        // In a real WordPress theme this becomes a wp-admin admin-post.php call
        window.location.href = contactForm.dataset.confirmationUrl || 'contact-confirmation.html';
      }, 1500);
    });
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Newsletter forms
     ─────────────────────────────────────────────────────────────────────────── */
  const newsletterForms = $$('.js-newsletter-form');
  newsletterForms.forEach((form) => {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const input = form.querySelector('input[type="email"]');
      const button = form.querySelector('button[type="submit"]');
      if (!input || !input.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
        input.classList.add('form-input-error');
        return;
      }
      input.classList.remove('form-input-error');
      if (button) {
        const original = button.textContent;
        button.textContent = 'Joined!';
        button.disabled = true;
        setTimeout(() => {
          button.textContent = original;
          button.disabled = false;
          input.value = '';
        }, 2500);
      }
    });
  });

  const inputErrorStyle = document.createElement('style');
  inputErrorStyle.textContent = `
    .form-input-error {
      border-color: var(--rs-error) !important;
      box-shadow: 0 0 0 3px rgba(255, 180, 171, 0.4) !important;
    }
  `;
  document.head.appendChild(inputErrorStyle);

  /* ───────────────────────────────────────────────────────────────────────────
     Header scroll behavior
     ─────────────────────────────────────────────────────────────────────────── */
  const siteHeader = $('.js-site-header');

  function updateHeader() {
    if (!siteHeader) return;
    siteHeader.classList.toggle('scrolled', window.scrollY > 20);
  }

  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

  /* ───────────────────────────────────────────────────────────────────────────
     Scroll reveal animations
     ─────────────────────────────────────────────────────────────────────────── */
  const revealElements = $$('.reveal, .reveal-scale, .reveal-left, .reveal-right, .reveal-stagger');
  if (revealElements.length && 'IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    revealElements.forEach((el) => revealObserver.observe(el));
  } else {
    revealElements.forEach((el) => el.classList.add('is-visible'));
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Archive filter checkboxes (client-side demo filtering)
     ─────────────────────────────────────────────────────────────────────────── */
  const archiveFilters = $$('.js-archive-filter');
  if (archiveFilters.length) {
    archiveFilters.forEach((filter) => {
      filter.addEventListener('change', () => {
        const checked = archiveFilters.filter((f) => f.checked).map((f) => f.value);
        const items = $$('.js-archive-item');
        items.forEach((item) => {
          const category = item.dataset.category;
          const visible = checked.length === 0 || checked.includes(category);
          item.style.display = visible ? '' : 'none';
        });
      });
    });
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Card bookmarks
     ─────────────────────────────────────────────────────────────────────────── */
  $$('.card-bookmark').forEach((btn) => {
    btn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      const isBookmarked = btn.classList.toggle('is-bookmarked');
      btn.setAttribute('aria-pressed', String(isBookmarked));
      btn.setAttribute('aria-label', isBookmarked ? 'Remove bookmark' : 'Bookmark article');
      // eslint-disable-next-line no-console
      if (typeof console !== 'undefined') {
        console.log(isBookmarked ? 'Article bookmarked' : 'Bookmark removed');
      }
    });
  });

  /* ───────────────────────────────────────────────────────────────────────────
     Card reactions
     ─────────────────────────────────────────────────────────────────────────── */
  $$('.card-reaction').forEach((btn) => {
    btn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (btn.dataset.reacted) return;
      btn.dataset.reacted = 'true';
      btn.classList.add('is-active');
      const countEl = btn.querySelector('.card-reaction-count');
      if (countEl) {
        const current = parseInt(countEl.textContent.replace(/\D/g, ''), 10) || 0;
        countEl.textContent = String(current + 1);
      }
      setTimeout(() => btn.classList.remove('is-active'), 400);
    });
  });

  /* ───────────────────────────────────────────────────────────────────────────
     Breaking news banner close button
     ─────────────────────────────────────────────────────────────────────────── */
  const breakingBar = $('.js-breaking-bar');
  const breakingClose = $('.js-breaking-bar-close');

  function initBreakingBar() {
    if (!breakingBar) return;
    if (sessionStorage.getItem('ripper-breaking-dismissed') === 'true') {
      breakingBar.classList.add('hidden');
      return;
    }
    breakingBar.classList.remove('hidden');
  }

  if (breakingClose && breakingBar) {
    breakingClose.addEventListener('click', () => {
      breakingBar.classList.add('hidden');
      sessionStorage.setItem('ripper-breaking-dismissed', 'true');
    });
  }

  initBreakingBar();

  /* ───────────────────────────────────────────────────────────────────────────
     Topic pills
     ─────────────────────────────────────────────────────────────────────────── */
  $$('.js-topic-pill').forEach((pill) => {
    pill.addEventListener('click', () => {
      pill.classList.toggle('is-active');
    });
  });

  /* ───────────────────────────────────────────────────────────────────────────
     Utility: current nav item highlight based on URL
     ─────────────────────────────────────────────────────────────────────────── */
  function setActiveNav() {
    const path = window.location.pathname;
    const page = path.split('/').pop() || 'index.html';

    const map = {
      'index.html': 'home',
      'news.html': 'news',
      'article.html': 'news',
      'sports.html': 'sports',
      'sport-archive.html': 'sports',
      'blog.html': 'blog',
      'blog-post.html': 'blog',
      'contact.html': 'contact',
      'contact-confirmation.html': 'contact',
      'about.html': 'about',
      'privacy.html': 'legal',
      'terms.html': 'legal'
    };

    const activeKey = map[page];
    if (!activeKey) return;

    $$(`.js-nav-${activeKey}`).forEach((el) => el.classList.add('is-active'));
  }

  setActiveNav();
})();
