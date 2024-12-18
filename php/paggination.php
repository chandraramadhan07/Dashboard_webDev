<?php
// PAGGINATION
$limit_baris = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit_baris;
$sql_total = "SELECT COUNT(*) as total_produk FROM produk";
$result_total = mysqli_query($db, $sql_total);
$total_baris = mysqli_fetch_assoc($result_total);
$total_data = $total_baris['total_produk'];
$total_page = ceil($total_data / $limit_baris);

?>