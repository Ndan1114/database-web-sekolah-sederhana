<?php
include "../database/konek.php";

if (isset($_GET['absen'])) {
    $absen = $_GET['absen'];

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("DELETE FROM nilai WHERE absen = ?");
    $stmt->bind_param("i", $absen);

    if ($stmt->execute()) {
        echo "<script>
                alert('Nilai berhasil dihapus!');
                window.location.href = 'nilai.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus nilai.');
                window.location.href = 'nilai.php';
              </script>";
    }
    $stmt->close();
} else {
    echo "<script>
            alert('Akses tidak valid!');
            window.location.href = 'nilai.php';
          </script>";
}
?>