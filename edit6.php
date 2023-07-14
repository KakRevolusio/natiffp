<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan data alat berdasarkan ID
function getlapangan($id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM lapangan WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $lapangan = mysqli_fetch_assoc($result);

    return $lapangan;
}

// Fungsi untuk mengedit data alat
function editlapangan($id, $gambar, $nama, $jabatan)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "UPDATE lapangan SET gambar = '$gambar', nama = '$nama', jabatan = '$jabatan' WHERE id = '$id'";
    mysqli_query($conn, $query);
}

// Mendapatkan data alat berdasarkan ID yang dikirim melalui parameter GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $lapangan = getlapangan($id);
} else {
    // Jika tidak ada ID yang diberikan, arahkan kembali ke halaman utama
    header('Location: control2.php');
    exit();
}

// Proses pengolahan form edit alat
if (isset($_POST['submit_lapangan'])) {
    $id = $_POST['id'];
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    if (move_uploaded_file($tmp_gambar, $gambar_path)) {
        editlapangan($id, $gambar, $nama, $jabatan);
        header('Location: control3.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Web Control - Edit Alat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Web Control - Edit Alat</h1>
        <h2>Edit Alat</h2>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo  $lapangan['nama']; ?>">
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <textarea class="form-control" id="jabatan" name="jabatan"><?php echo  $lapangan['jabatan']; ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo  $lapangan['id']; ?>">
            <button type="submit" name="submit_lapangan" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
