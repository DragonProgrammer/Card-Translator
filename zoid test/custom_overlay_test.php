<html>
<body>
<?php 

print '<form method=post>';

#------------------------------------------------------------------------------------
#data from SQL
$file = "custom.png";
$overlay = "custom mask take two.png";
$name ="Rennie K. (Kuehl) Schwester";


$specail_text =  "<declared> During your Custom Phase, equip an adjacent S-class Zoid. Trash all cards attached to the equipped Zoid, and treat it as a Custom Card that provides its ranged and melee AT as additional attack AT. During your Custom Phase, you may detach the equipped Zoid and place it on a square adjacent to the Zoid it was attached to, with the same HP as when it was attached. *Cannot be equipped on S-class Zoids.";


#---------------------------------------------------------------------------------
#image set up
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

#####Measuements based off of 499 X 688 image #####

					#print "width $width height $height <br>";

print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";
$im = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);

imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);
ob_start();
  imagejpeg( $im, NULL, 100 );
#  imagedestroy( $im2 );
  $i = ob_get_clean();

#110
echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!


$background_image = $im;
#text replacements for ease of read

$specail_text = str_replace("<","[",$specail_text);
$specail_text = str_replace(">","]",$specail_text);

# "attack AT" with "attack"
$specail_text = str_replace("attack AT","attack",$specail_text);
# "ranged" with "shoot"
$specail_text = str_replace("ranged","shoot",$specail_text);
$specail_text = str_replace("[declared]","[declared]:",$specail_text);





#-----------------------------------------------------------------------------------------
#font data
$font_file = 'times.TTF'; // link in a font file

#define colors
$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);


#define text size
$black_text_size = 12;
$name_size = 20;

#create rise for below line letter parts
$black_test_size = imageftbbox($black_text_size, 0, $font_file, "Ag");
$black_dip = $black_test_size[1];
$full_size = $black_dip + abs($black_test_size[7]);

					#print "<br> dip: $dip";
$name_test_size =imageftbbox($name_size, 0, $font_file, "Ag");
$name_dip = $name_test_size[1];

#name postion
$name_box_center = (335 - 29)/2;
$name_position = array(60, 478);

$white_box_positions = array(55, 505+$black_text_size);
$X_start = $white_box_positions[0];
$X_limit = 450;

#--------------------------------------------------------------------------------------------------



#print name
imagettftext($background_image, $name_size, 0, $name_position[0], $name_position[1], $white ,$font_file, $name);

#$---------------------------------------------------------------------------------------------------------
$total_lines= 0;
$specail_text2 = explode(" *", $specail_text);
if(count($specail_text2) > 1){
for($a = 1; $a < count($specail_text2); $a++){
	$asterix ="*";
	$specail_text2[$a] = $asterix .= $specail_text2[$a];
}
}
for($l = 0; $l < count($specail_text2); $l++){
	$text_size_raw = imageftbbox($black_text_size,0, $font_file, $specail_text2[$l]);
	if ($text_size_raw[4] > $X_limit-$X_start)
	{
		$char_count = 70;
		$text2 = wordwrap($specail_text2[$l], $char_count,"\n");
		$text_size_wrap = imageftbbox($black_text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_start){
			$char_count--;
			$text2 = wordwrap($specail_text2[$l], $char_count,"\n");
			$text_size_wrap = imageftbbox($black_text_size,0, $font_file, $text2);
		}
		$specail_text2[$l] = $text2;
	}
	}	
#----------------------------------------------------------------------

	
for($s = 0; $s < count($specail_text2); $s++){
$lines = explode("\n", $specail_text2[$s]);
for($l = 0; $l < count($lines); $l++)
	imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $black,$font_file, $lines[$l]);
$total_lines = $total_lines +count($lines);
}
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