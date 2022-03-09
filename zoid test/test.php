<html>
<body>
<?php 

$file = "page1.png";
print "Map Testing<br><br>";
print '<form method=post>';


# Make it work with width dynamics. 10

$ImageWidth = "500";
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

$ratio = ($width/$ImageWidth);


# 20
print "width $width height $height ratio $ratio<br><br>";

print '<input type="image"  width='.$ImageWidth;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";

$foo_x = intval($_POST['pos_x'])*$ratio;
$foo_y = intval($_POST['pos_y'])*$ratio;

print "$foo_x , $foo_y<br><br><br>";
# 30

print "crop<br><br>";

$im = imagecreatefrompng($file);
#$size = min(imagesx($im), imagesy($im));
$im2 = imagecrop($im, ['x' => 407, 'y' => 0, 'width' => $width-407, 'height' => '1392']);
if ($im2 !== FALSE) {
    imagejpeg($im2, 'out.jpg');
}
# 40
ob_start();
  imagejpeg( $im2, NULL, 100 );
#  imagedestroy( $im2 );
  $i = ob_get_clean();

echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!

print "<br><br>Do it again<br><Br>";
$white = imagecolorallocate($im, 255, 255, 255);
# 50
imagerectangle($im, $foo_x-25, $foo_y-25, $foo_x+25, $foo_y+25, $white);

$background_image = $im;
$text_color = imagecolorallocate($background_image, 0,0,0); 
$font_file = 'times.TTF'; // link in a font file



$text = "sample Text";
# 60
$text_size = 10; //in points

$X_position = 20; // top left of text
$Y_position = 120; 

imagettftext($background_image, $text_size, 0, $X_position, $Y_position, $text_color ,$font_file, $text); //create image object with text


$text_color = imagecolorallocate($background_image, 0,200,0); 
# 70
$text = "sample Text 4 haldfi0qtg labhhg ";

$text_size_raw = imageftbbox($text_size,0, $font_file, $text);
$text2= $text;
if ($text_size_raw[4] > $width-$X_position){
	$char_count = 20;
	$text2 = wordwrap($text, $char_count,"\n");
	$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
	while($text_size_wrap[4] > $width-$X_position){
		$char_count--;
		$text2 = wordwrap($text, $char_count,"\n");
		$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
	}
}


$Y_position = 20; 
imagettftext($background_image, $text_size, 0, $X_position, $Y_position, $text_color ,$font_file, $text2);







ob_start();
  imagejpeg( $im, NULL, 100 );
#  imagedestroy( $im2 );
  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!
# 60
?>
printing file<br />

<img src="out.jpg" />



</body>
</html>