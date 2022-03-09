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
    array('Godos',NULL,400,500,2,NULL,4,NULL,'forest',NULL,'F'),
array('Iguan',NULL,400,500,2,NULL,4,'straight +1','forest',NULL,'F'),
    array('Pteras',NULL,300,300,2,NULL,7,'straight +1','air',NULL,'F'),
   array('Helcat',NULL,400,500,2,'sideways/backwards +1',4,NULL,'mountain, forest',NULL,'F'),
    array('Double Sworder',NULL,300,400,3,NULL,5,'straight +1','air',NULL,'F'),
    array('Saicurtis',NULL,300,400,3,NULL,5,'straight +1','air',NULL,'F'),
    array('Blade Liger',NULL,300,700,3,NULL,6,'straight +2','mountain','(1) 800 melee AT only if attacking sideways. (2) -200 damage when attacked from the front.','F'),
    array('Geno Saurer',NULL,600,700,4,'forwards +2',5,'straight +2','mountain, forest','"Focused Charged Particle Cannon" (standard equipment): Declare usage. Reduces own HP by 200 and deals 700 damage (piercing) to 2 Zoids within forwards attack range.','F'),
    array('Storm Sworder',NULL,400,600,2,NULL,8,'straight +3','air','700 melee AT only if attacking sideways.','F'),
    array('Hel Digunner',NULL,400,400,3,'forwards +3',3,NULL,'sand, water',NULL,'F'),
    array('Guysack',NULL,400,500,3,NULL,3,'straight +1','sand','+1 accuracy when countering.','F'),
    array('Rev Rapter',NULL,300,600,3,NULL,4,'straight +1','sand, forest',NULL,'F'),
    array('Stealth Viper',NULL,400,300,4,NULL,4,'straight +1','forest, sand','+1 accuracy when attacking an <air>-aptitude Zoid.','F'),
    array('Gator',NULL,300,300,3,NULL,3,'straight +2','mountain, forest','Lowers accuracy of ranged attacks from enemies: -1 accuracy.','F'),
    array('Command Wolf AS','Irvine spec.',400,600,4,NULL,4,'straight +1','mountain, forest','"Long-Range Rifle" (standard equipment): Declare usage. 600 ranged AT, 7 range, +1 accuracy. However, -200 HP if you roll a 1.','F'),
    array('Saber Tiger RS','Raven spec.',400,600,3,'forwards/sideways +1',5,'straight +2','mountain','Can melee attack and counter 1 square diagonally to the front, as well as straight forwards, with 700 melee AT.','F'),
    array('Shield Liger DCS-J','LeoMaster exclusive',600,600,4,'forwards +2',5,'straight +2','mountain','(1) 700 melee AT when attacking an L-class Zoid. (2) +1 accuracy when attacking an <air>-aptitude Zoid.','F'),
    array('Iron Kong SS','Schwarz spec.',600,700,4,NULL,4,'straight +1','forest, mountain','-100 damage when attacked from the front. [Special armour (red parts) on its chest and shoulders.]','F'),
    array('Gojulas',NULL,600,700,4,'forwards +1',3,'straight +1',NULL,'Can simultaneously melee attack 2 Zoids within a 1-square radius. However, -200 HP if you roll a 1.','F'),
    array('Death Saurer',NULL,800,800,4,'forwards +1',3,'straight +1',NULL,'"Charged Particle Cannon" (standard equipment): Declare usage. Reduces own HP by 200 and deals 900 damage (piercing) to 2 Zoids within attack range.','F'),
    array('Gustav MS','Moonbay spec.',200,100,2,NULL,3,NULL,'mountain, forest, sand','"Transport": When this Zoid moves, you can move up to 2 M-class or 4 S-class adjacent ally Zoids with it.','F'),
    array('Gustav MS','Moonbay spec.',200,100,2,NULL,3,NULL,'mountain, forest, sand','"Transport": When this Zoid moves, you can move up to 2 M-class or 4 S-class adjacent ally Zoids with it.','F'),
    array('Gojulas The Ogre',NULL,900,500,5,NULL,3,NULL,'sand','+3 forwards range if this Zoid did not move this turn.','F'),
    array('Iron Kong PK',NULL,800,700,4,'forwards +2',4,'straight +3','mountain','+100 forwards melee AT.','F'),
    array('Mammoth',NULL,400,500,3,NULL,4,NULL,'forest','"Strike Nose": Can melee attack and counter 2 squares straight forwards.','F'),
    array('Saber Tiger SS','Schwarz spec.',600,600,4,'forwards +3',4,'straight +3','mountain, forest','+100 ranged AT when attacking or countering an <air>-aptitude Zoid.','F'),
    array('Hammer Head',NULL,400,200,3,NULL,6,'water -2','water, (air)','"Underwater Shooting": 500 ranged AT and 5 range when in water.','F'),
    array('Geno Breaker',NULL,400,800,3,NULL,4,'straight +4','mountain, forest, sand','"Destroy Weapons": If its attack hits, you can trash 1 Custom Card attached to the opponent\'s Zoid instead of dealing damage. "Focused Charged Particle Cannon" (standard equipment): Declare usage. Reduces own HP by 200 and deals 700 damage (piercing) to 2 Zoids within forwards attack range.','F'),
    array('Raynos',NULL,300,300,3,NULL,8,NULL,'air','+200 AT when attacking or countering an <air>-aptitude Zoid.','F'),
    array('Black Rhimos',NULL,400,500,3,NULL,4,NULL,NULL,'+200 forwards melee AT.','F'),
    array('Cannon Tortoise HBG',NULL,400,0,7,NULL,2,NULL,'water','"Large-Calibre Beam Cannon": 600 ranged AT and 9 range on forwards line only.','F'),
    array('Redler BC',NULL,300,400,2,NULL,8,'straight +2','air','"Booster Cannons": 500 ranged AT, 5 range.','F'),
    array('Gun Sniper',NULL,400,300,3,NULL,3,'straight +2','forest, sand','600 ranged AT and 5 range only when attacking directly backwards.','F'),
    array('Sinker',NULL,300,200,2,'water +2',6,'water -2','air, (water)','When on a <water> square, treat as having <water> aptitude. Otherwise, treat as having <air> aptitude.','F'),
    array('Ultra Saurus',NULL,800,400,4,'forwards +4',2,NULL,'water','"Omnidirectional Missiles" (standard equipment): Declare usage. 400 damage to all Zoids within a 2-square radius. *Includes bases and ally Zoids. "Weak At Melee": -1 accuracy when performing a melee attack.','F'),
    array('Death Stinger',NULL,500,800,4,'backwards +3',5,NULL,'sand, water','"Charged Particle Cannon" (standard equipment): Declare usage. Deals 700 damage (piercing) to up to 2 Zoids within either forwards or backwards attack range. "Berserk": If you roll a 1 when judging accuracy, it attacks an ally Zoid within range.','F'),
    array('Salamander',NULL,500,300,4,NULL,7,NULL,'air','"Bombing": Declare usage. Its ranged attack changes to 900 AT when attacking bases, 700 AT when attacking Zoids on plains, and 2 range, but it cannot attack Zoids with <air> aptitude.','F'),
    array('Lightning Saix',NULL,600,500,4,'forwards +3',5,'straight +3','mountain, forest','"Ambush": When receiving an attack from an enemy Zoid, it can attack first if that Zoid is within range. *After ambushing, it cannot counter against the enemy Zoid\'s attack.','F'),
    array('Blade Liger AB',NULL,500,700,3,'forwards +3',7,'straight +1','mountain, sand','-200 damage when attacked from the front. "Anger": If you roll a 6 when judging accuracy against a Geno Breaker, deal double damage, but do not deal the extra 100 critical hit damage.','F'),
    array('Dark Horn','Red Horn strengthened type',500,600,4,'forwards +2',4,'straight +2','mountain',NULL,'F'),
   array('Bearfighter',NULL,400,200,4,NULL,4,NULL,'mountain','"Transform": Before moving, you can change its stats to 200 ranged AT, 2 range, 600 melee AT (Bipedal Form). Before moving, you can return it to its original stats (Quadrupedal Form). *When transformed, turn this Zoid Card sideways.','F'),
    array('Dimetrodon',NULL,400,300,3,NULL,4,NULL,'forest, sand','"Electronic Tactics": +1 accuracy to ranged attacks of all ally Zoids within a 1-square radius. *Includes this Zoid.','F'),
    array('Arosaurer',NULL,300,600,3,NULL,5,NULL,'mountain','"Anti-Air Machine Guns": +1 accuracy to ranged attacks against Zoids with <air> aptitude.','F'),
    array('Dead Border',NULL,500,400,3,NULL,4,NULL,'sand','"Gravity Cannons": Declare usage. 5 range and 900 ranged AT against a Zoid that currently has 2000 or more HP.','F'),
    array('Cerberus','Command Wolf custom',400,600,3,NULL,4,'straight +2','mountain, forest','"Double Headed Fangs": Declare usage. You can perform a melee attack on up to 2 Zoids on the 3 squares in front of this Zoid.','F'),
    array('Hel Digunner DT',NULL,400,500,4,'forwards +2',4,NULL,'sand','"Sand Movement": Can be used instead of moving normally. Its mobility on sand terrain is doubled. However, it cannot leave sand terrain.','F'),
    array('Gorhecks',NULL,300,300,3,'forwards +2',4,NULL,'mountain, sand','"Jamming Waves": -1 accuracy to ranged attacks from enemies against all ally Zoids within a 1-square radius. *Does not include this Zoid.','F'),
    array('Hammer Rock',NULL,300,500,3,NULL,3,NULL,'forest','+100 forwards melee AT.','F'),
    array('Gojulas The Buzzsaw','Gojulas custom',400,800,4,NULL,4,NULL,'forest','"Buster Chainsaws (Huge Rotary Saws)": Declare usage. You can perform a melee attack on all adjacent Zoids. The attack will succeed on a result of 2 or higher, but this Zoid receives half of the damage dealt (rounding down to the nearest hundred).','F'),
    array('KFD (Killer From the Dark)','Death Stinger custom',400,700,4,'backwards +3',5,NULL,'sand','"Charged Particle Cannon": Declare usage. Deals 500 damage to up to 2 Zoids within either forwards or backwards attack range. "Berserk Propagation": If it attacks and destroys an enemy Zoid, +500 HP. *This HP increase may exceed the Zoid\'s maximum HP. However, if it does not attack during your turn, -100 HP.','F'),
    array('Liger Zero (Naked)',NULL,100,300,2,NULL,5,NULL,'mountain, forest','"Naked": During your Custom Phase, this Zoid can change into a Liger Zero type Zoid in the same stack with the "CAS" ability. "Wild Cry": Declare usage. Roll for accuracy against all Zoids within a 1-square radius, and paralyse them if the result is 5 or higher. If you roll a 6, deal 200 damage as a critical bonus.','F'),
    array('Bloody Demon','Death Saurer custom',700,800,4,'forwards +2',4,NULL,'sand','"Continuous Charged Particle Cannon": Declare usage. It can perform up to 3 successive attacks against Zoids on its forwards attack line, dealing 800 damage, but subtract 400 HP from this Zoid every time it attacks.','F'),
    array('Liger Zero',NULL,200,600,4,NULL,5,'straight +2','mountain, forest','"CAS (Changing Armour System)": During your Custom Phase, if this Zoid changes into a Liger Zero type Zoid in the same stack with the "Naked" ability, recover 200 HP. "Strike Laser Claw (Photon Claw)": When using a melee attack, the critical bonus becomes +300.','F'),
    array('Elephander',NULL,400,400,4,NULL,4,NULL,'forest','"Swap Equipment": During your Custom Phase, this Zoid can change into an Elephander type Zoid in the same stack with the "Swap Equipment" ability. "Defend Allies": If an adjacent ally Zoid or base receives damage, this Zoid may take the damage instead.','F'),
    array('Gunbluster',NULL,600,200,5,'forwards +1',4,NULL,NULL,'"Full-Power Strafing": Declare usage. For every 200 HP you subtract, you can add 100 ranged attack AT. However, this can only go up to a maximum of +400 AT.','F'),
    array('Elephander CT',NULL,400,400,4,NULL,4,NULL,'forest','"Swap Equipment": During your Custom Phase, this Zoid can change into an Elephander type Zoid in the same stack with the "Swap Equipment" ability. "Combat Command": If this Zoid is in ally territory, you may add 200 ranged attack AT to adjacent ally Zoids.','F'),
    array('Buster Blade','Blade Liger custom',400,400,3,NULL,3,'straight +3',NULL,'"Adapt To Location": If this Zoid is in ally territory, +300 ranged attack AT and +2 forwards range. If it is in enemy territory, +300 melee attack AT and +2 mobility.','F'),
    array('Wardick',NULL,400,200,4,NULL,2,'water +4','water','"Sonic Blaster": Can only declare usage if this Zoid is on <water> terrain. Deals damage to all Zoids on connected <water> terrain within a 6-square radius of this Zoid. Damage dealt ranges from 600 to 100, decreasing by 100 for each square of distance. *Includes bases and ally Zoids.','F'),
    array('Blitzer Wolf','Command Wolf custom',500,300,3,'forwards +2',4,'straight +3','forest, sand','-200 damage when attacked from the sides. "Forced Breakthrough": When moving straight ahead, it may jump over other Zoids.','F'),
    array('Sea Panther',NULL,400,200,3,NULL,3,NULL,'sand, water','-100 damage when attacked from the sides or rear. "Defensive Posture": Declare usage when this Zoid is targeted by an attack. -200 to damage received, but it cannot counter.','F'),
    array('Cannonfort',NULL,500,500,4,'forwards +1',4,NULL,'sand',NULL,'F'),);


