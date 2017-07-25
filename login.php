<?php
require './includes/config.php';

$page_title = 'Login';
$err = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['username'] = $_POST['username'];

    $req = $dbc->prepare('SELECT * FROM admin WHERE username = ?');
    $req->bindParam(1, $_POST['username']);
    $req->execute();

    if ($data = $req->fetch()) {
        if (password_verify($_POST['password'], $data['password'])) {
            $_SESSION['admin'] = true;
            header('Location: index.php');
            exit;
        }
    }

    $err = true;
}

include './includes/header.php';
?>
<div class="col-md-4 col-md-offset-4">
    <div class="page-header">
        <h1 class="text-center">Login</h1>
    </div>
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username"
            <?php
            if (isset($_SESSION['username'])) {
                echo "value = '$_SESSION[username]'";
            }
            ?>
            >
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <br />
    <p class="help-block">username: admin dan password: admin</p>
    <?php
    if ($err) {
        echo '<div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Username</strong> atau <strong>Password</strong> salah.
            </div>';
    }
    ?>
</div>

<?php
include './includes/footer.php';
?>
