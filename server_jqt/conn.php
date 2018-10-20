<?
/*
	返回值msg.code;
	0：操作成功
	10：token失效
	20：缺少参数
	30：SQL语句错误
	40：数据库链接错误
*/
header("Content_type:application/json;charset=utf8");
// 通知信息不显示
error_reporting(0);
// 设置北京时区
date_default_timezone_set('PRC');
// 缺少参数返回结果
function errorMsg($txt){
	return json_encode(array(
		'data'=>'',
		'msg'=>array(
			'suuc'=>false,
			'txt'=>$txt
		)
	));
}
/* 
	sql语句执行失败返回结果
	$conn 		必需		数据库链接
	$errorInfo 	可选		自定义返回结果
*/
function getSQLError($conn,$errorInfo){
	if($errorInfo){
		$infos = $errorInfo;
	}else{
		$infos = mysqli_error($conn);
	}
	return json_encode(array(
		'data'=>'',
		'msg'=>array(
			'succ'=>false,
			'txt'=>$infos
		)
	));
}
/*	
	sql语句执行成功返回结果
	$rs 	必需		数据查询结果集
*/
function succResult($rs,$data){
	$array = array();
	if($data){
		$array = $data;
	}else{
		while ($row = mysqli_fetch_assoc($rs)) {
			$array[] = $row;
		}
	}
	return  json_encode(array(
		'data'=>$array,
		'msg'=>array(
			'succ'=>true,
			'txt'=>'Success！')
		)
	);
}
// 数据库链接
function getConnection(){
	$conn = new mysqli('113.10.131.2','jqtdb_f','MY14JASD','jqtdb');
	// $conn = new mysqli('127.0.0.1','root','Bellzzy6937','jqtdb');
	if($conn->connect_error){
		$rs = array(
			'data'=>'',
			'msg'=>array(
				'succ'=>false,
				'txt'=>'数据库链接错误！'
			)
		);
		die(json_encode($rs));
	}
	$conn->query('set NAMES utf8');
	return $conn;
}
// token校验
function checkToken($token){
	session_start();
	$t = $_SESSION['token'];
	if($t!=$token){
		$_SESSION['token'] = '';
		echo json_encode(array(
			'data'=>'',
			'msg'=>array(
				'succ'=>false,
				'txt'=>'token失效，请重新登录。',
				'code'=>99
			)
		));
		exit();
	}
}
?>