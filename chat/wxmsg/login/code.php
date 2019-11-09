<?php
//验证码功能
session_start();
Header("Content-type:image/PNG");
$im = imagecreate(150,45);
$back = imagecolorallocate($im, 245, 245, 245);
imagefill($im, 20,20, $back);

$vcodes = "";
for($i = 0; $i < 4; $i++){
  $fontSize=28;
    $font = imagecolorallocate($im, rand(100, 255), rand(0, 100), rand(100, 255));
    $authnum = rand(0, 9);
    $vcodes .= $authnum;
    imagestring($im, $fontSize, 50 + $i * 10, 20, $authnum, $font);
}
$_SESSION['code'] = $vcodes; //存储在session里
for($i=0;$i<200;$i++) {
    $randcolor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($im, rand()%150, rand()%150, $randcolor); //
}
imagepng($im);
imagedestroy($im);
?>
