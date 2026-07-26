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
     AJAX helpers
     ───────────────────────────────────────────────────────────────────────────
     Single submitForm() handles every form that carries a
     `data-ajax-action="..."` attribute. The action name maps 1:1 to the
     wp_ajax_{action} hook in functions.php.
  */
  const ajaxData = window.ripperSportsData || {};

  function ajaxPost(action, payload) {
    if (!ajaxData.ajaxUrl) {
      return Promise.reject(new Error('AJAX endpoint not configured'));
    }
    const body = new FormData();
    body.append('action', action);
    Object.keys(payload || {}).forEach((k) => {
      if (payload[k] !== undefined && payload[k] !== null) {
        body.append(k, String(payload[k]));
      }
    });
    body.append('nonce', ajaxData.nonce || '');
    return fetch(ajaxData.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body,
    }).then((r) => r.json());
  }

  function setButtonBusy(button, busyText) {
    if (!button) return { restore: () => {} };
    const original = button.textContent;
    button.disabled = true;
    button.setAttribute('aria-busy', 'true');
    button.textContent = busyText;
    return {
      restore(text) {
        button.disabled = false;
        button.removeAttribute('aria-busy');
        button.textContent = text === undefined ? original : text;
      },
    };
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Contact form — AJAX submission
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
      if (!field) return;
      const error = field.closest('.form-group')?.querySelector('.form-error');
      if (error) error.classList.remove('is-visible');
    });

    if (!name || !name.value.trim()) {
      isValid = false;
      const error = name.closest('.form-group')?.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    if (!email || !email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
      isValid = false;
      const error = email.closest('.form-group')?.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    if (!message || !message.value.trim()) {
      isValid = false;
      const error = message.closest('.form-group')?.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    if (!consent || !consent.checked) {
      isValid = false;
      const error = consent.closest('.form-group')?.querySelector('.form-error');
      if (error) error.classList.add('is-visible');
    }

    return isValid;
  }

  if (contactForm) {
    const status = $('.js-form-status', contactForm);
    const confirmationUrl = contactForm.dataset.confirmationUrl;

    function setStatus(message, kind) {
      if (!status) return;
      status.textContent = message;
      status.classList.remove('is-success', 'is-error');
      if (kind) status.classList.add('is-' + kind);
    }

    contactForm.addEventListener('submit', (event) => {
      event.preventDefault();
      if (!validateContactForm(contactForm)) {
        setStatus('', null);
        // Focus the first invalid field for screen-reader users.
        const firstError = contactForm.querySelector('.form-error.is-visible');
        if (firstError) {
          const input = firstError.parentElement.querySelector('input, select, textarea');
          if (input) input.focus();
        }
        return;
      }

      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const busy = setButtonBusy(submitBtn, 'Dispatching…');
      setStatus('Sending your message…', null);

      const payload = {
        name:    contactForm.querySelector('[name="name"]').value.trim(),
        email:   contactForm.querySelector('[name="email"]').value.trim(),
        topic:   contactForm.querySelector('[name="topic"]')?.value || '',
        subject: contactForm.querySelector('[name="subject"]')?.value || '',
        message: contactForm.querySelector('[name="message"]').value.trim(),
      };

      const action = contactForm.dataset.ajaxAction || 'ripper_sports_contact';

      ajaxPost(action, payload)
        .then((response) => {
          if (response && response.success) {
            const msg = (response.data && typeof response.data === 'string')
              ? response.data
              : 'Message sent.';
            setStatus(msg, 'success');
            contactForm.reset();
            // Redirect to confirmation page if provided.
            if (confirmationUrl) {
              setTimeout(() => { window.location.href = confirmationUrl; }, 900);
            } else {
              busy.restore('Send Message');
            }
          } else {
            const errMsg = (response && response.data)
              ? (typeof response.data === 'string' ? response.data : (response.data.message || 'Something went wrong.'))
              : 'Something went wrong.';
            setStatus(errMsg, 'error');
            busy.restore('Send Message');
          }
        })
        .catch(() => {
          setStatus('Network error. Please try again.', 'error');
          busy.restore('Send Message');
        });
    });
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Newsletter forms — AJAX submission
     ─────────────────────────────────────────────────────────────────────────── */
  const newsletterForms = $$('.js-newsletter-form');
  newsletterForms.forEach((form) => {
    const status = form.parentElement?.querySelector('.js-newsletter-status');

    function setStatus(message, kind) {
      if (!status) return;
      status.textContent = message;
      status.classList.remove('is-success', 'is-error');
      if (kind) status.classList.add('is-' + kind);
    }

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const input = form.querySelector('input[type="email"]');
      const button = form.querySelector('button[type="submit"]');
      if (!input || !input.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
        input.classList.add('form-input-error');
        input.setAttribute('aria-invalid', 'true');
        setStatus('Please enter a valid email address.', 'error');
        return;
      }
      input.classList.remove('form-input-error');
      input.removeAttribute('aria-invalid');

      const busy = setButtonBusy(button, 'Joining…');
      setStatus('', null);

      const action = form.dataset.ajaxAction || 'ripper_sports_newsletter';
      ajaxPost(action, { email: input.value.trim() })
        .then((response) => {
          if (response && response.success) {
            const msg = (response.data && typeof response.data === 'string')
              ? response.data
              : 'You\'re on the team.';
            setStatus(msg, 'success');
            input.value = '';
            busy.restore('Joined!');
            // Restore the original button label after a beat so the form
            // is ready for another subscription.
            setTimeout(() => busy.restore(), 2500);
          } else {
            const errMsg = (response && response.data)
              ? (typeof response.data === 'string' ? response.data : 'Something went wrong.')
              : 'Something went wrong.';
            setStatus(errMsg, 'error');
            busy.restore('Subscribe');
          }
        })
        .catch(() => {
          setStatus('Network error. Please try again.', 'error');
          busy.restore('Subscribe');
        });
    });
  });

  const inputErrorStyle = document.createElement('style');
  inputErrorStyle.textContent = `
    .form-input-error {
      border-color: var(--rs-error) !important;
      box-shadow: 0 0 0 3px rgba(255, 180, 171, 0.4) !important;
    }
    .js-form-status, .js-newsletter-status {
      margin-top: 0.75rem;
      font-size: 0.875rem;
      font-family: var(--font-mono);
    }
    .js-form-status:empty, .js-newsletter-status:empty { display: none; }
    .js-form-status.is-success, .js-newsletter-status.is-success { color: #6FCF97; }
    .js-form-status.is-error,   .js-newsletter-status.is-error   { color: var(--rs-error); }
  `;
  document.head.appendChild(inputErrorStyle);

  /* ───────────────────────────────────────────────────────────────────────────
     Header scroll behavior
     ───────────────────────────────────────────────────────────────────────────
     Two responsibilities:
       1. Toggle `.scrolled` (compact shadow) past 20px.
       2. Scroll-direction show/hide:
            - On scroll DOWN past 120px, header slides out (is-hidden)
            - On scroll UP, header slides back in (is-revealed briefly)
            - Near the top of the page, always visible
            - Touch devices: never hide (no wheel-flicking the same way)
            - prefers-reduced-motion: CSS pins transform:none, so
              is-hidden becomes a no-op visually
  */
  const siteHeader = $('.js-site-header');
  let lastHeaderScrollY = window.scrollY || 0;
  let lastHeaderDirection = 'up';
  let isTouchNoHover = window.matchMedia('(hover: none)').matches;

  function updateHeader() {
    if (!siteHeader) return;
    const y = window.scrollY;

    // 1. Compact-on-scroll
    siteHeader.classList.toggle('scrolled', y > 20);

    // 2. Direction-based hide/show — only above the 120px dead zone
    if (y < 120) {
      siteHeader.classList.remove('is-hidden');
      lastHeaderScrollY = y;
      return;
    }
    // Touch devices keep the header always visible
    if (isTouchNoHover) {
      lastHeaderScrollY = y;
      return;
    }

    const direction = y > lastHeaderScrollY ? 'down' : 'up';
    if (direction !== lastHeaderDirection) {
      lastHeaderDirection = direction;
      if (direction === 'down') {
        siteHeader.classList.add('is-hidden');
      } else {
        siteHeader.classList.remove('is-hidden');
        siteHeader.classList.add('is-revealed');
        // Drop the is-revealed glow after the slide-in finishes
        setTimeout(() => siteHeader.classList.remove('is-revealed'), 600);
      }
    }
    lastHeaderScrollY = y;
  }

  window.addEventListener('scroll', updateHeader, { passive: true });
  // Recompute touch detection on resize (e.g. plugging in a mouse)
  window.addEventListener('resize', () => {
    isTouchNoHover = window.matchMedia('(hover: none)').matches;
  }, { passive: true });
  updateHeader();

  /* ───────────────────────────────────────────────────────────────────────────
     Scroll reveal animations
     ─────────────────────────────────────────────────────────────────────────── */
  const revealElements = $$('.reveal, .reveal-scale, .reveal-left, .reveal-right, .reveal-stagger');
  const sectionElements = $$('.section');
  const combinedReveal = revealElements.concat(sectionElements);
  if (combinedReveal.length && 'IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            // Sections also receive 'is-entered' which powers the
            // gold edge-glow pseudo (CSS section 53.6).
            if (entry.target.classList.contains('section')) {
              entry.target.classList.add('is-entered');
            }
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    combinedReveal.forEach((el) => revealObserver.observe(el));
  } else {
    combinedReveal.forEach((el) => el.classList.add('is-visible'));
  }

  /* ───────────────────────────────────────────────────────────────────────────
     Archive filter chips (sport taxonomy archive)
     Single-select within each filter group, instant client-side filtering.
     ─────────────────────────────────────────────────────────────────────────── */
  function initArchiveFilters() {
    const chips = $$('.js-filter-chip, .filter-chip[data-filter-group]');
    if (!chips.length) return;
    const items = $$('.js-archive-item');
    if (!items.length) return;
    const countEl = $('.js-visible-count');
    const clearBtn = $('.js-filter-clear');
    const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Active state — one value per group, or '' for the "All" chip.
    const active = { category: '', tag: '', date: 'all' };

    function matchesDate(dateAttr, range) {
      if (range === 'all' || !dateAttr) return true;
      const ts = parseInt(dateAttr, 10);
      if (!ts) return true;
      const now = Math.floor(Date.now() / 1000);
      if (range === 'week') return (now - ts) <= 7 * 24 * 60 * 60;
      if (range === 'month') return (now - ts) <= 30 * 24 * 60 * 60;
      if (range === 'season') {
        const yearStart = Math.floor(new Date(new Date().getFullYear(), 0, 1).getTime() / 1000);
        return ts >= yearStart;
      }
      return true;
    }

    function matchesTags(tagAttr, wanted) {
      if (!wanted) return true;
      if (!tagAttr) return false;
      return tagAttr.split(',').indexOf(wanted) !== -1;
    }

    function matchesCats(catAttr, wanted) {
      if (!wanted) return true;
      if (!catAttr) return false;
      const wantedId = String(wanted);
      return catAttr.split(',').indexOf(wantedId) !== -1;
    }

    function apply() {
      let visible = 0;
      items.forEach((item) => {
        const match =
          matchesCats(item.dataset.cats, active.category) &&
          matchesTags(item.dataset.tags, active.tag) &&
          matchesDate(item.dataset.date, active.date);
        if (match) {
          visible++;
          item.style.display = '';
          item.classList.remove('is-filtered-out');
        } else {
          item.style.display = 'none';
          if (!reduceMotion) {
            item.classList.add('is-filtered-out');
          }
        }
      });

      // Update count label.
      if (countEl) {
        const total = items.length;
        const noun = total === 1 ? 'story' : 'stories';
        countEl.textContent = visible + ' of ' + total + ' ' + noun;
      }

      // Toggle the "Clear all" button.
      if (clearBtn) {
        const hasActive = !!(active.category || active.tag) || active.date !== 'all';
        clearBtn.hidden = !hasActive;
      }
    }

    function setActive(group, value, sourceChip) {
      active[group] = value;
      // Update visual active state on chips within the same group.
      const groupChips = $$('.filter-chip[data-filter-group="' + group + '"]');
      groupChips.forEach((c) => c.classList.toggle('is-active', c === sourceChip));
      apply();
    }

    // Wire chip clicks.
    chips.forEach((chip) => {
      chip.addEventListener('click', (event) => {
        event.preventDefault();
        const group = chip.dataset.filterGroup;
        if (!group) return;
        if (group === 'category') setActive('category', chip.dataset.filterCat || '', chip);
        else if (group === 'tag') setActive('tag', chip.dataset.filterTag || '', chip);
        else if (group === 'date') setActive('date', chip.dataset.filterDate || 'all', chip);
      });
    });

    // Wire clear-all.
    if (clearBtn) {
      clearBtn.addEventListener('click', (event) => {
        event.preventDefault();
        active.category = '';
        active.tag = '';
        active.date = 'all';
        // Reset visual active states.
        $$('.filter-chip[data-filter-group]').forEach((c) => {
          const g = c.dataset.filterGroup;
          if (g === 'date') c.classList.toggle('is-active', c.dataset.filterDate === 'all');
          else c.classList.toggle('is-active', c.dataset.filterCat === '' || c.dataset.filterTag === '');
        });
        apply();
      });
    }

    // Initial pass — sets the count label to the right "X of X" baseline.
    apply();
  }
  initArchiveFilters();

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
     ───────────────────────────────────────────────────────────────────────────
     Posts a reaction to the server via AJAX. Server-side handler
     increments _rs_{type}_count and returns the new count.

     A11y: each reaction is a button with aria-pressed; after a successful
     reaction we announce the new count via a polite live region so
     screen-reader users get feedback without context loss.
  */
  const reactionAnnouncer = document.createElement('div');
  reactionAnnouncer.setAttribute('role', 'status');
  reactionAnnouncer.setAttribute('aria-live', 'polite');
  reactionAnnouncer.setAttribute('aria-atomic', 'true');
  reactionAnnouncer.className = 'sr-only';
  document.body.appendChild(reactionAnnouncer);

  function announce(message) {
    // Clear first so identical messages still fire the live region.
    reactionAnnouncer.textContent = '';
    setTimeout(() => { reactionAnnouncer.textContent = message; }, 30);
  }

  $$('.card-reaction').forEach((btn) => {
    btn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();

      // Already reacted this session — bail out.
      if (btn.dataset.reacted === 'true') return;

      const card = btn.closest('.card');
      const postId = card?.dataset.postId;
      const type   = btn.dataset.reactionType || 'like';

      // Mark optimistically.
      btn.dataset.reacted = 'true';
      btn.classList.add('is-pending');
      btn.setAttribute('aria-busy', 'true');

      ajaxPost('ripper_sports_reaction', {
        post_id: postId,
        type:    type,
        nonce:   ajaxData.reactionNonce || '',
      })
        .then((response) => {
          btn.classList.remove('is-pending');
          btn.removeAttribute('aria-busy');
          if (response && response.success) {
            btn.classList.add('is-active', 'is-success');
            btn.setAttribute('aria-pressed', 'true');
            const countEl = btn.querySelector('.card-reaction-count');
            if (countEl && response.data && typeof response.data.count === 'number') {
              countEl.textContent = String(response.data.count);
            }
            const labels = { like: 'Like', share: 'Share', comment: 'Comment' };
            const noun = (countEl && parseInt(countEl.textContent, 10) === 1) ? 'reaction' : 'reactions';
            announce(`${labels[type] || 'Reaction'} recorded. ${countEl ? countEl.textContent : ''} ${noun} total.`);
          } else {
            // Roll back optimistic state on failure.
            btn.dataset.reacted = '';
            btn.classList.remove('is-active');
            const msg = (response && response.data)
              ? (typeof response.data === 'string' ? response.data : 'Could not record reaction.')
              : 'Could not record reaction.';
            announce(msg);
          }
        })
        .catch(() => {
          btn.classList.remove('is-pending', 'is-active');
          btn.removeAttribute('aria-busy');
          btn.dataset.reacted = '';
          announce('Network error. Reaction not recorded.');
        });

      // Brief visual flash even before server responds.
      setTimeout(() => btn.classList.remove('is-active'), 400);
    });

    // Keyboard: Enter / Space already trigger click on <button>, no extra work.
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
     Utility: current nav item highlight
     ───────────────────────────────────────────────────────────────────────────
     WordPress renders contextual body classes via body_class() — e.g.
       home, page-id-42, single-post, category-news, tax-sport, ...
     We map those to a single nav key and add is-active to the matching
     .primary-nav-link. Falls back to the URL pathname for cases where
     body classes aren't enough (rare edge cases on custom post types).
  */
  function setActiveNav() {
    const bodyClasses = (ajaxData.bodyClasses || document.body.className || '').toLowerCase();

    // Priority order matters: more-specific first.
    const map = [
      { key: 'sports',         test: /\btax-sport\b/ },
      { key: 'sports',         test: /\bpage-id-.*sport\b/ },
      { key: 'news',           test: /\b(category|single-post|archive|tag)\b/ },
      { key: 'contact',        test: /\bpage-contact\b/ },
      { key: 'about',          test: /\bpage-about\b/ },
      { key: 'home',           test: /\b(home|front-page)\b/ },
    ];

    let activeKey = null;
    for (let i = 0; i < map.length; i++) {
      if (map[i].test.test(bodyClasses)) { activeKey = map[i].key; break; }
    }

    // Fallback: parse the URL.
    if (!activeKey) {
      const path = window.location.pathname.toLowerCase();
      if (path === '/' || path.endsWith('/index.php')) activeKey = 'home';
      else if (path.includes('/sport/'))               activeKey = 'sports';
      else if (path.includes('/category/') || path.includes('/tag/') || path.includes('/news')) activeKey = 'news';
      else if (path.includes('/contact'))              activeKey = 'contact';
      else if (path.includes('/about'))                activeKey = 'about';
    }

    if (!activeKey) return;

    $$(`.js-nav-${activeKey}`).forEach((el) => {
      el.classList.add('is-active');
      // Mirror to mobile nav if present.
      const mobileSelector = `.js-mobile-nav .js-nav-${activeKey}`;
      $$(mobileSelector).forEach((m) => m.classList.add('is-active'));
    });
  }

  setActiveNav();

  /* ───────────────────────────────────────────────────────────────────────────
     Nav rail — sliding gold underline beneath the active pill
     ───────────────────────────────────────────────────────────────────────────
     Measures each .primary-nav-link in the desktop row and writes the rail's
     translate3d + scaleX so it snaps under the current item. Re-measured on
     resize (debounced) and after setActiveNav(), since the active class
     affects the pill's visual width. */
  function setupNavRail() {
    const rail = $('.js-nav-rail');
    if (!rail) return;

    const list = $('.primary-nav-list');
    if (!list) return;

    function positionRail() {
      const active = list.querySelector('.primary-nav-link.is-active')
        || list.querySelector('.primary-nav-link');
      if (!active) {
        rail.style.transform = 'translate3d(0, -50%, 0) scaleX(0)';
        return;
      }
      const listRect = list.getBoundingClientRect();
      const itemRect = active.getBoundingClientRect();
      const x = itemRect.left - listRect.left;
      const w = itemRect.width;
      rail.style.transform = `translate3d(${x}px, -50%, 0) scaleX(${w})`;
    }

    // Wait one frame so the active class from setActiveNav has applied before measuring.
    requestAnimationFrame(positionRail);

    let resizeTimer = null;
    window.addEventListener('resize', () => {
      if (resizeTimer) cancelAnimationFrame(resizeTimer);
      resizeTimer = requestAnimationFrame(positionRail);
    });

    // Re-position when fonts finish loading (font swap changes widths).
    if (document.fonts && typeof document.fonts.ready === 'object') {
      document.fonts.ready.then(positionRail).catch(() => {});
    }
  }

  setupNavRail();

  /* ───────────────────────────────────────────────────────────────────────────
     CNN-style Live Match Ticker (count-up + count-down clocks)
     ─────────────────────────────────────────────────────────────────────────── */
  function initLiveTicker() {
    const cards = $$('[data-ripper-match]');
    if (!cards.length) return;

    // No ticking for reduced-motion users.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    // Track per-card start time so count-up is monotonic.
    const startedAt = Date.now();

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function formatMMSS(totalSeconds) {
      totalSeconds = Math.max(0, Math.floor(totalSeconds));
      const m = Math.floor(totalSeconds / 60);
      const s = totalSeconds % 60;
      return pad(m) + ':' + pad(s);
    }

    function tick() {
      const now = Math.floor(Date.now() / 1000);
      cards.forEach((card) => {
        const status = card.getAttribute('data-status');
        const clock  = card.querySelector('[data-ripper-clock]');
        if (!clock) return;

        const mode = clock.getAttribute('data-ripper-clock');
        if (mode === 'static') return;

        if (mode === 'down') {
          const target = parseInt(clock.getAttribute('data-target') || '0', 10);
          const diff   = Math.max(0, target - now);
          if (diff <= 0) {
            // Match has started.
            card.classList.remove('is-upcoming');
            card.classList.add('is-live');
            const pill = card.querySelector('.score-ticker-status-pill');
            if (pill) {
              pill.classList.remove('is-upcoming');
              pill.classList.add('is-live');
              pill.innerHTML = '<span class="score-ticker-pulse" aria-hidden="true"></span>LIVE';
            }
            clock.textContent = '00:00';
          } else {
            clock.textContent = formatMMSS(diff);
          }
        } else if (mode === 'up') {
          const elapsed = Math.floor((Date.now() - startedAt) / 1000);
          clock.textContent = formatMMSS(elapsed);
        }
      });
    }

    tick();
    setInterval(tick, 1000);
  }

  initLiveTicker();

  /* ───────────────────────────────────────────────────────────────────────────
     CNN-style Live Updates Ticker (slide-in notifications)
     ─────────────────────────────────────────────────────────────────────────── */
  function initUpdatesTicker() {
    const root  = $('.js-updates-ticker');
    if (!root) return;

    const items = $$('.updates-ticker-item', root);
    if (items.length < 1) return;

    // Respect dismissal for 24h.
    if (window.RipperStorage && window.RipperStorage.get('updates-dismissed-until')) {
      const until = parseInt(window.RipperStorage.get('updates-dismissed-until'), 10);
      if (Date.now() < until) return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    const closeBtn = $('.js-updates-ticker-close', root);
    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        root.hidden = true;
        if (window.RipperStorage) {
          window.RipperStorage.set('updates-dismissed-until', String(Date.now() + 24 * 60 * 60 * 1000), 24 * 60 * 60);
        }
      });
    }

    let activeIndex = 0;

    function show(index) {
      items.forEach((it, i) => {
        if (i === index) {
          it.removeAttribute('hidden');
          // Trigger reflow before adding is-active so the transition fires.
          void it.offsetWidth;
          it.classList.add('is-active');
        } else {
          it.classList.remove('is-active');
          // Hide after the transition completes.
          setTimeout(() => {
            if (!it.classList.contains('is-active')) it.setAttribute('hidden', '');
          }, 400);
        }
      });
    }

    function cycle() {
      activeIndex = (activeIndex + 1) % items.length;
      show(activeIndex);
    }

    // Show first item after 5s, then cycle every 4s.
    setTimeout(() => {
      root.hidden = false;
      show(0);
      setInterval(cycle, 4000);
    }, 5000);
  }

  // Tiny storage helper, used by the updates ticker dismissal.
  if (!window.RipperStorage) {
    window.RipperStorage = {
      get: (k) => {
        const m = document.cookie.match(new RegExp('(?:^|; )' + k + '=([^;]*)'));
        return m ? decodeURIComponent(m[1]) : null;
      },
      set: (k, v, maxAgeSeconds) => {
        document.cookie = k + '=' + encodeURIComponent(v) + '; max-age=' + maxAgeSeconds + '; path=/; SameSite=Lax';
      },
    };
  }

  function initBackgroundAnimation() {
    const root = $('[data-bg-animation]');
    if (!root) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return; // CSS handles static fallback.
    }

    const balls = $$('.bg-ball', root);
    if (!balls.length) return;

    // Cache per-ball data so we don't re-read CSS variables on every frame.
    const items = balls.map((el) => {
      const cs = getComputedStyle(el);
      return {
        el,
        baseX: parseFloat(cs.left) || 0,
        baseY: parseFloat(cs.top) || 0,
        speed: parseFloat(cs.getPropertyValue('--bg-parallax')) || 0.2,
        rect: el.getBoundingClientRect(),
        currentDX: 0,
        currentDY: 0,
        currentScale: 1,
        currentGlow: 0, // 0 = no glow, 1 = full gold glow
      };
    });

    // Recompute rects on resize.
    let resizeTO;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTO);
      resizeTO = setTimeout(() => {
        items.forEach((it) => { it.rect = it.el.getBoundingClientRect(); });
      }, 150);
    });

    const mouse = { x: -9999, y: -9999, active: false };
    window.addEventListener('mousemove', (e) => { mouse.x = e.clientX; mouse.y = e.clientY; mouse.active = true; });
    window.addEventListener('mouseleave', () => { mouse.x = -9999; mouse.y = -9999; mouse.active = false; });
    document.addEventListener('mouseleave', () => { mouse.active = false; });

    // rAF loop — one transform write per ball per frame.
    let ticking = false;
    function frame() {
      const scrollY = window.scrollY || window.pageYOffset || 0;
      for (let i = 0; i < items.length; i++) {
        const it = items[i];
        // Parallax drift: each ball moves at its own fraction of scroll.
        const scrollOffset = scrollY * it.speed;

        // Target scale + glow based on cursor proximity.
        let targetScale = 1;
        let targetGlow = 0;
        let dx = 0, dy = 0;

        if (mouse.active) {
          const cx = it.rect.left + it.rect.width / 2 - mouse.x;
          const cy = it.rect.top + it.rect.height / 2 - mouse.y + scrollOffset;
          const dist = Math.sqrt(cx * cx + cy * cy);

          if (dist < 200) {
            // Linear ramp: 0 at the edge of 200px, 1 right at the cursor.
            const proximity = 1 - dist / 200;
            targetScale = 1 + proximity * 0.15;     // up to 1.15x
            targetGlow = proximity;                  // up to 1.0

            if (dist < 160) {
              // Repulsion: stronger push, snappier easing.
              const force = (1 - dist / 160) * 45;   // up to 45px push
              dx = (cx / (dist || 1)) * force;
              dy = (cy / (dist || 1)) * force;
            }
          }
        }

        // Smooth toward target (lerp). Tighter than before for snappier feel.
        it.currentDX    += (dx      - it.currentDX)    * 0.30;
        it.currentDY    += (dy      - it.currentDY)    * 0.30;
        it.currentScale += (targetScale - it.currentScale) * 0.22;
        it.currentGlow  += (targetGlow  - it.currentGlow)  * 0.25;

        const y = (-scrollOffset + it.currentDY).toFixed(1);
        const transform = 'translate3d(' + it.currentDX.toFixed(1) + 'px, ' + y + 'px, 0) scale(' + it.currentScale.toFixed(3) + ')';
        it.el.style.transform = transform;
        it.el.style.setProperty('--bg-glow', it.currentGlow.toFixed(3));
      }
      ticking = false;
    }

    function onScroll() {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(frame);
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true });

    // Kick off one frame on init so initial state is correct.
    requestAnimationFrame(frame);
  }

  initBackgroundAnimation();
  initUpdatesTicker();

  /* ───────────────────────────────────────────────────────────────────────────
     Cursor glow + scroll-tinted gradient
     ───────────────────────────────────────────────────────────────────────────
     Two decorative layers stacked on top of the floating sports balls:

     1. The cursor glow is a soft gold/green radial that follows the mouse
        using eased lerp so the motion feels organic, not snappy. Strength
        ramps up from 0 to 1 on first mousemove and back to 0 when the
        cursor leaves the window (no glow on idle screens).

     2. The scroll tint writes a single CSS variable --scroll-progress
        (0..1) to :root on every scroll, which the .scroll-tint layer
        uses to interpolate from deep-green at the top to a cool
        blue-green at the bottom. rAF-throttled so it stays smooth
        even on long pages.

     Both honor prefers-reduced-motion (the CSS hides them and the JS
     bails out before doing any work).
  */
  function initCursorGlow() {
    const glow = $('[data-cursor-glow]');
    if (!glow) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let targetX = window.innerWidth / 2;
    let targetY = window.innerHeight / 2;
    let currentX = targetX;
    let currentY = targetY;
    let strength = 0;
    let targetStrength = 0;
    let active = false;
    let raf = 0;

    const tick = () => {
      // Lerp the cursor toward the target. 0.18 = smooth but responsive.
      currentX += (targetX - currentX) * 0.18;
      currentY += (targetY - currentY) * 0.18;
      strength += (targetStrength - strength) * 0.10;

      glow.style.setProperty('--cursor-x', currentX + 'px');
      glow.style.setProperty('--cursor-y', currentY + 'px');
      glow.style.setProperty('--cursor-strength', strength.toFixed(3));
      if (active || strength > 0.001) {
        raf = requestAnimationFrame(tick);
      } else {
        raf = 0;
        glow.classList.remove('is-active');
      }
    };

    const startLoop = () => {
      glow.classList.add('is-active');
      active = true;
      if (!raf) raf = requestAnimationFrame(tick);
    };

    window.addEventListener('mousemove', (e) => {
      targetX = e.clientX;
      targetY = e.clientY;
      targetStrength = 1;
      startLoop();
    }, { passive: true });

    window.addEventListener('mouseleave', () => {
      targetStrength = 0;
      active = false;
      // tick() will keep running while strength > 0 then stop itself.
      if (!raf) raf = requestAnimationFrame(tick);
    });

    // Initial paint so a centered glow exists before the first mousemove.
    glow.style.setProperty('--cursor-x', currentX + 'px');
    glow.style.setProperty('--cursor-y', currentY + 'px');
    glow.style.setProperty('--cursor-strength', '0');
  }

  function initScrollTint() {
    const tint = $('[data-scroll-tint]');
    if (!tint) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let ticking = false;
    const update = () => {
      const doc = document.documentElement;
      const scrollable = doc.scrollHeight - window.innerHeight;
      const progress = scrollable > 0
        ? Math.min(1, Math.max(0, window.scrollY / scrollable))
        : 0;
      doc.style.setProperty('--scroll-progress', progress.toFixed(3));
      ticking = false;
    };
    const onScroll = () => {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(update);
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    // Kick once so the gradient is correct on initial load.
    requestAnimationFrame(update);
  }

  initCursorGlow();
  initScrollTint();

  /* ───────────────────────────────────────────────────────────────────────────
     Scroll-driven motion layer (5 systems, one rAF loop)
     ───────────────────────────────────────────────────────────────────────────
     Runs in its own rAF, parallel to the background-balls loop (which
     already owns a tight tick for parallax/repulsion). Sharing one loop
     would couple ball-parallax to every other motion system and bloat
     frame() — easier to keep this self-contained.

     1. Section drift        — .section[data-drift] translateY by velocity
     2. Card parallax        — .card[data-parallax] .card-image > * translateY
     3. 3D featured tilt     — .card-featured perspective + rotateX/rotateY
     4. Section title fade   — .section-title opacity as it leaves top
     5. (handled by initStatCounters + reveal IO, not the rAF)
  */
  function initScrollMotion() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const driftSections   = $$('.section[data-drift]');
    const parallaxCards   = $$('.card[data-parallax]');
    const featuredCards   = $$('.card-featured');
    const sectionTitles   = $$('.section-title');

    if (!driftSections.length && !parallaxCards.length && !featuredCards.length && !sectionTitles.length) {
      return; // nothing to do on this page
    }

    // Shared pointer state. pointermove only updates the object; the
    // actual transform write happens in frame().
    const pointer = { x: 0, y: 0, active: false };
    window.addEventListener('pointermove', (e) => {
      pointer.x = e.clientX;
      pointer.y = e.clientY;
      pointer.active = true;
    }, { passive: true });
    window.addEventListener('pointerleave', () => { pointer.active = false; });

    // Build cached state for each tracked group.
    const sections = driftSections.map((el) => ({
      el,
      speed: parseFloat(el.getAttribute('data-drift')) || 0.04,
      current: 0,
      target: 0,
    }));

    const parallaxItems = [];
    parallaxCards.forEach((card) => {
      const speed = parseFloat(card.getAttribute('data-parallax')) || 0.1;
      const inner = card.querySelector('.card-image');
      if (!inner) return;
      // Drift the first painted child (img / svg).
      const child = inner.firstElementChild;
      if (!child) return;
      parallaxItems.push({ el: child, speed, current: 0 });
    });

    const featuredItems = featuredCards.map((card) => {
      const rect = () => card.getBoundingClientRect();
      return {
        el: card,
        rect, // function so we read fresh per frame
        currentX: 0,
        currentY: 0,
      };
    });

    const titles = sectionTitles.map((el) => {
      // Bind to the nearest .section so we know when the title is leaving
      // the section. If it lives directly inside a .section, use that.
      const section = el.closest('.section') || el.parentElement;
      return {
        el,
        section,
        current: 1,
      };
    });

    let lastScrollY = window.scrollY || 0;
    let lastT = performance.now();
    let ticking = false;

    function frame(now) {
      const scrollY = window.scrollY || 0;
      const dt = Math.max(1, now - lastT);
      lastT = now;

      // 1. Section drift — velocity-based, lerp-smoothed, clamped.
      for (let i = 0; i < sections.length; i++) {
        const s = sections[i];
        const velocity = (scrollY - lastScrollY) / dt; // px / ms
        // Scale velocity to a reasonable target. Cap at ±1.5 px/ms.
        const v = Math.max(-1.5, Math.min(1.5, velocity));
        s.target = Math.max(-24, Math.min(24, v * s.speed * 60));
        // Lerp toward target.
        s.current += (s.target - s.current) * 0.12;
        // Use a CSS variable so the CSS owns the transform binding.
        s.el.style.setProperty('--drift-current', s.current.toFixed(2) + 'px');
      }

      // 2. Card parallax — child image drifts against page scroll.
      for (let i = 0; i < parallaxItems.length; i++) {
        const it = parallaxItems[i];
        it.current += (scrollY * it.speed - it.current) * 0.18;
        it.el.style.transform = 'translate3d(0,' + (-it.current).toFixed(2) + 'px,0)';
      }

      // 3. 3D tilt on featured cards — pointer drives target, lerp smooths.
      if (pointer.active) {
        for (let i = 0; i < featuredItems.length; i++) {
          const f = featuredItems[i];
          const r = f.rect();
          if (r.width === 0) continue; // hidden
          const halfW = r.width / 2;
          const halfH = r.height / 2;
          const cx = r.left + halfW;
          const cy = r.top + halfH;
          const dx = (pointer.x - cx) / halfW;   // -1..1
          const dy = (pointer.y - cy) / halfH;   // -1..1
          const targetX = Math.max(-1, Math.min(1, dx)) * 6; // ±6deg
          const targetY = Math.max(-1, Math.min(1, dy)) * 6;
          f.currentX += (targetX - f.currentX) * 0.18;
          f.currentY += (targetY - f.currentY) * 0.18;
          f.el.style.setProperty('--tilt-x', (-f.currentY).toFixed(2) + 'deg'); // rotateX = -dy
          f.el.style.setProperty('--tilt-y', f.currentX.toFixed(2) + 'deg');    // rotateY =  dx
        }
      } else {
        // Pointer not active — relax to flat.
        for (let i = 0; i < featuredItems.length; i++) {
          const f = featuredItems[i];
          f.currentX += (0 - f.currentX) * 0.12;
          f.currentY += (0 - f.currentY) * 0.12;
          f.el.style.setProperty('--tilt-x', f.currentY.toFixed(2) + 'deg');
          f.el.style.setProperty('--tilt-y', f.currentX.toFixed(2) + 'deg');
        }
      }

      // 4. Section-title fade — fades as the section's top crosses above
      //    the viewport top by more than 80px.
      for (let i = 0; i < titles.length; i++) {
        const t = titles[i];
        if (!t.section) continue;
        const r = t.section.getBoundingClientRect();
        // When the section's top is 80px above the viewport, opacity ~ 0.
        const opacity = Math.max(0, Math.min(1, (r.top + 80) / 80));
        if (Math.abs(opacity - t.current) > 0.01) {
          t.current = opacity;
          t.el.style.opacity = opacity.toFixed(3);
          t.el.style.transform = 'translateY(' + ((1 - opacity) * -8).toFixed(2) + 'px)';
        }
      }

      lastScrollY = scrollY;
      ticking = false;
    }

    function onScroll() {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(frame);
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    // Kick one frame so initial state is correct.
    requestAnimationFrame(frame);
  }

  initScrollMotion();

  /* ───────────────────────────────────────────────────────────────────────────
     Stat value count-up
     ───────────────────────────────────────────────────────────────────────────
     For each .stat-value[data-counter] (with a numeric data-counter-target
     and optional data-counter-suffix like '+' or '%'), animate 0 → target
     over ~1200ms with easeOutCubic when the element first enters the
     viewport. The reveal IntersectionObserver in this file already fires
     when sections come into view — we re-use the same threshold by
     observing all .stat-value elements directly.
  */
  function initStatCounters() {
    const counters = $$('.stat-value[data-counter]');
    if (!counters.length) return;
    if (!('IntersectionObserver' in window)) {
      // No IO support — just reveal at final value.
      counters.forEach(revealFinal);
      return;
    }
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      counters.forEach(revealFinal);
      return;
    }

    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        io.unobserve(el);
        animate(el);
      });
    }, { threshold: 0.4 });

    counters.forEach((el) => io.observe(el));

    function animate(el) {
      if (el.children.length > 0) return; // defensive — don't clobber children
      const target = parseFloat(el.getAttribute('data-counter-target')) || 0;
      const suffix = el.getAttribute('data-counter-suffix') || '';
      const dur = 1200;
      const start = performance.now();

      function step(now) {
        const t = Math.min(1, (now - start) / dur);
        const eased = 1 - Math.pow(1 - t, 3); // easeOutCubic
        const value = Math.round(eased * target);
        el.textContent = value + suffix;
        if (t < 1) {
          requestAnimationFrame(step);
        } else {
          el.classList.add('is-counted');
        }
      }
      // Set visible immediately so the count is visible during the tween.
      el.classList.add('is-counted');
      el.textContent = '0' + suffix;
      requestAnimationFrame(step);
    }

    function revealFinal(el) {
      if (el.children.length > 0) return;
      const target = parseFloat(el.getAttribute('data-counter-target')) || 0;
      const suffix = el.getAttribute('data-counter-suffix') || '';
      el.textContent = target + suffix;
      el.classList.add('is-counted');
    }
  }

  initStatCounters();
})();
