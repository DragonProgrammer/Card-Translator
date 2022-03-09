<html>
<body>
<?php 

$file = "gilvader.png";
$overlay = "zoid mask transparent.png";
$overlay2 = "zoid mask transparent2.png";
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

$im = imagecreatefrompng($file);
$im2 = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);
$im_overlay2 = imagecreatefrompng($overlay2);
#30


imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);
imagecopy($im2, $im_overlay2, 0,0,0,0, $width, $height);

$background_image = $im;
$background_image2 = $im2;
$font_file = 'times.TTF'; // link in a font file

#40
$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);

$text_size = 25; //in points




#50 
$text = array("Attack", "Ranged", "Melee", "Range", "Mobility", "Aptitude");

$database_text= array("1100","800","5", "Forward + 2", 6);
$database_text2 = "Forward";

$displacement_box = imageftbbox($text_size,0,$font_file,$text[1]);
$at_displacment = $displacement_box[2];


#60
#echo $displacement_box[2];
#print "<br>";
#echo $at_displacment;

$Y_positions = array(420, 423, 448, 420,480,480);
$X_positions = array(28, 100, 100, 228, 28,228);
$X_positions2 = array(28, 140-.5*$at_displacment, 140-.5*$at_displacment, 228, 28,228);
$database_Y_positions = array(423,448,423,448,480);
$database_X_positions = array(218,218,416,416,218);
#70
$elements = count($text);
$database_elements = count($database_text);

$text_size = 14;

for( $i = 0; $i < $elements; $i++) {
	imagettftext($background_image, $text_size, 0, $X_positions[$i], $Y_positions[$i]+$text_size, $black ,$font_file, $text[$i]);
	imagettftext($background_image2, $text_size, 0, $X_positions2[$i], $Y_positions[$i]+$text_size, $black ,$font_file, $text[$i]);
}
#80
for( $i = 0; $i < $database_elements; $i++) {
	$displacement_box = imageftbbox($text_size,0,$font_file,$database_text[$i]);
	$text_displacement = $displacement_box[2];
	imagettftext($background_image, $text_size, 0, $database_X_positions[$i]-$text_displacement, $database_Y_positions[$i]+$text_size, $black ,$font_file, $database_text[$i]);
}


$displacement_box = imageftbbox($text_size,0,$font_file,$database_text2);
$text_displacement = $displacement_box[2];
imagettftext($background_image2, $text_size, 0, 372-$text_displacement, 448+$text_size, $black ,$font_file, $database_text2);



#100




ob_start();
  imagejpeg( $im, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!

ob_start();
  imagejpeg( $im2, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>";
?>
printing file<br />




</body>
</html>
#120