print '<form method=post>';

   
#---------------------------------------------------------------------------------------
#check for Icon_Flag


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


#compute midpoint of boxes in Y
#		Y positiona: 420 = Top of yellow divider   468 = bottom of yellow divide
#								 478 = top of green divide     525 =  bottom of green divide
$yellow_mid = 420+((468 - 420)/2);
$green_mid = 478+((525 - 478)/2);

#text locations
# imagettftext position is lower left of string  [$yellow_mid + 6] for middle alisgnment
$Y_positions = array($yellow_mid+6, 420 + $text_size, 468 - 3, $yellow_mid+6, $green_mid+6, $green_mid+6);
$X_positions = array(28, 105, 105, 228, 28,228);


#$database_elements = count($database_text);




#----------------------------------------------------------------------------------------------------------

#base image creation

#get file sizes
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

$size2 = (getimagesize($overlay));
$width_2=$size2[0];
$height_2=$size2[1];

# post origanal image
print '<input type="image"  width='.$width;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";
# --------------------------

#create images from files
$im = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);

$image_sized = imagecreatetruecolor($width_2, $height_2);
imagecopyresampled($image_sized, $im, 0,0,0,0, $width_2, $height_2, $width, $height);


#check for Icon_Flag


#--------------------------------------------------------------------------------------------------------
$black = imagecolorallocate($image_sized, 0,0,0);
$white = imagecolorallocate($image_sized, 255,255,255);
$red = imagecolorallocate($image_sized, 255,0,0);
$yellow_divide = imagecolorallocate($image_sized, 202,123,64);
$yellow_shadow = imagecolorallocate($image_sized, 162, 89, 21);
$green_divide = imagecolorallocate($image_sized, 20,132,86);
$green_shadow = imagecolorallocate($image_sized, 7, 111, 60);

