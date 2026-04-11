<!DOCTYPE html>
<html>
<head>
    <title>Login JAFO</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        height: 100vh;
        background: #f3f4f6;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* CARD */
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

    /* LEFT */
    .left {
        width: 50%;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .brand {
        font-size: 18px;
        margin-bottom: 20px;
        color: #555;
        font-weight: 500;
    }

    .left h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .desc {
        font-size: 14px;
        color: #777;
        margin-bottom: 30px;
    }

    /* INPUT */
    .input-box {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 30px;
        padding: 12px 15px;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    .input-box i {
        color: #aaa;
        margin-right: 10px;
    }

    .input-box input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 14px;
    }

    .input-box:focus-within {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    /* BUTTON */
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

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(59,130,246,0.3);
    }

    /* ERROR */
    .error {
        color: red;
        font-size: 13px;
        text-align: center;
        margin-bottom: 10px;
    }

   .right {
    width: 50%;
    position: relative;
}

    /* OVERLAY */
    .right::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
    }

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

    /* ANIMASI */
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
</head>

<body>

<div class="card">

    <!-- LEFT -->
    <div class="left">

        <div class="brand">JAFO</div>

        <h1>Welcome Back</h1>
        <p class="desc">Login untuk mengakses dashboard fotografi kamu</p>

        <!-- ERROR (TETAP PUNYA KAMU) -->
        <?php if($this->session->flashdata('error')): ?>
            <div class="error">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM (TIDAK DIUBAH LOGIC) -->
        <form method="post" action="<?= base_url('login/login') ?>">

            <div class="input-box">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-box">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>

        </form>

    </div>

    <!-- RIGHT -->
   <!-- RIGHT -->
<div class="right" style="background: url('<?= base_url('assets/images/fotoo.jpg') ?>') center/cover;">
    <div class="overlay">
        <h2>Capture Your Moment</h2>
        <p>Professional photography experience for every story.</p>
    </div>
</div>

</div>

<script>
document.querySelectorAll("input").forEach(input => {
    input.addEventListener("focus", () => {
        input.parentElement.style.transform = "scale(1.02)";
    });

    input.addEventListener("blur", () => {
        input.parentElement.style.transform = "scale(1)";
    });
});
</script>

</body>
</html>
