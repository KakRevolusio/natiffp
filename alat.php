<?php
include 'koneksi.php';

// Mengimpor file "koneksi.php" untuk menghubungkan ke database

// Fungsi untuk mendapatkan semua data blog dari database
function getAlat()
{
    global $conn;
    // Mendeklarasikan variabel global $conn untuk digunakan di dalam fungsi ini

    $query = "SELECT * FROM alat";
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

$alat = getAlat();
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
      Beranda -> Tentang kami -> Alat Dan Spesifikasi
    </div>
  </div>
  <div class="main-banner">
    <div class="container">
      <div class="col-8 mx-auto bg-white rounded-pill">
        <h1 class="text-center p-3 mb-2 mt-3">Alat Dan Spesifikasi</h1>
      </div>
      <div class="row">
            <?php foreach ($alat as $alatt)  : ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="uploads/<?php echo $alatt['gambar']; ?>" class="card-img-top" alt="Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $alatt['nama']; ?></h5>
                        <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $alatt['id']; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $alatt['id']; ?>">
                            Baca
                        </button>
                        <div class="collapse" id="collapse-<?php echo $alatt['id']; ?>">
                            <div class="card card-body">
                                <?php echo $alatt['spesifikasi']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
  </div>
  <?php include 'footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
