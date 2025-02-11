<?php
include "database/konek.php";

// Menambah pengguna baru
if (isset($_POST['tambah'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengguna berhasil ditambahkan!'); window.location.href = 'administrator.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pengguna!');</script>";
    }
}

// Menghapus pengguna
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengguna berhasil dihapus!'); window.location.href = 'administrator.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pengguna!');</script>";
    }
}

// Mengedit pengguna
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $query = "UPDATE users SET username='$username', password='$password' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengguna berhasil diedit!'); window.location.href = 'administrator.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit pengguna!');</script>";
    }
}

// Menampilkan daftar pengguna
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - Kelola Pengguna</title>
    <link rel="stylesheet" type="text/css" href="hias/style.css">
</head>
<body>
    <script src="hias/script.js"></script>
    <div class="container">
        <h2>Kelola Pengguna</h2>
        <h3>Tambah Pengguna Baru</h3>
        <form action="administrator.php" method="post">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="tambah">Tambah Pengguna</button>
        </form>
        <h3>Daftar Pengguna</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['username']; ?></td>
                <td>
                    <a href="administrator.php?edit=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                    <a href="administrator.php?hapus=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirmHapus()">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $query = "SELECT * FROM users WHERE id=$id";
            $result = mysqli_query($conn, $query);
            $user = mysqli_fetch_assoc($result);
        ?>
        <h3>Edit Pengguna</h3>
        <form action="administrator.php" method="post">
            <input type="hidden" name="id" value="<?= $user['id']; ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?= $user['username']; ?>" required>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Masukkan password baru">
            <button type="submit" name="edit">Simpan Perubahan</button>
        </form>
        <?php } ?>
        <br><a href="logout.php" class="btn-logout">Logout</a>
    </div>
    <script>
        function confirmHapus() {
            return confirm('Yakin ingin menghapus pengguna ini?');
        }
    </script>
</body>
</html>