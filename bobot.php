<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['nilai-alternatif'])) {
    header('Location: nilai-alternatif.php');
    exit;
} else {
    $req = $dbc->prepare("SELECT * FROM pemilihan WHERE id = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $pemilihan = $req->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errBobot = false;

    $errBobotData = array();

    for($i = 0; $i < count($_POST['bobot']); $i++) {
        if (filter_var($_POST['bobot'][$i], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>100))) == false) {
            $errBobotData[] = $i;
        }
    }

    if (!empty($errBobotData)) {
        $errBobot = true;
    }

    if (!$errBobot) {
        unset($_SESSION['bobot']);
        unset($_SESSION['errBobot']);
        unset($_SESSION['errBobotData']);
        $status = "bobot";

        try {
            $dbc->beginTransaction();

            $dbc->exec("DELETE FROM bobot WHERE id_pemilihan = $_SESSION[id]");

            $req = $dbc->prepare("INSERT INTO bobot VALUES(:id, :c1, :c2, :c3, :c4, :c5, :c6)");
            $req->bindValue(':id', $_SESSION['id']);

            $req->bindValue(':c1', $_POST['bobot'][0]);
            $req->bindValue(':c2', $_POST['bobot'][1]);
            $req->bindValue(':c3', $_POST['bobot'][2]);
            $req->bindValue(':c4', $_POST['bobot'][3]);
            $req->bindValue(':c5', $_POST['bobot'][4]);
            $req->bindValue(':c6', $_POST['bobot'][5]);
            $req->execute();

            $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
            $req->bindParam(1, $status);
            $req->bindParam(2, $_SESSION['id']);
            $req->execute();

            $dbc->commit();

            $_SESSION['bobot'] = true;
            header('Location: matrik-r.php');
            exit;
        } catch (PDOException $e) {
            $dbc->rollback();
        }
    } else {
        $_SESSION['bobot'] = $_POST['bobot'];
        $_SESSION['errBobot'] = $errBobot;
        $_SESSION['errBobotData'] = $errBobotData;

        header('Location: bobot.php');
    }
} else {
    $req = $dbc->prepare("SELECT * FROM bobot WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $bobot = $req->fetchAll();
}

$page_title = 'Bobot';

include './includes/header.php';
?>

<div class="col-md-12">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
    <h3>Nilai Alternatif</h3>
    <form method="post">
        <?php
        if (isset($_SESSION['errBobot']) && $_SESSION['errBobot']) {
            echo '<div class="alert alert-warning alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Bobot</strong> tidak valid.
                </div>';
        }
        ?>
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
            if (isset($_SESSION['errBobot']) && $_SESSION['errBobot']) {
                echo '<tr>';

                for($i = 0; $i < count($_SESSION['bobot']); $i++) {

                    if (in_array($i, $_SESSION['errBobotData'])) {
                        echo '<td class="col-md-2 has-error"><input class="form-control" type="text" name="bobot[]" value="'.$_SESSION['bobot'][$i].'"/></td>';
                    } else {
                        echo '<td class="col-md-2"><input class="form-control" type="text" name="bobot[]" value="'.$_SESSION['bobot'][$i].'"/></td>';
                    }
                }

                echo '</tr>';
            } else if (isset($bobot) && $bobot ) {
                echo '<tr>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100" value="'.$bobot[0]['c1'].'"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100" value="'.$bobot[0]['c2'].'"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100" value="'.$bobot[0]['c3'].'"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100" value="'.$bobot[0]['c4'].'"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100" value="'.$bobot[0]['c5'].'"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100" value="'.$bobot[0]['c6'].'"/></td>
                    </tr>';
            } else {
                echo '<tr>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100"/></td>
                        <td class="col-md-2"><input class="form-control" type="text" name="bobot[]" placeholder="1 - 100"/></td>
                    </tr>';
            }
            ?>
        </table>
        <br/>
        <div class="row">
            <div class="col-md-6 text-left">
                <a class="btn btn-primary" href="nilai-alternatif.php">&laquo; Nilai</a>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Matrik R &raquo;</button>
            </div>
        </div>
    </br/>
    </form>
</div>

<?php
include './includes/footer.php';
?>
