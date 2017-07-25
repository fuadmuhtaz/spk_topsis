<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['ranking'])) {
    header('Location: ranking.php');
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

    $req = $dbc->prepare("SELECT * FROM ranking WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $v = $req->fetchAll();

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

    $status = "selesai";
    try {
        $dbc->beginTransaction();

        $dbc->exec("DELETE FROM hasil WHERE id_pemilihan = $_SESSION[id]");

        $req = $dbc->prepare("INSERT INTO hasil VALUES(:id, :alternatif, :v)");
        $req->bindValue(':id', $_SESSION['id']);
        $req->bindValue(':alternatif', $hasil[0]['alternatif']);
        $req->bindValue(':v', $hasil[0]['v']);
        $req->execute();

        $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
        $req->bindParam(1, $status);
        $req->bindParam(2, $_SESSION['id']);
        $req->execute();

        $dbc->commit();
    } catch (PDOException $e) {
        $dbc->rollback();
    }

    unset($_SESSION['id']);
    unset($_SESSION['alternatif']);
    unset($_SESSION['nilai-alternatif']);
    unset($_SESSION['bobot']);
    unset($_SESSION['matrik-r']);
    unset($_SESSION['matrik-y']);
    unset($_SESSION['nilai-ideal']);
    unset($_SESSION['jarak-solusi-ideal']);
    unset($_SESSION['ranking']);
}
$page_title = 'Hasil';

include './includes/header.php';
?>
<div class="col-md-8 col-md-offset-2">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
    <h3>Hasil</h3>
    <div class="well well-lg text-center">
        <strong><?php echo $hasil[0]['alternatif']; ?> sebagai alternatif terbaik.</strong>
    </div>
    <table class="table table-bordered">
        <tr>
            <th class="col-md-4">Alternatif</th>
            <th class="col-md-2">V</th>
            <th class="col-md-1">Rank</th>
        </tr>
        <?php
        for($i = 0; $i < count($hasil); $i++) {
            echo '<tr>
                    <td class="col-md-4">'.$hasil[$i]['alternatif'].'</td>
                    <td class="col-md-2">'.$hasil[$i]['v'].'</td>
                    <td class="col-md-2">'.($i+1).'</td>
                </tr>';
        }
        ?>
    </table>
</div>
<?php
include './includes/footer.php';
?>
