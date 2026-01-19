<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../frontend/login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:
    radial-gradient(1200px 600px at 10% 10%, rgba(255,255,255,0.03), transparent 10%),
    radial-gradient(1000px 500px at 90% 90%, rgba(255,255,255,0.02), transparent 10%),
    linear-gradient(135deg,#0f1724 0%, #0b1a2b 50%, #05202e 100%);min-height:100vh;margin:0;color:#e6eef6}
.container{width:100%;max-width:760px;margin:0 auto;padding:24px}
.header{display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:16px;padding:18px 0}
.brand{justify-self:end;font-weight:700;letter-spacing:.6px;font-size:1rem;text-transform:uppercase;color:#f8fbff;text-shadow:0 2px 18px rgba(0,0,0,.5)}
.panel{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);padding:20px;border-radius:12px;box-shadow:0 12px 40px rgba(0,0,0,.35)}
h2{margin:0 0 14px;font-size:22px;color:#fff;font-weight:700}
.form-row{display:flex;flex-direction:column;gap:8px;margin-bottom:14px}
label{font-size:13px;color:#cfe7ff}
input[type="text"],input[type="number"],input[type="url"]{width:100%;padding:12px 14px;border:1px solid rgba(255,255,255,.12);border-radius:10px;font-size:15px;background:rgba(255,255,255,.04);color:#e6eef6;outline:none;transition:box-shadow .15s,border-color .15s}
input:focus{border-color:#1f7aeb;box-shadow:0 8px 20px rgba(31,122,235,0.25)}
.actions{display:flex;justify-content:flex-end;gap:10px;align-items:center}
button{type:none;background:#1f7aeb;color:#fff;border:none;padding:10px 16px;border-radius:10px;font-weight:700;cursor:pointer;font-size:15px}
.note{font-size:13px;color:#cfe7ff;margin-top:10px}
.grid{margin-top:18px;display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px}
.card{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);padding:12px;border-radius:12px;box-shadow:0 6px 24px rgba(2,8,15,.45)}
.thumb img{width:100%;height:120px;object-fit:cover;border-radius:8px}
</style>
</head>
<body>
<script src="../frontend/header.js"></script>
<div id="site-header"></div>
<script>renderHeader('site-header');</script>
<div class="container">
    <div class="header">
        <nav><a href="../frontend/home.html" style="color:#cfe7ff;text-decoration:none;margin-right:14px">Home</a><a href="../frontend/products.html" style="color:#cfe7ff;text-decoration:none;margin-right:14px">Products</a></nav>
        <div></div>
        <div class="brand">Admin Panel</div>
    </div>
    <div class="panel" role="main" aria-label="Add product form">
        <h2>Add Product</h2>
        <div class="form-row">
            <label for="name">Product Name</label>
            <input id="name" type="text" placeholder="e.g., Wireless Headphones">
        </div>
        <div class="form-row">
            <label for="price">Price</label>
            <input id="price" type="number" step="0.01" placeholder="e.g., 49.99">
        </div>
        <div class="form-row">
            <label for="image">Image URL</label>
            <input id="image" type="url" placeholder="https://example.com/image.jpg">
        </div>
        <div class="actions">
            <button type="button" onclick="addProduct()">Add Product</button>
        </div>
        <p class="note">Use a full image URL for best display.</p>
    </div>
    <div id="preview" class="grid"></div>
</div>
<script>
function addProduct(){
        let name = document.getElementById("name").value;
        let price = document.getElementById("price").value;
        let image = document.getElementById("image").value;
        let formData = new FormData();
        formData.append("name", name);
        formData.append("price", price);
        formData.append("image", image);
        fetch("../backend/addProducts.php", {
                method: "POST",
                body: formData
        })
        .then(res => res.text())
        .then(msg => {
            alert(msg);
            fetch("../backend/getProducts.php").then(r=>r.json()).then(d=>{
                const list=Array.isArray(d)?d.slice(-4):[];
                document.getElementById('preview').innerHTML=list.map(p=>`<div class="card"><div class="thumb"><img src="${p.image}" alt="${p.name}"></div><div style="margin-top:6px;font-weight:600">${p.name}</div><div style="color:#9ef0d1;font-weight:700">₹${Number(p.price).toFixed(2)}</div></div>`).join('');
            });
        })
        .catch(err => alert("Error: " + err));
}
</script>
</body>
</html>
