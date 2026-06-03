<?php include 'koneksi.php';
session_start();

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi,
        "SELECT * FROM user
         WHERE username='$username'
         AND password='$password'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['email'] = $data['email'];
        header("Location: home.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

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
            font-size:42px;
            letter-spacing:2px;
        }

        .subtitle{
            text-align:center;
            color:#a3a3a3;
            margin-bottom:30px;
            font-size:14px;
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

        input:focus{
            border:1px solid #d4af37;
            box-shadow:0 0 15px rgba(212,175,55,.2);
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

        .error{
            background:rgba(239,68,68,.15);

            border:1px solid rgba(239,68,68,.4);

            color:#fca5a5;

            padding:10px;
            border-radius:10px;

            margin-bottom:20px;
        }

        #toggleText{
            color:#94a3b8 !important;
            font-size:13px !important;
            user-select:none;
        }

        .bg-circle,
        .bg-circle2{
            position:fixed;
            border-radius:50%;
            filter:blur(100px);
            z-index:-1;
        }

        .bg-circle{
            width:250px;
            height:250px;
            background:#3a3a3a;
            top:-50px;
            left:-50px;
        }

        .bg-circle2{
            width:250px;
            height:250px;
            background:#5a4a2f;
            bottom:-50px;
            right:-50px;
        }

        </style>
    </head>

    <body>
        <div class="bg-circle"></div>
        <div class="bg-circle2"></div>
        <div class="box">

            <h2>PPBS GALLERY</h2>

            <p class="subtitle">
                Sistem Inventaris dan Manajemen Galeri
            </p>

            <?php if(isset($error)) { ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <form method="POST">

                <label>Username</label>
                    <input type="text" name="username" required>

                <label>Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" required>
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

                <button type="submit" name="login">
                    Login
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