#---------------------------------------------------------------------------------------------------------
imageline($im_overlay,103,$yellow_mid-1,223,$yellow_mid-1, $yellow_shadow);
imageline($im_overlay,103,$yellow_mid,223,$yellow_mid, $yellow_divide);
imageline($im_overlay,290,$yellow_mid-1,415,$yellow_mid-1, $yellow_shadow);
imageline($im_overlay,290,$yellow_mid,415,$yellow_mid, $yellow_divide);
imageline($im_overlay,112,$green_mid,223,$green_mid, $green_shadow);
imageline($im_overlay,112,$green_mid-1,223,$green_mid-1, $green_divide);





#-------------------------------------------------------------------------------------------------------
#place green and yellow text

#set up fixed text
for( $i = 0; $i < count($text); $i++) {
	imagettftext($im_overlay, $text_size, 0, $X_positions[$i], $Y_positions[$i], $black ,$font_file, $text[$i]);
}

 for($R = 0; $R < count($Table); $R++){
$Row = $Table[$R];
$Name = $Row[0];

$database_text= array($Row[2],$Row[3],$Row[4], $Row[5], $Row[6], $Row[7]);
$Icon_Flag = $Row[10];
$specail_text = $Row[9];
createCard($im, $Name, $database_text, $specail_text, $Icon_Flag, $image_sized, $im_overlay, $width, $height, $text_size, $black, $red, $white, $font_file);
$im = imagecreatefrompng($file);
$image_sized = imagecreatetruecolor($width_2, $height_2);
imagecopyresampled($image_sized, $im, 0,0,0,0, $width_2, $height_2, $width, $height);
}


