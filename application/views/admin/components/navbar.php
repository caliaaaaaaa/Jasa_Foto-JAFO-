
<style>

/* NAVBAR */
.navbar {
    height: 70px;
    background: #2F4B7C;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 35px;
    color: white;
}

.navbar {
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
/* LEFT (LOGO + TEXT) */
.nav-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ICON CAMERA */
.nav-left img {
    width: 38px;
}

/* TEXT */
.logo-text {
    display: flex;
    flex-direction: column;
}

/* JAFO */
.logo-title {
    font-family: 'Audiowide', sans-serif;
    font-size: 22px;
    letter-spacing: 1px;
}

/* JASA FOTOGRAFI */
.logo-sub {
    font-size: 12px;
    opacity: 0.8;
    margin-top: -3px;
}

/* GARIS */
.logo-line {
    width: 120px;
    height: 2px;
    background: rgba(255,255,255,0.5);
    margin-top: 4px;
}

/* RIGHT PROFILE */
.profile {
    background: #3B6FB6;
    padding: 8px 18px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
}

/* FONT IMPORT */
@import url('https://fonts.googleapis.com/css2?family=Audiowide&display=swap');

</style>

<div class="navbar">

    <!-- 🔥 LEFT -->
    <div class="nav-left">
         <img src="<?= base_url('assets/images/logtas.png') ?>">

        <div class="logo-text">
            <div class="logo-title">JAFO</div>
            <div class="logo-sub">Jasa Fotografi</div>
            <div class="logo-line"></div>
        </div>
    </div>

    <!-- 🔥 RIGHT -->
    <div class="profile">
        <?= ucfirst($this->session->userdata('role')) ?>
    </div>

</div>
