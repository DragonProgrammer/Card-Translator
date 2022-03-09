<html>
<body>
<?php 

print '<form method=post>';

#------------------------------------------------------------------------------------
#data from SQL
$file = "moonbay.png";
$overlay = "pilot mask.png";
$name ="Moonbay";
$black_text = array("Terrain Bonus", "Favored Zoid", "Restrictions");
$database_text = array("[mountain]: +200 HP", "[Gustav]: +1 mobility", "[Gustav] only");
#$database_text = array("[air]: Increased accuracy against Zoids on plains (attacks will succeed on a die roll of 2 or higher)", "[Storm Sworder]: +200 HP, 500 ranged attack AT.", "[-]");
#$database_text = array("<forest>: +100 ranged and melee attack", "[Schwarz spec. Zoids]: +200 HP, movement aptitudes <forest>, <mountain> and <sand>.", "[-]");
#$database_text = array("<mountain>: +200 HP", "[Command Wolf]: +2 mobility", "Cannot pilot Zoids with <water> or <air> aptitude.");

$specail_text =  "Instead of attacking, you may roll a die and give 100 x the result in HP from the Zoid she is piloting to 1 adjacent Zoid.";

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
$blue = imagecolorallocate($background_image,60,69,139);
$yellow	= imagecolorallocate($background_image, 234,239,97);

#define text size
$text_size = 12; //in points
$name_size = 20;
#set up line sp[acing numbers]
$test_size = imageftbbox($text_size, 0, $font_file, "Ag");
$dip = $test_size[1];
$full_size = $dip + abs($test_size[7]);

					#print "<br> dip: $dip";

#set up white text
$white_text = array("Pilot", "Aptitude");
$white_Y_positions = array(360- $dip, 360 - $dip);

					#print "<br> Y position: $white_Y_positions[0]";
$white_X_positions = array(25, 260);
for( $i = 0; $i < count($white_text); $i++) {
	imagettftext($background_image, $text_size, 0, $white_X_positions[$i], $white_Y_positions[$i], $white,$font_file, $white_text[$i]);
}

$name_position = array(60, $white_Y_positions[0]);
#imagettftext($background_image, $name_size, 0, $name_position[0], $name_position[1], $yellow,$font_file, $name);


#set up text size for 2hite box
$black_text_size = 10;

$test_size = imageftbbox($black_text_size, 0, $font_file, "Ag");
$dip = $test_size[1];
$full_size = $dip + abs($test_size[7]);





#text replacements


$black_Y_positions =array(387 + $text_size, 404 + $text_size, 421 +$text_size);
$black_X_positions = array(43, 43, 43);
$database_Y_positions =array( 387 + $text_size, 404 + $text_size, 421 +$text_size);
$database_X_positions = array(125, 125, 125); # font size 14  x = 140 (before i added " - " to the black_text)


$X_start = $database_X_positions[0];
$X_limit = 340;

