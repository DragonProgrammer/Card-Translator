<html>
<body>
<?php 

$file = "moonbay.png";
$overlay = "pilot mask.png";
print "Map Testing<br><br>";
print '<form method=post>';

# Make it work with width dynamics. 10

#$ImageWidth = "500";
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];



# 20
print "width $width height $height <br>";

print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";

$im = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);

imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);
#30

$background_image = $im;
$font_file = 'times.TTF'; // link in a font file

#define colors
$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);


#define text size
$text_size = 12; //in points

#set up line sp[acing numbers]
$test_size = imageftbbox($text_size, 0, $font_file, "Ag");
$dip = $test_size[1];
$full_size = $dip = abs($test_size[7]);
#40

#set up
$white_text = array("Pilot", "Aptitude");
$white_Y_positions = array(360- $dip, 360 - $dip);
$white_X_positions = array(25, 260);
for( $i = 0; $i < count($white_text); $i++) {
	imagettftext($background_image, $text_size, 0, $white_X_positions[$i], $white_Y_positions[$i], $white,$font_file, $white_text[$i]);
}




$black_text = array("Terrain Bonus", "Favored Zoid", "Restrictions");
$database_text = array("[mountain]: +200 HP", "[Gustav]: +1 mobility", "[Gustav] only");
$database_text = array("[air]: Increased accuracy against Zoids on plains (attacks will succeed on a die roll of 2 or higher)", "[Storm Sworder]: +200 HP, 500 ranged attack AT.", "[-]");
$database_text = array("<forest>: +100 ranged and melee attack  e", "[Schwarz spec. Zoids]: +200 HP, movement aptitudes <forest>, <mountain> and <sand>.", "[-]");
#$database_text = array("<mountain>: +200 HP", "[Command Wolf]: +2 mobility", "Cannot pilot Zoids with <water> or <air> aptitude.");

$specail_text =  "Instead of attacking, you may roll a die and give 100 x the result in HP from the Zoid she is piloting to 1 adjacent Zoid.";


#text replacements


$black_Y_positions =array(387 + $text_size, 404 + $text_size, 421 +$text_size);
$black_X_positions = array(43, 43, 43);
$database_Y_positions =array( 387 + $text_size, 404 + $text_size, 421 +$text_size);
$database_X_positions = array(125, 125, 125); # font size 14  x = 140 (before i added " - " to the black_text)


$X_start = $database_X_positions[0];
$X_limit = 340;
for( $i = 0; $i < count($database_text); $i++) {
	$text_size_raw = imageftbbox($text_size,0, $font_file, $database_text[$i]);

	if($database_text[$i] == "[-]"){
		if($i+1 < count($database_text)){
			$black_Y_positions[$i+1] = $black_Y_positions[$i];
			$database_text[$i+1] = $database_text[$i];
		}
		if($i+1 == count($database_text)){
			$black_Y_positions[$i] = $black_Y_positions[$i-1]+	($full_size+3)*(count($lines)+1);
		}
		continue;
	}
	

	if ($text_size_raw[4] > $X_limit-$X_start)
	{
		$char_count = 50;
		$text2 = wordwrap($database_text[$i], $char_count,"\n");
		$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_start){
			$char_count--;
			$text2 = wordwrap($database_text[$i], $char_count,"\n");
			$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		}
		$temp_lines = explode("\n", $text2);
		$text_line_1 = $temp_lines[0];
		print "<br> text whole: $text2";
		print "<br> $text_line_1 <br>";


		$text_rest = str_replace($text_line_1, "",$text2);
		print "<br> text rest : $text_rest";

		$text_rest = str_replace("\n", "",$text_rest);

		$char_count = 50;
		$rest_wrap = wordwrap($text_rest, $char_count,"\n");
		$rest_size = imageftbbox($text_size,0, $font_file, $rest_wrap);

		$X_start = $black_X_positions[0];
		while($rest_size[4] > $X_limit-$X_start){
			$char_count--;
			$rest_wrap = wordwrap($text_rest, $char_count,"\n");
			$rest_size = imageftbbox($text_size,0, $font_file, $rest_wrap);
		}
		imagettftext($background_image, $text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);
		imagettftext($background_image, $text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);
		imagettftext($background_image, $text_size, 0, $database_X_positions[$i], $database_Y_positions[$i], $black,$font_file, $text_line_1);
		$lines = explode("\n", $text_rest);
		$line_count = count($lines);
		print "<br> line $line_count <br>";
		print "<br> y position 3 $black_Y_positions[2] <br>";
		for($l = 0; $l <count($lines); $l++)
			imagettftext($background_image, $text_size, 0, $black_X_positions[$i], $database_Y_positions[$i]+(($full_size+3)*($l+1)), $black,$font_file, $lines[$l]);
		$X_start=$database_X_positions[$i];
		
		if($i+1 < count($database_text)){
		$database_Y_positions[$i+1] = $database_Y_positions[$i+1] + ($full_size+3)*count($lines);
		$black_Y_positions[$i+1] = $black_Y_positions[$i+1] + ($full_size+3)*count($lines);
	}
	print "<br> change i + 1; y position 3 $black_Y_positions[2] <br>";
	if($i+2 < count($database_text)){
		$database_Y_positions[$i+2] = $database_Y_positions[$i+1] + ($full_size+3)*(count($lines)-1)+3;
		$black_Y_positions[$i+2] = $black_Y_positions[$i+1] + ($full_size+3)*(count($lines)-1)+3;
	}
	print "<br> change i + 2; y position 3 $black_Y_positions[2] <br>";
	#	echo $Y_Positions[$i]+$text_size_wrap[1]+$text_size*1.5;
	}
	else{
		imagettftext($background_image, $text_size, 0, $database_X_positions[$i], $database_Y_positions[$i], $black ,$font_file, $database_text[$i]);

	
	imagettftext($background_image, $text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);
	imagettftext($background_image, $text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);
}
}


$X_start = $black_X_positions[0];
$specail_wrap = wordwrap($specail_text,$char_count,"\n");
$specail_box = imagettfbbox($text_size,0,$font_file, $specail_wrap);
while($specail_box[4] > $X_limit - $X_start){
	$char_count--;
			$specail_wrap = wordwrap($specail_text, $char_count,"\n");
			$rest_wrap = imageftbbox($text_size,0, $font_file, $specail_wrap);
}
$specail_Y_position = $black_Y_positions[2] + ($full_size+3)*(count($lines)-1)+3;
imagettftext($background_image, $text_size, 0, $black_X_positions[0], $specail_Y_position, $red,$font_file, $specail_wrap);





ob_start();
  imagejpeg( $im, NULL, 100 );
#  imagedestroy( $im2 );
  $i = ob_get_clean();

#110
echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!
?>



</body>
</html>
#120