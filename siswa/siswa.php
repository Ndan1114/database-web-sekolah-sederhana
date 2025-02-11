<?php
include "../database/konek.php";
$query = "SELECT * FROM siswa";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #0056b3;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .search-box {
            margin-bottom: 15px;
            text-align: left;
        }
        .search-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-add {
            background-color: #28a745;
            margin-bottom: 15px;
        }
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.8;
        }
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .modal-buttons button {
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-yes {
            background-color: #dc3545;
            color: white;
        }
        .btn-no {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Siswa</h2>
    <a href="tambah.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Siswa</a>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari siswa...">
    </div>

    <table id="dataTable">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['nis']; ?></td>
            <td><?= $row['kelas']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['lahir']; ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_siswa']; ?>" class="btn btn-edit"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-delete" onclick="confirmDelete(<?= $row['id_siswa']; ?>)"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Apakah Anda yakin ingin menghapus data ini?</p>
        <div class="modal-buttons">
            <button class="btn-yes" id="confirmYes">Ya</button>
            <button class="btn-no" onclick="closeModal()">Tidak</button>
        </div>
    </div>
</div>

<script>
    // Fitur pencarian tabel
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll("#dataTable tr:not(:first-child)");

        rows.forEach(row => {
            let nama = row.cells[1].textContent.toLowerCase();
            let nis = row.cells[2].textContent.toLowerCase();
            let kelas = row.cells[3].textContent.toLowerCase();

            if (nama.includes(input) || nis.includes(input) || kelas.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // Modal Konfirmasi Hapus
    let deleteModal = document.getElementById("deleteModal");
    let confirmYes = document.getElementById("confirmYes");
    let deleteUrl = "";

    function confirmDelete(id) {
        deleteUrl = "hapus.php?id=" + id;
        deleteModal.style.display = "block";
    }

    confirmYes.onclick = function() {
        window.location.href = deleteUrl;
    };

    function closeModal() {
        deleteModal.style.display = "none";
    }

    // Menutup modal jika klik di luar modal
    window.onclick = function(event) {
        if (event.target == deleteModal) {
            closeModal();
        }
    };
</script>

</body>
</html>