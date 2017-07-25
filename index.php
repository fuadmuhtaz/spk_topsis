<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include './includes/header.php';
?>

<div class="col-md-12">
    <div class="page-header">
        <h1>SPK Penerimaan Karyawan dengan Metode TOPSIS Pada Blizzard Entertainment Ltd.</h1>
    </div>
    <h3>Kriteria karyawan yang dibutuhkan</h3>
    <table class="table table-bordered">
      <tr>
          <th>Kode</th>
          <th>Nama Kriteria</th>
          <th>Atribut</th>
          <th>Nilai</th>
      </tr>
      <tr>
          <td>C1</td>
          <td>Pengalaman menggunakan PHP</td>
          <td>Benefit</td>
          <td>6 - 60 (bulan)</td>
      </tr>
      <tr>
          <td>C2</td>
          <td>Pengalaman menggunakan MySQL</td>
          <td>Benefit</td>
          <td>6 - 60 (bulan)</td>
      </tr>
      <tr>
          <td>C3</td>
          <td>Proyek menggunakan PHP dan MySQL</td>
          <td>Benefit</td>
          <td>1 - ... (proyek)</td>
      </tr>
      <tr>
          <td>C4</td>
          <td>Besar gaji</td>
          <td>Cost</td>
          <td>3 - 15 (juta)</td>
      </tr>
      <tr>
          <td>C5</td>
          <td>Jarak tempat tinggal</td>
          <td>Cost</td>
          <td>1 - 30 (km)</td>
      </tr>
      <tr>
          <td>C6</td>
          <td>Umur</td>
          <td>Cost</td>
          <td>20 - 40 (tahun)</td>
      </tr>
    </table>
    <p class="text-right"><a href="informasi-pemilihan.php" class="btn btn-primary">Mulai</a></p>
</div>
<?php
include './includes/footer.php';
?>
