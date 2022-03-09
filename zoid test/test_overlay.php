<html>
<body>
<?php 

$file = "beam_smasher.png";
$overlay = "custum part transparent test.png";
print "Map Testing<br><br>";
print '<form method=post>';

# Make it work with width dynamics. 10

$ImageWidth = "500";
$size = (getimagesize($file));
$width=$size[0];
$height=$size[1];

$ratio = ($width/$ImageWidth);


# 20
print "width $width height $height ratio $ratio<br><br>";

print '<input type="image"  width='.$ImageWidth;
print ' src="'.$file.'" name="pos" style=cursor:crosshair;/></form>'."\n";

$im = imagecreatefrompng($file);
$im_overlay = imagecreatefrompng($overlay);

imagecopy($im, $im_overlay, 0,0,0,0, $width, $height);
#30

$background_image = $im;
$font_file = 'times.TTF'; // link in a font file

$black = imagecolorallocate($background_image, 0,0,0);
$white = imagecolorallocate($background_image, 255,255,255);
$red = imagecolorallocate($background_image, 255,0,0);


$text = "Beam Smasher";

$text_size = 25; //in points

#40
$X_position = 55; // top left of text, this is the left of white box
$Y_position = 400+ $text_size; //this is the top of the grey long box adjusted for text, adobe puts it at 400
$X_limit = 400; // right side of white box
$Y_limit = 574; //bottom of white box

imagettftext($background_image, $text_size, 0, $X_position, $Y_position, $white ,$font_file, $text); //create image object with text


$colors = arraY($red, $black,$red);

#50 
$text = "[Declared] 1000 ranged attack, 4-10 range. If this attack hits a Zoid, move the Zoid by 3 squares however you wish. *Can only be equipped on LL-class Zoids.";

print "<br>";
echo $text;
print "<br>";

$lines = explode(". ",$text);  #creat different lines to change color
$line_count = count($lines);

#60
echo $line_count;
echo var_dump($lines);
Print "<br>";

$Y_position = 480; // this is the top of the white box, ajusted for texp position, photshop puts it at 465

$Y_Start = array($Y_position); #create a 1 element array with the first bing the top of the white box
$Y_Positions = array_pad($Y_Start, $line_count, $Y_position); # create a starting array of y positions  equal to the line count

$text_size = 14;

#70
for( $i = 0; $i < $line_count; $i++) {
	$text_size_raw = imageftbbox($text_size,0, $font_file, $lines[$i]);
	$text2= $lines[$i];
	print "<br>";
#90
	echo $text2;	


	#if ($text_size_raw[4] > $X_limit-$X_position){
		$char_count = 50;
		$text2 = wordwrap($lines[$i], $char_count,"\n");
		$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		while($text_size_wrap[4] > $X_limit-$X_position){
			$char_count--;
			$text2 = wordwrap($lines[$i], $char_count,"\n");
			$text_size_wrap = imageftbbox($text_size,0, $font_file, $text2);
		}
		$lines[$i] = $text2;
		print "<br> lines: ";
		echo $lines[$i];
		print "<br>";
		echo $Y_Positions[$i];
		print "<br>";
		echo $text_size_wrap[5];
	#	echo $Y_Positions[$i]+$text_size_wrap[1]+$text_size*1.5;
		if($i+1 < $line_count){
			$Y_Positions[$i+1] = $Y_Positions[$i] + $text_size_wrap[1]+$text_size*1.5;
	#	}
	}
}
print "<br>";
echo var_dump($lines);
for($l = 0; $l < $line_count; $l++){ 
imagettftext($background_image, $text_size, 0, $X_position, $Y_Positions[$l], $colors[$l] ,$font_file, $lines[$l]);
}

#100




ob_start();
  imagejpeg( $im, NULL, 100 );
#  imagedestroy( $im2 );
  $i = ob_get_clean();

#110
echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!
?>
printing file<br />

<img src="out.jpg" />


</body>
</html>
#120