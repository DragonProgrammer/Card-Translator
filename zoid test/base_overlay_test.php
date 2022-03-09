<html>
<body>
<?php 

print '<form method=post>';

#------------------------------------------------------------------------------------
#data from SQL
$file = "base.png";
$overlay = "base_mask.png";
$name ="S-Class Coupling Latch";

$set_text = array("Shoot Attack", "Range", "Mobility");
$database_text = array("100, 2, -");
$specail_text =  "You may attach any Custom Cards that could be equipped on an L-class Zoid. Ranged attacks are performed directly after your Custom Phase ends. *The base cannot move. *It cannot battle adjacent enemy Zoids.";

$test_text = "*The base cannot move. *It cannot battle adjacent enemy Zoids.";

#based off of a 496 X 695
$set_X_locations = array(35,205,290);
$set_Y_location = 588;
$specail_Y_start = 605;
$specail_X_location = 35;
$X_limit = 460;

$specail_text_size = 12;

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
$specail_text = str_replace("Ranged","Shoot",$specail_text);
$specail_text = str_replace("[declared]","[declared]:",$specail_text);
$specail_text = str_replace("Declare usage.","[declared]:",$specail_text);
$specail_text = str_replace("[constant]","[constant]:",$specail_text);
$specail_text = str_replace("[induced]","[induced]:",$specail_text);




#-----------------------------------------------------------------------------------------
#font data
$font_file = 'times.TTF'; // link in a font file

#define colors
$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);


#define text size
$set_text_size = 14;
$specail_text_size = 12;




$name_size = 20;

#create rise for below line letter parts
$black_test_size = imageftbbox($specail_text_size, 0, $font_file, "Ag");
$black_dip = $black_test_size[1];
$full_size = $black_dip + abs($black_test_size[7]);

					#print "<br> dip: $dip";

#--------------------------------------------------------------------------------------------------



#print name

for($t = 0; $t < count($set_text); $t++){
	imagettftext($background_image, $set_text_size, 0, $set_X_locations[$t], $set_Y_location, $black, $font_file, $set_text[$t]);
}
#imagettftext($background_image, 12, 0, $specail_X_location, $specail_Y_start+ 10, $black, $font_file, $test_text);




#$---------------------------------------------------------------------------------------------------------

$split = explode("*", $specail_text);

$text_size_raw = imagettfbbox($specail_text_size,0, $font_file, $specail_text);
	$text2= $split[0];
		$char_count = 100;
		$text2 = wordwrap($split[0], $char_count,"\n");
		$text_size_wrap = imagettfbbox($specail_text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$specail_X_location){
			echo "in wrap";
			$char_count--;
			$text2 = wordwrap($split[0], $char_count,"\n");
			$text_size_wrap = imagettfbbox($specail_text_size,0, $font_file, $text2);
		}

$lines = explode("\n", $text2);
$total_lines = count($lines);
for ($l = 0; $l < count($lines); $l++)
{
	imagettftext($background_image, $specail_text_size, 0, $specail_X_location, $specail_Y_start+ $specail_text_size +(($full_size) * $l), $black, $font_file, $lines[$l]);
}
for ($s = 1; $s < count($split); $s++){
	$asterix ="*";
	$split[$s] = $asterix .= $split[$s];
}
if (count($split) > 2){
	$split[1] = $split[1] .= $split[2];
}
imagettftext($background_image, $specail_text_size, 0, $specail_X_location, $specail_Y_start+ $specail_text_size +(($full_size) * $total_lines), $red, $font_file, $split[1]);
#----------------------------------------------------------------------

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