<?php
include 'conn.php';
$data = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
if(!$data->usn){
	die(errorMsg('缺少参数usn'));
}
if(!$data->pwd){
	die(errorMsg('缺少参数pwd'));
}
$sql = 'select a_id from d_admin where a_usn="'.$data->usn.'" and a_pwd="'.$data->pwd.'"';
$conn = getConnection();
$rs = $conn->query($sql);
$len = mysqli_num_rows($rs);
if($len===1){
	$array = array();
	while ($row = mysqli_fetch_assoc($rs)) {
		$array[] = $row;
	}
	mysqli_free_result($rs);
	$conn->close();
	$token = crypt(date('s',time()),strtoupper('token'));
	$array['token'] = $token;
	session_start();
	$_SESSION['token'] = $token;
	echo json_encode(array(
		'data'=>$array,
		'msg'=>array(
			'succ'=>true,
			'txt'=>'Success！'
			)
		));
}else{
	echo(errorMsg('用户名或密码错误。'));
}
?>