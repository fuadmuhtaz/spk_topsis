<?php
require './includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['id'])) {
    header('Location: informasi-pemilihan.php');
    exit;
} else {
    $req = $dbc->prepare("SELECT * FROM pemilihan WHERE id = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $pemilihan = $req->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errAlternatif = false;
    $errAlternatifData = array();

    for ($i = 0; $i < count($_POST['alternatif']); $i++) {
        if (!preg_match ('/^[A-Z \'.-]{1,255}$/i', $_POST['alternatif'][$i])) {
            $errAlternatifData[] = $i;
        }
    }

    if (!empty($errAlternatifData)) {
        $errAlternatif = true;
    }

    if (!$errAlternatif) {
        unset($_SESSION['alternatif']);
        unset($_SESSION['errAlternatif']);
        unset($_SESSION['errAlternatifData']);
        $status = "alternatif";

        try {
            $dbc->beginTransaction();

            $dbc->exec("DELETE FROM alternatif WHERE id_pemilihan = $_SESSION[id]");

            $req = $dbc->prepare("INSERT INTO alternatif VALUES(:id, :alternatif)");
            $req->bindValue(':id', $_SESSION['id']);

            for ($i = 0; $i<count($_POST['alternatif']); $i++) {
                $req->bindValue(':alternatif', $_POST['alternatif'][$i]);
                $req->execute();
            }

            $req = $dbc->prepare("UPDATE pemilihan SET status = ? WHERE id = ?");
            $req->bindParam(1, $status);
            $req->bindParam(2, $_SESSION['id']);
            $req->execute();

            $dbc->commit();

            $_SESSION['alternatif'] = true;
            header('Location: nilai-alternatif.php');
            exit;
        } catch (PDOException $e) {
            $dbc->rollback();
        }
    } else {
        $_SESSION['alternatif'] = $_POST['alternatif'];
        $_SESSION['errAlternatif'] = $errAlternatif;
        $_SESSION['errAlternatifData'] = $errAlternatifData;

        header('Location: alternatif.php');
    }
} else {
    $req = $dbc->prepare("SELECT * FROM alternatif WHERE id_pemilihan = ?");
    $req->bindParam(1, $_SESSION['id']);
    $req->execute();

    $alternatif = $req->fetchAll();
}

$page_title = 'Alternatif';

include './includes/header.php';
?>
<div class="col-md-6 col-md-offset-3">
    <div class="page-header text-center">
        <h1>Pemilihan Karyawan</h1>
        <h4><?php echo $pemilihan['keterangan']; ?></h4>
    </div>
    <h3>Alternatif</h3>
    <form method="post">
        <div id="alternatif">
            <?php
            if (isset($_SESSION['errAlternatif']) && $_SESSION['errAlternatif']) {
                echo '<div class="alert alert-warning alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>Alternatif</strong> tidak boleh kosong.
                    </div>';

                for ($i = 0; $i < count($_SESSION['alternatif']); $i++) {
                    if (in_array($i, $_SESSION['errAlternatifData'])) {
                        echo '<div class="form-group has-error">
                                <input type="text" class="form-control" name="alternatif[]" placeholder="Alternatif">
                            </div>';
                    } else {
                        echo '<div class="form-group">
                                <input type="text" class="form-control" name="alternatif[]" placeholder="Alternatif" value="'.$_SESSION['alternatif'][$i].'">
                            </div>';
                    }
                }
            } else if (isset($alternatif) && $alternatif) {
                for ($i = 0; $i < count($alternatif); $i++) {
                    echo '<div class="form-group">
                            <input type="text" class="form-control" name="alternatif[]" placeholder="Alternatif" value="'.$alternatif[$i]['alternatif'].'">
                        </div>';
                }
            } else {
                echo '<div class="form-group">
                        <input type="text" class="form-control" name="alternatif[]" placeholder="Alternatif">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="alternatif[]" placeholder="Alternatif">
                    </div>';
            }
            ?>
        </div>
            <div class="text-right">
                <button class="btn btn-success" id="tambah_alternatif">Tambah</button>
                <button class="btn btn-danger" id="hapus_alternatif">Hapus</button>
            </div>
        <br/>

        <div class="row">
            <div class="col-md-6 text-left">
                <a class="btn btn-primary" href="informasi-pemilihan.php">&laquo; Pemilihan</a>
            </div>
            <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-primary">Nilai &raquo;</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('#tambah_alternatif').click(function(e) {
            e.preventDefault();
            $('#alternatif').append('<div class="form-group"><input type="text" class="form-control" name="alternatif[]" placeholder="Alternatif"></div>');
        });

        $('#hapus_alternatif').click(function(e) {
            e.preventDefault();
            var banyakAlternatif = $('#alternatif .form-group').length;

            if (banyakAlternatif > 2) {
                $('#alternatif .form-group:last-child').remove();
            } else {
                alert("Minimal harus terdapat dua alternatif");
            }
        });
    });
</script>
<?php
include './includes/footer.php';
?>
