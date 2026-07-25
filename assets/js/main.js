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
})();
