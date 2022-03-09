<html>
<body>
<?php

$im = imagecreatetruecolor(200,3000);
$white = imagecolorallocate($im, 255,255,255);



$text_size = array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,21, 22, 23);
$test_text = "AAAAAAAA. AAAAAgAA. AAAAAAAA\nAAAAAAAA. AAAAAAAA\nAAAAAgAA. AAAAAgAA\nAAAAAgAA";
$test_lines = explode(". ", $test_text);
$test_count = count($test_lines);

$font_file = 'times.TTF';

$Y_start = 0;
$Y_pos = $Y_start;

$text_w_dip = 0;
$line_spacing = 0;
$dip = 0;
$apprent_spacing = 0;

for($s =0; $s < count($text_size); $s++){
	Print "<br>--------------------------------";
	
	#Print "<br> Text Size: ";
	#echo $text_size[$s];

	for($t = 0; $t < $test_count; $t++){
		$test_size = imageftbbox($text_size[$s], 0, $font_file, $test_lines[$t]);
		#Print "<br> Text: ";
		#echo $test_lines[$t];
		#print "<br> Upper Y: ";
		#echo $test_size[7];
		#print "<br> Lower Y: ";
		#echo $test_size[1];
		#print "<br> Left X: ";
		#echo $test_size[0];
		#print "<br> right X: ";
		#echo $test_size[2];
		#print "<br> Total box hieght: ";
		#echo abs($test_size[7]) + $test_size[1];
		#print "<br>";


		if($t == 1){
			$text_w_dip = abs($test_size[7]) + $test_size[1];
			$dip = $test_size[1];
		}
		if($t == 2){
			$line_spacing = $test_size[1] - $text_size[$s];
			$apprent_spacing = $line_spacing - $dip; 
		}



		imagefttext($im, $text_size[$s], 0, 0, $Y_pos+$text_size[$s], $white ,$font_file, $test_lines[$t]);
		$Y_pos = $Y_pos + abs($test_size[7]) + $test_size[1]; #<-- puts text lines under one other no spacing

	}

	Print "<br> Text Size: ";
	echo $text_size[$s];
	print "<br> apperent text height: ";
	echo $text_w_dip - $dip;
	print "<br> lost pixels: ";
	echo $text_size[$s] - ($text_w_dip - $dip);
	print "<br> text dip: ";
	echo $dip;
	print "<br> Total text size: ";
	echo $text_w_dip;
	print "<br> line spacing: ";
	echo $line_spacing;

	print "<br> apperent spacing: ";
	echo $apprent_spacing;

}
print "<br>";
ob_start();
  imagejpeg( $im, NULL, 100 );

  $i = ob_get_clean();


echo "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>";
?>
</body>
</html>