<?php
include 'koneksi.php';

// Mengimpor file "koneksi.php" untuk menghubungkan ke database

// Fungsi untuk mendapatkan semua data blog dari database
function getPerusahaan()
{
    global $conn;
    // Mendeklarasikan variabel global $conn untuk digunakan di dalam fungsi ini

    $query = "SELECT * FROM perusahaan";
    // Query SQL untuk mengambil semua data dari tabel "posts"

    $result = mysqli_query($conn, $query);
    // Menjalankan query SQL menggunakan objek koneksi database ($conn) dan menyimpan hasilnya dalam variabel $result

    $posts = [];
    // Membuat array kosong dengan nama $posts untuk menyimpan data blog

    while ($row = mysqli_fetch_assoc($result)) {
        // Melakukan perulangan untuk setiap baris data yang diambil dari hasil query

        $posts[] = $row;
        // Menambahkan baris data ke dalam array $posts
    }

    return $posts;
    // Mengembalikan array $posts yang berisi semua data blog
}

$perusahaan = getPerusahaan();
// Memanggil fungsi getPosts() untuk mendapatkan semua data blog dari database dan menyimpannya dalam variabel $posts
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Struktur Perusahaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <style>
    .main-banner {
      background-image: url(./aset/KantorTelkom.jpg);
      height: auto;
      width: auto;
      padding: 10px 200px;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php' ?>
  <div class="row">
    <div class="col bg-danger text-white">
      Beranda -> Tentang kami -> Struktur Perusahaan
    </div>
  </div>
  <div class="main-banner">
    <div class="container">
      <div class="col-8 mx-auto bg-white rounded-pill">
        <h1 class="text-center p-3 mb-2 mt-3">Struktur Perusahaan</h1>
      </div>
      <div class="row">
        <?php foreach ($perusahaan as $perusahaan) : ?>
          <div class="col-md-4">
            <div class="card">
              <img src="uploads/<?php echo $perusahaan['gambar']; ?>" width="150" height="200" class="card-img-top" alt="Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $perusahaan['nama_jabatan']; ?></h5>
                <p class="card-text"><?php echo $perusahaan['deskripsi']; ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <?php include 'footer.php' ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