function createCard($im, $Name, $database_text, $specail_text, $Icon_Flag, $image_sized, $im_overlay, $width, $height, $text_size, $black, $red, $white, $font_file){


if($Icon_Flag == 'T'){

# transfers the icon from the lower gray box onto the overlay if the card has one
$tmp = $image_sized;
imagecopy($im_overlay, $tmp, 358,545,358,545, 52, 50);
}

#TODO add Elephander case

#apply overlay to image
imagecopy($image_sized, $im_overlay, 0,0,0,0, $width, $height);


#place name

$Name_pos = array(225,54);
$name_size = 30;

$name_box = imagettfbbox($name_size,0,$font_file,$Name);
$name_half = ($name_box[0]+$name_box[2])/2;
imagettfstroketext($image_sized, $name_size, 0, $Name_pos[0]-$name_half, $Name_pos[1], $white, $black ,$font_file, $Name, 1);

#place database text
$Specail_text_size = 15;

$database_Y_positions = array(420 + $text_size, 468 - 3, 420 + $text_size, 468 - 3, 478 + $text_size, 525-3);
$database_X_positions = array(218,218,416,416,218, 218);

for( $i = 0; $i < count($database_text); $i++) {
	$displacement_box = imagettfbbox($text_size,0,$font_file,$database_text[$i]);
	$text_displacement = $displacement_box[2];
	imagettftext($image_sized, $text_size, 0, $database_X_positions[$i]-$text_displacement, $database_Y_positions[$i], $black ,$font_file, $database_text[$i]);
}

#--------------------------------------------------------------------------------------------------------





#Replaceing characters so no code insertion occures --------------
#remove (standard equipment)
$specail_text = str_replace("(standard equipment)","",$specail_text);

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
#print "<br> <br> Line Check <br>";
#for($l =0; $l < count($new_lines); $l++){
#	Print "<br> Line $l ";
#	if(is_array($new_lines[$l]) == true){
#		$text = $new_lines[$l];
#		print "Segmented line:  $text[0] | $text[1]"; 
#	}
#	else
#		echo $new_lines[$l]; 
#}
		#-------------------------
#--------------------------------------------------
$total_lines = count($new_lines);
#set grey box text size based on line count
#if($total_lines == 1)
#	$Specail_text_size = 18;
#if($total_lines == 2)
#	$Specail_text_size = 13;

#if($total_lines == 3)
#	$Specail_text_size = 9;

#if($total_lines == 4)
#	$Specail_text_size = 7;
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
#	print "<br> Prior Y position $prior";
	$new_Y = $Y_Positions[$l-1] + $Specail_text_size + $spacing;
	array_push($Y_Positions, $new_Y);
}

#for($y = 0; $y< count($Y_Positions); $y++){
#	print "<br> Line $y Yposition ";
#	echo $Y_Positions[$y];
#}

   
#   }
#}



#place grey box text
for($l = 0; $l < $total_lines; $l++){ 
	$text = $new_lines[$l];

    #this means there needs to be red text
	if(strpos($text, ": ") !== false){
       print "found a: in line == $lines[$l]";
        $sub_lines = explode(": ", $new_lines[$l]);
        $sub_lines[0] .= ": ";
        $title = imagettfbbox($Specail_text_size,0, $font_file, $sub_lines[0]);
		$offset = $title[2];
        imagettftext($image_sized, $Specail_text_size, 0, $X_position, $Y_Positions[$l], $red ,$font_file, $sub_lines[0]);
		imagettftext($image_sized, $Specail_text_size, 0, $X_position+$offset, $Y_Positions[$l], $black ,$font_file, $sub_lines[1]);
							
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
