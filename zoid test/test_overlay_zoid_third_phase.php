<html>
<body>
<?php 

$file = "blade_liger.png";
$overlay = "zoid mask transparent.png";

print '<form method=post>';

# Make it work with width dynamics. 10

$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

$size2 = (getimagesize($overlay));
$width_2=$size2[0];
$height_2=$size2[1];

# 20
print "width $width height $height <br><br>";
print "width $width_2 height $height_2 <br><br>";
print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";

$im = imagecreatefrompng($file);
$image_sized = imagecreatetruecolor($width_2, $height_2);
$im_overlay = imagecreatefrompng($overlay);

#30
imagecopyresampled($image_sized, $im, 0,0,0,0, $width_2, $height_2, $width, $height);

ob_start();
  imagejpeg( $image_sized, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>";
#40

$tmp = $image_sized;

imagecopy($im_overlay, $tmp, 358,545,358,545, 52, 50);
imagecopy($image_sized, $im_overlay, 0,0,0,0, $width, $height);
$background_image = $image_sized;

$font_file = 'times.TTF'; // link in a font file

#50
$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);

imageline($image_sized,80,444,415,444, $black);

imageline($image_sized,110,500,218,500, $black);


#60 
$text = array("Shoot", "Melee", "Range", "Mobility", "Aptitude");

$database_text= array("300","700","3", "", 6, "straight +2");

$text_size = 18;

$displacement_box = imageftbbox($text_size,0,$font_file,$text[0]);
$at_displacment = $displacement_box[2];

#70


$Y_positions = array(423, 448, 420,480,480);
$X_positions = array(90, 90, 228, 28,228);
$X_positions2 = array(28, 140-.5*$at_displacment, 140-.5*$at_displacment, 228, 28,228);
$database_Y_positions = array(423,448,423,448,480, 505);
$database_X_positions = array(218,218,416,416,218, 218);


#80
$elements = count($text);
$database_elements = count($database_text);

imagettftext($background_image, 30, 0, 30, 425+30, $black ,$font_file, "AT");

for( $i = 0; $i < $elements; $i++) {
	imagettftext($background_image, $text_size, 0, $X_positions[$i], $Y_positions[$i]+$text_size, $black ,$font_file, $text[$i]);
}

#90-----------------------------------------------------
for( $i = 0; $i < $database_elements; $i++) {
	$displacement_box = imageftbbox($text_size,0,$font_file,$database_text[$i]);
	$text_displacement = $displacement_box[2];
	imagettftext($background_image, $text_size, 0, $database_X_positions[$i]-$text_displacement, $database_Y_positions[$i]+$text_size, $black ,$font_file, $database_text[$i]);
}
$specail_text ="'Plasma Particle Cannons' [declared]: Reduce this Zoid's HP by 1000 and deal 1000 damage to up to 2 enemy Zoids in range, or up to 3 if you reduce this Zoid's HP by 1500 instead. 'Blitzkrieg' [constant]: -1 enemy accuracy when targeted by enemies without [air] aptitude, but +1 enemy accuracy when targeted by enemies with it.";
#$specail_text = "(1) 800 melee AT only if attacking sideways. (2) -200 damage when attacked from the front.";
$lines = explode(". ", $specail_text);
$line_count = count($lines);
#100 -------------------------------------------------
$X_position = 30;
$X_limit = 415;

$Y_position = 540;
$Y_Start = array($Y_position); #create a 1 element array with the first bing the top of the white box
$Y_Positions = array_pad($Y_Start, $line_count, $Y_position); # create a starting array of y positions  equal to the line count

$text_size = 7;

#determing number of lines 110 -------------------------------
$total_lines = 0;
for( $i = 0; $i < $line_count; $i++) {
	$text_size_raw = imageftbbox($text_size,0, $font_file, $lines[$i]);






#120 ------------------------------------------------------------
	$text2= $lines[$i];
		$char_count = 100;
		$text2 = wordwrap($lines[$i], $char_count,"\n");
		$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_position){
			$char_count--;
			$text2 = wordwrap($lines[$i], $char_count,"\n");
			$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		}
#130 --------------------------------------------------------
		$lines[$i] = $text2;
		if($i+1 < $line_count){
			$Y_Positions[$i+1] = $Y_Positions[$i] + $text_size_wrap[1]+$text_size*1.5;
	}
}


for($l = 0; $l < $line_count; $l++){ 
	if(strpos($lines[$l], ": ") !== false){
#140 ----------------------------------------------------------------
		$sub_lines = explode(": ", $lines[$l]);
		$lines[$l] = $sub_lines;
	}
}
echo $total_lines;
print "<br>";
for($l = 0; $l < $line_count; $l++){ 
	$text_counter = $lines[$l];
	if(is_array($text_counter) == true){
#170------------------------------------
		$total_lines++;
echo $total_lines;
print "<br>";
		$text_counter2 = explode("\n", $text_counter[1]); #splitt the rest of the text into lines and count
echo count($text_counter2);
print "<br><br>";		

		for($c = 1; $c < count($text_counter2); $c++){
			$total_lines++;
echo $total_lines;
print "<br>";

		}
	}
	else{
		$text_counter2 = explode("\n", $text_counter[0]); #splitt the rest of the text into lines and count
echo count($text_counter2);
print "<br>";
		for($c = 0; $c < count($text_counter2); $c++){
		$total_lines++;
echo $total_lines;
print "<br>";

		}
	}
}


echo $total_lines;
print "<br>";
if($total_lines == 2)
	$text_size = 10;

if($total_lines == 3)
	$text_size = 9;

if($total_lines == 4)
	$text_size = 7;
echo $text_size;
for($l = 0; $l < $line_count; $l++){ 
	$text = $lines[$l];
	if(is_array($text) == true){


		$title = imageftbbox($text_size,0, $font_file, $text[0]);
		$offset = $title[2];

		imagettftext($background_image, $text_size, 0, $X_position, $Y_Positions[$l]+$text_size, $red ,$font_file, $text[0]);

		$text_indented = explode("\n", $text[1]);

		imagettftext($background_image, $text_size, 0, $X_position+$offset+$text_size, $Y_Positions[$l]+$text_size, $black ,$font_file, $text_indented[0]);
		for ($i = 1; $i < count($text_indented); $i++){
			imagettftext($background_image, $text_size, 0, $X_position, $Y_Positions[$l]+(($text_size*2.75)*$i), $black ,$font_file, $text_indented[$i]);
		}
	}
	else{

		imagettftext($background_image, $text_size, 0, $X_position, $Y_Positions[$l]+($text_size*2.75), $black ,$font_file, $text);
	}
}

#100




ob_start();
  imagejpeg( $image_sized, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!


?>
printing file<br />

</body>
</html>
#120