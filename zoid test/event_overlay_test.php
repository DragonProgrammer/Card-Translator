<html>
<body>
<?php 

print '<form method=post>';

#------------------------------------------------------------------------------------
#data from SQL
#$file = "event_base.png";
$file = "event_symbol.png";

$overlay = "event_mask.png";
$symbol = "event_symbol.png";
$name ="Dream Crush (Dream Annihilation Formation)";


$specail_text =  "An encirclement attack against 1 enemy Zoid by 3 or more Zoids piloted by Team Dream Dragon members. Move the participating Zoids in order. If the Zoid targeted by the attack is within attack range of the participating Zoids, roll as many dice as there are participating Zoids that have it in range, and deal the total result x 200 in damage to the target Zoid. Do not receive counters.";

$Icon_Flag = 'T';

#---------------------------------------------------------------------------------
#image set up
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

#####Measuements based off of 499 X 694 image #####

					#print "width $width height $height <br>";

print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";
$im = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);
$im_symbol = imagecreatefrompng($symbol);

imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);
ob_start();
  imagejpeg( $im, NULL, 100 );
#  imagedestroy( $im2 );
  $i = ob_get_clean();

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
$specail_text = str_replace("Declare usage.","[declared]:",$specail_text);
$specail_text = str_replace("[constant]","[constant]:",$specail_text);
$specail_text = str_replace("[induced]","[induced]:",$specail_text);
#-----------------------------------------

#check for Icon_Flag
if($Icon_Flag == 'T'){

# transfers the icon from the lower gray box onto the overlay if the card has one
imagecopy($im_overlay, $im_symbol, 395,554,395,554, 53, 53);
}

#TODO add Elephander case

#apply overlay to image
imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);



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
$name_position = array(30, 460);

$white_box_positions = array(55, 505+$black_text_size);
$X_start = $white_box_positions[0];
$X_limit = 450;
$X_limit_symbol = 395;
$Y_limit_symbol = 554;
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
$line_bottom = 0;
$Shortened_text= "";
$unshortend_lines = 0;
if($Icon_Flag =='T'){
	for($s = 0; $s < count($specail_text2); $s++){
		$lines = explode("\n", $specail_text2[$s]);
		for($l = 0; $l < count($lines); $l++){
			$line_bottom = $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines);
			if($line_bottom <= $Y_limit_symbol){
				imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $line_bottom, $black,$font_file, $lines[$l]);
				$unshortend_lines++;
			}
			#create a new set of text to wrap in a smaller box
			if($line_bottom > $Y_limit_symbol){
				$Shortened_text .= $lines[$l];
				$Shortened_text .= " ";
			}
		}
	}


print "<br> $Shortened_text";

$Shortened_text2 = explode(" *", $Shortened_text);
if(count($Shortened_text2) > 1){
for($a = 1; $a < count($specail_text2); $a++){
	$asterix ="*";
	$Shortened_text2[$a] = $asterix .= $Shortened_text2[$a];
}
}
for($l = 0; $l < count($specail_text2); $l++){
	$text_size_raw = imageftbbox($black_text_size,0, $font_file, $Shortened_text2[$l]);
	if ($text_size_raw[4] > $X_limit_symbol-$X_start)
	{
		$char_count = 70;
		$text2 = wordwrap($Shortened_text2[$l], $char_count,"\n");
		$text_size_wrap = imageftbbox($black_text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit_symbol-$X_start){
			$char_count--;
			$text2 = wordwrap($Shortened_text2[$l], $char_count,"\n");
			$text_size_wrap = imageftbbox($black_text_size,0, $font_file, $text2);
		}
		$Shortened_text2[$l] = $text2;
	}
	}	
