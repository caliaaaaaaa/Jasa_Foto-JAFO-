<?php if(!isset($active)) $active = ''; ?>

<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --bg-color: #f5f6fa; /* Warna background utama */
    --sidebar-color: #2F4B7C; /* Warna sidebar */
    --active-text: #2F4B7C;
}

.wrapper {
    display: flex;
    background: var(--bg-color);
    min-height: 100vh;
}

/* 🔥 SIDEBAR */
.sidebar {
    width: 260px;
    background: var(--sidebar-color);
    padding: 20px 0 20px 15px; /* Padding kanan dihilangkan agar nempel */
    border-radius: 0 40px 40px 0;
    margin-top: 20px;
    display: flex;
    flex-direction: column;
}

/* 🔥 MENU */
.menu {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 20px;
    margin: 5px 0;
    color: white;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.3s;
    position: relative;
    border-radius: 30px 0 0 30px; /* Lengkungan kiri saja */
}

.menu i {
    font-size: 20px;
    width: 25px;
    text-align: center;
}

/* 🔥 ACTIVE STATE (EFEK MENYATU) */
.menu.active {
    background: var(--bg-color); /* Harus sama dengan background content */
    color: var(--active-text);
    font-weight: 700;
}

/* Lengkungan Atas */
.menu.active::before {
    content: "";
    position: absolute;
    background-color: transparent;
    top: -50px;
    right: 0;
    height: 50px;
    width: 50px;
    border-bottom-right-radius: 25px;
    box-shadow: 0 25px 0 0 var(--bg-color);
    pointer-events: none;
}

/* Lengkungan Bawah */
.menu.active::after {
    content: "";
    position: absolute;
    background-color: transparent;
    bottom: -50px;
    right: 0;
    height: 50px;
    width: 50px;
    border-top-right-radius: 25px;
    box-shadow: 0 -25px 0 0 var(--bg-color);
    pointer-events: none;
}

/* 🔥 LOGOUT BUTTON */
.logout {
    margin-top: auto; /* Dorong ke bawah */
    margin-bottom: 50px;
    margin-right: 25px;
    background: #3B6FB6;
    border-radius: 8px;
    justify-content: center;
    padding: 10px;
}

.logout:hover {
    background: #4a82d1;
}

/* CONTENT */
.content {
    flex: 1;
    padding: 30px;
}
</style>

<div class="wrapper">

<div class="sidebar">


   
<br>
<br>
    <!-- MENU -->
    <a href="<?= base_url('admin/dashboard') ?>" 
       class="menu <?= ($active=='dashboard')?'active':'' ?>">
        <i class="fa fa-home"></i> Dashboard
    </a>

    <a href="<?= base_url('admin/paket') ?>" 
       class="menu <?= ($active=='paket')?'active':'' ?>">
        <i class="fa fa-image"></i> Data Paket Foto
    </a>

    <a href="<?= base_url('admin/form_tambah_paket') ?>" 
       class="menu <?= ($active=='kelola')?'active':'' ?>">
        <i class="fa fa-pen-to-square"></i> Kelola Paket Foto
    </a>

    <a href="<?= base_url('admin/users') ?>" 
       class="menu <?= ($active=='user')?'active':'' ?>">
        <i class="fa fa-users"></i> Data User
    </a>

    <a href="<?= base_url('admin/status') ?>" 
       class="menu <?= ($active=='status')?'active':'' ?>">
        <i class="fa fa-list-check"></i> Status Pesanan
    </a>

    <a href="<?= base_url('admin/riwayat') ?>" 
       class="menu <?= ($active=='riwayat')?'active':'' ?>">
        <i class="fa fa-clock-rotate-left"></i> Riwayat Transaksi
    </a>

    <!-- 🔥 LOGOUT -->
    <a href="<?= base_url('login/logout') ?>" class="menu logout">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>

</div>

<div class="content">
