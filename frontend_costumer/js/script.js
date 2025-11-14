// Toggle menu mobile (gunakan id agar aman)
const hambtn = document.getElementById('hambtn');
const mainNav = document.getElementById('mainNav');
if (hambtn && mainNav) {
  hambtn.addEventListener('click', () => {
    mainNav.classList.toggle('show');
  });
}

// Mark active nav link berdasarkan URL (menambahkan class 'active')
document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll('.nav-links a');
  const current = window.location.pathname.split('/').pop() || 'index.html';
  navLinks.forEach(a => {
    const href = a.getAttribute('href');
    if (!href) return;
    if (href === current) {
      a.classList.add('active');
      a.setAttribute('aria-current', 'page');
    } else {
      a.classList.remove('active');
      a.removeAttribute('aria-current');
    }
  });
});


