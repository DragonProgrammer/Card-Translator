<html>
<body>
<?php 
#-----------------------------------------------------------------------------------------------------------
#hard code in data that will later be gotten from SQL database
#assign files to variable, 
$file = "blade_liger.png";
$overlay = "zoid mask transparent.png";

#assign a flag indicating if the card has an icon that needs to be transfered
#		T = True/Yes   F = False/No  E = Elephander (the specail case)
$Icon_Flag = 'T';

#assign the quriable text elements
#		values are (Shoot, Melee, Range, Melee range, Mobility, Mobility Modifier)
$database_text= array("300","700","3", "", 6, "straight +2");

#assign the grey box text
$specail_text = "(1) 800 melee AT only if attacking sideways. (2) -200 damage when attacked from the front.";
#-----------------------------------------------------------------------------------------------------------

#additional variables

$color_image = imagecreate(10,10);


#constant text
$text = array("Attack", "Shoot", "Melee", "Range", "Mobility", "Aptitude");

#text variable
$font_file = 'times.TTF'; // link in a font file
$text_size = 18;
$Specail_text_size = 7;

#compute midpoint of boxes in Y
#		Y positiona: 420 = Top of yellow divider   468 = bottom of yellow divide
#								 478 = top of green divide     525 =  bottom of green divide
$yellow_mid = 420+((468 - 420)/2);
$green_mid = 478+((525 - 478)/2);

#text locations
# imagettftext position is lower left of string  [$yellow_mid + 6] for middle alisgnment
$Y_positions = array($yellow_mid+6, 420 + $text_size, 468 - 3, $yellow_mid+6, $green_mid+6, $green_mid+6);
$X_positions = array(28, 105, 105, 228, 28,228);
$database_Y_positions = array(420 + $text_size, 468 - 3, 420 + $text_size, 468 - 3, 478 + $text_size, 525-3);
$database_X_positions = array(218,218,416,416,218, 218);

$elements = count($text);
$database_elements = count($database_text);

#----------------------------------------------------------------------------------------------------------

print '<form method=post>';
#base image creation

#get file sizes
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

$size2 = (getimagesize($overlay));
$width_2=$size2[0];
$height_2=$size2[1];

#debuging output -----------
print "width $width height $height <br><br>";
print "width $width_2 height $height_2 <br><br>";

# post origanal image
print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";
# --------------------------

#create images from files
$im = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);

# Create an image the size of the overlay
#		ASSUMES that the card image is a different size to the overlay
#		if they are not this just moves the image to a different variable
$image_sized = imagecreatetruecolor($width_2, $height_2);
imagecopyresampled($image_sized, $im, 0,0,0,0, $width_2, $height_2, $width, $height);

#print out the resized image, Debug ------
ob_start();
imagejpeg( $image_sized, NULL, 100 );
$i = ob_get_clean();
echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>";
#-----------------------------------------

#check for Icon_Flag
if($Icon_Flag == 'T'){

# transfers the icon from the lower gray box onto the overlay if the card has one
$tmp = $image_sized;
imagecopy($im_overlay, $tmp, 358,545,358,545, 52, 50);
}

#TODO add Elephander case

#apply overlay to image
imagecopy($image_sized, $im_overlay, 0,0,0,0, $width, $height);

#--------------------------------------------------------------------------------------------------------
# define colors

#colors for text
$black = imagecolorallocate($image_sized, 0,0,0);
$white = imagecolorallocate($image_sized, 255,255,255);
$red = imagecolorallocate($image_sized, 255,0,0);
$yellow_divide = imagecolorallocate($image_sized, 202,123,64);
$yellow_shadow = imagecolorallocate($image_sized, 162, 89, 21);
$green_divide = imagecolorallocate($image_sized, 20,132,86);
$green_shadow = imagecolorallocate($image_sized, 7, 111, 60);

#---------------------------------------------------------------------------------------------------------
#add a dividing line in the boxes
#	y positions   103 = begining of text in yellow left    223 = middle of divider    290 = right of "range" 
#								415 = right of yellow box                112 = Right of "mobility"     
imageline($image_sized,103,$yellow_mid-1,223,$yellow_mid-1, $yellow_shadow);
imageline($image_sized,103,$yellow_mid,223,$yellow_mid, $yellow_divide);
imageline($image_sized,290,$yellow_mid-1,415,$yellow_mid-1, $yellow_shadow);
imageline($image_sized,290,$yellow_mid,415,$yellow_mid, $yellow_divide);
imageline($image_sized,112,$green_mid,223,$green_mid, $green_shadow);
imageline($image_sized,112,$green_mid-1,223,$green_mid-1, $green_divide);

