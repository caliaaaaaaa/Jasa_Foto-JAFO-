<!DOCTYPE html>
<html>
<head>
    <title>Login JAFO</title>

    <!-- STYLE -->
    <style>

        /* RESET */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        
        }

        /* CONTAINER UTAMA */
        .container {
            display: flex;
            height: 100vh;
        }

        /* BAGIAN KIRI */
        .left {
            width: 50%;
            background: #273F6B;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .left img {
            width: 150px;
        }

       .left h1 {
    font-family: 'Audiowide', cursive;
    color: white;
    margin-top: 10px;
    letter-spacing: 2px;
}

        .left p {
            color: #ddd;
        }

        /* BAGIAN KANAN */
        .right {
            width: 50%;
            background: #E5E7EF;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

		
.right::before {
    content: '';
    position: absolute;
    left: -150px;
    width: 300px;
    height: 100%;
    background: #E5E7EF;
    border-radius: 50%;
}

        /* CARD LOGIN */
        .login-box {
            width: 300px;
        }

        /* INPUT */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border-radius: 30px;
            border: none;
            background: #6192D7;
            color: white;
            font-size: 16px;
            outline: none;
        }

        .input-group input::placeholder {
            color: #ddd;
        }

        /* BUTTON */
     .btn-login {
    width: 60%;
    padding: 15px;
    border-radius: 30px;
    border: none;
    background: #3B6FB6;
    color: white;
    font-size: 18px;
    cursor: pointer;
    display: block;
    margin: auto; /* 🔥 BIAR TENGAH */
}

        .btn-login:hover {
            background: #2F5DA3;
        }

    </style>
</head>

<body>

<div class="container">

    <!-- KIRI (LOGO) -->
    <div class="left">
        <img src="<?= base_url('assets/images/logo.png') ?>">
        <h1>JAFO</h1>
        <p>Jasa Fotografi</p>
    </div>

    <!-- KANAN (FORM LOGIN) -->
    <div class="right">

        <div class="login-box">

            <!-- ERROR LOGIN -->
            <?php if($this->session->flashdata('error')): ?>
                <p style="color:red; text-align:center;">
                    <?= $this->session->flashdata('error') ?>
                </p>
            <?php endif; ?>

            <form method="post" action="<?= base_url('auth/login') ?>">

                <!-- USERNAME -->
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <!-- PASSWORD -->
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <!-- BUTTON LOGIN -->
                <button type="submit" class="btn-login">LOGIN</button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
