// assets/js/app.js
document.addEventListener('DOMContentLoaded', () => {
  const toasts = document.querySelectorAll('.toast');
  toasts.forEach(t => setTimeout(() => t.classList.add('show'), 200));

  // simple client-side validation
  document.querySelectorAll('form[novalidate]').forEach(form => {
    form.addEventListener('submit', (e) => {
      const required = form.querySelectorAll('[required]');
      let ok = true;
      required.forEach(inp => {
        if (!inp.value.trim()) { inp.classList.add('error'); ok = false; }
        else inp.classList.remove('error');
      });
      if (!ok) {
        e.preventDefault();
        showToast('Please fill in all required fields.');
      }
    });
  });

  function showToast(msg){
    let el = document.querySelector('.toast') || document.body.appendChild(Object.assign(document.createElement('div'), {className:'toast'}));
    el.textContent = msg;
    el.classList.add('show');
    setTimeout(()=>el.classList.remove('show'), 3000);
  }
});
