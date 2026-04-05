<?php if(!isset($active)) $active = ''; ?>

<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.wrapper {
    display: flex;
    background: #f5f6fa;
}

/* 🔥 SIDEBAR */
.sidebar {
    width: 240px;
    background: #2F4B7C;
    min-height: 100vh;
    padding: 20px 15px;
    border-radius: 0 40px 40px 0;
    position: relative;
	margin-top: 50px;
}

/* 🔥 LOGO */
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    margin-bottom: 30px;
}

.logo img {
    width: 35px;
}

.logo span {
    font-weight: 600;
    font-size: 18px;
}

/* 🔥 MENU */
.menu {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    margin: 10px 0;
    border-radius: 30px;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

/* ICON */
.menu i {
    font-size: 18px;
}

/* HOVER */
.menu:hover {
    background: #3B6FB6;
}

/* 🔥 ACTIVE (EFEK FIGMA) */
.menu.active {
    background: white;
    color: #2F4B7C;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* 🔥 BULAT SAMPING (EFEK Figma curve) */
/* .menu.active::before {
    content: '';
    position: absolute;
    left: -15px;
    top: 0;
    width: 30px;
    height: 100%;
    background: white;
    border-radius: 0 30px 30px 0;
} */

/* 🔥 LOGOUT */
.logout {
    position: absolute;
    bottom: 30px;
    width: 65%;
    background: #3B6FB6;
    text-align: center;
    justify-content: center;
}

/* CONTENT */
.content {
    flex: 1;
    padding: 30px;
}
</style>

<div class="wrapper">

<div class="sidebar">


   

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
    <a href="<?= base_url('auth/logout') ?>" class="menu logout">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>

</div>

<div class="content">
