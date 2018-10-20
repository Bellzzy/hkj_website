<?php
include 'conn.php';
include 'category.class.php';
$data = $GLOBALS['HTTP_RAW_POST_DATA'];
$ca = new Category($data);
$sql = $ca->getSql();
$conn = getConnection();
$rs = $conn->query($sql);
echo(succResult($rs));
mysqli_free_result($rs);
$conn->close();
?>