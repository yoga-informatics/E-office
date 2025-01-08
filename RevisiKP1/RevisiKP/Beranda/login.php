<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <img src="../image/logo.png" alt="Logo" />
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Form Login</header>
            
            <!-- Menampilkan pesan error jika login gagal -->
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <p style="color: red; text-align: center;">Username atau password salah!</p>
            <?php endif; ?>

            <form action="proses_login.php" method="post">
                <input type="text" placeholder="Masukan username" name="username" required>
                <input type="password" placeholder="Masukan password" name="password" required>
                <input type="submit" value="Login" class="button">
            </form>
        </div>
    </div>
</body>
</html>