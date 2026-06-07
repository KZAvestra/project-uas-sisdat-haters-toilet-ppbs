<?php
include 'koneksi.php';
session_start();

$id = $_SESSION['id_user'];

$sql3 = mysqli_prepare(
    $koneksi,
    "SELECT id_user, username, nama, email
     FROM user
     WHERE id_user = ?"
);

mysqli_stmt_bind_param($sql3, "i", $id);
mysqli_stmt_execute($sql3);

$result = mysqli_stmt_get_result($sql3);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $username = $_POST['username'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql3 = mysqli_prepare(
    $koneksi,
    "UPDATE user
    SET username = ?, nama = ?, email = ?, password = ?
    WHERE id_user = ?"
    );

    mysqli_stmt_bind_param(
        $sql3,
        "ssssi",
        $username,
        $nama,
        $email,
        $password,
        $id
    );

    if (mysqli_stmt_execute($sql3)) {

        $_SESSION['username'] = $username;
        $_SESSION['nama']     = $nama;
        $_SESSION['email']    = $email;
        $_SESSION['password'] = $password;
        $success = "Profile berhasil diperbarui.";

        $user['username'] = $username;
        $user['nama']     = $nama;
        $user['email']    = $email;

    } else {
        $error = "Profile gagal diperbarui.";
    }
} ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>

        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&display=swap" rel="stylesheet">

        <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;

            background:linear-gradient(
                135deg,
                #0f0f0f,
                #151515,
                #1c1c1c
            );

            color:white;
        }

        .box{
            position: relative;
            width:400px;
            background:rgba(30,30,30,0.75);
            backdrop-filter:blur(15px);
            -webkit-backdrop-filter:blur(15px);
            border:1px solid rgba(255,255,255,0.06);
            border-radius:20px;
            padding:40px;
            box-shadow:
            0 8px 32px rgba(0,0,0,0.4);
        }

        .box h2{
            font-family:'Cormorant Garamond', serif;
            text-align: center;
            font-size:42px;
            letter-spacing:2px;
        }


        label{
            display:block;
            margin-bottom:8px;
            color:#cbd5e1;
        }

        input{
            width:100%;
            padding:12px 14px;
            margin-bottom:20px;
            border:none;
            outline:none;
            border-radius:10px;
            background:rgba(255,255,255,0.04);
            color:#f5f5f5;
            border:1px solid rgba(255,255,255,.08);
        }

        button{
            width:100%;
            padding:12px;

            border:none;
            border-radius:10px;

            cursor:pointer;

            background:linear-gradient(
                135deg,
                #2b2b2b,
                #444444
            );

            color:white;

            font-size:15px;
            font-weight:600;

            transition:0.3s;
        }

        button:hover{
            background:linear-gradient(
                135deg,
                #444444,
                #5a5a5a
            );
            box-shadow:0 5px 20px rgba(255,255,255,.08);
        }

        .btn-x{
            position: absolute;
            top: 10px;
            right: 10px;
            background:transparent;
            border:1px solid #4d4d4d;
            color:#444444;
            border-radius:10px;
            padding:5px 12px;
            align-items: center;
            text-decoration:none;
            text-align:center;
        }

        .btn-x:hover{
            background: #444444;
            color:white;
        }

        .error{
            background:rgba(239,68,68,.15);

            border:1px solid rgba(239,68,68,.4);

            color:#fca5a5;

            padding:10px;
            border-radius:10px;

            margin-bottom:20px;
        }
        .success{
            background: rgba(45,106,79,.08);

            border: 1px solid rgba(45,106,79,.25);

            color:#2d6a4f;

            padding:10px;
            border-radius:10px;

            margin-bottom:20px;
        }

        #toggleText{
            color:#94a3b8 !important;
            font-size:13px !important;
            user-select:none;
        }

        </style>
    </head>

    
    <body>
        <div class="box">

            <a href="home.php" class="btn-x">X</a>

            <h2>EDIT PROFIL</h2>

            <?php if(isset($error)) { ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <?php if(isset($success)) { ?>
                <div class="success">
                    <?php echo $success; ?>
                </div>
            <?php } ?>

            <form method="POST">

                <label>Username</label>
                    <input type="text" name="username" value="<?php echo $_SESSION['username'] ?>" required>

                <label>Nama</label>
                    <input type="text" name="nama" value="<?php echo $_SESSION['nama'] ?>" required>

                <label>E-Mail</label>
                    <input type="text" name="email" value="<?php echo $_SESSION['email'] ?>">

                <label>Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" placeholder="Masukkan password baru." id=password>
                            <span onclick="togglePassword()" id="toggleText"
                                style="
                                    position:absolute;
                                    right:15px;
                                    top:33%;
                                    transform:translateY(-50%);
                                    cursor:pointer;
                                    color:gray;
                                    font-size:14px;
                                "
                            > Lihat
                            </span>

                    </div>

                <button type="submit" name="update">
                    Update
                </button>

            </form>

        </div>

        <script>

        function togglePassword() {

            const passwordInput = document.getElementById("password");
            const toggleText = document.getElementById("toggleText");

            if (passwordInput.type === "password") {

                passwordInput.type = "text";
                toggleText.textContent = "Tutup";

            } else {

                passwordInput.type = "password";
                toggleText.textContent = "Lihat";
            }
        }

        </script>

    </body>
</html>