<?php  
error_reporting(0);

/****************************************************************************** 
 
参数说明: 
$max_file_size  : 上传文件大小限制, 单位BYTE 
$destination_folder : 上传文件路径 
$watermark   : 是否附加水印(1为加水印,其他为不加水印); 
 
使用说明: 
1. 将PHP.INI文件里面的"extension=php_gd2.dll"一行前面的;号去掉,因为我们要用到GD库; 
2. 将extension_dir =改为你的php_gd2.dll所在目录; 
******************************************************************************/  
  
//上传文件类型列表  
$uptypes=array(  
    'image/jpg',  
    'image/jpeg',  
    'image/png',  
    'image/pjpeg',  
    'image/gif',  
    'image/bmp',  
    'image/x-png'  
);  
  
$max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
$destination_folder="../upfile/img/"; //上传文件路径  
$watermark=9;      //是否附加水印(1为加水印,其他为不加水印);  
$watertype=1;      //水印类型(1为文字,2为图片)  
$waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
// $waterstring="http://www.higou88.com/";  //水印字符串  
$waterstring = '';
$waterimg="xplore.gif";    //水印图片  
$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
$imgpreviewsize=1/2;    //缩略图比例  


if ($_SERVER['REQUEST_METHOD'] == 'POST'){  
    $f = $_FILES['file'];
    $imgs = array();
    // echo $f;
    // print_r($f);
    // exit();
    if (!is_uploaded_file($f['tmp_name']))  
    //是否存在文件  
    {  
        echo(json_encode(array(
        'data'=>'',
        'info'=>array(
            'code'=>1,
            'msg'=>'图片不存在'
            )
        )));
        exit;  
    }  
  
    if($max_file_size < $f["size"])  
    //检查文件大小  
    {  
        echo(json_encode(array(
        'data'=>'',
        'info'=>array(
            'code'=>2,
            'msg'=>'文件太大'
            )
        )));
        exit;  
    }  
  
    if(!in_array($f["type"], $uptypes))  
    //检查文件类型  
    {  
        echo(json_encode(array(
        'data'=>'',
        'info'=>array(
            'code'=>3,
            'msg'=>"文件类型不符!".$file["type"]
            )
        ))); 
        exit;  
    }
    // 判断文件类型
    switch ($f['type']) {
        case 'image/jpg':
            $ftype = 'jpg';
            break;
        case 'image/jpeg':
            $ftype = 'jpeg';
            break;
        case 'image/png':
            $ftype = 'png';
            break;
        case 'image/gif':
            $ftype = 'gif';
            break;
        case 'image/pjpeg':
            $ftype = 'pjpeg';
            break;
        case 'image/bmp':
            $ftype = 'jpg';
            break;
        case 'image/x-png':
            $ftype = 'png';
            break;
        default:
            $ftype = '';
            break;
    }
  
    if(!file_exists($destination_folder))  
    {  
        mkdir($destination_folder);  
    }  
  
    $filename=$f["tmp_name"];  
    $image_size = getimagesize($filename);  
    $mt = explode(' ',microtime());
    $destination = $destination_folder.$mt[1].str_replace('0.','-',$mt[0]).".".$ftype;
    if (file_exists($destination) && $overwrite != true)  
    {  
        echo(json_encode(array(
        'data'=>'',
        'info'=>array(
            'code'=>4,
            'msg'=>'同名文件已经存在了'
            )
        )));
        exit;  
    }  
  
    if(!move_uploaded_file ($filename, $destination))  
    {  
        echo(json_encode(array(
        'data'=>'',
        'info'=>array(
            'code'=>5,
            'msg'=>'移动文件出错'
            )
        )));
        exit;  
    }  
  
    $pinfo=pathinfo($destination);  
    $fname=$pinfo['basename'];
    if($watermark==1)  
    {  
        $iinfo=getimagesize($destination,$iinfo);  
        $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);  
        $white=imagecolorallocate($nimage,255,255,255);  
        $black=imagecolorallocate($nimage,0,0,0);  
        $red=imagecolorallocate($nimage,255,0,0);  
        imagefill($nimage,0,0,$white);  
        switch ($iinfo[2])  
        {  
            case 1:  
            $simage =imagecreatefromgif($destination);  
            break;  
            case 2:  
            $simage =imagecreatefromjpeg($destination);  
            break;  
            case 3:  
            $simage =imagecreatefrompng($destination);  
            break;  
            case 6:  
            $simage =imagecreatefromwbmp($destination);  
            break;  
            default:  
            echo(json_encode(array(
            'data'=>'',
            'info'=>array(
                'code'=>6,
                'msg'=>'不支持的文件类型'
                )
            )));
            exit;  
        }  
  
        imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);  
        imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);  
  
        switch($watertype)  
        {  
            case 1:   //加水印字符串  
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);  
            break;  
            case 2:   //加水印图片  
            $simage1 =imagecreatefromgif("xplore.gif");  
            imagecopy($nimage,$simage1,0,0,0,0,85,15);  
            imagedestroy($simage1);  
            break;  
        }  
  
        switch ($iinfo[2])  
        {  
            case 1:  
            //imagegif($nimage, $destination);  
            imagejpeg($nimage, $destination);  
            break;  
            case 2:  
            imagejpeg($nimage, $destination);  
            break;  
            case 3:  
            imagepng($nimage, $destination);  
            break;  
            case 6:  
            imagewbmp($nimage, $destination);   
            break;  
        }  
  
        //覆盖原上传文件  
        imagedestroy($nimage);  
        imagedestroy($simage);  
    }  
  
    $imgs[] = $destination_folder.str_replace($destination_folder,'',$destination);
    echo(json_encode(array(
        'data'=>$imgs,
        'info'=>array(
            'code'=>0,
            'msg'=>'succ'
            )
        )));
}  
?>
