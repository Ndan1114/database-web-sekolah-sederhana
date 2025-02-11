<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: ../login.php"); 
        exit();
    }

    include '../database/konek.php';

    // Mengambil jumlah total siswa
    $query_siswa = "SELECT COUNT(*) AS total_siswa FROM siswa";
    $result_siswa = mysqli_query($conn, $query_siswa);
    $data_siswa = mysqli_fetch_assoc($result_siswa);
    $total_siswa = $data_siswa['total_siswa'];

    // Mengambil jumlah total guru
    $query_guru = "SELECT COUNT(*) AS total_guru FROM guru";
    $result_guru = mysqli_query($conn, $query_guru);
    $data_guru = mysqli_fetch_assoc($result_guru);
    $total_guru = $data_guru['total_guru'];

    // Mengambil jumlah total mata pelajaran
    $query_mapel = "SELECT COUNT(*) AS total_mapel FROM mapel";
    $result_mapel = mysqli_query($conn, $query_mapel);
    $data_mapel = mysqli_fetch_assoc($result_mapel);
    $total_mapel = $data_mapel['total_mapel'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }
        .sidebar .fa-chevron-down {
            transition: transform 0.3s ease;
        }
        .sidebar .fa-chevron-down.active {
            transform: rotate(180deg);
        }
        .sidebar {
            width: 250px;
            background-color: #0056b3;
            color: white;
            position: fixed;
            height: 100vh;
            padding-top: 70px;
            transition: 0.3s;
            left: -250px;
            top: 0;
            z-index: 999;
        }
        .sidebar .dropdown {
            display: none;
            background: #004080;
        }
        .sidebar .dropdown a {
            padding-left: 30px;
            display: block;
            font-size: 16px;
        }
        .sidebar .arrow {
            float: right;
            transition: transform 0.3s;
        }
        .sidebar .dropdown.active {
            display: block;
        }
        .sidebar .arrow.active {
            transform: rotate(180deg);
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .sidebar b {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dropdown-content {
            display: none;
            background: #004080;
            padding-left: 20px;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
            opacity: 0;
        }
        .dropdown-content a {
            font-size: 16px;
        }
        .show {
            display: block;
        }
        .sidebar a:hover {
            background: #003f80;
        }
        .sidebar i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s;
            min-height: 80vh;
        }
        .main-content.active {
            margin-left: 250px;
        }
        .topbar {
            background: #0056b3;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        .dropdown-content.show {
            display: block;
            max-height: 500px;
            opacity: 1;
        }
        .profile {
            display: flex;
            align-items: center;
            margin-left: 10px;
        }
        .profile span {
            margin-right: 10px;
            font-weight: bold;
            white-space: nowrap;
        }
        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 80px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33.333% - 20px);
            text-align: center;
        }
        .card h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #0056b3;
        }
        footer {
            background: #0056b3;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            margin-left: 20px;
            flex-grow: 1;
        }
    </style>
</head>
<body>

    <div class="topbar">
        <button class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <div class="greeting">
            <?= "Selamat datang, " . $_SESSION['username']; ?>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <a onclick="toggleDropdown('siswa-dropdown')"><i class="fas fa-users"></i> Data Siswa <i class="fas fa-chevron-down right"></i></a>
        <div class="dropdown-content" id="siswa-dropdown">
            <a onclick="loadPage('../siswa/siswa.php')">Data Siswa</a>
            <a onclick="loadPage('../siswa/tambah.php')">Tambah Siswa</a>
        </div>

        <a onclick="toggleDropdown('guru-dropdown')"><i class="fas fa-chalkboard-teacher"></i> Data Guru <i class="fas fa-chevron-down right"></i></a>
        <div class="dropdown-content" id="guru-dropdown">
            <a onclick="loadPage('../guru/guru.php')">Data Guru</a>
            <a onclick="loadPage('../guru/tambah.php')">Tambah Guru</a>
        </div>
        
        <a onclick="toggleDropdown('nilai-dropdown')"><i class="fas fa-chart-line"></i> Nilai Siswa <i class="fas fa-chevron-down right"></i></a>
        <div class="dropdown-content" id="nilai-dropdown">
            <a onclick="loadPage('../nilai/nilai.php')">Data Nilai</a>
            <a onclick="loadPage('../nilai/tambah.php')">Tambah Nilai</a>
        </div>

        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content" id="main-content">
        <div class="card-container">
            <div class="card">
                <h3>Total Siswa</h3>
                <p><?= $total_siswa; ?></p>
            </div>
            <div class="card">
                <h3>Data Guru</h3>
                <p><?= $total_guru; ?></p>
            </div>
            <div class="card">
                <h3>Data Mapel</h3>
                <p><?= $total_mapel; ?></p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Sistem Informasi Sekolah</p>
    </footer>

    <script>
        // Fungsi untuk toggle sidebar
        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('main-content');

            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');

            // Simpan status sidebar ke localStorage
            if (sidebar.classList.contains('active')) {
                localStorage.setItem('sidebarState', 'active');
            } else {
                localStorage.setItem('sidebarState', 'inactive');
            }
        }

        function toggleDropdown(id) {
            let selectedDropdown = document.getElementById(id);
            let allDropdowns = document.querySelectorAll('.dropdown-content');
            let allArrows = document.querySelectorAll('.sidebar a i.fas.fa-chevron-down');

            allDropdowns.forEach(dropdown => {
                if (dropdown !== selectedDropdown) {
                    dropdown.style.maxHeight = '0';
                    dropdown.style.opacity = '0';
                    setTimeout(() => {
                        dropdown.classList.remove('show');
                    }, 300);
                }
            });

            allArrows.forEach(arrow => {
                if (!selectedDropdown.classList.contains('show')) {
                    arrow.classList.remove('active');
                }
            });

            if (selectedDropdown.classList.contains('show')) {
                selectedDropdown.style.maxHeight = '0';
                selectedDropdown.style.opacity = '0';
                setTimeout(() => {
                    selectedDropdown.classList.remove('show');
                }, 300);
            } else {
                selectedDropdown.classList.add('show');
                selectedDropdown.style.maxHeight = selectedDropdown.scrollHeight + 'px';
                selectedDropdown.style.opacity = '1';

                // Menambahkan efek rotasi pada ikon panah
                let arrow = selectedDropdown.previousElementSibling.querySelector('.fas.fa-chevron-down');
                if (arrow) {
                    arrow.classList.add('active');
                }
            }
        }

        // Fungsi untuk load halaman dengan AJAX (kecuali dashboard)
        function loadPage(page) {
            if (page === 'dashboard.php') {
                window.location.href = 'dashboard.php'; 
            } else {
                fetch(page)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('main-content').innerHTML = data;
                })
                .catch(error => console.error('Error loading page:', error));
            }
        }

        // Saat halaman dimuat, periksa status sidebar di localStorage
        document.addEventListener('DOMContentLoaded', function () {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('main-content');

            if (localStorage.getItem('sidebarState') === 'active') {
                sidebar.classList.add('active');
                mainContent.classList.add('active');
            }
        });
    </script>

</body>
</html>
