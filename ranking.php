<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['jarak-solusi-ideal'])) {
    header('Location: jarak-solusi-ideal.php');
    exit;
} else {
    $req = $dbc->prepare("SELECT * FROM pemilihan WHERE id = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $pemilihan = $req->fetch();

    $req = $dbc->prepare("SELECT * FROM alternatif WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $alternatif = $req->fetchAll();

    $req = $dbc->prepare("SELECT * FROM jarak_solusi_ideal WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $d = $req->fetchAll();
}

$v = array();

foreach ($d as $dNilai) {
    $v[] = round($dNilai['negatif']/($dNilai['negatif']+$dNilai['positif']), 4);
}

$status = "ranking";
try {
    $dbc->beginTransaction();

    $dbc->exec("DELETE FROM ranking WHERE id_pemilihan = $_SESSION[id]");

    $req = $dbc->prepare("INSERT INTO ranking VALUES(:id, :v)");
    $req->bindValue(':id', $_SESSION['id']);

    for ($i = 0; $i < count($alternatif); $i++) {
        $req->bindValue(':v', $v[$i]);
        $req->execute();
    }

    $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
    $req->bindParam(1, $status);
    $req->bindParam(2, $_SESSION['id']);
    $req->execute();

    $dbc->commit();

    $_SESSION['ranking'] = true;
} catch (PDOException $e) {
    $dbc->rollback();
}

$page_title = 'Ranking';

include './includes/header.php';
?>

<div class="col-md-12">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
    <h3>Rangking</h3>
    <table class="table table-bordered">
        <tr>
            <th class="col-md-1">No</th>
            <th class="col-md-8">Alternatif</th>
            <th class="col-md-3">V</th>
        </tr>
        <?php

        for ($i = 0; $i < count($alternatif); $i++) {
            echo '<tr>
                    <td class="col-md-1">'.($i+1).'</td>
                    <td class="col-md-8">'.$alternatif[$i]['alternatif'].'</td>
                    <td class="col-md-3">'.$v[$i].'</td>
                </tr>';
        }
        ?>
    </table>
    <br/>
    <div class="row">
        <div class="col-md-6 text-left">
            <a class="btn btn-primary" href="jarak-solusi-ideal.php">&laquo; Jarak Solusi Ideal</a>
        </div>
        <div class="text-right">
            <a class="btn btn-primary" href="hasil.php">Hasil &raquo;</a>
        </div>
    </div>
</div>

<?php
include './includes/footer.php';
?>
