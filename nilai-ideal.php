<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['matrik-y'])) {
    header('Location: matrik-y.php');
    exit;
} else {
    $req = $dbc->prepare("SELECT * FROM pemilihan WHERE id = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $pemilihan = $req->fetch();

    $req = $dbc->prepare("SELECT * FROM matrik_y WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $matrik_y = $req->fetchAll();
}

$a = array();

$tempMatrikY = array(
    "c1" => array(),
    "c2" => array(),
    "c3" => array(),
    "c4" => array(),
    "c5" => array(),
    "c6" => array()
);

for ($i = 0; $i < count($matrik_y); $i++) {
    $tempMatrikY['c1'][] = $matrik_y[$i]['c1'];
    $tempMatrikY['c2'][] = $matrik_y[$i]['c2'];
    $tempMatrikY['c3'][] = $matrik_y[$i]['c3'];
    $tempMatrikY['c4'][] = $matrik_y[$i]['c4'];
    $tempMatrikY['c5'][] = $matrik_y[$i]['c5'];
    $tempMatrikY['c6'][] = $matrik_y[$i]['c6'];
}

$a['positif'][] = max($tempMatrikY['c1']);
$a['positif'][] = max($tempMatrikY['c2']);
$a['positif'][] = max($tempMatrikY['c3']);
$a['positif'][] = min($tempMatrikY['c4']);
$a['positif'][] = min($tempMatrikY['c5']);
$a['positif'][] = min($tempMatrikY['c6']);

$a['negatif'][] = min($tempMatrikY['c1']);
$a['negatif'][] = min($tempMatrikY['c2']);
$a['negatif'][] = min($tempMatrikY['c3']);
$a['negatif'][] = max($tempMatrikY['c4']);
$a['negatif'][] = max($tempMatrikY['c5']);
$a['negatif'][] = max($tempMatrikY['c6']);

$status = "nilai-ideal";
try {
    $dbc->beginTransaction();

    $dbc->exec("DELETE FROM nilai_ideal WHERE id_pemilihan = $_SESSION[id]");

    $req = $dbc->prepare("INSERT INTO nilai_ideal VALUES(:id, :ideal, :c1, :c2, :c3, :c4, :c5, :c6)");
    $req->bindValue(':id', $_SESSION['id']);

    foreach ($a as $ideal => $y) {
        $req->bindValue(':ideal', $ideal);
        $req->bindValue(':c1', $y[0]);
        $req->bindValue(':c2', $y[1]);
        $req->bindValue(':c3', $y[2]);
        $req->bindValue(':c4', $y[3]);
        $req->bindValue(':c5', $y[4]);
        $req->bindValue(':c6', $y[5]);
        $req->execute();
    }

    $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
    $req->bindParam(1, $status);
    $req->bindParam(2, $_SESSION['id']);
    $req->execute();

    $dbc->commit();

    $_SESSION['nilai-ideal'] = true;
} catch (PDOException $e) {
    $dbc->rollback();
}

$page_title = 'Nilai Ideal';

include './includes/header.php';
?>

<div class="col-md-12">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
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
                    <td class="col-md-2">'.ucfirst($ideal).'</td>
                    <td class="col-md-1">'.$y[0].'</td>
                    <td class="col-md-1">'.$y[1].'</td>
                    <td class="col-md-1">'.$y[2].'</td>
                    <td class="col-md-1">'.$y[3].'</td>
                    <td class="col-md-1">'.$y[4].'</td>
                    <td class="col-md-1">'.$y[5].'</td>
                </tr>';
        }
        ?>
    </table>
    <br/>
    <div class="row">
        <div class="col-md-6 text-left">
            <a class="btn btn-primary" href="matrik-r.php">&laquo; Matrik R</a>
        </div>
        <div class="text-right">
            <a class="btn btn-primary" href="jarak-solusi-ideal.php">Jarak Solusi Ideal &raquo;</a>
        </div>
    </div>
</div>

<?php
include './includes/footer.php';
?>
