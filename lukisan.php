<?php include 'koneksi.php';

$nama_lukisan   = "";
$deskripsi      = "";
$tahun_dibuat   = "";
$id_pelukis     = "";
$harga          = "";
$gambar         = "";
$sukses         = "";
$error          = "";

if(isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete') {
    $id_lukisan = $_GET['id_lukisan'];

    $sql1 = "DELETE FROM lukisan WHERE id_lukisan = '$id_lukisan'";
    $q1   = mysqli_query($koneksi, $sql1);

    if($q1) {
        $sukses = "Data berhasil dihapus.";
    } else {
        $error = "Gagal hapus data.";
    }
}

if($op == 'edit') {
    $id_lukisan = $_GET['id_lukisan'];

    $sql1 = "SELECT * FROM lukisan WHERE id_lukisan = '$id_lukisan'";
    $q1   = mysqli_query($koneksi, $sql1);
    $r1   = mysqli_fetch_array($q1);

    $nama_lukisan = $r1['nama_lukisan'];
    $deskripsi    = $r1['deskripsi'];
    $tahun_dibuat = $r1['tahun_dibuat'];
    $id_pelukis   = $r1['id_pelukis'];
    $harga        = $r1['harga'];
    $gambar       = $r1['gambar'];
}

if(isset($_POST['submit'])) {

    $nama_lukisan = $_POST['nama_lukisan'];
    $deskripsi    = $_POST['deskripsi'];
    $tahun_dibuat = $_POST['tahun_dibuat'];
    $id_pelukis   = $_POST['id_pelukis'];
    $harga        = $_POST['harga'];

    $gambar_lama = $_POST['gambar_lama'];

    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    $folder    = "img/";

    if($nama_file != "") {
        move_uploaded_file($tmp_file, $folder . $nama_file);
    } else {
        $nama_file = $gambar_lama;
    }

    if($nama_lukisan && $deskripsi && $tahun_dibuat && $id_pelukis && $harga) {
        if($op == 'edit') {

            $sql1 = "UPDATE lukisan SET
                        nama_lukisan = '$nama_lukisan',
                        deskripsi = '$deskripsi',
                        tahun_dibuat = '$tahun_dibuat',
                        id_pelukis = '$id_pelukis',
                        harga = '$harga',
                        gambar = '$nama_file'
                     WHERE id_lukisan = '$id_lukisan'";

            $q1 = mysqli_query($koneksi, $sql1);

            if($q1) {
                $sukses = "Data berhasil diupdate.";
            } else {
                $error = "Gagal update data.";
            }

        } else {

            $sql1 = "INSERT INTO lukisan (nama_lukisan, deskripsi, tahun_dibuat, id_pelukis, harga, gambar)
                    VALUES('$nama_lukisan', '$deskripsi', '$tahun_dibuat', '$id_pelukis', '$harga', '$nama_file')";

            $q1 = mysqli_query($koneksi, $sql1);

            if($q1) {
                $sukses = "Berhasil memasukkan data baru.";
            } else {
                $error = "Gagal memasukkan data.";
            }
        }

    } else {
        $error = "Semua data wajib diisi.";
    }
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
                            <a class="text-decoration-none text-light active-link" href="lukisan.php">Lukisan</a>
                            <a class="text-decoration-none text-light" href="pelukis.php">Pelukis</a>
                            <a class="text-decoration-none text-light" href="pembelian.php">Pembelian</a>
                        <a class="btn btn-light rounded-pill px-4"
                            href="logout.php"
                            onclick="return confirm('Yakin mau logout?')">
                            Logout
                        </a>
                    </div>
                </div>
            </nav>

        <div class="modal-container" id="modalContainer">
            <div class="custom-modal">
                <div class="modal-header-custom">
                    <h3>
                        <?php echo ($op == 'edit') ? 'Edit Lukisan' : 'Tambah Lukisan'; ?>
                    </h3>

                    <button id="closeModal" class="close-btn">
                        ✕
                    </button>
                </div>

                <div class="modal-body-custom">
                     <?php
                    if($error) {
                    ?>
                        <div class="alert alert-danger" role="alert"> <?php echo $error ?> </div>
                    <?php
                        header("refresh:3;url=lukisan.php");
                    }
                    ?>
                    <?php
                    if($sukses) {
                    ?>
                        <div class="alert alert-success" role="alert"> <?php echo $sukses ?> </div>
                    <?php
                        header("refresh:3;url=lukisan.php");
                    }
                    ?>

                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="mb-3 row">
                            <label for="nama_lukisan" class="col-sm-2 col-form-label">Nama Lukisan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_lukisan" name="nama_lukisan" value="<?php echo $nama_lukisan ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?php echo $deskripsi ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tahun_dibuat" class="col-sm-2 col-form-label">Tahun Dibuat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tahun_dibuat" name="tahun_dibuat" value="<?php echo $tahun_dibuat ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="id_pelukis" class="col-sm-2 col-form-label">Pelukis</label>
                            <div class="col-sm-10">
                                <select name="id_pelukis" class="form-select">
                                    <option value="">-- Pilih Pelukis --</option>
                                    <?php
                                    $pel = mysqli_query($koneksi, "SELECT * FROM pelukis");
                                    while($p = mysqli_fetch_array($pel)) {
                                        $selected = "";
                                        if($id_pelukis == $p['id_pelukis']) {
                                            $selected = "selected";
                                        }
                                        echo "
                                            <option value='{$p['id_pelukis']}' $selected>
                                                {$p['nama_pelukis']}
                                            </option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="harga" class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" accept=".jpg, .jpeg, .png" class="form-control" id="gambar" name="gambar">
                                <input type="hidden" name="gambar_lama" value="<?php echo $gambar ?>">
                            </div>
                        </div>

                        <div class="col-12">
                            <input type="submit" name="submit" value="Submit" class="btn-dark-custom">
                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="hero fade-up">
            <h1>KOLEKSI LUKISAN</h1>
            <div class="gold-line"></div>
        </div>

        <div class="text-end mb-4 fade-up">
            <button id="openModal" class="btn-dark-custom">
                + Tambah Lukisan
            </button>
        </div>

               <table class="table table-hover align-middle fade-up">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Lukisan</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Tahun Dibuat</th>
                    <th scope="col">Pelukis</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Status</th>
                    <th scope="col">    </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2    = "SELECT lukisan.*, pelukis.nama_pelukis FROM lukisan
                                JOIN pelukis ON lukisan.id_pelukis = pelukis.id_pelukis order by id_lukisan desc";
                    $q2     = mysqli_query($koneksi, $sql2);
                    $urut   = 1;
                    while($r2 = mysqli_fetch_array($q2)) {
                        $id_lukisan   = $r2['id_lukisan'];
                        $nama_lukisan = $r2['nama_lukisan'];
                        $deskripsi    = $r2['deskripsi'];
                        $tahun_dibuat = $r2['tahun_dibuat'];
                        $nama_pelukis = $r2['nama_pelukis'];
                        $harga        = $r2['harga'];
                        $gambar       = $r2['gambar'];
                        $status       = $r2['status'];
                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $nama_lukisan ?></td>
                            <td scope="row"><?php echo $deskripsi ?></td>
                            <td scope="row"><?php echo $tahun_dibuat ?></td>
                            <td scope="row"><?php echo $nama_pelukis ?></td>
                            <td scope="row"> Rp<?php echo number_format($harga,0,',','.') ?></td>
                            <td scope="row">
                                <img src="img/<?php echo $gambar; ?>" style="width:120px;
                                                                            height:120px;
                                                                            object-fit:cover;
                                                                            border-radius:16px;
                                                                            border:1px solid rgba(255,255,255,.1);
                                                                            transition:.3s;">
                            </td>
                            <td scope="row"><?php echo $status ?></td>
                            <td scope="row">
                                <a class="btn-dark-custom" href="lukisan.php?op=edit&id_lukisan=<?php echo $r2['id_lukisan']; ?>">
                                    ✏
                                </a>

                                <a class="btn-dark-custom btn-delete" href="lukisan.php?op=delete&id_lukisan=<?php echo $r2['id_lukisan']; ?>"
                                onclick="return confirm('Hapus data ini?')">
                                    🗑
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
                </table>
                </div>

                <br><br>
                
        </div>


    </div>

    <script src="scripts.js"></script>
    <?php if($op == 'edit') { ?>
    <script>
    window.onload = function(){
        document.getElementById("modalContainer").classList.add("show");
    }
    </script>
    <?php } ?>
</body>
</html>