<html>
<body>
<?php 
#-----------------------------------------------------------------------------------------------------------
#hard code in data that will later be gotten from SQL database
#assign files to variable, 
$file = "mobile_base.png";
$size_test = "gilvader.png";
$overlay = "mobile_fort_mask.png";

#assign a flag indicating if the card has an icon that needs to be transfered
#		T = True/Yes   F = False/No  E = Elephander (the specail case)
$Icon_Flag = 'F';

#assign the quriable text elements
#		values are (Shoot, Melee, Range, Melee range, Mobility, Mobility Modifier)
#$database_text= array("300","700","3", "", 6, "straight +2");
$database_text= array("1100","800", 6, "");
#assign the grey box text
$specail_text = "(1) 800 melee AT only if attacking sideways. (2) -200 damage when attacked from the front.";
#-----------------------------------------------------------------------------------------------------------

#additional variables

$color_image = imagecreate(10,10);


#constant text
$text = array("Attack", "Shoot", "Melee", "AoE", "Mobility", "Aptitude");

#text variable
$font_file = 'times.TTF'; // link in a font file
$text_size = 18;
$Specail_text_size = 7;
$area_text_size;

#compute midpoint of boxes in Y
#		Y positiona: 420 = Top of yellow divider   468 = bottom of yellow divide
#								 478 = top of green divide     525 =  bottom of green divide
$yellow_mid = 420+((468 - 420)/2);
$green_mid = 478+((525 - 478)/2);

$base_offset = 5; # for boter problem between zoid and mobile base

#text locations
# imagettftext position is lower left of string  [$yellow_mid + 6] for middle alisgnment
$Y_positions = array($yellow_mid+6, 420 + $text_size, 468 - 3, $yellow_mid+6, $green_mid+6, $green_mid+6);
$X_positions = array(28+1, 105, 105, 228+1, 28+1,228+$base_offset);
$database_Y_positions = array(420 + $text_size, 468 - 3, 478 + $text_size, 525-3);
$database_X_positions = array(218,218,218, 218);

$elements = count($text);
$database_elements = count($database_text);


$Name = "Gilvader";
$Name_pos = array(225,54);
$name_size = 30;

#----------------------------------------------------------------------------------------------------------

print '<form method=post>';
#base image creation

#get file sizes
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

$size2 = (getimagesize($size_test));
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



$tmp = $im;
imagecopy($im_overlay, $tmp, 295,468,290,468, 55, 50);

#apply overlay to image [location changed from zoid]
imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);

# Create an image the size the smaler zoid image, preseves code from zoid to mobile fort

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

#-------------------------------------------------------------------------------------------------------
#$tmp = $image_sized;
#imagecopy($tmp, $image_sized, 465,423,260,423, 70, 50);
#$image_sized = $tmp;



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
imageline($image_sized,112,$green_mid,223,$green_mid, $green_shadow);
imageline($image_sized,112,$green_mid-1,223,$green_mid-1, $green_divide);

#-------------------------------------------------------------------------------------------------------
#text outline function
# from https://stackoverflow.com/questions/31453028/php-and-gd-library-add-1px-solid-border-to-a-text-im-getting-a-border-like-dot
function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}

#place name

$name_box = imagettfbbox($name_size,0,$font_file,$Name);
$name_half = ($name_box[0]+$name_box[2])/2;
imagettfstroketext($image_sized, $name_size, 0, $Name_pos[0]-$name_half, $Name_pos[1], $white, $black ,$font_file, $Name, 1);

#-------------------------------------------------------------------------------------------------------
#place green and yellow text

#set up fixed text
for( $i = 0; $i < $elements; $i++) {
	imagettftext($image_sized, $text_size, 0, $X_positions[$i], $Y_positions[$i], $black ,$font_file, $text[$i]);
}

#place database text
for( $i = 0; $i < $database_elements; $i++) {
	$displacement_box = imagettfbbox($text_size,0,$font_file,$database_text[$i]);
	$text_displacement = $displacement_box[2];
	imagettftext($image_sized, $text_size, 0, $database_X_positions[$i]-$text_displacement, $database_Y_positions[$i], $black ,$font_file, $database_text[$i]);
}

#---------------------------------------------------------------------------------------------------------
#new text boxes

imagettftext($image_sized, $text_size, 0, 230, 84, $black ,$font_file, "Heal");
$area_letters = array("A","o","E");
$area_text_size = 16;


	$displacement_box = imagettfbbox($area_text_size,0,$font_file,"o");
	$text_displacement = $area_text_size + $displacement_box[5];

$tmp = $image_sized;
imagecopy($im_overlay, $tmp, 358,545,358,545, 52, 50);


for($l= 0; $l < count($area_letters); $l++){
#	imagettftext($image_sized, $area_text_size, 0, 230, 418+(($l+1) * $area_text_size), $black ,$font_file, $area_letters[$l]);
}


#imagettftext($image_sized, $area_text_size, 0, 230, 418+$area_text_size, $black ,$font_file, "$area_letters[0]");

