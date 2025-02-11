<?php
require_once('../tcpdf/tcpdf.php');
include "../database/konek.php";

class PDF extends TCPDF {
    // Header otomatis
    public function Header() {
        // Tambahkan logo sekolah (ganti dengan path gambar yang sesuai)
        $image_file = '../assets/logo.png'; // Ganti dengan lokasi logo Anda
        // $this->Image($image_file, 10, 10, 20, '', 'PNG');

        // Judul Laporan
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'LAPORAN NILAI SISWA', 0, 1, 'C');
        
        // Nama Sekolah
        $this->SetFont('helvetica', 'I', 12);
        $this->Cell(0, 5, 'SMK Negeri 1 Teknologi Informasi', 0, 1, 'C');
        
        // Garis bawah header
        $this->Ln(5);
        $this->Cell(190, 0, '', 'T', 1, 'C');
        $this->Ln(5);
    }

    // Footer otomatis
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 10);
        
        // Tanggal cetak
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-m-Y H:i");
        $this->Cell(0, 10, 'Dicetak pada: ' . $tanggal, 0, 0, 'L');

        // Nomor halaman
        $this->Cell(0, 10, 'Halaman ' . $this->getAliasNumPage() . ' dari ' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Buat objek PDF
$pdf = new PDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Laporan Nilai Siswa");
$pdf->SetMargins(10, 30, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// CSS untuk mempercantik tabel
$style = '
<style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #444; padding: 8px; text-align: center; }
    th { background-color: #007bff; color: white; font-weight: bold; }
    td { background-color: #f9f9f9; }
    tr:nth-child(even) td { background-color: #e9ecef; }
</style>';

// Header tabel
$html = $style . '<table>
<tr>
    <th>No Absen</th>
    <th>Nama Siswa</th>
    <th>Mata Pelajaran</th>
    <th>Nilai</th>
</tr>';

// Ambil Data
$query = "SELECT nilai.absen, siswa.nama AS siswa_nama, mapel.nama AS mapel_nama, nilai.nilai 
          FROM nilai 
          JOIN siswa ON nilai.id_siswa = siswa.id_siswa 
          JOIN mapel ON nilai.id_mapel = mapel.id_mapel";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>{$row['absen']}</td>
                <td>{$row['siswa_nama']}</td>
                <td>{$row['mapel_nama']}</td>
                <td>{$row['nilai']}</td>
              </tr>";
}

$html .= '</table>';

// Tambahkan ke PDF
$pdf->writeHTML($html);
$pdf->Output('laporan_nilai.pdf', 'I');
?>