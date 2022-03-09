<html>
<body>
<?php 

#-------------------------------------------------------------------------------------------------------
#text outline function
# from https://stackoverflow.com/questions/31453028/php-and-gd-library-add-1px-solid-border-to-a-text-im-getting-a-border-like-dot
function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}

#--------------------------------------------------------------------------------------------------

$Table= array(array('Gojulas',NULL,600,700,4,'forwards +1',3,'straight +1',NULL,NULL,'F'),
    array('Death Saurer',NULL,800,800,4,'forwards +1',3,'straight +1',NULL,NULL,'F'),
    array('Gordos',NULL,500,300,5,'forwards +1',3,NULL,'forest','Can attack and counter 1 square diagonally to the rear (its blind spots).','F'),
    array('Iron Kong',NULL,600,700,3,'forwards +1',4,NULL,'forest',NULL,'F'),
    array('Shield Liger',NULL,400,600,3,'forwards +1',5,'straight +2','mountain',NULL,'F'),
    array('Saber Tiger',NULL,400,600,3,'forwards +1',4,'straight +2','mountain',NULL,'F'),
    array('Dibison',NULL,500,500,3,'forwards +2',3,'straight +2',NULL,NULL,'F'),
    array('Red Horn',NULL,400,600,4,'forwards +1',3,'straight +1',NULL,NULL,'F'),
    array('Command Wolf',NULL,400,500,3,'forwards/sideways/backwards +1',4,'straight +2','mountain, forest',NULL,'F'),
    array('Redler',NULL,300,500,2,NULL,8,'straight +1','air',NULL,'F'),
    array('Cannon Tortoise',NULL,400,200,5,'forwards +2',2,'water +1','water',NULL,'F'),
    array('Brachios',NULL,400,400,3,NULL,3,'water +2','water',NULL,'F'),
    array('Barigator',NULL,400,400,3,NULL,3,'water +2','water',NULL,'F'),
    array('Molga',NULL,400,400,3,'forwards +1',4,'straight +1','forest, sand','-100 damage when attacked from the front.','F'),
    array('Godos',NULL,400,500,2,NULL,4,NULL,'forest',NULL,'F'));
#-----------------------------------------------------------------------------------------------------------

#-----------------------------------------------------------------------------------------------------------
#hard code in data that will later be gotten from SQL database
#assign files to variable, 
$file = "gilvader.png";
$overlay = "zoid mask transparent.png";




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
#$database_elements = count($database_text);



$Name_pos = array(225,54);
$name_size = 30;

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

#---------------------EVERYTHING ABOVE IS ONE TIME DO-----------------------------

#-----------------------------------------------------------------------------
for($R = 0; $R < count($Table); $R++){
$Row = $Table[$R];
$Name = $Row[0];

$database_text= array($Row[2],$Row[3],$Row[4], $Row[5], $Row[6], $Row[7]);
$Icon_Flag = $Row[10];
$specail_text = $Row[9];
createCard($im, $Name, $database_text, $specail_text, $Icon_Flag, $image_sized, $im_overlay, $width, $height);
}
#---------------------------------------------------------------------------------------
#check for Icon_Flag

function createCard(&$image, $Name, $database_text, $specail_text, $Icon_Flag, &$image_sized, $im_overlay, $width, $height ){
if($Icon_Flag == 'T'){

# transfers the icon from the lower gray box onto the overlay if the card has one
$tmp = $image_sized;
imagecopy($im_overlay, $tmp, 358,545,358,545, 52, 50);
}

#TODO add Elephander case

#apply overlay to image
imagecopy($image_sized, $im_overlay, 0,0,0,0, $width, $height);

#--------------------------------------------------------------------------------------
#place name

$name_box = imagettfbbox($name_size,0,$font_file,$Name);
$name_half = ($name_box[0]+$name_box[2])/2;
imagettfstroketext($image_sized, $name_size, 0, $Name_pos[0]-$name_half, $Name_pos[1], $white, $black ,$font_file, $Name, 1);

#------------------------------------------------------------------------------------------
#place database text
for( $i = 0; $i < $database_elements; $i++) {
	$displacement_box = imagettfbbox($text_size,0,$font_file,$database_text[$i]);
	$text_displacement = $displacement_box[2];
	imagettftext($image_sized, $text_size, 0, $database_X_positions[$i]-$text_displacement, $database_Y_positions[$i], $black ,$font_file, $database_text[$i]);
}

#--------------------------------------------------------------------------------------------------------

#do grey box text






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






ob_start();
  imagejpeg( $image_sized, NULL, 100 );
  $i = ob_get_clean();
echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!
}
?>

</body>
</html>