for($s = 0; $s < count($Shortened_text2); $s++){
		$lines = explode("\n", $Shortened_text2[$s]);
		for($l = 0; $l < count($lines); $l++){
			$line_bottom = $white_box_positions[1]+($l*$full_size)+($full_size*$unshortend_lines);
			imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $line_bottom, $red,$font_file, $lines[$l]);
			}
		}
}
#------------------------------------------------------------------------	
if($Icon_Flag =='F'){
$flag_red = 'F';
$Left_X_position = $white_box_positions[0];	
for($s = 0; $s < count($specail_text2); $s++){
	if(str_contains($specail_text2[$s], "*") == true){
		$lines = explode("\n", $specail_text2[$s]);
		for($l = 0; $l < count($lines); $l++)
			imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $red,$font_file, $lines[$l]);
		$total_lines = $total_lines +count($lines);
		continue;
		}
	
	$lines = explode("\n", $specail_text2[$s]);
	for($l = 0; $l < count($lines); $l++){
#splitt stuff up for making red text
		if(str_contains($lines[$l], ":") == true){
			$split= explode(":", $lines[$l]);
			$first_box = imagettfbbox($black_text_size, 0 , $font_file, $split[0]);
			$box_displacement = $first_box[4];
			imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $red,$font_file, $split[0]);
#this will need to be fit into the below equasion
			imagettftext($background_image, $black_text_size, 0, $white_box_positions[0]+$box_displacement, $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $black,$font_file, $split[1]);
			continue;
		}

		if(str_contains($lines[$l], "+") !== true)
			imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $black,$font_file, $lines[$l]);
	#split on plus
		else if(str_contains($lines[$l], "+") == true){
			$math_split = explode("+",$lines[$l]);
			$plus = "+";
			for($m=1; $m < count($math_split); $m++){
				$text_replace= $plus;
				$text_replace .= $math_split[$m];
				$math_split[$m] = $text_replace;
			}
#set up printing line
			for($m=0; $m < count($math_split); $m++){
				# close off the red area
				if(str_contains($math_split[$m], ",")==true || str_contains($math_split[$m], ".") == true){
					$end_char = "."; # might want to diferenciate more later
					$second_segments = preg_split("/[.,]/", $math_split[$m]);
					for($s=0; $s < count($second_segments)-1; $s++){
							$text_replace= $second_segments[$s];
							$text_replace .= $end_char;
							$second_segments[$s] = $text_replace;
					}
					for($s=0; $s < count($second_segments)-1; $s++){
							$text_box = imagettfbbox($black_text_size,0,$font_file,$second_segments[$s]);
							$text_legnth = $text_box[4];
						if(str_contains($second_segments[$s], "+") == true ){
							imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $red,$font_file, $second_segments[$s]);
							$white_box_positions[0]= $text_legnth + $white_box_positions[0]; #increment along line
							$flag_red = 'F';  # just finished a red section
						}
						else{
							imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $black,$font_file, $second_segments[$s]);
							$white_box_positions[0]= $text_legnth + $white_box_positions[0];
						}
					}
				}
					#we have a open ened + symbol
				else if(str_contains($math_split[$m], "+") == true){
					$flag_red = 'T';
					$text_box = imagettfbbox($black_text_size,0,$font_file,$math_split[$m]);
					$text_legnth = $text_box[4];
					imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $red,$font_file, $math_split[$m]);
					$white_box_positions[0]= $text_legnth + $white_box_positions[0];
				}
				else{   		#we have not gotten to the red part
					$text_box = imagettfbbox($black_text_size,0,$font_file,$math_split[$m]);
					$text_legnth = $text_box[4];
					imagettftext($background_image, $black_text_size, 0, $white_box_positions[0], $white_box_positions[1]+($l*$full_size)+($full_size*$total_lines), $black,$font_file, $math_split[$m]);
					$white_box_positions[0]= $text_legnth + $white_box_positions[0];
				}
			}
			$white_box_positions[0] = $Left_X_position;
		}
			#if flag is true need to resolve close
			# we have now completeed the spliting on the +
	}
	$total_lines = $total_lines +count($lines);
}
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