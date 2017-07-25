<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['nilai-ideal'])) {
    header('Location: nilai-ideal.php');
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

    $req = $dbc->prepare("SELECT * FROM matrik_y WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $matrik_y = $req->fetchAll();

    $req = $dbc->prepare("SELECT * FROM nilai_ideal WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $a = $req->fetchAll();
    $a['positif'] = $a[0];
    $a['negatif'] = $a[1];
}

$d = array();

foreach ($matrik_y as $nilai) {
    $sum = pow($a['positif']['c1']-$nilai['c1'], 2) + pow($a['positif']['c2']-$nilai['c2'], 2) + pow($a['positif']['c3']-$nilai['c3'], 2)
            + pow($a['positif']['c4']-$nilai['c4'], 2) + pow($a['positif']['c5']-$nilai['c5'], 2) + pow($a['positif']['c6']-$nilai['c6'], 2);
    $d['positif'][] = round(sqrt($sum), 4);

    $sum = pow($nilai['c1']-$a['negatif']['c1'], 2) + pow($nilai['c2']-$a['negatif']['c2'], 2) + pow($nilai['c3']-$a['negatif']['c3'], 2)
            + pow($nilai['c4']-$a['negatif']['c4'], 2) + pow($nilai['c5']-$a['negatif']['c5'], 2) + pow($nilai['c6']-$a['negatif']['c6'], 2);
    $d['negatif'][] = round(sqrt($sum), 4);
}

$status = "jarak-solusi-ideal";
try {
    $dbc->beginTransaction();

    $dbc->exec("DELETE FROM jarak_solusi_ideal WHERE id_pemilihan = $_SESSION[id]");

    $req = $dbc->prepare("INSERT INTO jarak_solusi_ideal VALUES(:id, :positif, :negatif)");
    $req->bindValue(':id', $_SESSION['id']);

    for ($i = 0; $i < count($alternatif); $i++) {
        $req->bindValue(':positif', $d['positif'][$i]);
        $req->bindValue(':negatif', $d['negatif'][$i]);
        $req->execute();
    }

    $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
    $req->bindParam(1, $status);
    $req->bindParam(2, $_SESSION['id']);
    $req->execute();

    $dbc->commit();

    $_SESSION['jarak-solusi-ideal'] = true;
} catch (PDOException $e) {
    $dbc->rollback();
}

$page_title = 'Jarak Solusi Ideal';

include './includes/header.php';
?>

<div class="col-md-12">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
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
                    <td class="col-md-3">'.$d['positif'][$i].'</td>
                    <td class="col-md-3">'.$d['negatif'][$i].'</td>
                </tr>';
        }
        ?>
    </table>
    <br/>
    <div class="row">
        <div class="col-md-6 text-left">
            <a class="btn btn-primary" href="nilai-ideal.php">&laquo; Nilai Ideal</a>
        </div>
        <div class="text-right">
            <a class="btn btn-primary" href="ranking.php">Ranking &raquo;</a>
        </div>
    </div>
</div>

<?php
include './includes/footer.php';
?>
