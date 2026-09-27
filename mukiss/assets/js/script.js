/**
 * MUKISS - Shared Vanilla JavaScript
 * Location: assets/js/script.js
 *
 * Handles: mobile nav, navbar search toggle, flavor filtering,
 * product detail modal, form validation, password visibility toggle,
 * toast notifications, delete confirmation, admin bar chart bars.
 */

document.addEventListener('DOMContentLoaded', function () {
  initMobileNav();
  initNavSearch();
  initFlavorFilter();
  initProductModal();
  initFormValidation();
  initPasswordToggle();
  initDeleteConfirm();
  initBarChart();
});

/* ---------------------------------------------------
   Mobile navigation (hamburger)
--------------------------------------------------- */
function initMobileNav() {
  var btn = document.getElementById('hamburgerBtn');
  var links = document.getElementById('navLinks');
  if (!btn || !links) return;

  btn.addEventListener('click', function () {
    var isOpen = links.classList.toggle('is-open');
    btn.classList.toggle('is-open', isOpen);
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });
}

/* ---------------------------------------------------
   Navbar search bar toggle
--------------------------------------------------- */
function initNavSearch() {
  var toggle = document.getElementById('searchToggle');
  var panel = document.getElementById('navSearch');
  if (!toggle || !panel) return;

  toggle.addEventListener('click', function () {
    panel.classList.toggle('is-open');
    if (panel.classList.contains('is-open')) {
      var input = panel.querySelector('input');
      if (input) input.focus();
    }
  });
}

/* ---------------------------------------------------
   Flavor search + category filter (Flavors page)
--------------------------------------------------- */
function initFlavorFilter() {
  var grid = document.getElementById('flavorGrid');
  if (!grid) return;

  var searchInput = document.getElementById('flavorSearch');
  var pills = document.querySelectorAll('.pill[data-filter]');
  var emptyState = document.getElementById('flavorEmpty');
  var cards = Array.prototype.slice.call(grid.querySelectorAll('.product-card'));
  var activeCategory = 'ALL';

  function applyFilters() {
    var term = (searchInput ? searchInput.value : '').trim().toLowerCase();
    var visibleCount = 0;

    cards.forEach(function (card) {
      var name = (card.getAttribute('data-name') || '').toLowerCase();
      var category = card.getAttribute('data-category') || '';
      var matchesSearch = name.indexOf(term) !== -1;
      var matchesCategory = activeCategory === 'ALL' || category === activeCategory;
      var visible = matchesSearch && matchesCategory;
      card.style.display = visible ? '' : 'none';
      if (visible) visibleCount++;
    });

    if (emptyState) {
      emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }

  pills.forEach(function (pill) {
    pill.addEventListener('click', function () {
      pills.forEach(function (p) { p.classList.remove('is-active'); });
      pill.classList.add('is-active');
      activeCategory = pill.getAttribute('data-filter');
      applyFilters();
    });
  });

  applyFilters();
}

/* ---------------------------------------------------
   Product / flavor detail modal
--------------------------------------------------- */
function initProductModal() {
  var overlay = document.getElementById('productModal');
  if (!overlay) return;

  var fields = {
    name: overlay.querySelector('[data-field="name"]'),
    profile: overlay.querySelector('[data-field="profile"]'),
    description: overlay.querySelector('[data-field="description"]'),
    category: overlay.querySelector('[data-field="category"]'),
    design: overlay.querySelector('[data-field="design"]'),
    finish: overlay.querySelector('[data-field="finish"]'),
    status: overlay.querySelector('[data-field="status"]'),
    imageLetter: overlay.querySelector('[data-field="imageLetter"]')
  };

  document.querySelectorAll('[data-view-details]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var card = btn.closest('[data-name]');
      if (!card) return;

      if (fields.name) fields.name.textContent = card.getAttribute('data-name') || '';
      if (fields.profile) fields.profile.textContent = card.getAttribute('data-profile') || '';
      if (fields.description) fields.description.textContent = card.getAttribute('data-description') || '';
      if (fields.category) fields.category.textContent = card.getAttribute('data-category') || '';
      if (fields.design) fields.design.textContent = card.getAttribute('data-design') || '';
      if (fields.finish) fields.finish.textContent = card.getAttribute('data-finish') || '';
      if (fields.status) fields.status.textContent = card.getAttribute('data-status') || '';
      if (fields.imageLetter) fields.imageLetter.textContent = (card.getAttribute('data-name') || '?').charAt(0);

      overlay.classList.add('is-open');
    });
  });

  overlay.querySelectorAll('[data-close-modal]').forEach(function (el) {
    el.addEventListener('click', function () { overlay.classList.remove('is-open'); });
  });

  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) overlay.classList.remove('is-open');
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') overlay.classList.remove('is-open');
  });
}

/* ---------------------------------------------------
   Client-side form validation (contact, login, register)
--------------------------------------------------- */
function initFormValidation() {
  document.querySelectorAll('form[data-validate]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var valid = true;

      form.querySelectorAll('[data-rule]').forEach(function (field) {
        var rules = field.getAttribute('data-rule').split('|');
        var group = field.closest('.form-group') || field.parentElement;
        var value = field.value.trim();
        var fieldValid = true;

        rules.forEach(function (rule) {
          if (rule === 'required' && value === '') fieldValid = false;
          if (rule === 'email' && value !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) fieldValid = false;
          if (rule.indexOf('minlength:') === 0) {
            var min = parseInt(rule.split(':')[1], 10);
            if (value.length < min) fieldValid = false;
          }
        });

        if (group) group.classList.toggle('has-error', !fieldValid);
        if (!fieldValid) valid = false;
      });

      if (!valid) {
        e.preventDefault();
        showToast('Please check the highlighted fields.', true);
      }
    });
  });
}

/* ---------------------------------------------------
   Password visibility toggle
--------------------------------------------------- */
function initPasswordToggle() {
  document.querySelectorAll('.password-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = document.getElementById(btn.getAttribute('data-target'));
      if (!input) return;
      var isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      btn.textContent = isPassword ? 'HIDE' : 'SHOW';
    });
  });
}

/* ---------------------------------------------------
   Delete confirmation (admin CRUD)
--------------------------------------------------- */
function initDeleteConfirm() {
  document.querySelectorAll('[data-confirm-delete]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      var message = el.getAttribute('data-confirm-delete') || 'Are you sure you want to delete this item?';
      if (!window.confirm(message)) {
        e.preventDefault();
      }
    });
  });
}

/* ---------------------------------------------------
   Simple admin bar chart (animates bar heights on load)
--------------------------------------------------- */
function initBarChart() {
  document.querySelectorAll('.bar-chart__bar').forEach(function (bar) {
    var target = bar.getAttribute('data-value') || '0';
    bar.style.height = '0%';
    requestAnimationFrame(function () {
      setTimeout(function () {
        bar.style.height = target + '%';
      }, 60);
    });
  });
}

/* ---------------------------------------------------
   Toast notification helper (used across pages)
--------------------------------------------------- */
function showToast(message, isError) {
  var existing = document.querySelector('.toast');
  if (existing) existing.remove();

  var toast = document.createElement('div');
  toast.className = 'toast' + (isError ? ' toast--error' : '');
  toast.textContent = message;
  document.body.appendChild(toast);

  requestAnimationFrame(function () {
    toast.classList.add('is-visible');
  });

  setTimeout(function () {
    toast.classList.remove('is-visible');
    setTimeout(function () { toast.remove(); }, 300);
  }, 3500);
}
