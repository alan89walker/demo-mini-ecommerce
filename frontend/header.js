function renderHeader(mountId){
  const mount = document.getElementById(mountId);
  if (!mount) return;
  injectHeaderStyles();
  const isBackend = location.pathname.toLowerCase().includes('/backend/');
  const pref = isBackend ? '../frontend/' : '';
  const adminHref = isBackend ? 'admin.php' : '../backend/admin.php';
  mount.innerHTML = `
    <div class="container header-inner">
      <nav class="nav">
        <a href="${pref}home.html">Home</a>
        <a href="${pref}products.html">Products</a>
        <a href="${pref}orders.html">Orders</a>
        <a id="admin-link" href="${adminHref}">Admin</a>
        <a id="login-link" href="${pref}login.html">Login</a>
      </nav>
      <div id="header-user" style="justify-self:center;color:#cfe7ff"></div>
      <div style="justify-self:end">
        <button id="cart-btn" class="cart-btn" aria-label="Cart" type="button">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 6h15l-1.5 9h-12L4 2H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          <span id="cart-count" class="cart-count">0</span>
        </button>
      </div>
    </div>
  `;
  try {
    fetch('../backend/userInfo.php')
      .then(r=>r.json())
      .then(u=>{
        const ul = document.getElementById('login-link');
        const al = document.getElementById('admin-link');
        const hu = document.getElementById('header-user');
        const nav = document.querySelector('.nav');
        const isBackend = location.pathname.toLowerCase().includes('/backend/');
        const logoutUrl = isBackend ? 'logout.php' : '../backend/logout.php';
        const redirectUrl = isBackend ? '../frontend/login.html' : 'login.html';
        if (u && u.username) {
          hu.textContent = 'Hello, ' + u.username + (u.role==='admin'?' (admin)':'');
          ul.style.display = 'none';
          if (u.role !== 'admin') { al.style.display = 'none'; }
          const btn = document.createElement('button');
          btn.className = 'logout-btn';
          btn.textContent = 'Logout';
          btn.addEventListener('click', ()=>{
            fetch(logoutUrl, {method:'POST'}).then(()=>{ window.location.href = redirectUrl; }).catch(()=>{ window.location.href = redirectUrl; });
          });
          nav.appendChild(btn);
        } else {
          hu.textContent = '';
          al.style.display = 'none';
        }
        highlightActive();
      }).catch(()=>{});
  } catch(e){}
  const btn = document.getElementById('cart-btn');
  if (btn) {
    btn.addEventListener('click', ()=> {
      try {
        if (typeof toggleCart === 'function') { toggleCart(true); }
        else { window.location.href = 'products.html'; }
      } catch(e){ window.location.href = 'products.html'; }
    });
  }
  try {
    const cnt = (JSON.parse(localStorage.getItem('cart')) || []).reduce((a,b)=>a+(b.qty||1),0);
    document.getElementById('cart-count').textContent = cnt;
  } catch(e){}
}

function injectHeaderStyles(){
  if (document.getElementById('shared-header-styles')) return;
  const style = document.createElement('style');
  style.id = 'shared-header-styles';
  style.textContent = `
    .header-inner{display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:16px;padding:18px 20px}
    .nav{display:flex;gap:10px;flex-wrap:wrap}
    .nav a{display:inline-block;color:#cfe7ff;text-decoration:none;padding:8px 12px;border-radius:999px;border:1px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.04);transition:all .15s}
    .nav a:hover{background:rgba(255,255,255,0.12);color:#ffffff}
    .nav a.active{background:#1f7aeb;border-color:#1f7aeb;color:#ffffff;box-shadow:0 8px 20px rgba(31,122,235,0.25)}
    .cart-btn{position:relative;background:linear-gradient(180deg,#0ea5a4,#02848a);border:none;color:white;padding:8px 12px;border-radius:10px;display:inline-flex;align-items:center;gap:8px;cursor:pointer;box-shadow:0 6px 20px rgba(0,0,0,0.35)}
    .cart-count{background:linear-gradient(180deg,#ff7a59,#ff4b2e);padding:4px 8px;border-radius:999px;font-weight:700;font-size:12px;color:white;min-width:20px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.4)}
    .logout-btn{color:#fff;background:linear-gradient(90deg,#ef4444,#dc2626);border:none;border-radius:999px;padding:8px 12px;font-weight:700;cursor:pointer}
  `;
  document.head.appendChild(style);
}

function highlightActive(){
  const links = document.querySelectorAll('.nav a');
  const href = location.pathname.toLowerCase();
  links.forEach(a=>{
    const t = a.getAttribute('href').toLowerCase();
    const pathEnd = t.split('/').pop();
    if (href.endsWith(pathEnd) || (pathEnd.includes('admin.php') && href.includes('admin.php'))) {
      a.classList.add('active');
    } else {
      a.classList.remove('active');
    }
  });
}
