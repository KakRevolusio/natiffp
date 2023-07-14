<?php
// Koneksi ke database
include 'koneksi.php';

// Fungsi untuk mendapatkan data perusahaan dari database
function getPerusahaan()
{
    global $conn;
    $query = "SELECT * FROM perusahaan";
    $result = mysqli_query($conn, $query);

    $perusahaan = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $perusahaan[] = $row;
    }

    return $perusahaan;
}

// Fungsi untuk menambah data perusahaan ke database
function addPerusahaan($nama_jabatan, $gambar, $deskripsi)
{
    global $conn;
    $nama_jabatan = mysqli_real_escape_string($conn, $nama_jabatan);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    $gambar = mysqli_real_escape_string($conn, $gambar);

    $query = "INSERT INTO perusahaan (nama_jabatan, gambar, deskripsi) VALUES ('$nama_jabatan', '$gambar', '$deskripsi')";
    mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data perusahaan di database
function editPerusahaan($id, $nama_jabatan, $gambar, $deskripsi)
{
    global $conn;
    $nama_jabatan = mysqli_real_escape_string($conn, $nama_jabatan);
    $gambar = mysqli_real_escape_string($conn, $gambar);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);

    $query = "UPDATE perusahaan SET nama_jabatan='$nama_jabatan', gambar='$gambar', deskripsi='$deskripsi' WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data perusahaan dari database
function deletePerusahaan($id)
{
    global $conn;
    $query = "DELETE FROM perusahaan WHERE id=$id";
    mysqli_query($conn, $query);
}

// Proses pengolahan form tambah/edit perusahaan
if (isset($_POST['submit_perusahaan'])) {
    $id = $_POST['id'];
    $nama_jabatan = $_POST['nama_jabatan'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'uploads/' . $gambar;

    if (move_uploaded_file($tmp_gambar, $gambar_path)) {
        if ($id == '') {
            addPerusahaan($nama_jabatan, $gambar, $deskripsi);
        } else {
            editPerusahaan($id, $nama_jabatan, $gambar, $deskripsi);
        }
    }
}

// Proses pengolahan form hapus perusahaan
if (isset($_GET['delete_perusahaan'])) {
    $id = $_GET['delete_perusahaan'];
    deletePerusahaan($id);
    header('Location: control.php');
    exit();
}

$perusahaan = getPerusahaan();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Web Control - Perusahaan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Web Control - Perusahaan</h1>
        <h2>Manage Perusahaan</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Jabatan</th>
                    <th>Gambar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($perusahaan as $item) : ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $item['nama_jabatan']; ?></td>
                        <td><img src="uploads/<?php echo $item['gambar']; ?>" width="100"></td>
                        <td>
                            <a href="edit1.php?id=<?php echo $item['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="control.php?delete_perusahaan=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Add/Edit Perusahaan</h2>
        <form action="control.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="mb-3">
                <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="<?php echo isset($_GET['id']) ? $perusahaan[0]['nama_jabatan'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?php echo isset($_GET['id']) ? $perusahaan[0]['deskripsi'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
            </div>
            <button type="submit" class="btn btn-primary" name="submit_perusahaan">Submit</button>
        </form>
    </div>
</body>

</html>
