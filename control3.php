<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan semua data lapangan dari database
function getlapangan()
{
    global $conn;
    $query = "SELECT * FROM lapangan";
    $result = mysqli_query($conn, $query);

    $lapangan = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $lapangan[] = $row;
    }

    return $lapangan;
}

// Fungsi untuk menambah data lapangan ke database
function addlapangan($gambar, $nama, $jabatan)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "INSERT INTO lapangan (gambar, nama, jabatan) VALUES ('$gambar', '$nama', '$jabatan')";
    mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data lapangan di database
function editlapangan($id, $gambar, $nama, $jabatan)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "UPDATE lapangan SET gambar='$gambar', nama='$nama', jabatan='$jabatan' WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data lapangan dari database
function deletelapangan($id)
{
    global $conn;
    $query = "DELETE FROM lapangan WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fungsi untuk mendapatkan semua data marketing dari database
function getmarketing()
{
    global $conn;
    $query = "SELECT * FROM marketing";
    $result = mysqli_query($conn, $query);

    $marketing = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $marketing[] = $row;
    }

    return $marketing;
}

// Fungsi untuk menambah data marketing ke database
function addmarketing($gambar, $nama, $jabatan)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "INSERT INTO marketing (gambar, nama, jabatan) VALUES ('$gambar', '$nama', '$jabatan')";
    mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data marketing di database
function editmarketing($id, $gambar, $nama, $jabatan)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "UPDATE marketing SET gambar='$gambar', nama='$nama', jabatan='$jabatan' WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data marketing dari database
function deletemarketing($id)
{
    global $conn;
    $query = "DELETE FROM marketing WHERE id=$id";
    mysqli_query($conn, $query);
}

// Proses pengolahan form tambah/edit lapangan
if (isset($_POST['submit_lapangan'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Periksa ketersediaan 'id'
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    if (move_uploaded_file($tmp_gambar, $gambar_path)) {
        if ($id == '') {
            addlapangan($gambar, $nama, $jabatan);
        } else {
            editlapangan($id, $gambar, $nama, $jabatan);
        }
    }
}

// Proses pengolahan form hapus lapangan
if (isset($_GET['delete_lapangan'])) {
    $id = $_GET['delete_lapangan'];
    deletelapangan($id);
    header('Location: control3.php');
    exit();
}

// Proses pengolahan form tambah/edit marketing
if (isset($_POST['submit_marketing'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Periksa ketersediaan 'id'
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    if (move_uploaded_file($tmp_gambar, $gambar_path)) {
        if ($id == '') {
            addmarketing($gambar, $nama, $jabatan);
        } else {
            editmarketing($id, $gambar, $nama, $jabatan);
        }
    }
}

// Proses pengolahan form hapus marketing
if (isset($_GET['delete_marketing'])) {
    $id = $_GET['delete_marketing'];
    deletemarketing($id);
    header('Location: control3.php');
    exit();
}
/////////////////////////////////////////


$lapangan = getlapangan();
$marketing = getmarketing();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Web Control - Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Web Control - lapangan</h1>
    <h2>Manage lapangan</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
            <?php foreach ($lapangan as $data) { ?>
                <tr>
                    <td><?php echo $i++; ?></td></td>
                    <td><img src="uploads/<?php echo $data['gambar']; ?>" width="100" height="100"></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['jabatan']; ?></td>
                    <td>
                        <a href="control3.php?delete_lapangan=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="edit6.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Add/Edit lapangan</h2>
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
            <label for="jabatan">Jabatan:</label>
            <textarea class="form-control" id="jabatan" name="jabatan"></textarea>
        </div>
        <button type="submit" name="submit_lapangan" class="btn btn-primary">Submit</button>
    </form>
</div>
<!--  -->
<!-- <div class="container">
    <h1>Web Control - marketing</h1>
    <h2>Manage marketing</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
            <?php foreach ($marketing as $data) { ?>
                <tr>
                    <td><?php echo $i++; ?></td></td>
                    <td><img src="uploads/<?php echo $data['gambar']; ?>" width="100" height="100"></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['jabatan']; ?></td>
                    <td>
                        <a href="control3.php?delete_marketing=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="edit6.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Add/Edit marketing</h2>
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
            <label for="jabatan">Jabatan:</label>
            <textarea class="form-control" id="jabatan" name="jabatan"></textarea>
        </div>
        <button type="submit" name="submit_marketing" class="btn btn-primary">Submit</button>
    </form>
</div> -->
</body>
</html>
