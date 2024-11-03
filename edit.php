<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil kecamatan dari URL
$kecamatan = $_GET['kecamatan'];

// Query untuk mengambil data sesuai kecamatan
$sql = "SELECT * FROM penduduk WHERE kecamatan = '$kecamatan'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penduduk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff; /* Latar belakang putih */
        }

        .container {
            background-color: #ffffff; /* Latar belakang kontainer putih */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px; /* Ukuran lebar kontainer */
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: #333; /* Warna teks header */
            margin-bottom: 20px;
        }

        .form-group label {
            color: #333; /* Warna label gelap */
        }

        .btn-custom {
            background-color: #f7c945; /* Warna tombol kuning */
            color: #fff; /* Teks putih */
            border: none; /* Menghapus border */
            font-weight: bold;
            transition: background-color 0.3s ease; /* Efek transisi */
            height: 45px; /* Mengatur tinggi tombol */
            margin: 10px 0; /* Memberikan margin atas dan bawah antar tombol */
        }

        .btn-custom:hover {
            background-color: #e6b636; /* Warna saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Kecamatan</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="kecamatan" value="<?php echo $data['kecamatan']; ?>">

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" class="form-control" value="<?php echo $data['kecamatan']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" value="<?php echo $data['latitude']; ?>">
            </div>

            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" value="<?php echo $data['longitude']; ?>">
            </div>

            <div class="form-group">
                <label for="luas">Luas (km²)</label>
                <input type="text" id="luas" name="luas" class="form-control" value="<?php echo $data['luas']; ?>">
            </div>

            <div class="form-group">
                <label for="jumlah_penduduk">Jumlah Penduduk</label>
                <input type="text" id="jumlah_penduduk" name="jumlah_penduduk" class="form-control" value="<?php echo $data['jumlah_penduduk']; ?>">
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-custom btn-block">Update</button>
                <a href="index.php" class="btn btn-custom btn-block">Batal</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
