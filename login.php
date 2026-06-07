<?php
include 'koneksi.php';
session_start();
 
$error = '';
$success = '';
$mode = isset($_POST['mode']) ? $_POST['mode'] : 'login';
 
// ── LOGIN ──────────────────────────────────────────────────────────────────
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
 
    $query = mysqli_query($koneksi,
        "SELECT * FROM user
         WHERE username='$username'
         AND password='$password'"
    );
    $data = mysqli_fetch_assoc($query);
 
    if ($data) {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama']     = $data['nama'];
        $_SESSION['role']     = $data['role'];
        $_SESSION['email']    = $data['email'];
        header("Location: home.php");
        exit;
    } else {
        $error = "Username atau password salah.";
        $mode  = 'login';
    }
}
 
// ── REGISTER ───────────────────────────────────────────────────────────────
if (isset($_POST['register'])) {
    $mode     = 'register';
    $username = mysqli_real_escape_string($koneksi, trim($_POST['reg_username']));
    $email    = mysqli_real_escape_string($koneksi, trim($_POST['reg_email']));
    $password = $_POST['reg_password'];
    $confirm  = $_POST['reg_confirm'];
 
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua kolom wajib diisi.";
    } elseif ($password !== $confirm) {
        $error = "Password dan konfirmasi tidak cocok.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        // cek username/email sudah ada
        $cek = mysqli_query($koneksi,
            "SELECT id_user FROM user
             WHERE username='$username' OR email='$email'
             LIMIT 1"
        );
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau email sudah terdaftar.";
        } else {
            $ins = mysqli_query($koneksi,
                "INSERT INTO user (username, email, password, role)
                 VALUES ('$username','$email','$password','member')"
            );
            if ($ins) {
                $success = "Akun berhasil dibuat! Silakan login.";
                $mode    = 'login';
            } else {
                $error = "Terjadi kesalahan. Coba lagi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPBS Gallery — Auth</title>
 
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
 
    <style>
    *, *::before, *::after {
        margin: 0; padding: 0;
        box-sizing: border-box;
    }
 
    :root {
        --cream:   #f5f0e8;
        --ink:     #1a1612;
        --muted:   #8a7f72;
        --gold:    #c9a84c;
        --gold-lt: #e8d99a;
        --danger:  #c0392b;
        --success: #2d6a4f;
        --card-bg: #fffcf7;
        --border:  rgba(26,22,18,.1);
    }
 
    body {
        min-height: 100vh;
        background-color: var(--cream);
        background-image:
            radial-gradient(ellipse 60% 50% at 80% 20%, rgba(201,168,76,.12) 0%, transparent 60%),
            radial-gradient(ellipse 50% 60% at 10% 90%, rgba(26,22,18,.06) 0%, transparent 60%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        padding: 24px;
    }
 
    /* ── SPLIT CARD ─────────────────────────────────────────────── */
    .card {
        width: 840px;
        max-width: 100%;
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        overflow: hidden;
        display: flex;
        box-shadow: 0 24px 80px rgba(26,22,18,.12);
        min-height: 520px;
    }
 
    /* ── LEFT PANEL ─────────────────────────────────────────────── */
    .panel-left {
        flex: 0 0 42%;
        background: var(--ink);
        padding: 52px 44px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
 
    .panel-left::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(201,168,76,.18) 0%, transparent 70%);
        top: -80px; right: -80px;
    }
 
    .panel-left::after {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(201,168,76,.1) 0%, transparent 70%);
        bottom: -60px; left: -40px;
    }
 
    .brand {
        position: relative; z-index: 1;
    }
 
    .brand-name {
        font-family: 'DM Serif Display', serif;
        font-size: 26px;
        letter-spacing: 3px;
        color: #fff;
        text-transform: uppercase;
    }
 
    .brand-tag {
        font-size: 11px;
        letter-spacing: 2px;
        color: var(--gold);
        text-transform: uppercase;
        margin-top: 6px;
    }
 
    .panel-copy {
        position: relative; z-index: 1;
    }
 
    .panel-copy h2 {
        font-family: 'DM Serif Display', serif;
        font-size: 36px;
        line-height: 1.2;
        color: #fff;
        margin-bottom: 14px;
    }
 
    .panel-copy h2 em {
        font-style: italic;
        color: var(--gold-lt);
    }
 
    .panel-copy p {
        font-size: 14px;
        color: rgba(255,255,255,.55);
        line-height: 1.7;
    }
 
    .panel-ornament {
        position: relative; z-index: 1;
        width: 40px; height: 1px;
        background: var(--gold);
    }
 
    /* ── RIGHT PANEL ─────────────────────────────────────────────── */
    .panel-right {
        flex: 1;
        padding: 48px 44px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
 
    /* ── TOGGLE ──────────────────────────────────────────────────── */
    .toggle-wrap {
        display: flex;
        background: rgba(26,22,18,.06);
        border-radius: 12px;
        padding: 4px;
        margin-bottom: 32px;
        width: fit-content;
    }
 
    .toggle-btn {
        padding: 8px 24px;
        border-radius: 9px;
        border: none;
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 400;
        color: var(--muted);
        cursor: pointer;
        transition: all .25s;
    }
 
    .toggle-btn.active {
        background: var(--card-bg);
        color: var(--ink);
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(26,22,18,.1);
    }
 
    /* ── FORM TITLE ──────────────────────────────────────────────── */
    .form-title {
        font-family: 'DM Serif Display', serif;
        font-size: 28px;
        color: var(--ink);
        margin-bottom: 6px;
    }
 
    .form-sub {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 28px;
    }
 
    /* ── ALERTS ──────────────────────────────────────────────────── */
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
 
    .alert.error {
        background: rgba(192,57,43,.08);
        border: 1px solid rgba(192,57,43,.25);
        color: var(--danger);
    }
 
    .alert.success {
        background: rgba(45,106,79,.08);
        border: 1px solid rgba(45,106,79,.25);
        color: var(--success);
    }
 
    .alert-icon { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
 
    /* ── FIELDS ──────────────────────────────────────────────────── */
    .field { margin-bottom: 16px; }
 
    .field label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: .6px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 6px;
    }
 
    .input-wrap { position: relative; }
 
    .field input {
        width: 100%;
        padding: 11px 14px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: rgba(26,22,18,.03);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--ink);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
 
    .field input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.15);
    }
 
    .eye-btn {
        position: absolute;
        right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        cursor: pointer;
        color: var(--muted);
        font-size: 12px;
        font-family: 'DM Sans', sans-serif;
        padding: 0;
        user-select: none;
    }
 
    /* ── SUBMIT ──────────────────────────────────────────────────── */
    .btn-submit {
        width: 100%;
        padding: 13px;
        margin-top: 8px;
        border: none;
        border-radius: 12px;
        background: var(--ink);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background .2s, transform .15s;
        letter-spacing: .3px;
    }
 
    .btn-submit:hover   { background: #2e2820; }
    .btn-submit:active  { transform: scale(.98); }
 
    /* ── FORM PANELS ─────────────────────────────────────────────── */
    .form-panel { display: none; }
    .form-panel.active { display: block; }
 
    /* ── RESPONSIVE ──────────────────────────────────────────────── */
    @media (max-width: 640px) {
        .card { flex-direction: column; }
        .panel-left { flex: none; padding: 36px 28px; min-height: unset; }
        .panel-copy h2 { font-size: 26px; }
        .panel-right { padding: 32px 28px; }
    }
    </style>
</head>
 
<body>
<div class="card">
 
    <!-- ── LEFT PANEL ─────────────────────────────────── -->
    <div class="panel-left">
        <div class="brand">
            <div class="brand-name">PPBS</div>
            <div class="brand-tag">Gallery System</div>
        </div>
 
        <div class="panel-copy">
            <h2>Kelola koleksi <em>galeri</em> dengan mudah.</h2>
            <p>Sistem inventaris dan manajemen galeri terpadu untuk mencatat, menelusuri, dan memantau seluruh koleksi karya.</p>
        </div>
 
        <div class="panel-ornament"></div>
    </div>
 
    <!-- ── RIGHT PANEL ────────────────────────────────── -->
    <div class="panel-right">
 
        <!-- toggle -->
        <div class="toggle-wrap">
            <button class="toggle-btn <?= ($mode === 'login')    ? 'active' : '' ?>"
                    onclick="switchMode('login')">Masuk</button>
            <button class="toggle-btn <?= ($mode === 'register') ? 'active' : '' ?>"
                    onclick="switchMode('register')">Daftar</button>
        </div>
 
        <!-- alerts -->
        <?php if ($error): ?>
        <div class="alert error">
            <span class="alert-icon">✕</span>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
 
        <?php if ($success): ?>
        <div class="alert success">
            <span class="alert-icon">✓</span>
            <?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>
 
        <!-- ── LOGIN FORM ──────────────────────────────── -->
        <div class="form-panel <?= ($mode === 'login') ? 'active' : '' ?>" id="panel-login">
            <p class="form-title">Selamat datang</p>
            <p class="form-sub">Masukkan kredensial akun Anda untuk melanjutkan.</p>
 
            <form method="POST">
                <input type="hidden" name="mode" value="login">
 
                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" autocomplete="username" required>
                </div>
 
                <div class="field">
                    <label>Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="pw-login" autocomplete="current-password" required>
                        <button type="button" class="eye-btn" onclick="togglePw('pw-login', this)">Lihat</button>
                    </div>
                </div>
 
                <button type="submit" name="login" class="btn-submit">Masuk</button>
            </form>
        </div>
 
        <!-- ── REGISTER FORM ───────────────────────────── -->
        <div class="form-panel <?= ($mode === 'register') ? 'active' : '' ?>" id="panel-register">
            <p class="form-title">Buat akun baru</p>
            <p class="form-sub">Isi data berikut untuk mendaftarkan akun Anda.</p>
 
            <form method="POST">
                <input type="hidden" name="mode" value="register">
 
                <div class="field">
                    <label>Username</label>
                    <input type="text" name="reg_username"
                           value="<?= isset($_POST['reg_username']) ? htmlspecialchars($_POST['reg_username']) : '' ?>"
                           autocomplete="username" required>
                </div>
 
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="reg_email"
                           value="<?= isset($_POST['reg_email']) ? htmlspecialchars($_POST['reg_email']) : '' ?>"
                           autocomplete="email" required>
                </div>
 
                <div class="field">
                    <label>Password</label>
                    <div class="input-wrap">
                        <input type="password" name="reg_password" id="pw-reg" autocomplete="new-password" required>
                        <button type="button" class="eye-btn" onclick="togglePw('pw-reg', this)">Lihat</button>
                    </div>
                </div>
 
                <div class="field">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input type="password" name="reg_confirm" id="pw-conf" autocomplete="new-password" required>
                        <button type="button" class="eye-btn" onclick="togglePw('pw-conf', this)">Lihat</button>
                    </div>
                </div>
 
                <button type="submit" name="register" class="btn-submit">Buat Akun</button>
            </form>
        </div>
 
    </div><!-- /panel-right -->
</div><!-- /card -->
 
<script>
function switchMode(mode) {
    document.getElementById('panel-login').classList.toggle('active',    mode === 'login');
    document.getElementById('panel-register').classList.toggle('active', mode === 'register');
    document.querySelectorAll('.toggle-btn').forEach((btn, i) => {
        btn.classList.toggle('active', (i === 0 && mode === 'login') || (i === 1 && mode === 'register'));
    });
}
 
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const show = inp.type === 'password';
    inp.type   = show ? 'text' : 'password';
    btn.textContent = show ? 'Tutup' : 'Lihat';
}
</script>
 
</body>
</html>
 