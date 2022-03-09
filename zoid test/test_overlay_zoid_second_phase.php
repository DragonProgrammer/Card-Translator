<html>
<body>
<?php 

$file = "gilvader.png";
$overlay = "zoid mask transparent.png";

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

#30


imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);
imagecopy($im2, $im_overlay, 0,0,0,0, $width, $height);

$background_image = $im;
$background_image2 = $im2;
$font_file = 'times.TTF'; // link in a font file

#40
$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);

imageline($im,80,444,415,444, $black);




#50 
$text = array("Shoot", "Melee", "Range", "Mobility", "Aptitude");

$database_text= array("1100","800","5", "Forward + 2", 6);

$text_size = 18;

$displacement_box = imageftbbox($text_size,0,$font_file,$text[0]);
$at_displacment = $displacement_box[2];

#60


$Y_positions = array(423, 448, 420,480,480);
$X_positions = array(90, 90, 228, 28,228);
$X_positions2 = array(28, 140-.5*$at_displacment, 140-.5*$at_displacment, 228, 28,228);
$database_Y_positions = array(423,448,423,448,480);
$database_X_positions = array(218,218,416,416,218);



#70
$elements = count($text);
$database_elements = count($database_text);

imagettftext($background_image, 30, 0, 30, 425+30, $black ,$font_file, "AT");

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

$specail_text = "'Plasma Particle Cannons' [declared]: Reduce this Zoid's HP by 1000 and deal 1000 damage to up to 2 enemy Zoids in range, or up to 3 if you reduce this Zoid's HP by 1500 instead. 'Blitzkrieg' [constant]: -1 enemy accuracy when targeted by enemies without [air] aptitude, but +1 enemy accuracy when targeted by enemies with it.";
$lines = explode(". ", $specail_text);
$line_count = count($lines);

$X_position = 30;
$X_limit = 415;

$Y_position = 540;
$Y_Start = array($Y_position); #create a 1 element array with the first bing the top of the white box
$Y_Positions = array_pad($Y_Start, $line_count, $Y_position); # create a starting array of y positions  equal to the line count

$text_size = 7;


for( $i = 0; $i < $line_count; $i++) {
	$text_size_raw = imageftbbox($text_size,0, $font_file, $lines[$i]);
	$text2= $lines[$i];
		$char_count = 100;
		$text2 = wordwrap($lines[$i], $char_count,"\n");
		$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_position){
			$char_count--;
			$text2 = wordwrap($lines[$i], $char_count,"\n");
			$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		}
		$lines[$i] = $text2;
		print "<br> lines: ";
		echo $lines[$i];
		print "<br>";
		echo $Y_Positions[$i];
		print "<br>";
		echo $text_size_wrap[5];
		if($i+1 < $line_count){
			$Y_Positions[$i+1] = $Y_Positions[$i] + $text_size_wrap[1]+$text_size*1.5;
	}
}


for($l = 0; $l < $line_count; $l++){ 
	$sub_lines = explode(": ", $lines[$l]);
	$lines[$l] = $sub_lines;
}

for($l = 0; $l < $line_count; $l++){ 
$text = $lines[$l];
$title = imageftbbox($text_size,0, $font_file, $text[0]);
$offset = $title[2];

imagettftext($background_image, $text_size, 0, $X_position, $Y_Positions[$l]+$text_size, $red ,$font_file, $text[0]);

$text_indented = explode("\n", $text[1]);

imagettftext($background_image, $text_size, 0, $X_position+$offset+$text_size, $Y_Positions[$l]+$text_size, $black ,$font_file, $text_indented[0]);
	for ($i = 1; $i < count($text_indented); $i++){
		imagettftext($background_image, $text_size, 0, $X_position, $Y_Positions[$l]+(($text_size*2.75)*$i), $black ,$font_file, $text_indented[$i]);
}
}

#100




ob_start();
  imagejpeg( $im, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!


?>
printing file<br />

</body>
</html>
#120