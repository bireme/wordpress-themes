(function () {
  'use strict';

  var MQ = '(max-width: 992px)';

  function ready(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  ready(function () {
    var btn = document.querySelector('.menu-toggle');
    var sidebar = document.getElementById('mobile-sidebar');
    var overlay = document.querySelector('.mobile-overlay');
    var closeBtn = document.querySelector('.close-sidebar');
    var primaryMenu = document.getElementById('primary-menu');
    var i18n = window.lilacsHeader || {};

    if (primaryMenu) {
      primaryMenu.querySelectorAll(':scope > li.menu-item-has-children > a').forEach(function (a) {
        a.setAttribute('aria-haspopup', 'true');
      });
    }

    if (!btn || !sidebar || !overlay) return;

    function isMobile() {
      return window.matchMedia(MQ).matches;
    }

    function openSidebar() {
      sidebar.classList.add('is-open');
      overlay.classList.add('is-active');
      document.body.classList.add('sidebar-open');
      btn.setAttribute('aria-expanded', 'true');
      sidebar.setAttribute('aria-hidden', 'false');
      overlay.setAttribute('aria-hidden', 'false');
    }

    function closeSidebar() {
      sidebar.classList.remove('is-open');
      overlay.classList.remove('is-active');
      document.body.classList.remove('sidebar-open');
      btn.setAttribute('aria-expanded', 'false');
      sidebar.setAttribute('aria-hidden', 'true');
      overlay.setAttribute('aria-hidden', 'true');
    }

    function toggleSidebar(e) {
      if (e) {
        e.preventDefault();
        e.stopPropagation();
      }
      if (!isMobile()) return;
      if (sidebar.classList.contains('is-open')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    }

    btn.setAttribute('aria-controls', 'mobile-sidebar');
    sidebar.setAttribute('aria-hidden', 'true');
    overlay.setAttribute('aria-hidden', 'true');

    btn.addEventListener('click', toggleSidebar);

    if (closeBtn) {
      closeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeSidebar();
      });
    }

    overlay.addEventListener('click', function (e) {
      e.preventDefault();
      closeSidebar();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
        closeSidebar();
        btn.focus();
      }
    });

    window.addEventListener('resize', function () {
      if (!isMobile() && sidebar.classList.contains('is-open')) {
        closeSidebar();
      }
    });

    // Accordion toggles for sidebar submenus
    sidebar.querySelectorAll('li.menu-item-has-children').forEach(function (li) {
      if (li.querySelector(':scope > .sidebar-submenu-toggle')) return;

      var link = li.querySelector(':scope > a');
      var toggle = document.createElement('button');
      toggle.className = 'sidebar-submenu-toggle';
      toggle.type = 'button';
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute(
        'aria-label',
        i18n.openSubmenu || 'Abrir submenu'
      );
      toggle.innerHTML = '<span class="toggle-icon" aria-hidden="true">+</span>';

      if (link) {
        link.parentNode.insertBefore(toggle, link.nextSibling);
      } else {
        li.insertBefore(toggle, li.firstChild);
      }

      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var isOpen = li.classList.toggle('submenu-open');
        var icon = toggle.querySelector('.toggle-icon');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        if (icon) icon.textContent = isOpen ? '\u2212' : '+';

        Array.prototype.forEach.call(li.parentElement.children, function (sib) {
          if (sib !== li && sib.classList.contains('menu-item-has-children')) {
            sib.classList.remove('submenu-open');
            var sibToggle = sib.querySelector(':scope > .sidebar-submenu-toggle');
            if (sibToggle) {
              sibToggle.setAttribute('aria-expanded', 'false');
              var sibIcon = sibToggle.querySelector('.toggle-icon');
              if (sibIcon) sibIcon.textContent = '+';
            }
          }
        });
      });
    });
  });
})();
