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
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&display=swap" rel="stylesheet">
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
                            <a class="text-decoration-none text-light active-link" href="katalog.php">Katalog</a>
                            <a class="text-decoration-none text-light" href="profil.php">Profil</a>
                        <a class="btn btn-light rounded-pill px-4"
                            href="logout.php"
                            onclick="return confirm('Yakin mau logout?')">
                            Logout
                        </a>
                    </div>
                </div>
            </nav>

        <?php if(isset($_GET['pesan'])) { ?>
        <div class="alert alert-success">
            Pembelian berhasil dilakukan!
        </div>
        <?php 
        header("refresh:3;url=katalog.php"); 
        } ?>

        <div class="hero fade-up">
            <br>
            <h1>KOLEKSI LUKISAN</h1>
            <div class="gold-line"></div>
            <p>Kelola data lukisan dalam sistem inventaris galeri dengan mudah dan terstruktur.</p>
            <br><br>
        </div>

        <div class="gallery-grid">
        <?php
        $sql2 = "SELECT lukisan.*, pelukis.nama_pelukis FROM lukisan
                JOIN pelukis ON lukisan.id_pelukis = pelukis.id_pelukis
                ORDER BY id_lukisan DESC";
        $q2 = mysqli_query($koneksi,$sql2);
        while($r2 = mysqli_fetch_array($q2)){
        ?>

        <div class="glass-card fade-up">
            <div class="image-wrapper">
                <img src="img/<?php echo $r2['gambar']; ?>" alt="">
                <?php if($r2['status'] == 'terjual') { ?>
                    <div class="sold-badge">SOLD</div>
                <?php } ?>
            </div>
            <div class="card-content">
                <div class="card-title">
                    <?php echo $r2['nama_lukisan']; ?>
                </div>

                <div class="artist">
                    <?php echo $r2['nama_pelukis']; ?>
                </div>

                <div class="price">
                    Rp <?php echo number_format($r2['harga'],0,",","."); ?>
                </div>

                <div class="action-btns">
                    <a class="btn-dark-custom" href="detail.php?id_lukisan=<?php echo $r2['id_lukisan']; ?>"> Lihat </a>
                <?php if($r2['status'] == 'tersedia') { ?>
                    <a class="btn-dark-custom btn-delete" href="transaksi.php?id_lukisan=<?php echo $r2['id_lukisan']; ?>"> Beli </a>
                <?php } else { ?>
                    <button class="btn-dark-custom" style="opacity:.5; cursor:not-allowed;" disabled> Terjual </button>
                <?php } ?>
         
                </div>

            </div>
        </div>
        <?php } ?>
<style>

    body{
        background:#050505;
        color:white;
        font-family: "Segoe UI", sans-serif;
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

    .gold-line{
        width:250px;
        height:2px;
        background:#c9a96e;
        margin:20px auto;
    }
    
    .search-section{
        display:flex;
        gap:20px;
        margin-bottom:40px;
    }

    .search-box{
        flex:1;
    }

    .search-box input{
        width:100%;
        background:transparent;
        border:1px solid rgba(255,255,255,.2);
        color:white;
        padding:15px 25px;
        border-radius:50px;
    }

    .search-box input:focus{
        outline:none;
        border-color:#c9a96e;
    }

    .btn-gold{
        background:#d9c29c;
        color:black;
        border:none;
        padding:14px 30px;
        border-radius:50px;
        font-weight:600;
    }

    .btn-gold:hover{
        background:#e6d2b2;
    }

    .gallery-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
        gap:30px;
        margin-bottom:80px;
    }

    .glass-card{
        background:rgba(255,255,255,.05);
        border:1px solid rgba(255,255,255,.15);
        backdrop-filter:blur(12px);
        border-radius:20px;
        overflow:hidden;
        transition:.4s;
    }

    .glass-card:hover{
        border-color:#c9a96e;
        transform: scale(1.05);
    }

    .glass-card:active {
        transform: scale(0.95) rotateZ(1.7deg);
    }

    .glass-card img{
        width:100%;
        height:250px;
        object-fit:cover;
    }

    .card-content{
        padding:20px;
    }

    .card-title{
        font-family:"Times New Roman", serif;
        font-size:32px;
        margin-bottom:8px;
    }

    .artist{
        color:#c7c7c7;
        margin-bottom:15px;
    }

    .price{
        color:#d9c29c;
        font-size:24px;
        font-weight:600;
        margin-bottom:20px;
    }

    .action-btns{
        display:flex;
        gap:10px;
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

    .pagination-custom{
        margin-top:60px;
        display:flex;
        justify-content:center;
        gap:15px;
    }

    .pagination-custom a{
        width:45px;
        height:45px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        color:white;
        border:1px solid rgba(255,255,255,.15);
    }

    .pagination-custom a.active{
        background:#d9c29c;
        color:black;
    }

    .image-wrapper{
        position:relative;
    }
    
    .sold-badge{
        position: absolute;
        top: 30px;
        right: -45px;
        width: 180px;
        text-align: center;

        background: #d9c29c;
        color: #000;

        transform: rotate(45deg);

        padding: 10px 0;

        font-size: 15px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;

        box-shadow: 0 6px 15px rgba(0,0,0,.4);

        z-index: 10;
    }

</style>
<script>
    const observer = new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting){ entry.target.classList.add('show'); }
            else{ entry.target.classList.remove('show'); }
        });
    },{threshold:0.2});

    document.querySelectorAll('.fade-up').forEach(el=>{
        observer.observe(el);
    });
</script>
</body>
</html>

