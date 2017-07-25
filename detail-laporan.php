<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: laporan.php');
    exit;
}

$req = $dbc->prepare("SELECT * FROM pemilihan WHERE id = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$pemilihan = $req->fetch();

$req = $dbc->prepare("SELECT * FROM alternatif WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$alternatif = $req->fetchAll();

$req = $dbc->prepare("SELECT * FROM nilai WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$nilai = $req->fetchAll();

$req = $dbc->prepare("SELECT * FROM bobot WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$bobot = $req->fetch();

$req = $dbc->prepare("SELECT * FROM matrik_r WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$r = $req->fetchAll();

$req = $dbc->prepare("SELECT * FROM matrik_y WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$y = $req->fetchAll();

$req = $dbc->prepare("SELECT * FROM nilai_ideal WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$a = $req->fetchAll();

$req = $dbc->prepare("SELECT * FROM jarak_solusi_ideal WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$d = $req->fetchAll();

$req = $dbc->prepare("SELECT * FROM ranking WHERE id_pemilihan = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

$v = $req->fetchAll();

$page_title = 'Detail Laporan';

include './includes/header.php';
?>
<div class="col-md-12">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
    <h3>Tabel Nilai Alternatif</h3>
    <table class="table table-bordered">
        <tr>
            <td class="col-md-1">No</td>
            <th class="col-md-3">Alternatif</th>
            <th class="col-md-1">C1</th>
            <th class="col-md-1">C2</th>
            <th class="col-md-1">C3</th>
            <th class="col-md-1">C4</th>
            <th class="col-md-1">C5</th>
            <th class="col-md-1">C6</th>
        </tr>
        <?php
        for($i = 0; $i < count($alternatif); $i++) {
            echo '<tr>
                    <td class="col-md-1">'.($i+1).'</td>
                    <td class="col-md-3">'.$alternatif[$i]['alternatif'].'</td>
                    <td class="col-md-1">'.$nilai[$i]['c1'].'</td>
                    <td class="col-md-1">'.$nilai[$i]['c2'].'</td>
                    <td class="col-md-1">'.$nilai[$i]['c3'].'</td>
                    <td class="col-md-1">'.$nilai[$i]['c4'].'</td>
                    <td class="col-md-1">'.$nilai[$i]['c5'].'</td>
                    <td class="col-md-1">'.$nilai[$i]['c6'].'</td>
                </tr>';
        }
        ?>
    </table>
    <hr />
    <h3>Tabel Bobot</h3>
    <table class="table table-bordered">
        <tr>
            <th class="col-md-2">C1</th>
            <th class="col-md-2">C2</th>
            <th class="col-md-2">C3</th>
            <th class="col-md-2">C4</th>
            <th class="col-md-2">C5</th>
            <th class="col-md-2">C6</th>
        </tr>
        <?php
        echo '<tr>
                <td class="col-md-1">'.$bobot['c1'].'</td>
                <td class="col-md-1">'.$bobot['c2'].'</td>
                <td class="col-md-1">'.$bobot['c3'].'</td>
                <td class="col-md-1">'.$bobot['c4'].'</td>
                <td class="col-md-1">'.$bobot['c5'].'</td>
                <td class="col-md-1">'.$bobot['c6'].'</td>
            </tr>';
        ?>
    </table>
    <hr />
    <h3>Normalisasi Matriks R</h3>
    <table class="table table-bordered">
        <tr>
            <td class="col-md-1">No</td>
            <th class="col-md-3">Alternatif</th>
            <th class="col-md-1">C1</th>
            <th class="col-md-1">C2</th>
            <th class="col-md-1">C3</th>
            <th class="col-md-1">C4</th>
            <th class="col-md-1">C5</th>
            <th class="col-md-1">C6</th>
        </tr>
        <?php
        for($i = 0; $i < count($alternatif); $i++) {
            echo '<tr>
                    <td class="col-md-1">'.($i+1).'</td>
                    <td class="col-md-3">'.$alternatif[$i]['alternatif'].'</td>
                    <td class="col-md-1">'.$r[$i]['c1'].'</td>
                    <td class="col-md-1">'.$r[$i]['c2'].'</td>
                    <td class="col-md-1">'.$r[$i]['c3'].'</td>
                    <td class="col-md-1">'.$r[$i]['c4'].'</td>
                    <td class="col-md-1">'.$r[$i]['c5'].'</td>
                    <td class="col-md-1">'.$r[$i]['c6'].'</td>
                </tr>';
        }
        ?>
    </table>
    <hr />
    <h3>Normalisasi Matriks Y</h3>
    <table class="table table-bordered">
        <tr>
            <td class="col-md-1">No</td>
            <th class="col-md-3">Alternatif</th>
            <th class="col-md-1">C1</th>
            <th class="col-md-1">C2</th>
            <th class="col-md-1">C3</th>
            <th class="col-md-1">C4</th>
            <th class="col-md-1">C5</th>
            <th class="col-md-1">C6</th>
        </tr>
        <?php
        for($i = 0; $i < count($alternatif); $i++) {
            echo '<tr>
                    <td class="col-md-1">'.($i+1).'</td>
                    <td class="col-md-3">'.$alternatif[$i]['alternatif'].'</td>
                    <td class="col-md-1">'.$y[$i]['c1'].'</td>
                    <td class="col-md-1">'.$y[$i]['c2'].'</td>
                    <td class="col-md-1">'.$y[$i]['c3'].'</td>
                    <td class="col-md-1">'.$y[$i]['c4'].'</td>
                    <td class="col-md-1">'.$y[$i]['c5'].'</td>
                    <td class="col-md-1">'.$y[$i]['c6'].'</td>
                </tr>';
        }
        ?>
    </table>
    <hr />
    <h3>Nilai Ideal</h3>
    <table class="table table-bordered">
        <tr>
            <th class="col-md-3">Y</th>
            <th class="col-md-1">C1</th>
            <th class="col-md-1">C2</th>
            <th class="col-md-1">C3</th>
            <th class="col-md-1">C4</th>
            <th class="col-md-1">C5</th>
            <th class="col-md-1">C6</th>
        </tr>
        <?php

        foreach ($a as $ideal => $y) {
            echo '<tr>
                    <td class="col-md-2">'.ucfirst($y['ideal']).'</td>
                    <td class="col-md-1">'.$y['c1'].'</td>
                    <td class="col-md-1">'.$y['c2'].'</td>
                    <td class="col-md-1">'.$y['c3'].'</td>
                    <td class="col-md-1">'.$y['c4'].'</td>
                    <td class="col-md-1">'.$y['c5'].'</td>
                    <td class="col-md-1">'.$y['c6'].'</td>
                </tr>';
        }
        ?>
    </table>
    <hr />
    <h3>Jarak Solusi Ideal</h3>
    <table class="table table-bordered">
        <tr>
            <th class="col-md-1">No</th>
            <th class="col-md-5">Alternatif</th>
            <th class="col-md-3">Positif</th>
            <th class="col-md-3">Negatif</th>
        </tr>
        <?php

        for ($i = 0; $i < count($alternatif); $i++) {
            echo '<tr>
                    <td class="col-md-1">'.($i+1).'</td>
                    <td class="col-md-5">'.$alternatif[$i]['alternatif'].'</td>
                    <td class="col-md-3">'.$d[$i]['positif'].'</td>
                    <td class="col-md-3">'.$d[$i]['negatif'].'</td>
                </tr>';
        }
        ?>
    </table>
    <hr />
    <h3>Tabel Perankingan</h3>
    <table class="table table-bordered">
        <tr>
            <td class="col-md-1">No</td>
            <th class="col-md-3">Alternatif</th>
            <th class="col-md-1">V</th>
        </tr>
        <?php
        for($i = 0; $i < count($alternatif); $i++) {
            echo '<tr>
                    <td class="col-md-1">'.($i+1).'</td>
                    <td class="col-md-10">'.$alternatif[$i]['alternatif'].'</td>
                    <td class="col-md-1">'.$v[$i]['v'].'</td>
                </tr>';
        }
        ?>
    </table>
    <hr />
    <?php
    $hasil = array();

    for($i = 0; $i < count($alternatif); $i++) {
        $hasil[] = array(
            "alternatif" => $alternatif[$i]['alternatif'],
            "v" => $v[$i]['v']
        );
    }

    usort($hasil, function($a, $b) {
        return $a['v'] < $b['v'];
    });
    ?>
    <h3>Tabel Hasil Akhir</h3>
    <table class="table table-bordered">
        <tr>
            <th class="col-md-3">Alternatif</th>
            <th class="col-md-1">V</th>
            <td class="col-md-1">Rank</td>
        </tr>
        <?php
        for($i = 0; $i < count($hasil); $i++) {
            echo '<tr>
                    <td class="col-md-3">'.$hasil[$i]['alternatif'].'</td>
                    <td class="col-md-1">'.$hasil[$i]['v'].'</td>
                    <td class="col-md-1">'.($i+1).'</td>
                </tr>';
        }
        ?>
    </table>
</div>
<?php
include './includes/footer.php';
?>
