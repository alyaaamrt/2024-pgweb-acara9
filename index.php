<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web GIS - Kabupaten Sleman</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            background-color: #fffbea;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Custom color scheme */
        .bg-yellow {
            background-color: #f7c945 !important;
        }

        .text-yellow {
            color: #f7c945;
        }
        
        /* Scrollable container */
        .scrollable-container {
            max-height: 500px;
            overflow-y: auto;
        }

        /* Map container */
        #map {
            width: 100%;
            height: 450px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Layout adjustments */
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .card {
            margin-top: 20px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .navbar {
            padding: 15px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            font-weight: bold;
        }

        .container {
            padding-top: 20px;
            padding-bottom: 40px;
        }

        table {
            font-size: 15px;
        }

        th {
            background-color: #f7c945;
            color: #fff;
        }

        /* Styling for table hover */
        tbody tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-yellow navbar-dark">
        <a class="navbar-brand font-weight-bold" href="#">KABUPATEN SLEMAN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#peta" onclick="openTab('peta')">Peta Kependudukan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabel" onclick="openTab('tabel')">Tabel Kependudukan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#infoModal">Informasi Pembuat</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <!-- Peta Section -->
        <div id="peta" class="content-section active">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title text-center text-yellow mb-3 font-weight-bold">Peta Kependudukan</h4>
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <!-- Tabel Kependudukan Section -->
        <div id="tabel" class="content-section">
            <div class="card bg-light scrollable-container">
                <div class="card-body">
                    <h4 class="card-title text-center text-yellow mb-3 font-weight-bold">Tabel Kependudukan</h4>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Luas (km²)</th>
                                <th>Jumlah Penduduk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Pengaturan koneksi MySQL
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "pgweb_acara8";

                            // Membuat koneksi
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Cek koneksi
                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            // Query untuk mengambil semua data dari tabel 'penduduk'
                            $sql = "SELECT * FROM penduduk";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Mengambil data dan menampilkannya dalam tabel
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['kecamatan']}</td>
                                            <td>{$row['latitude']}</td>
                                            <td>{$row['longitude']}</td>
                                            <td>{$row['luas']}</td>
                                            <td>{$row['jumlah_penduduk']}</td>
                                            <td>
                                                <a href='edit.php?kecamatan={$row['kecamatan']}' class='btn btn-sm btn-success'>Edit</a>
                                                <a href='hapus.php?kecamatan={$row['kecamatan']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada data penduduk.</td></tr>";
                            }

                            // Tutup koneksi
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Informasi Pembuat -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-yellow text-white">
                <h5 class="modal-title font-weight-bold" id="infoModalLabel">Informasi Pembuat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>Allya Miranti</p>
                    <p>PGWEB - B</p>
                    <p><a href="https://github.com/alyaaamrt" target="_blank">github.com/alyaaamrt</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS untuk Peta -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Inisialisasi peta dengan koordinat DIY (Daerah Istimewa Yogyakarta)
        var map = L.map("map").setView([-7.7956, 110.3695], 12);

        // Tile Layer Base Map
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        <?php
        // Query untuk mengambil data penduduk dan menampilkannya sebagai marker di peta
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM penduduk";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $kecamatan = $row["kecamatan"];
                $latitude = $row["latitude"];
                $longitude = $row["longitude"];
                $luas = $row["luas"];
                $jumlahPenduduk = $row["jumlah_penduduk"];
                
                echo "L.marker([$latitude, $longitude])
                .addTo(map)
                .bindPopup('<b>Kecamatan: $kecamatan</b><br>Luas: $luas km²<br>Jumlah Penduduk: $jumlahPenduduk');";
            }
        }

        $conn->close();
        ?>

        // Fungsi untuk mengaktifkan tab
        function openTab(tabName) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.remove('active'));

            document.getElementById(tabName).classList.add('active');
        }
    </script>

</body>

</html>