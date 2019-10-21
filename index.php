<?php
//Setting error level
error_reporting(0);

//Including required files
require 'src/Box.php';
require 'src/FarsiGD.php';
require 'src/color.php';

use GDText\Box;
use GDText\Color;


$file =  "/output/test.png";
$path = __dir__.$file;

//creating an image 500x500 pixels.
$im = imagecreatetruecolor(500, 500);

//setting background color for the image
$backgroundColor = imagecolorallocate($im, 125, 255, 255);
imagefill($im, 0, 0, $backgroundColor);

/**
 *  The box class is located in /src/Box.php and creates a "text box" over the image.   
 */
    

$box = new Box($im);

//Setting the text font. I used Arial here, any font that support Hebrew / Arabic will work here.
$font = __DIR__.'/Arial.ttf';
$box->setFontFace($font); 


// Setting the Text properties. 
$box->setFontColor(new Color(0, 0, 0));
$box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
$box->setFontSize(23);
$box->setLineHeight(1.5);

/**
 *  The debug function "marks" the text and create the text box in a different color. 
 *  This is helpful if for some reason you cannot see the text.
 */ 

//$box->enableDebug();

//Setting the box size
$box->setBox(20, 20, 460, 460);
//Setting the text allignment 
$box->setTextAlign('right', 'top');


/**
 *  The FarsiGD located at /src/FarsiGD.php and responsible for reversing the text order based on the language.
 *  As GD outputs the text as LTR and Hebrew and Arabic are RTL - this requrie to write these languages "Backword" 
 *  שלום will become םלוש
 *  سلام will become مالس (with correct character format)
 *  Hello will remain Hello
 */
$gd = new FarsiGD();

// The text For conversion
$text = 'آموزشی مختلف';

// Converting the text
$text = $gd->persianText($text, 'fa', 'normal');

// Draws the text on the picture
$box->draw($text);


/**
 *  I'm useing save method so no need for header type decleration.
 *  In order to return the picture instead of saving:
 *      1. Remove the comment from the header
 *      2. Change the $path to NULL in imagepng method
 *      3. Remove the HTML markup
*/ 

//header("Content-type: image/png;");
imagepng($im, $path, 9, PNG_ALL_FILTERS);

?>
<html>
<body>
    <img src="<?php echo $file ; ?>" >
</body>
</html>