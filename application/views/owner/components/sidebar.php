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
.menu.active::before {
    content: '';
    position: absolute;
    right: -15px; /* 🔥 pindah ke kanan */
    top: 0;
    width: 30px;
    height: 100%;
    background: white;
    border-radius: 30px 0 0 30px; /* 🔥 dibalik */
}

/* 🔥 LOGOUT */
.logout {
    position: absolute;
    bottom: 170px;
    width: 65%;
    background: #3B6FB6;
    text-align: center;
    justify-content: center;
	 margin-left: 15px; 
	
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
    <a href="<?= base_url('owner/dashboard') ?>" 
       class="menu <?= ($active=='dashboard')?'active':'' ?>">
        <i class="fa fa-home"></i> Dashboard
    </a>

    <a href="<?= base_url('owner/paket') ?>" 
       class="menu <?= ($active=='paket')?'active':'' ?>">
        <i class="fa fa-image"></i> Data Paket Foto
    </a>

    <a href="<?= base_url('owner/status_pesanan') ?>" 
       class="menu <?= ($active=='status')?'active':'' ?>">
        <i class="fa fa-list-check"></i> Status Pesanan
    </a>

    <a href="<?= base_url('owner/riwayat') ?>" 
       class="menu <?= ($active=='riwayat')?'active':'' ?>">
        <i class="fa fa-clock-rotate-left"></i> Riwayat Transaksi
    </a>

	  <a href="<?= base_url('owner/activity_log') ?>" 
       class="menu <?= ($active=='log')?'active':'' ?>">
        <i class="fa fa-history"></i> Log Aktivitas
    </a>


    <!-- 🔥 LOGOUT -->
    <a href="<?= base_url('login/logout') ?>" class="menu logout">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>

</div>

<div class="content">