#imagettftext($image_sized, $area_text_size, 0, 230, 418+(2 * $area_text_size) - $text_displacement+ 2, $black ,$font_file, $area_letters[1]);

#imagettftext($image_sized, $area_text_size, 0, 230, 418+(3 * $area_text_size) - $text_displacement+2 , $black ,$font_file, $area_letters[2]);



#--------------------------------------------------------------------------------------------------------

#do grey box text

$specail_text ="'Plasma Particle Cannons' [declared]: Reduce this Zoid's HP by 1000 and deal 1000 damage to up to 2 enemy Zoids in range, or up to 3 if you reduce this Zoid's HP by 1500 instead. 'Blitzkrieg' [constant]: -1 enemy accuracy when targeted by enemies without [air] aptitude, but +1 enemy accuracy when targeted by enemies with it.";

#$specail_text ="'Plasma Particle Cannons' [declared]: Reduce this Zoid's HP by 1000 and deal 1000 damage to up to 2 enemy Zoids in range, or up to 3 if you reduce this Zoid's HP by 1500 instead. 'Blitzkrieg' [constant]: -1 enemy accuracy when targeted by enemies without [air] aptitude, but +1 enemy accuracy when targeted by enemies with it, AAA AAAAAA AA AA AA A A A A A A A A A";

#$specail_text = "\"Electron Drivers\" <declared>: 500 melee attack AT. When judging accuracy, you may roll anywhere from 1 to 5 dice and use whichever result you prefer. Deal 100 x the number of dice you rolled in additional damage, and subtract 200 x the number of dice you rolled from this Zoid's HP. \"Objective Blade Sensors\" <constant>: By trashing 1 Custom Card attached to this Zoid, nullify the effects of an Event Card of the same card level used by the enemy.";

#$specail_text = "\"CAS\" <declared>: During your Custom Phase, change this Zoid into a Liger Zero type Zoid in the same stack with the \"Naked\" ability. After changing, recover 200 HP. \"Rushing Laser Blades\" <declared>: After moving straight ahead, perform a melee attack. +1 accuracy, deals 100 x the number of squares you moved in damage. *Only normal movement is added to damage.";

#$specail_text = "\"X-Breakers\" <declared>: If its melee attack hits a Zoid, deal 100 x the number of Custom Cards attached to that Zoid in damage. \"Focused Charged Particle Cannon\" <declared>: 600 ranged attack AT, certain hit. Attack all Zoids within forwards range, including ally Zoids. If used, subtract 200 from this Zoid's HP and return its pilot to your deck. Afterwards, reshuffle your deck. *This ability cannot be used on turns in which you attached a pilot to this Zoid.";

#$specail_text = "\"Naked\" <declared>: During your Custom Phase, change this Zoid into a Berserk Führer type Zoid in the same stack with the \"CAS\" ability. \"Reflexive Response\" <declared>: Roll a die in response to the accuracy roll for an attack from an enemy. If you roll a higher number than your opponent, nullify the attack and deal 200 damage to the attacking Zoid. If you use this effect, you cannot counter.";


echo $specail_text;
#$specail_text = "+1 ranged accuracy.";

#Replaceing characters so no code insertion occures --------------

# " with '
$specail_text = str_replace("\"","'",$specail_text);

# <> with []
$specail_text = str_replace("<","[",$specail_text);
$specail_text = str_replace(">","]",$specail_text);

# "attack AT" with "attack"
$specail_text = str_replace("attack AT","attack",$specail_text);

# "attack AT" with "attack"
$specail_text = str_replace("ranged","shoot",$specail_text);

# ---------------------------------------------------------------

#initial split on ". '" most comon case
$lines = explode(". '", $specail_text);
$line_count = count($lines);
$X_position = 30;
$X_limit = 415;

if($line_count > 1){
#add back the .
	for($l= 0; $l<$line_count-1; $l++)
		$lines[$l] .= ".";

#add back the '
	for($l= 1; $l<$line_count; $l++){
		$add = "'";
		$add .= $lines[$l];
		$lines[$l] = $add;
	}
}
#inistal split on ". (" secondary case
if($line_count == 1){
	$lines = explode(". (", $specail_text);
	$line_count = count($lines);
	if($line_count > 1){
#add back the .
		for($l= 0; $l<$line_count-1; $l++)
			$lines[$l] .= ".";

#add back the (
		for($l= 1; $l<$line_count; $l++){
			$add = "(";
			$add .= $lines[$l];
			$lines[$l] = $add;
		}
	}
}


#text wrap
for( $i = 0; $i < $line_count; $i++) {
	$text_size_raw = imagettfbbox($Specail_text_size,0, $font_file, $lines[$i]);
	$text2= $lines[$i];
		$char_count = 100;
		$text2 = wordwrap($lines[$i], $char_count,"\n");
		$text_size_wrap = imagettfbbox($Specail_text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_position){
			$char_count--;
			$text2 = wordwrap($lines[$i], $char_count,"\n");
			$text_size_wrap = imagettfbbox($Specail_text_size,0, $font_file, $text2);
		}
		$lines[$i] = $text2;
#		if($i+1 < $line_count){

#			$Y_Positions[$i+1] = $Y_Positions[$i] + abs($text_size_wrap[7]) + $text_size_wrap[1];
#	}
}