#Place the text for Terain, Favored and Restrictions ------------------------------
for( $i = 0; $i < count($database_text); $i++) {
	$text_size_raw = imageftbbox($text_size,0, $font_file, $database_text[$i]);


#if section is "[-]"/null skip ---
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
# ------------------------------

#text wrap each effect line
	if ($text_size_raw[4] > $X_limit-$X_start)
	{
		$char_count = 50;
		$text2 = wordwrap($database_text[$i], $char_count,"\n");
		$text_size_wrap = imageftbbox($black_text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_start){
			$char_count--;
			$text2 = wordwrap($database_text[$i], $char_count,"\n");
			$text_size_wrap = imageftbbox($black_text_size,0, $font_file, $text2);
		}
		$temp_lines = explode("\n", $text2);
#create the line that goes whthi the section title
		$text_line_1 = $temp_lines[0];
						#print "<br> text whole: $text2";
						#print "<br> $text_line_1 <br>";
#remove first line from text, moved and wrap the remaining text----

		$text_rest = str_replace($text_line_1, "",$text2);
						#print "<br> text rest : $text_rest";

		$text_rest = str_replace("\n", "",$text_rest);

		$char_count = 50;
		$rest_wrap = wordwrap($text_rest, $char_count,"\n");
		$rest_size = imageftbbox($black_text_size,0, $font_file, $rest_wrap);

		$X_start = $black_X_positions[0];
		while($rest_size[4] > $X_limit-$X_start){
			$char_count--;
			$rest_wrap = wordwrap($black_text_rest, $char_count,"\n");
			$rest_size = imageftbbox($black_text_size,0, $font_file, $rest_wrap);
		}
#----------------------------------------------------------------------

		#douple place the text to make bold
		imagettftext($background_image, $black_text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);
		imagettftext($background_image, $black_text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);

		#split the line so effects are blue ------
		$segments= explode(": ",$text_line_1);
		$restriction = $segments[0] .= ": ";
		$effect = $segments[1];
		$restriction_box = imagettfbox($black_text_size,0,$font_file, $restriction);
		$effect_ofset = $restriction_box[4];

		imagettftext($background_image, $black_text_size, 0, $database_X_positions[$i], $database_Y_positions[$i], $black,$font_file, $restriction);

		imagettftext($background_image, $black_text_size, 0, $database_X_positions[$i]+$effect_ofset, $database_Y_positions[$i], $blue, $font_file, $effect);
		#--------------------------------------------


		$lines = explode("\n", $text_rest);
		$line_count = count($lines);
							#print "<br> line $line_count <br>";
							#print "<br> y position 3 $black_Y_positions[2] <br>";
		for($l = 0; $l <count($lines); $l++)
			imagettftext($background_image, $black_text_size, 0, $black_X_positions[$i], $database_Y_positions[$i]+(($full_size+3)*($l+1)), $blue,$font_file, $lines[$l]);
		$X_start=$database_X_positions[$i];
		
#chnage the Ypostion of the rest
		if($i+1 < count($database_text)){
			$database_Y_positions[$i+1] = $database_Y_positions[$i+1] + ($full_size+3)*count($lines);
			$black_Y_positions[$i+1] = $black_Y_positions[$i+1] + ($full_size+3)*count($lines);
		}
						#print "<br> change i + 1; y position 3 $black_Y_positions[2] <br>";
		if($i+2 < count($database_text)){
			$database_Y_positions[$i+2] = $database_Y_positions[$i+1] + ($full_size+3)*(count($lines)-1)+3;
			$black_Y_positions[$i+2] = $black_Y_positions[$i+1] + ($full_size+3)*(count($lines)-1)+3;
		}
						#print "<br> change i + 2; y position 3 $black_Y_positions[2] <br>";
	}

#single line effect data-----------
	else{
	#douple place the text to make bold
		imagettftext($background_image, $black_text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);
		imagettftext($background_image, $black_text_size, 0, $black_X_positions[$i], $black_Y_positions[$i], $black,$font_file, $black_text[$i]);

		#split the line so effects are blue ------
		$segments= explode(": ",$database_text[$i]);
		$restriction = $segments[0] .= ": ";
		$effect = $segments[1];
		$restriction_box = imagettfbbox($black_text_size,0,$font_file, $restriction);
		$effect_ofset = $restriction_box[4];
		imagettftext($background_image, $black_text_size, 0, $database_X_positions[$i], $database_Y_positions[$i], $black,$font_file, $restriction);
		imagettftext($background_image, $black_text_size, 0, $database_X_positions[$i]+$effect_ofset, $database_Y_positions[$i], $blue, $font_file, $effect);
	}
#--------------------------------------------
}
# ---------------------------------------------------------------------------------------

#Specail text section --------------------

#set up an array of 2 if there is no lines
if(empty($lines))
	$lines = array(" ", " ");


$X_start = $black_X_positions[0];
$char_count =50;
$specail_wrap = wordwrap($specail_text,$char_count,"\n");
$specail_box = imagettfbbox($text_size,0,$font_file, $specail_wrap);
while($specail_box[4] > $X_limit - $X_start){
	$char_count--;
			$specail_wrap = wordwrap($specail_text, $char_count,"\n");
			$rest_wrap = imageftbbox($black_text_size,0, $font_file, $specail_wrap);
}
$specail_Y_position = $black_Y_positions[2] + ($full_size+3)*(count($lines)-1)+3;

$lines = explode("\n", $specail_wrap);
for($l = 0; $l < count($lines); $l++)
imagettftext($background_image, $black_text_size, 0, $black_X_positions[0], $specail_Y_position+($full_size+3)*$l, $red,$font_file, $lines[$l]);

#---------------------------------------------------



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