<?php include 'koneksi.php';

$tgl_beli      = "";
$id_lukisan    = "";
$id_user       = "";

$sukses        = "";
$error         = "";

if(isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete') {

    $id_pembelian = $_GET['id_pembelian'];

    $cek = mysqli_query($koneksi, "SELECT id_lukisan FROM pembelian WHERE id_pembelian='$id_pembelian'");

    $data = mysqli_fetch_assoc($cek);

    if($data){
        mysqli_query($koneksi, "UPDATE lukisan SET status='tersedia' WHERE id_lukisan='".$data['id_lukisan']."'");

        $sql1 = "DELETE FROM pembelian WHERE id_pembelian='$id_pembelian'";

        $q1 = mysqli_query($koneksi, $sql1);

        if($q1) {
            $sukses = "Data berhasil dihapus.";
        } else {
            $error = "Gagal menghapus data.";
        }
    } else {
        $error = "Data pembelian tidak ditemukan.";
    }
}

if($op == 'edit') {

    $id_pembelian = $_GET['id_pembelian'];

    $sql1 = "SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian'";

    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    $tgl_beli   = $r1['tgl_beli'];
    $id_lukisan = $r1['id_lukisan'];
    $id_user    = $r1['id_user'];
}

if(isset($_POST['submit'])) {

    $tgl_beli   = $_POST['tgl_beli'];
    $id_lukisan = $_POST['id_lukisan'];
    $id_user    = $_POST['id_user'];

    if($tgl_beli && $id_lukisan && $id_user) {

        if($op == 'edit') {

            $sql1 = "UPDATE pembelian SET
                        tgl_beli = '$tgl_beli',
                        id_lukisan = '$id_lukisan',
                        id_user = '$id_user'
                    WHERE id_pembelian = '$id_pembelian'";

            $q1 = mysqli_query($koneksi, $sql1);

            if($q1) {
                $sukses = "Data berhasil diupdate.";
            } else {
                $error = "Gagal update data.";
            }

        } else {

            $sql1 = "INSERT INTO pembelian (tgl_beli, id_lukisan, id_user)
                    VALUES ('$tgl_beli', '$id_lukisan', '$id_user')";

            $q1 = mysqli_query($koneksi, $sql1);

            if($q1) {
                $sukses = "Berhasil menambahkan data.";
            } else {
                $error = "Gagal menambahkan data.";
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
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                            <a class="text-decoration-none text-light" href="lukisan.php">Lukisan</a>
                            <a class="text-decoration-none text-light" href="pelukis.php">Pelukis</a>
                            <a class="text-decoration-none text-light active-link" href="pembelian.php">Pembelian</a>
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
                        <?php echo ($op == 'edit') ? 'Edit Pembelian' : 'Tambah Pembelian'; ?>
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

                    <form action="" method="POST">

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label"> Tanggal Beli </label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tgl_beli" value="<?php echo $tgl_beli ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label"> Lukisan </label>
                            <div class="col-sm-10">
                                <select name="id_lukisan" class="form-select">
                                    <option value=""> -- Pilih Lukisan -- </option>
                                    <?php
                                    $lukisan = mysqli_query($koneksi, "SELECT * FROM lukisan WHERE status='tersedia'");

                                    while($l = mysqli_fetch_array($lukisan)) {
                                        $selected = "";
                                        if($id_lukisan == $l['id_lukisan']) {
                                            $selected = "selected";
                                        }
                                        echo " <option value='{$l['id_lukisan']}' $selected> {$l['nama_lukisan']} </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label"> Pembeli </label>
                            <div class="col-sm-10">
                                <select name="id_user" class="form-select">
                                    <option value=""> -- Pilih User -- </option>
                                    <?php
                                    $user = mysqli_query($koneksi, "SELECT * FROM user");

                                    while($u = mysqli_fetch_array($user)) {
                                        $selected = "";
                                        if($id_user == $u['id_user']) {
                                            $selected = "selected";
                                        }
                                        echo "<option value='{$u['id_user']}' $selected> {$u['username']} </option>";
                                    }
                                    ?>
                                </select>
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
        <h1>RIWAYAT PEMBELIAN</h1>
        <div class="gold-line"></div>
    </div>

        <div class="text-end mb-4 fade-up">
            <button id="openModal" class="btn-dark-custom">
                + Tambah Pembelian
            </button>
        </div>

            <table class="table table-hover align-middle fade-up">
                <thead>
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nama Lukisan</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">    </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT pembelian.*, lukisan.nama_lukisan, user.username FROM pembelian
                             JOIN lukisan ON pembelian.id_lukisan = lukisan.id_lukisan
                             JOIN user ON pembelian.id_user = user.id_user
                             ORDER BY id_pembelian DESC";
                    $q2 = mysqli_query($koneksi, $sql2);
                    while($r2 = mysqli_fetch_array($q2)) {
                        ?>
                        <tr>
                            <td scope="row"> <?php echo $r2['id_pembelian'] ?> </td>
                            <td scope="row"> <?php echo $r2['tgl_beli'] ?> </td>
                            <td scope="row"> <?php echo $r2['nama_lukisan'] ?> </td>
                            <td scope="row"> <?php echo $r2['username'] ?> </td>
                            <td scope="row">
                                <a class="btn-dark-custom" href="pembelian.php?op=edit&id_pembelian=<?php echo $r2['id_pembelian']; ?>">
                                    ✏
                                </a>

                                <a class="btn-dark-custom btn-delete" href="pembelian.php?op=delete&id_pembelian=<?php echo $r2['id_pembelian']; ?>"
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
        <br><br>
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