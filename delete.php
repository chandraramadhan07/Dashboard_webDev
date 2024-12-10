<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: index.php");
    exit;
}

include_once("database/database.php");

$id = $_GET['id_produk'];

$result = mysqli_query($db, "DELETE FROM produk WHERE id_produk=$id");

header("Location:manage_data.php");
?>