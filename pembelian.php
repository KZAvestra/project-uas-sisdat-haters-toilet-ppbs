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

    $sql1 = "DELETE FROM pembelian WHERE id_pembelian = '$id_pembelian'";

    $q1 = mysqli_query($koneksi, $sql1);

    if($q1) {
        $sukses = "Data berhasil dihapus.";
    } else {
        $error = "Gagal menghapus data.";
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

    <div class="glass-card fade-up mb-5">
            <h3>Tambah / Edit Data Pembelian</h3>

        <div class="card-body">
            <?php
            if($error) {
            ?>
                <div class="alert alert-danger"> <?php echo $error ?> </div>
            <?php
                header("refresh:3;url=pembelian.php");
            }
            ?>
            <?php
            if($sukses) {
            ?>
                <div class="alert alert-success"> <?php echo $sukses ?> </div>
            <?php
                header("refresh:3;url=pembelian.php");
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
                            $lukisan = mysqli_query($koneksi, "SELECT * FROM lukisan");

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
                        <select name="id_user" class="form-control">
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

    <div class="hero fade-up">
        <h1>RIWAYAT PEMBELIAN</h1>
        <div class="gold-line"></div>
        <p>Kelola data pembelian dalam sistem inventaris galeri dengan mudah dan terstruktur.</p>
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

    .glass-card{
        max-width: 850px;
        margin: 0 auto 50px auto;

        background: rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }

    .glass-card h3{
        color:#d4af37;
        font-family:'Cormorant Garamond', serif;
        margin-bottom:20px;
    }

    .form-control,
    .form-select{
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color:white;
    }

    .form-control:focus,
    .form-select:focus{
        background: rgba(255,255,255,0.08);
        color:white;
        border-color:#d4af37;
        box-shadow:none;
    }

    .form-select option{
        background:#111;
        color:white;
    }

    .table{
        color:white;
    }

    .table th,
    .table td {
        padding: 20px;
    }

    .table thead th{
        color: #929292;
        border-bottom: 1px solid rgba(255,255,255,0.15);
        font-weight: 500;
    }

    .table-hover tbody tr{
        transition: all .25s ease;
    }

    .table-hover tbody tr:hover{
        background: rgba(212,175,55,0.08);
    }

    .table-hover tbody tr:hover td,
    .table-hover tbody tr:hover th{
        color: white;
    }
    
    .btn-dark-custom{
        flex:1;
        background:transparent;
        border:1px solid rgba(255,255,255,.15);
        border-color:#c9a96e;
        color:#c9a96e;
        border-radius:12px;
        padding:10px;
        text-decoration:none;
        text-align:center;
        margin: 5px;
    }

    .btn-dark-custom:hover{
        background:#c9a96e;
        color:white;
    }

    .btn-delete{
        border-color:#dc3545;
        color:#dc3545;
    }

    .btn-delete:hover{
        background:#dc3545;
        color:white;
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