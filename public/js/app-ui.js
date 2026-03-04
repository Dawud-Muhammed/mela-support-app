document.addEventListener('DOMContentLoaded', () => {
  lucide.createIcons();

  const sidebar = document.querySelector('[data-sidebar]');
  const menuBtn = document.querySelector('.mobile-menu-btn');
  const closeBtn = document.querySelector('.close-sidebar-btn');
  const collapseBtn = document.querySelector('[data-sidebar-toggle]');
  const folderToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
  if (collapseBtn && sidebar) {
    collapseBtn.addEventListener('click', () => {
      sidebar.classList.toggle('sidebar-collapsed');
    });
  }

  folderToggles.forEach((toggle) => {
    const targetSelector = toggle.getAttribute('data-bs-target');
    const target = targetSelector ? document.querySelector(targetSelector) : null;
    const chevron = toggle.querySelector('[data-folder-chevron]');

    if (!target) {
      return;
    }

    toggle.addEventListener('click', () => {
      const isOpen = target.classList.contains('max-h-96');

      if (isOpen) {
        target.classList.remove('max-h-96', 'opacity-100');
        target.classList.add('max-h-0', 'opacity-0');
        if (chevron) {
          chevron.classList.remove('rotate-180');
        }
        return;
      }

      target.classList.remove('max-h-0', 'opacity-0');
      target.classList.add('max-h-96', 'opacity-100');
      if (chevron) {
        chevron.classList.add('rotate-180');
      }
    });
  });

  if (menuBtn && sidebar) {
    menuBtn.addEventListener('click', () => {
      sidebar.classList.remove('hidden');
      sidebar.classList.add('flex', 'fixed', 'inset-0', 'z-50', 'w-full');
    });
  }

  if (closeBtn && sidebar) {
    closeBtn.addEventListener('click', () => {
      sidebar.classList.add('hidden');
      sidebar.classList.remove('flex', 'fixed', 'inset-0', 'z-50', 'w-full');
    });
  }
});
