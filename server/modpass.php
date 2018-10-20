<?
/*管理员添加*/
include 'conn.php';
$data = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
checkToken($data->token);
if(!$data->id){
	die(errorMsg('缺少用户ID'));
}
if(!$data->pwd){
	die(errorMsg('缺少密码'));
}
$sql = 'update d_admin set a_pwd="'.$data->pwd.'" where a_id='.$data->id;
$conn = getConnection();
$rs = $conn->query($sql);
echo(succResult($rs));
mysqli_free_result($rs);
$conn->close();
?>