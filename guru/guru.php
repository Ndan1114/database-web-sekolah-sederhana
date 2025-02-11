<?php
include "../database/konek.php";
$query = "SELECT * FROM guru";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        
        /* Kotak Pencarian */
        .search-box {
            width: 90%;
            max-width: 400px;
            margin: 10px auto;
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Tombol Tambah */
        .add-btn {
            display: inline-block;
            margin: 15px 0;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .add-btn:hover {
            background: #218838;
        }

        /* Tabel */
        table {
            width: 90%;
            max-width: 800px;
            margin: 10px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }

        /* Tombol Aksi */
        .action-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .edit-btn {
            background: #ffc107;
            color: black;
        }
        .edit-btn:hover {
            background: #e0a800;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        .delete-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

<h2>Daftar Guru</h2>

<!-- Kotak Pencarian -->
<input type="text" id="searchInput" class="search-box" placeholder="🔍 Cari guru...">

<a href="tambah.php" class="add-btn"><i class="fas fa-user-plus"></i> Tambah Guru</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Mata Pelajaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="guruTable">
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['nip']; ?></td>
            <td><?= $row['mapel']; ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_guru']; ?>" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a>
                <a href="hapus.php?id=<?= $row['id_guru']; ?>" class="action-btn delete-btn" onclick="return confirmDelete('<?= $row['nama']; ?>');"><i class="fas fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    // Fungsi pencarian real-time
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#guruTable tr");

        rows.forEach(row => {
            let nama = row.cells[1].textContent.toLowerCase();
            let nip = row.cells[2].textContent.toLowerCase();
            let mapel = row.cells[3].textContent.toLowerCase();

            if (nama.includes(filter) || nip.includes(filter) || mapel.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // Konfirmasi hapus data
    function confirmDelete(nama) {
        return confirm("Yakin ingin menghapus guru '" + nama + "'?");
    }
</script>

</body>
</html>