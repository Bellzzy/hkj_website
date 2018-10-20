<?php
include 'conn.php';
include 'article.class.php';
$data = $GLOBALS['HTTP_RAW_POST_DATA'];
$art = new Article($data);
$sql = $art->getSql();
// echo $sql;
// exit();
$conn = getConnection();
$rs = $conn->query($sql);
$opt = json_decode($data)->opt;
if($opt==='que'){
	$array = array();
	while ($row = mysqli_fetch_assoc($rs)) {
		$array[] = $row;
	};
	mysqli_free_result($rs);
	$sqlcount = 'select count(id) as count from d_article';
	$rscount = $conn->query($sqlcount);
	$arrcount = array();
	while ($row1 = mysqli_fetch_assoc($rscount)) {
		$arrcount[] = $row1;
	}
	mysqli_free_result($rscount);

	echo json_encode(array(
		'data'=>array(
			'list'=>$array,
			'count'=>$arrcount[0]
			),
		'msg'=>array(
			'succ'=>true,
			'txt'=>'Success！')
		)
	);
}else{
	echo(succResult($rs));
	mysqli_free_result($rs);
}

$conn->close();
?>