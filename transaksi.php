<?php include 'koneksi.php';
session_start();

$id_lukisan = $_GET['id_lukisan'];

$q = mysqli_query($koneksi,"
SELECT lukisan.*, pelukis.nama_pelukis FROM lukisan
JOIN pelukis ON lukisan.id_pelukis = pelukis.id_pelukis
WHERE id_lukisan='$id_lukisan'");

$lukisan = mysqli_fetch_assoc($q);

if(isset($_POST['beli'])){
    $id_user = $_SESSION['id_user'];
    $metode = $_POST['metode'];
    mysqli_query($koneksi,"
    INSERT INTO pembelian
    (id_user, id_lukisan, tgl_beli, metode)
    VALUES
    ('$id_user', '$id_lukisan', NOW(), '$metode')");
    mysqli_query($koneksi,"UPDATE lukisan SET status='terjual' WHERE id_lukisan='$id_lukisan'");
    header("Location: katalog.php?pesan=sukses");
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
    <link rel="stylesheet" href="styles.css?v=1">
</head>

<body style="background:#0d0d0d;color:white;">

<div class="container">

    <nav class="navbar navbar-expand-lg py-4">
        <div class="container-fluid">
            <span style="font-family:'Times New Roman',serif; font-size:35px; font-weight:bold; color:white;">
                PPBS Gallery
            </span>
        </div>
    </nav>

    <div class="hero">
        <h1>PEMBELIAN LUKISAN</h1>
        <p>Selesaikan transaksi dan miliki karya seni pilihan Anda.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="glass-card">
                <img src="img/<?php echo $lukisan['gambar']; ?>" class="img-fluid rounded mb-3">
                <h3> <?php echo $lukisan['nama_lukisan']; ?> </h3>
                <p> <?php echo $lukisan['nama_pelukis']; ?> </p>
                <hr>
                <h4 class="gold">
                    Rp <?php echo number_format($lukisan['harga'],0,',','.'); ?>
                </h4>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="glass-card">
                <h4>Rincian</h4>
                <table class="detail-table">
                    <tr>
                        <td>Pesanan Atas Nama</td>
                        <td><?= $_SESSION['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>Rp <?php echo number_format($lukisan['harga'],0,',','.'); ?></td>
                    </tr>
                </table>
                <form method="POST">
                    <br>
                    <div class="mb-3">
                        <label class="form-label mb-3">Metode Pembayaran</label>
                        <div class="payment-option">
                            <input type="radio" id="bank" name="metode" value="Transfer Bank" checked>
                            <label for="bank">🏦 Transfer Bank</label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="ewallet" name="metode" value="E-Wallet">
                            <label for="ewallet">📱 E-Wallet</label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="kredit" name="metode" value="Kartu Kredit">
                            <label for="kredit">💳 Kartu Kredit</label>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex gap-3">
                        <input type="hidden" name="id_lukisan" value="<?= $lukisan['id_lukisan']; ?>">
                        <button type="submit" name="beli" class="btn-gold">Konfirmasi Pembelian</button>
                        <a href="katalog.php" class="btn btn-delete btn-transaksi-cancel">Batalkan Pembelian</a>
                    </div>
                </form>
                </form>
            </div>
        </div>
    </div>
       
    <br><br>
</div>

<style>

.gold{
    color:#d4af37;
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
    color: #d4af37;
    font-family:'Times New Roman',serif;
    margin-bottom:20px;
}

.detail-table{
    width:100%;
}

.detail-table td{
    padding:14px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.detail-table td:first-child{
    color:#9d9d9d;
    width:40%;
}

.payment-option{
    display:flex;
    align-items:center;
    gap:12px;

    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);
    border-radius:14px;

    padding:14px 18px;
    margin-bottom:12px;

    transition:.3s;
}

.payment-option:hover{
    border-color:#c9a96e;
    background:rgba(201,169,110,.08);
}

.payment-option input[type="radio"]{
    accent-color:#c9a96e;
    width:18px;
    height:18px;
}

.payment-option label{
    cursor:pointer;
    width:100%;
    color:white;
}

.btn-transaksi-cancel{
    padding:10px 60px !important;
    border-radius:14px !important;
    display:flex;
    align-items:center;
    justify-content:center;
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