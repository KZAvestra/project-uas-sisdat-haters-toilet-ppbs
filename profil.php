<?php include 'koneksi.php';
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Lukisan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body style="background:#0d0d0d;color:white;">

<div class="container">

        <nav class="navbar navbar-expand-lg py-4">
                <div class="container-fluid">
                    <span style="font-family:'Times New Roman',serif; font-size:35px; font-weight:bold; color:white;">
                        PPBS Gallery
                    </span>
                    <div class="ms-auto d-flex align-items-center gap-4">
                        <a class="text-decoration-none text-light" href="home.php">
                            Home
                        </a>
                            <a class="text-decoration-none text-light" href="katalog.php">Katalog</a>
                            <a class="text-decoration-none text-light active-link" href="profil.php">Profil</a>
                        <a class="btn btn-light rounded-pill px-4"
                            href="logout.php"
                            onclick="return confirm('Yakin mau logout?')">
                            Logout
                        </a>
                    </div>
                </div>
            </nav>

    <div class="profile-header fade-up">
        <br><br>
        <div class="profile-avatar">
            <?= strtoupper(substr($_SESSION['nama'],0,1)); ?>
        </div>
        <h2><?= $_SESSION['nama']; ?></h2>
        <p><?= $_SESSION['username']; ?></p>
    </div>

    <div class="gold-line fade-up"></div>

    <div class="row g-4 mt-2 fade-up">

        <!-- DATA PRIBADI -->
        <div class="col-lg-5">
            <div class="glass-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Data Pribadi</h4>
                    <div>
                        <a href="edit_profil.php" class="btn-dark-custom">Edit</a>
                    </div>
                </div>

                <table class="profile-table">
                    <tr>
                        <td>Nama</td>
                        <td><?= $_SESSION['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?= $_SESSION['username']; ?></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><?= $_SESSION['email']; ?></td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- RIWAYAT PEMBELIAN -->
        <div class="col-lg-7">
            <div class="glass-card">
                <h4 class="mb-4">Riwayat Pembelian</h4>
                <div class="table-responsive">
                    <table class="table h-table align-middle">
                        <tbody>

                        <?php
                        $id_user = $_SESSION['id_user'];

                        $q = mysqli_query(
                            $koneksi,
                            "SELECT pembelian.*, lukisan.nama_lukisan, lukisan.gambar FROM pembelian
                            JOIN lukisan ON pembelian.id_lukisan = lukisan.id_lukisan
                            WHERE pembelian.id_user = '$id_user' ORDER BY pembelian.id_pembelian DESC"
                        );
                        while($r = mysqli_fetch_array($q)){
                        ?>

                        <tr>
                            <td scope="row"> <?= $r['tgl_beli']; ?> </td>
                            <td scope="row"> <?= $r['nama_lukisan']; ?> </td>
                            <td scope="row">
                                <img src="img/<?= $r['gambar']; ?>" style="width:120px;
                                                                            height:120px;
                                                                            object-fit:cover;
                                                                            border-radius:16px;
                                                                            border:1px solid rgba(255,255,255,.1);
                                                                            transition:.3s;">
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>

<style>

.gold-line{
    width:500px;
    height:2px;
    background:#c9a96e;
    margin:20px auto;
}

.profile-header{
    text-align:center;
    padding:5px 0;
}

.profile-avatar{
    width:120px;
    height:120px;
    margin:auto;
    border-radius:50%;
    background:linear-gradient(135deg,#d4af37,#f0d68a);
    color:#000;
    font-size:48px;
    font-weight:bold;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:20px;
}

.profile-header h2{
    font-family:"Times New Roman",serif;
    margin-bottom:5px;
}

.profile-header p{
    color:#9d9d9d;
}

.glass-card{
    background:rgba(255,255,255,0.01);
    border:1px solid rgba(255,255,255,.08);
    border-radius:24px;
    backdrop-filter:blur(12px);
    padding:30px;
    height:100%;
}

.glass-card h4{
    color:#d4af37;
    font-family:"Times New Roman",serif;
}

.profile-table{
    width:100%;
}

.profile-table td{
    padding:14px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.profile-table td:first-child{
    color:#9d9d9d;
    width:40%;
}

.h-table{
    color: #dadada;
    width:100%;
}

.h-table td{
    padding:14px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.btn-dark-custom{
    flex:1;
    background:transparent;
    border:1px solid rgba(255,255,255,.15);
    color:white;
    border-radius:12px;
    padding:10px;
    text-decoration:none;
    text-align:center;
}

.btn-dark-custom:hover{
    border-color:#c9a96e;
    color:#c9a96e;
}

</style>
    <script>
    const observer = new IntersectionObserver(
    (entries)=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting){ entry.target.classList.add("show"); }
            else { entry.target.classList.remove("show");}
        });
    },{ threshold:0.15 });

    document
    .querySelectorAll(".fade-up")
    .forEach(el=>observer.observe(el));
    </script>

</body>

</html>