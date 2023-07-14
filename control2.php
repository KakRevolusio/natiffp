<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan semua data progamer dari database
function getprogamer()
{
    global $conn;
    $query = "SELECT * FROM progamer";
    $result = mysqli_query($conn, $query);

    $progamer = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $progamer[] = $row;
    }

    return $progamer;
}

// Fungsi untuk menambah data progamer ke database
function addprogamer($gambar, $nama, $jabatan)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "INSERT INTO progamer (gambar, nama, jabatan) VALUES ('$gambar', '$nama', '$jabatan')";
    mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data progamer di database
function editprogamer($id, $gambar, $nama, $jabatan)
{
    global $conn;
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jabatan = mysqli_real_escape_string($conn, $jabatan);

    $query = "UPDATE progamer SET gambar='$gambar', nama='$nama', jabatan='$jabatan' WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data progamer dari database
function deleteprogamer($id)
{
    global $conn;
    $query = "DELETE FROM progamer WHERE id=$id";
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

// Proses pengolahan form tambah/edit progamer
if (isset($_POST['submit_progamer'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Periksa ketersediaan 'id'
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    if (move_uploaded_file($tmp_gambar, $gambar_path)) {
        if ($id == '') {
            addprogamer($gambar, $nama, $jabatan);
        } else {
            editprogamer($id, $gambar, $nama, $jabatan);
        }
    }
}

// Proses pengolahan form hapus progamer
if (isset($_GET['delete_progamer'])) {
    $id = $_GET['delete_progamer'];
    deleteprogamer($id);
    header('Location: control2.php');
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
    header('Location: control2.php');
    exit();
}
/////////////////////////////////////////


$progamer = getprogamer();
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
    <h1>Web Control - progamer</h1>
    <h2>Manage progamer</h2>

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
            <?php foreach ($progamer as $data) { ?>
                <tr>
                    <td><?php echo $i++; ?></td></td>
                    <td><img src="uploads/<?php echo $data['gambar']; ?>" width="100" height="100"></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['jabatan']; ?></td>
                    <td>
                        <a href="control2.php?delete_progamer=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="edit4.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Add/Edit progamer</h2>
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
        <button type="submit" name="submit_progamer" class="btn btn-primary">Submit</button>
    </form>
</div>
<!--  -->
<div class="container">
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
                        <a href="control2.php?delete_marketing=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="edit5.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Edit</a>
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
</div>
</body>
</html>
