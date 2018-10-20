<?
session_start();
$_SESSION['token'] = '';
echo json_encode(array(
	'data'=>'',
	'msg'=>array(
		'succ'=>true,
		'txt'=>''
	)
));
?>