<!DOCTYPE html>
<html>
<head>
    <title>Login JAFO</title>

    <!--  FONT GOOGLE (Poppins untuk tampilan modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- ICON FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

    /* RESET CSS (biar rapi di semua browser) */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* BODY (posisi tengah layar) */
    body {
        height: 100vh;
        background: transparent; /* agar tidak menutupi background/video */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* CARD UTAMA LOGIN */
    .card {
        width: 1000px;
        height: 550px;
        background: white;
        border-radius: 25px;
        display: flex;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        animation: fadeIn 1s ease;
    }

    /* BAGIAN KIRI (FORM LOGIN) */
    .left {
        width: 50%;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* BRAND / NAMA APLIKASI */
    .brand {
        font-size: 18px;
        margin-bottom: 20px;
        color: #555;
        font-weight: 500;
    }

    /* JUDUL */
    .left h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }

    /*DESKRIPSI */
    .desc {
        font-size: 14px;
        color: #777;
        margin-bottom: 30px;
    }

    /* INPUT FIELD */
    .input-box {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 30px;
        padding: 12px 15px;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    /* ICON INPUT */
    .input-box i {
        color: #aaa;
        margin-right: 10px;
    }

    /* INPUT TEXT */
    .input-box input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 14px;
    }

    /* EFEK SAAT FOCUS */
    .input-box:focus-within {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    /* BUTTON LOGIN */
    .btn-login {
        width: 100%;
        padding: 12px;
        border-radius: 30px;
        border: none;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    /* HOVER BUTTON */
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(59,130,246,0.3);
    }

    /* ERROR MESSAGE */
    .error {
        color: red;
        font-size: 13px;
        text-align: center;
        margin-bottom: 10px;
    }

    /* BAGIAN KANAN (IMAGE BACKGROUND) */
    .right {
        width: 50%;
        position: relative;
    }

    /*OVERLAY GELAP DI ATAS GAMBAR */
    .right::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
    }

    /* TEXT DI ATAS GAMBAR */
    .overlay {
        position: absolute;
        bottom: 40px;
        left: 40px;
        right: 40px;
        color: white;
        z-index: 1;
    }

    .overlay h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .overlay p {
        font-size: 14px;
        opacity: 0.8;
    }

    /* ANIMASI MASUK */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    </style>

<!-- CONTAINER UTAMA -->
<div class="card">

    <!-- LEFT: FORM LOGIN -->
    <div class="left">

        <div class="brand">JAFO</div>

        <h1>Welcome Back</h1>
        <p class="desc">Login untuk mengakses dashboard fotografi kamu</p>

        <!-- ERROR DARI SESSION -->
        <?php if($this->session->flashdata('error')): ?>
            <div class="error">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM LOGIN (POST KE CONTROLLER) -->
        <form method="post" action="<?= base_url('login/login') ?>">

            <!-- INPUT USERNAME -->
            <div class="input-box">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <!-- INPUT PASSWORD -->
            <div class="input-box">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <!-- BUTTON SUBMIT -->
            <button type="submit" class="btn-login">Login</button>

        </form>

    </div>

    <!-- RIGHT: GAMBAR + OVERLAY -->
    <div class="right" style="background: url('<?= base_url('assets/images/fotoo.jpg') ?>') center/cover;">
        <div class="overlay">
            <h2>Capture Your Moment</h2>
            <p>Professional photography experience for every story.</p>
        </div>
    </div>

</div>

</body>
</html>
