<?php include 'koneksi.php';

session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT lukisan.*, pelukis.nama_pelukis 
        FROM lukisan 
        JOIN pelukis ON lukisan.id_pelukis = pelukis.id_pelukis
        ORDER BY lukisan.id_lukisan DESC
        LIMIT 4";

$q = mysqli_query($koneksi, $sql);

$data = [];
while($row = mysqli_fetch_array($q)) {
    $data[] = $row;
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
                    <a class="text-decoration-none text-light active-link" href="home.php">
                        Home
                    </a>
                    <?php if($_SESSION['role'] == 'admin') { ?>
                        <a class="text-decoration-none text-light" href="lukisan.php">Lukisan</a>
                        <a class="text-decoration-none text-light" href="pelukis.php">Pelukis</a>
                        <a class="text-decoration-none text-light" href="pembelian.php">Pembelian</a>
                    <?php } ?>
                    <?php if($_SESSION['role'] == 'member') { ?>
                        <a class="text-decoration-none text-light" href="katalog.php">Katalog</a>
                        <a class="text-decoration-none text-light" href="profil.php">Profil</a>
                    <?php } ?>

                    <a class="btn btn-light rounded-pill px-4"
                        href="logout.php"
                        onclick="return confirm('Yakin mau logout?')">
                        Logout
                    </a>
                </div>
            </div>
        </nav>

    <?php if($_SESSION['role'] == 'admin') { ?>

        <div class="text-center mt-5">

            <div class="hero fade-up">
                <br>
                <h1>Halo, Admin!</h1>
                <div class="gold-line"></div>
                <p>Selamat datang di Panel Admin Sistem Inventaris Galeri. <br>Siap kerja?</p>
            </div>

            <br><br><br>

        </div>

    <?php } ?>

    <?php if($_SESSION['role'] == 'member') { ?>

        <div class="text-center mt-5">

            <div class="hero fade-up">
                <br>
                <h1>Halo, <?php echo $_SESSION['nama']; ?>!</h1>
                <div class="gold-line"></div>
                <p>Selamat datang di Galeri Lukisan PPBS: Menampilkan koleksi karya seni, mengelola inventaris galeri,
                <br>dan mempermudah proses pembelian dalam satu platform.</p>
            </div>

            <br><br><br>

        </div>

    <?php } ?>

    <div class="gallery-section">

        <h2 class="gallery-title fade-up">
             ↓  ↓  ↓  Check Out New Added Arts !
        </h2>

        <div class="slider fade-up">
            <div class="slide-track">

                <?php
                for($i=0; $i<3; $i++){
                    foreach($data as $lukisan){
                ?>
                    <div class="glass-card">
                        <img src="img/<?php echo $lukisan['gambar']; ?>">
                        <h3 class="lukisan-title">
                            <?php echo $lukisan['nama_lukisan']; ?>
                        </h3>
                        <p class="artist">
                            <?php echo $lukisan['nama_pelukis']; ?>
                        </p>
                        <p class="price">
                            Rp <?php echo number_format($lukisan['harga']); ?>
                        </p>
                    </div>

                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <br><br>

</div>

<style>

.gallery-section{
    margin-top:80px;
    padding:15px 0;
}

.gallery-title{
    text-align:right;
    font-family:'Times New Roman', serif;
    font-size:42px;
    margin-bottom:40px;
}

.slider{
    overflow:hidden;
    padding:15px 0;
}

.slide-track{
    display:flex;
    gap:30px;
    width:max-content;
    animation:scroll 25s linear infinite;
}

@keyframes scroll{
    0%{
        transform:translateX(0);
    }
    100%{
        transform:translateX(calc(-330px * 4));
    }
}

.glass-card{
    width:190px;
    min-width:300px;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.12);
    backdrop-filter:blur(8px);
    border-radius:18px;
    padding:15px;
    transition:0.4s;
    color:white;
    box-shadow:
    0 10px 30px rgba(0,0,0,.25);
}

.glass-card:hover{
    border: 1px solid white;
    transform: scale(1.05);
}

.glass-card:active {
  transform: scale(0.95) rotateZ(1.7deg);
}

.glass-card img{
    width:100%;
    height:250px;
    object-fit:cover;
    border-radius:12px;
}

.lukisan-title{
    margin-top:15px;
    font-family:'Times New Roman', serif;
    font-size:28px;
}

.artist{
    color:#9ca3af;
}

.price{
    font-weight:bold;
    font-size:18px;
}

.hero{
    text-align:center;
    padding:80px 0 50px;
}

.hero h1{
    font-family:"Times New Roman", serif;
    font-size:70px;
    letter-spacing:3px;
}

.hero p{
    color:#bdbdbd;
    margin-top:15px;
}


</style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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