#-------------------------------------------------------------------------------------------------------

#place green and yellow text

#set up fixed text
for( $i = 0; $i < $elements; $i++) {
	imagettftext($image_sized, $text_size, 0, $X_positions[$i], $Y_positions[$i], $black ,$font_file, $text[$i]);
}

#place database text
for( $i = 0; $i < $database_elements; $i++) {
	$displacement_box = imageftbbox($text_size,0,$font_file,$database_text[$i]);
	$text_displacement = $displacement_box[2];
	imagettftext($image_sized, $text_size, 0, $database_X_positions[$i]-$text_displacement, $database_Y_positions[$i], $black ,$font_file, $database_text[$i]);
}

#--------------------------------------------------------------------------------------------------------

#do grey box text

#specail_text ="'Plasma Particle Cannons' [declared]: Reduce this Zoid's HP by 1000 and deal 1000 damage to up to 2 enemy Zoids in range, or up to 3 if you reduce this Zoid's HP by 1500 instead. 'Blitzkrieg' [constant]: -1 enemy accuracy when targeted by enemies without [air] aptitude, but +1 enemy accuracy when targeted by enemies with it.";

$lines = explode(". ", $specail_text);
$line_count = count($lines);
$X_position = 30;
$X_limit = 415;

#create Y positions
$Y_position = 540;
$Y_Start = array($Y_position); #create a 1 element array with the first bing the top of the white box
$Y_Positions = array_pad($Y_Start, $line_count, $Y_position); # create a starting array of y positions  equal to the line count

#initial split
for( $i = 0; $i < $line_count; $i++) {
	$text_size_raw = imageftbbox($Specail_text_size,0, $font_file, $lines[$i]);
	$text2= $lines[$i];
		$char_count = 100;
		$text2 = wordwrap($lines[$i], $char_count,"\n");
		$text_size_wrap = imageftbbox($Specail_text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_position){
			$char_count--;
			$text2 = wordwrap($lines[$i], $char_count,"\n");
			$text_size_wrap = imageftbbox($Specail_text_size,0, $font_file, $text2);
		}
		$lines[$i] = $text2;
		if($i+1 < $line_count){
echo $text_size_wrap[1];
print "<br>";

			$Y_Positions[$i+1] = $Y_Positions[$i] + $Specail_text_size+5 +$text_size_wrap[1];
	}
}

#secondary split if line need red text
for($l = 0; $l < $line_count; $l++){ 
	if(strpos($lines[$l], ": ") !== false){
		$sub_lines = explode(": ", $lines[$l]);
		$lines[$l] = $sub_lines;
	}
}

#determing number of lines
$total_lines = 0;

#echo $total_lines;
#print "<br>";
for($l = 0; $l < $line_count; $l++){ 
	$text_counter = $lines[$l];
	if(is_array($text_counter) == true){
		$total_lines++;
#echo $total_lines;
#print "<br>";
		$text_counter2 = explode("\n", $text_counter[1]); #splitt the rest of the text into lines and count
#echo count($text_counter2);
#print "<br><br>";		
		for($c = 1; $c < count($text_counter2); $c++){
			$total_lines++;
#echo $total_lines;
#print "<br>";
		}
	}
	else{
		$text_counter2 = explode("\n", $text_counter[0]); #splitt the rest of the text into lines and count
#echo count($text_counter2);
#print "<br>";
		for($c = 0; $c < count($text_counter2); $c++){
		$total_lines++;
#echo $total_lines;
#print "<br>";
		}
	}
}
#echo $total_lines;
#print "<br>";

#set grey box text size based on line count
if($total_lines == 2)
	$Specail_text_size = 13;

if($total_lines == 3)
	$Specail_text_size = 9;

if($total_lines == 4)
	$Specail_text_size = 7;
#echo $Specail_text_size;

#place grey box text
for($l = 0; $l < $line_count; $l++){ 
	$text = $lines[$l];
	if(is_array($text) == true){


		$title = imageftbbox($Specail_text_size,0, $font_file, $text[0]);
		$offset = $title[2];

		imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l]+$Specail_text_size, $red ,$font_file, $text[0]);

		$text_indented = explode("\n", $text[1]);

		imagettftext($image_sized, $Specail_text_size, 0, $X_position+$offset+$Specail_text_size, $Y_Positions[$l]+$Specail_text_size, $black ,$font_file, $text_indented[0]);
		for ($i = 1; $i < count($text_indented); $i++){
			imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l]+(($Specail_text_size*2.75)*$i), $black ,$font_file, $text_indented[$i]);
#change Y positions to reflect new lines

		}
	}
	else{

		imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l]+($Specail_text_size), $black ,$font_file, $text);
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