<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['matrik-r'])) {
    header('Location: matrik-r.php');
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

    $req = $dbc->prepare("SELECT * FROM matrik_r WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $matrik_r = $req->fetchAll();

    $req = $dbc->prepare("SELECT * FROM bobot WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $bobot = $req->fetch();
}

$y = array(
    array(),
    array(),
    array(),
    array(),
    array(),
    array()
);

for ($i = 0; $i < count($alternatif); $i++) {
    $y[0][] = round($matrik_r[$i]['c1']*$bobot['c1'], 4);
    $y[1][] = round($matrik_r[$i]['c2']*$bobot['c2'], 4);
    $y[2][] = round($matrik_r[$i]['c3']*$bobot['c3'], 4);
    $y[3][] = round($matrik_r[$i]['c4']*$bobot['c4'], 4);
    $y[4][] = round($matrik_r[$i]['c5']*$bobot['c5'], 4);
    $y[5][] = round($matrik_r[$i]['c6']*$bobot['c6'], 4);
}


$status = "matrik-y";
try {
    $dbc->beginTransaction();

    $dbc->exec("DELETE FROM matrik_y WHERE id_pemilihan = $_SESSION[id]");

    $req = $dbc->prepare("INSERT INTO matrik_y VALUES(:id, :c1, :c2, :c3, :c4, :c5, :c6)");
    $req->bindValue(':id', $_SESSION['id']);

    for ($i = 0; $i<count($alternatif); $i++) {
        $req->bindValue(':c1', $y[0][$i]);
        $req->bindValue(':c2', $y[1][$i]);
        $req->bindValue(':c3', $y[2][$i]);
        $req->bindValue(':c4', $y[3][$i]);
        $req->bindValue(':c5', $y[4][$i]);
        $req->bindValue(':c6', $y[5][$i]);
        $req->execute();
    }

    $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
    $req->bindParam(1, $status);
    $req->bindParam(2, $_SESSION['id']);
    $req->execute();

    $dbc->commit();

    $_SESSION['matrik-y'] = true;
} catch (PDOException $e) {
    $dbc->rollback();
}

$page_title = 'Matrik Y';

include './includes/header.php';
?>

<div class="col-md-12">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
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
                    <td class="col-md-1">'.$y[0][$i].'</td>
                    <td class="col-md-1">'.$y[1][$i].'</td>
                    <td class="col-md-1">'.$y[2][$i].'</td>
                    <td class="col-md-1">'.$y[3][$i].'</td>
                    <td class="col-md-1">'.$y[4][$i].'</td>
                    <td class="col-md-1">'.$y[5][$i].'</td>
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
            <a class="btn btn-primary" href="nilai-ideal.php">Nilai Ideal &raquo;</a>
        </div>
    </div>
</div>

<?php
include './includes/footer.php';
?>
