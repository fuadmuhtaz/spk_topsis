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

$req = $dbc->prepare("DELETE FROM pemilihan WHERE id = ?");
$req->bindParam(1, $_GET['id']);
$req->execute();

header('Location: laporan.php');