#secondary split if line need red text
for($l = 0; $l < $line_count; $l++){ 
	if(strpos($lines[$l], ": ") !== false){
		$sub_lines = explode(": ", $lines[$l]);
		$sub_lines[0] .= ": ";
		$lines[$l] = $sub_lines;
	}
}

#debug output -----------
#print "<br> <br> Secondary split check <br>";
#$count = count($lines)
#Print "<br> line count: $count <br>";
#for($l =0; $l < count($lines); $l++){
#		Print "<br> Line $l ";
#	if(is_array($lines[$l]) == true){
		#$text = $lines[$l];
		#print "Segmented line: $text[0] | $text[1]"; 
	#}
	#else
#		echo $lines[$l]; 
#}
		#-------------------------




#determing number of lines, and creating final lines array------
$line_number = 0;
$new_lines = array();
							#echo $total_lines; 
							#print "<br> Line creation step by step <br>";
for($l = 0; $l < $line_count; $l++){ 
							#print "<br> Line $l from lines array <br>";
							#$new_count = count($new_lines);
							#print "<br> Lines in new_lines $new_count<br>";
	$text_counter = $lines[$l];
#set up split lines in new array
	if(is_array($text_counter) == true){
							#print "<br> this line is split";
		$tmp = array(" ", " ");
		$tmp[0] = $text_counter[0];
							#print "<br> Element 1 is $tmp[0] ";							
#split on new lines
		$text_counter2 = explode("\n", $text_counter[1]);
		$tmp[1] = $text_counter2[0];
							#print "| Element 2 is $tmp[1]"; 
		array_push($new_lines, $tmp);
							#$new_count = count($new_lines);
							#print "<br> Lines in new_lines $new_count<br>";
#put rest of lines into spots in new_lines array
		for($c = 1; $c < count($text_counter2); $c++){
			array_push($new_lines, $text_counter2[$c]);
			$line_number++;
		}
	}
	else{
#split on new lines
		$text_counter2 = explode("\n", $text_counter); 
		#print "<br> Total lines before split at new line ";
							#echo $total_lines;
		#$total_lines += count($text_counter2);
							#print "<br> Total lines after split at new line ";
							#echo $total_lines;
		for($c = 0; $c < count($text_counter2); $c++){
		array_push($new_lines, $text_counter2[$c]);
		$line_number++;
		}
	}
}


		#debug output -----------
print "<br> <br> Line Check <br>";
for($l =0; $l < count($new_lines); $l++){
	Print "<br> Line $l ";
	if(is_array($new_lines[$l]) == true){
		$text = $new_lines[$l];
		print "Segmented line:  $text[0] | $text[1]"; 
	}
	else
		echo $new_lines[$l]; 
}
		#-------------------------
#--------------------------------------------------
$total_lines = count($new_lines);
#set grey box text size based on line count
if($total_lines == 1)
	$Specail_text_size = 18;
if($total_lines == 2)
	$Specail_text_size = 13;

if($total_lines == 3)
	$Specail_text_size = 9;

if($total_lines == 4)
	$Specail_text_size = 7;
							#echo $Specail_text_size;

#find spaceing for font size
$spacing_text = "Ag";
$spacing_box = $title = imagettfbbox($Specail_text_size,0, $font_file, $spacing_text);
$spacing = $spacing_box[1]+1;# - $Specail_text_size;

# create the Y positions of each line
$Y_position = 540 + $Specail_text_size;
$Y_Positions = array($Y_position); 
for($l = 1; $l < $total_lines; $l++){
	$prior = $Y_Positions[$l-1];
	print "<br> Prior Y position $prior";
	$new_Y = $Y_Positions[$l-1] + $Specail_text_size + $spacing;
	array_push($Y_Positions, $new_Y);
}

for($y = 0; $y< count($Y_Positions); $y++){
	print "<br> Line $y Yposition ";
	echo $Y_Positions[$y];
}




#place grey box text
for($l = 0; $l < $total_lines; $l++){ 
	$text = $new_lines[$l];
	#this means there needs to be red text
	if(is_array($text) == true){
		$title = imagettfbbox($Specail_text_size,0, $font_file, $text[0]);
		$offset = $title[2];
		imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l], $red ,$font_file, $text[0]);
		$text_indented = explode("\n", $text[1]);
		imagettftext($image_sized, $Specail_text_size, 0, $X_position+$offset, $Y_Positions[$l], $black ,$font_file, $text_indented[0]);
							#print "<br> Number of lines in block";
							#echo count($text_indented);		
		for ($i = 1; $i < count($text_indented); $i++){
			imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l], $black ,$font_file, $text_indented[$i]);
#change Y positions to reflect new lines

		}
	}
	else{

		imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l], $black ,$font_file, $text);
	}
}

#100




ob_start();
  imagejpeg( $image_sized, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!


?>

</body>
</html>
