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
    <link rel="stylesheet" href="styles.css?v=1">
</head>

<body style="background:#0d0d0d; color:white;">

    <div class="container">

        <nav class="navbar navbar-expand-lg py-4">
            <div class="container-fluid">
                <span style="font-family:'Times New Roman',serif; font-size:35px; font-weight:bold; color:white;">
                    PPBS Gallery
                </span>
                <div class="ms-auto d-flex align-items-center gap-4">
                    <a class="text-decoration-none text-light" href="home.php">Home</a>
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

        <?php if (isset($_GET['pesan'])) { ?>
            <div class="alert alert-success">
                Pembelian berhasil dilakukan!
            </div>
            <?php header("refresh:3;url=katalog.php"); ?>
        <?php } ?>

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
        $q2 = mysqli_query($koneksi, $sql2);
        while ($r2 = mysqli_fetch_array($q2)) {
            $modalId = 'modal_' . $r2['id_lukisan'];
        ?>
            <div class="glass-card fade-up">
                <div class="image-wrapper">
                    <img src="img/<?php echo htmlspecialchars($r2['gambar']); ?>" alt="<?php echo htmlspecialchars($r2['nama_lukisan']); ?>">
                    <?php if ($r2['status'] == 'terjual') { ?>
                        <div class="sold-badge">SOLD</div>
                    <?php } ?>
                </div>
                <div class="card-content">
                    <div class="card-title"><?php echo htmlspecialchars($r2['nama_lukisan']); ?></div>
                    <div class="artist"><?php echo htmlspecialchars($r2['nama_pelukis']); ?></div>
                    <div class="price">Rp <?php echo number_format($r2['harga'], 0, ",", "."); ?></div>
                    <div class="action-btns">
                        <a class="btn-dark-custom" href="javascript:void(0)" onclick="openModal('<?= $modalId ?>')"> Lihat </a>
                        <?php if ($r2['status'] == 'tersedia') { ?>
                        <a class="btn-dark-custom btn-delete" href="transaksi.php?id_lukisan=<?php echo $r2['id_lukisan']; ?>"> Beli </a>
                        <?php } else { ?>
                            <button class="btn-dark-custom" style="opacity:.5; cursor:not-allowed;" disabled> Terjual </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>

    </div>

    <?php
    $sqlModal = "SELECT lukisan.*, pelukis.nama_pelukis FROM lukisan
                 JOIN pelukis ON lukisan.id_pelukis = pelukis.id_pelukis";
    $qModal = mysqli_query($koneksi, $sqlModal);
    while ($rm = mysqli_fetch_array($qModal)) {
        $modalId = 'modal_' . $rm['id_lukisan'];
    ?>
        <div class="modal-overlay" id="<?= $modalId ?>">
            <div class="custom-modal">
                <button class="close-btn" onclick="closeModal('<?= $modalId ?>')">✕</button>
                <div class="modal-grid">
                    <div class="modal-info">
                        <h2><?= htmlspecialchars($rm['nama_lukisan']) ?></h2>
                        <div class="modal-meta">
                            <?= htmlspecialchars($rm['nama_pelukis']) ?> &nbsp;•&nbsp; <?= htmlspecialchars($rm['tahun_dibuat']) ?>
                        </div>
                        <p class="modal-desc"><?= nl2br(htmlspecialchars($rm['deskripsi'])) ?></p>
                        <div class="modal-price">Rp <?= number_format($rm['harga'], 0, ",", ".") ?></div>
                        <?php if ($rm['status'] == 'tersedia') { ?>
                            <a class="btn-dark-custom" href="transaksi.php?id_lukisan=<?= $rm['id_lukisan'] ?>">Beli Lukisan</a>
                        <?php } else { ?>
                            <span class="sold-text">Sudah Terjual</span>
                        <?php } ?>
                    </div>
                    <div class="modal-image">
                        <img src="img/<?= htmlspecialchars($rm['gambar']) ?>" alt="<?= htmlspecialchars($rm['nama_lukisan']) ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<style>

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 80px;
}

.glass-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.15);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    overflow: hidden;
    transition: .4s;
}

.glass-card:hover {
    border-color: #c9a96e;
    transform: scale(1.05);
}

.glass-card:active {
    transform: scale(0.95) rotateZ(1.7deg);
}

.glass-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.card-content {
    padding: 20px;
}

.card-title {
    font-family: "Times New Roman", serif;
    font-size: 32px;
    margin-bottom: 8px;
}

.artist {
    color: #c7c7c7;
    margin-bottom: 10px;
}

.price {
    color: #d9c29c;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
}

.action-btns {
    display: flex;
    gap: 10px;
}

.image-wrapper {
    position: relative;
}

.sold-badge {
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

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.75);
    backdrop-filter: blur(6px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-y: auto;
}

.modal-overlay.active {
    display: flex;
}

.custom-modal {
    background: #1a1a1a;
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 24px;
    width: 100%;
    max-width: 900px;
    padding: 40px;
    position: relative;
    animation: modalIn .35s ease;
}

@keyframes modalIn {
    from { opacity: 0; transform: translateY(30px) scale(.97); }
    to   { opacity: 1; transform: translateY(0)   scale(1);    }
}

.modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.modal-info h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 48px;
    margin-bottom: 10px;
}

.modal-meta {
    color: #c9a96e;
    font-size: 18px;
    margin-bottom: 25px;
}

.modal-desc {
    color: #cfcfcf;
    line-height: 1.9;
    margin-bottom: 30px;
}

.modal-price {
    color: #bcbcbc;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 30px;
}

.modal-image {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.03);
    padding: 12px;
}

.modal-image img {
    width: 100%;
    height: auto;
    max-height: 560px;
    object-fit: contain;
    display: block;
}

.sold-text {
    color: #d4af37;
    font-weight: 600;
    font-size: 18px;
}

@media (max-width: 900px) {
    .modal-grid {
        grid-template-columns: 1fr;
    }
    .modal-image img {
        height: 300px;
    }
    .modal-info h2 {
        font-size: 36px;
    }
}

@media (max-width: 576px) {
    .custom-modal {
        padding: 24px 18px;
    }
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts.js"></script>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        }
        document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(function(m) {
                    m.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>