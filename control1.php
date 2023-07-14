<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan semua data alat dari database
function getAlat()
{
    global $conn;
    $query = "SELECT * FROM alat";
    $result = mysqli_query($conn, $query);

    $alat = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $alat[] = $row;
    }

    return $alat;
}

// Fungsi untuk menambah data alat ke database
function addAlat($gambar, $nama, $spesifikasi)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $spesifikasi = mysqli_real_escape_string($conn, $spesifikasi);

    $query = "INSERT INTO alat (gambar, nama, spesifikasi) VALUES ('$gambar', '$nama', '$spesifikasi')";
    mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data alat di database
function editAlat($id, $gambar, $nama, $spesifikasi)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $spesifikasi = mysqli_real_escape_string($conn, $spesifikasi);

    $query = "UPDATE alat SET gambar='$gambar', nama='$nama', spesifikasi='$spesifikasi' WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data alat dari database
function deleteAlat($id)
{
    global $conn;
    $query = "DELETE FROM alat WHERE id=$id";
    mysqli_query($conn, $query);
}

// Proses pengolahan form tambah/edit alat
if (isset($_POST['submit_alat'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Periksa ketersediaan 'id'
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;
    $nama = $_POST['nama'];
    $spesifikasi = $_POST['spesifikasi'];

    if (move_uploaded_file($tmp_gambar, $gambar_path)) {
        if ($id == '') {
            addAlat($gambar, $nama, $spesifikasi);
        } else {
            editAlat($id, $gambar, $nama, $spesifikasi);
        }
    }
}

// Proses pengolahan form hapus alat
if (isset($_GET['delete_alat'])) {
    $id = $_GET['delete_alat'];
    deleteAlat($id);
    header('Location: control1.php');
    exit();
}

$alat = getAlat();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Web Control - Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Web Control - Alat</h1>
    <h2>Manage Alat</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Spesifikasi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
            <?php foreach ($alat as $alatt) { ?>
                <tr>
                    <td><?php echo $i++; ?></td></td>
                    <td><img src="uploads/<?php echo $alatt['gambar']; ?>" width="100" height="100"></td>
                    <td><?php echo $alatt['nama']; ?></td>
                    <td><?php echo $alatt['spesifikasi']; ?></td>
                    <td>
                        <a href="control1.php?delete_alat=<?php echo $alatt['id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="edit3.php?id=<?php echo $alatt['id']; ?>" class="btn btn-primary">Edit</a>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Add/Edit Alat</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="gambar">Gambar:</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama">
        </div>
        <div class="form-group">
            <label for="spesifikasi">Spesifikasi:</label>
            <textarea class="form-control" id="spesifikasi" name="spesifikasi"></textarea>
        </div>
        <button type="submit" name="submit_alat" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
