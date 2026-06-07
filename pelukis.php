<?php include 'koneksi.php';

$nama_pelukis   = "";
$email          = "";
$tahun_lahir    = "";
$sukses         = "";
$error          = "";

if(isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete') {
    $id_pelukis     = $_GET['id_pelukis'];
    $sql1           = "DELETE FROM pelukis where id_pelukis = '$id_pelukis'";
    $q1             = mysqli_query($koneksi, $sql1);
    if($q1) {
        $sukses = "Data berhasil dihapus.";
    } else {
        $error = "Gagal hapus data.";
    }
}

if($op == 'edit') {
    $id_pelukis     = $_GET['id_pelukis'];
    $sql1           = "SELECT * FROM pelukis where id_pelukis = '$id_pelukis'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nama_pelukis   = $r1['nama_pelukis'];
    $email          = $r1['email'];
    $tahun_lahir    = $r1['tahun_lahir'];
}

if(isset($_POST['submit'])) {

    $nama_pelukis = $_POST['nama_pelukis'];
    $email        = $_POST['email'];
    $tahun_lahir  = $_POST['tahun_lahir'];

    if($nama_pelukis && $email && $tahun_lahir) {

        // UPDATE
        if($op == 'edit') {
            $sql1    = "UPDATE pelukis SET nama_pelukis = '$nama_pelukis', email = '$email', tahun_lahir = '$tahun_lahir'
                        WHERE id_pelukis = '$id_pelukis'";
            $q1      = mysqli_query($koneksi, $sql1);
            if($q1) {
                $sukses = "Data berhasil diupdate.";
            } else {
                $error = "Gagal update data.";
            }

        }

        // INSERT
        else {

            $sql = "INSERT INTO pelukis (nama_pelukis, email, tahun_lahir)
                    VALUES ('$nama_pelukis', '$email', '$tahun_lahir')";

            $q1 = mysqli_query($koneksi, $sql);

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
                            <a class="text-decoration-none text-light active-link" href="pelukis.php">Pelukis</a>
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
                        <?php echo ($op == 'edit') ? 'Edit Pelukis' : 'Tambah Pelukis'; ?>
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
                            <label for="nama_pelukis" class="col-sm-2 col-form-label">Nama Pelukis</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_pelukis" name="nama_pelukis" value="<?php echo $nama_pelukis ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                            <div class="col-sm-10">
                                <input type="email" placeholder="example@gmail.com" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tahun_lahir" class="col-sm-2 col-form-label">Tahun Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tahun_lahir" name="tahun_lahir" value="<?php echo $tahun_lahir ?>">
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
            <h1>DAFTAR PELUKIS</h1>
            <div class="gold-line"></div>
        </div>

        <div class="text-end mb-4 fade-up">
            <button id="openModal" class="btn-dark-custom">
                + Tambah Pelukis
            </button>
        </div>

            <table class="table table-hover align-middle fade-up">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">ID</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Tahun Lahir</th>
                    <th scope="col">    </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2    = "SELECT * FROM pelukis order by id_pelukis desc";
                    $q2     = mysqli_query($koneksi, $sql2);
                    $urut   = 1;
                    while($r2 = mysqli_fetch_array($q2)) {
                        $id_pelukis   = $r2['id_pelukis'];
                        $nama_pelukis = $r2['nama_pelukis'];
                        $email        = $r2['email'];
                        $tahun_lahir  = $r2['tahun_lahir'];
                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $nama_pelukis ?></td>
                            <td scope="row"><?php echo $id_pelukis ?></td>
                            <td scope="row"><?php echo $email?></td>
                            <td scope="row"><?php echo $tahun_lahir ?></td>
                            <td scope="row">
                                <a class="btn-dark-custom" href="pelukis.php?op=edit&id_pelukis=<?php echo $r2['id_pelukis']; ?>">
                                    ✏
                                </a>

                                <a class="btn-dark-custom btn-delete" href="pelukis.php?op=delete&id_pelukis=<?php echo $r2['id_pelukis']; ?>"
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