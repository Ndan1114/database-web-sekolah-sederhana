<?php
include "../database/konek.php";

$query = "SELECT nilai.absen, siswa.nama AS siswa_nama, mapel.nama AS mapel_nama, nilai.nilai, nilai.id_siswa 
          FROM nilai 
          JOIN siswa ON nilai.id_siswa = siswa.id_siswa 
          JOIN mapel ON nilai.id_mapel = mapel.id_mapel";

$result = mysqli_query($conn, $query);

$siswaNilai = [];

while ($row = mysqli_fetch_assoc($result)) {
    $siswaNilai[$row['id_siswa']]['nama'] = $row['siswa_nama'];
    $siswaNilai[$row['id_siswa']]['nilai'][] = $row['nilai'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
        .btn-container {
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        #search {
            width: 80%;
            max-width: 400px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        table {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
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

<h2>Daftar Nilai</h2>

<div class="btn-container">
    <a href="tambah.php" class="btn"><i class="fas fa-plus"></i> Tambah Nilai</a>
    <a href="cetak.php" class="btn" target="_blank"><i class="fas fa-print"></i> Cetak PDF</a>
</div>

<input type="text" id="search" onkeyup="filterTable()" placeholder="Cari siswa atau mata pelajaran...">

<table id="nilaiTable">
    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Mata Pelajaran</th>
        <th>Nilai</th>
        <th>Rata-rata Nilai</th>
        <th>Aksi</th>
    </tr>
    <?php
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_siswa = $row['id_siswa'];
        $rata_rata = array_sum($siswaNilai[$id_siswa]['nilai']) / count($siswaNilai[$id_siswa]['nilai']);
    ?>
    <tr>
        <td><?= $row['absen']; ?></td>
        <td><?= $row['siswa_nama']; ?></td>
        <td><?= $row['mapel_nama']; ?></td>
        <td><?= $row['nilai']; ?></td>
        <td><?= number_format($rata_rata, 2); ?></td>
        <td>
            <a href="edit.php?absen=<?= $row['absen']; ?>" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a>
            <a href="hapus.php?absen=<?= $row['absen']; ?>" class="action-btn delete-btn" onclick="return confirmDelete('<?= $row['siswa_nama']; ?>');"><i class="fas fa-trash"></i> Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete(nama) {
        return confirm("Yakin ingin menghapus nilai milik '" + nama + "'?");
    }

    function filterTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let table = document.getElementById("nilaiTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let tdNama = tr[i].getElementsByTagName("td")[1];
            let tdMapel = tr[i].getElementsByTagName("td")[2];
            if (tdNama || tdMapel) {
                let nama = tdNama.textContent || tdNama.innerText;
                let mapel = tdMapel.textContent || tdMapel.innerText;
                if (nama.toLowerCase().includes(input) || mapel.toLowerCase().includes(input)) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

</body>
</html>