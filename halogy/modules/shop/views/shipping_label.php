<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the TCPDF library */
require APPPATH."third_party/TCPDF/config/lang/eng.php";
require APPPATH."third_party/TCPDF/tcpdf.php";

//============================================================+
// File name   : shipping_label.php
// Last Update : 10-5-2013
// Description : Shipping label generator for TCPDF class
// Author: Ken Boyer, Vizlogix LLC (www.vizlogix.com)
//============================================================+

$product		= $_GET["product"];
$product_type	= $_GET["product-type"];

$name			= $_GET["name"];
$title			= $_GET["title"];
$email			= $_GET["email-address"];

$phone			= $_GET["phone"];
$extension		= $_GET["extension"];
$mobile			= $_GET["mobile"];
$fax			= $_GET["fax"];

$address1		= $_GET["address-line-1"];
$address2		= $_GET["address-line-2"];
$address3		= $_GET["city"].", ".$_GET["state"]." ".$_GET["zip"];;;
$website_url	= $_GET["website-url"];

$license_list	= $_GET["license-list"];

// PRINT: the sample customer-generated example to be printed
// SUBMISSION: the final file that has been approved, set up in print-ready format

// DIMENSIONS:
// Card					252x144
// Card + 1 level		312x222

if ($product == "Print")
{
	// PRINT CONSTANTS
	define("FORMAT_W", 252);
	define("FORMAT_H", 144);
	define("GRID", false);
	define("CROP_MARKS", false);
	define("X_OFFSET", 0);
	define("Y_OFFSET", 0);
	define("LOGO_ORIGIN_X", 10);
	define("LOGO_ORIGIN_Y", 14);
	define("LOGO_LABEL_ORIGIN_X", 86);
	define("LOGO_LABEL_ORIGIN_Y", 31);

	define("PERSONAL_ORIGIN_X", 80);
	define("PERSONAL_ORIGIN_Y", 46);
	define("PERSONAL_SPACING_Y", 9);

	define("PHONE_ORIGIN_X", 80);
	define("PHONE_ORIGIN_Y", 80);
	define("PHONE_SPACING_Y", 9);

	define("SEPARATOR_ORIGIN_X", 158);
	define("SEPARATOR_ORIGIN_Y", 81);
	define("SEPARATOR_DESTINATION_X", 158);
	define("SEPARATOR_DESTINATION_Y", 105);

	define("ADDRESS_ORIGIN_X", 160);
	define("ADDRESS_ORIGIN_Y", 80);
	define("ADDRESS_SPACING_Y", 9);

	define("DBL_LINE_ORIGIN_Y", 130);

	define("SLOGAN_ORIGIN_X", 20);
	define("SLOGAN_ORIGIN_X2", 130);
	define("SLOGAN_ORIGIN_Y", 38);

	define("URL_BOX_ORIGIN_X", 78);
	define("URL_BOX_ORIGIN_Y", 68);
	define("URL_BOX_WIDTH", 96);
	define("URL_BOX_HEIGHT", 12);

	define("LICENSE_BOX_ORIGIN_X", 25);
	define("LICENSE_BOX_ORIGIN_Y", 116);
	define("LICENSE_BOX_WIDTH", 202);
	define("LICENSE_BOX_HEIGHT", 18);

	// create new PDF document
	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf = new TCPDF('L', 'pt', array(FORMAT_W, FORMAT_H), true, 'UTF-8', false);
}
else
{
	// SUBMISSION CONSTANTS
	define("FORMAT_W", 312);
	define("FORMAT_H", 222);
	define("GRID", false);
	define("CROP_MARKS", true);
	define("CROP_TOP_Y", 38);
	define("CROP_LEFT_X", 30);
	define("X_OFFSET", 30);
	define("Y_OFFSET", 39);
	define("LOGO_ORIGIN_X", 10 + X_OFFSET);
	define("LOGO_ORIGIN_Y", 14 + Y_OFFSET);
	define("LOGO_LABEL_ORIGIN_X", 86 + X_OFFSET);
	define("LOGO_LABEL_ORIGIN_Y", 31 + Y_OFFSET);

	define("PERSONAL_ORIGIN_X", 80 + X_OFFSET);
	define("PERSONAL_ORIGIN_Y", 46 + Y_OFFSET);
	define("PERSONAL_SPACING_Y", 9);

	define("PHONE_ORIGIN_X", 80 + X_OFFSET);
	define("PHONE_ORIGIN_Y", 80 + Y_OFFSET);
	define("PHONE_SPACING_Y", 9);

	define("SEPARATOR_ORIGIN_X", 158 + X_OFFSET);
	define("SEPARATOR_ORIGIN_Y", 81 + Y_OFFSET);
	define("SEPARATOR_DESTINATION_X", 158 + X_OFFSET);
	define("SEPARATOR_DESTINATION_Y", 105 + Y_OFFSET);

	define("ADDRESS_ORIGIN_X", 160 + X_OFFSET);
	define("ADDRESS_ORIGIN_Y", 80 + Y_OFFSET);
	define("ADDRESS_SPACING_Y", 9);

	define("DBL_LINE_ORIGIN_Y", 130 + Y_OFFSET);

	define("SLOGAN_ORIGIN_X", 20 + X_OFFSET);
	define("SLOGAN_ORIGIN_X2", 130 + X_OFFSET);
	define("SLOGAN_ORIGIN_Y", 38 + Y_OFFSET);

	define("URL_BOX_ORIGIN_X", 78 + X_OFFSET);
	define("URL_BOX_ORIGIN_Y", 68 + Y_OFFSET);
	define("URL_BOX_WIDTH", 96);
	define("URL_BOX_HEIGHT", 12);

	define("LICENSE_BOX_ORIGIN_X", 25 + X_OFFSET);
	define("LICENSE_BOX_ORIGIN_Y", 116 + Y_OFFSET);
	define("LICENSE_BOX_WIDTH", 202);
	define("LICENSE_BOX_HEIGHT", 18);

	// create new PDF document
	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf = new TCPDF('L', 'pt', array(FORMAT_W, FORMAT_H), true, 'UTF-8', false);
}

// convert font
// see http://www.tcpdf.org/doc/classTCPDF.html#ac145b4da0e6f0b78beb22f3900f8df3b
$grotesk_lgt = $pdf->addTTFfont('../tcpdf/fonts/groteskbelight.ttf', 'TrueTypeUnicode', '', 32);
$grotesk_bld = $pdf->addTTFfont('../tcpdf/fonts/altehaasgroteskbold.ttf', 'TrueTypeUnicode', '', 32);
$grotesk_bld_ital = $pdf->addTTFfont('../tcpdf/fonts/groteskboldit.ttf', 'TrueTypeUnicode', '', 32);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('web');
$pdf->SetTitle('Business Card');
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// -------------------------------------------------------------------

// add the front of the card
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(100);

//============================================================+
// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=true, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

// Vector Security logo
$pdf->Image('Vector_PMS_HORZ_no_tag.png', LOGO_ORIGIN_X, LOGO_ORIGIN_Y, 150, 22, 'PNG', '', 'T', true, 600, '', false, false, 0, false, false, false);

// Normal, Auth Dealer, or Patrol
if ($product_type != "STANDARD")
{
	// color: #A44031;
	$pdf->SetTextColor(164, 64, 49);
	$pdf->SetFont($grotesk_bld,'','4');
	$pdf->setFontStretching(140);
	$pdf->setFontSpacing(0.4);
	$pdf->writeHTMLCell(0, 0, LOGO_LABEL_ORIGIN_X, LOGO_LABEL_ORIGIN_Y, $product_type, 0, 0);
}

//============================================================+

// color:#174A7C;
$pdf->SetTextColor(23, 74, 124);
$pdf->setFontSpacing(0.2);
$pdf->setFontStretching(100);

// Personal section
$nextY = PERSONAL_ORIGIN_Y;
$pdf->SetFont($grotesk_bld,'','7');
$pdf->writeHTMLCell(0, 0, PERSONAL_ORIGIN_X, $nextY, $name, 0, 0);
$nextY += PERSONAL_SPACING_Y;

if (strlen($title) > 0)
{
	$pdf->SetFont($grotesk_lgt,'','7');
	$pdf->writeHTMLCell(0, 0, PERSONAL_ORIGIN_X, $nextY, $title, 0, 0);
	$nextY += PERSONAL_SPACING_Y;
}

if (strlen($email) > 0)
{
	$pdf->SetFont($grotesk_lgt,'','7');
	$pdf->writeHTMLCell(0, 0, PERSONAL_ORIGIN_X, $nextY, $email, 0, 0);
	$nextY += PERSONAL_SPACING_Y;
}

// Phone section
$nextY = PHONE_ORIGIN_Y;
$pdf->SetFont($grotesk_bld,'','7');
$pdf->setFontSpacing(0);
$pdf->setFontStretching(94);
$pdf->writeHTMLCell(0, 0, PHONE_ORIGIN_X, $nextY - 1, "T:", 0, 0);
$pdf->SetFont($grotesk_lgt,'','7');
if (strlen($extension) > 0)
	$phone .= ' x'.$extension;
$pdf->writeHTMLCell(0, 0, PHONE_ORIGIN_X + 8, $nextY, $phone, 0, 0);
$nextY += PHONE_SPACING_Y;

if (strlen($mobile) > 0)
{
	$pdf->SetFont($grotesk_bld,'','7');
	$pdf->writeHTMLCell(0, 0, PHONE_ORIGIN_X, $nextY - 1, "M:", 0, 0);
	$pdf->SetFont($grotesk_lgt,'','7');
	$pdf->writeHTMLCell(0, 0, PHONE_ORIGIN_X + 8, $nextY, $mobile, 0, 0);
	$nextY += PHONE_SPACING_Y;
}

if (strlen($fax) > 0)
{
	$pdf->SetFont($grotesk_bld,'','7');
	$pdf->writeHTMLCell(0, 0, PHONE_ORIGIN_X, $nextY - 1, "F:", 0, 0);
	$pdf->SetFont($grotesk_lgt,'','7');
	$pdf->writeHTMLCell(0, 0, PHONE_ORIGIN_X + 8, $nextY, $fax, 0, 0);
	$nextY += PHONE_SPACING_Y;
}

// Dashed separator
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 1, 'color' => array(23, 74, 124)));
$pdf->Line(SEPARATOR_ORIGIN_X, SEPARATOR_ORIGIN_Y, SEPARATOR_DESTINATION_X, SEPARATOR_DESTINATION_Y);

// Address section
$pdf->SetFont($grotesk_lgt,'','7');
$pdf->setFontSpacing(0);
$pdf->setFontStretching(94);

$pdf->writeHTMLCell(0, 0, ADDRESS_ORIGIN_X, ADDRESS_ORIGIN_Y, $address1, 0, 0);
$nextY = ADDRESS_ORIGIN_Y + ADDRESS_SPACING_Y;

if (strlen($address2) > 0)
{
	$pdf->writeHTMLCell(0, 0, ADDRESS_ORIGIN_X, $nextY, $address2, 0, 0);
	$nextY += ADDRESS_SPACING_Y;
}

$pdf->writeHTMLCell(0, 0, ADDRESS_ORIGIN_X, $nextY, $address3, 0, 0);
$nextY += ADDRESS_SPACING_Y;

// Double line at bottom
$pdf->Image('dbl_line_bc.jpg', X_OFFSET, DBL_LINE_ORIGIN_Y, 0, 0, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);

//============================================================+
// Alignment grid
if (GRID)
{
	// 10pt grid
	$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(224, 224, 224)));
	// horizontal lines
	for ($i = 10; $i < FORMAT_H; $i += 10)
	{
		$pdf->Line(0, $i, FORMAT_W, $i);
	}

	// vertical lines
	for ($i = 10; $i < FORMAT_W; $i += 10)
	{
		$pdf->Line($i, 0, $i, FORMAT_H);
	}
}

//============================================================+
// Triad printing marks
if (CROP_MARKS)
{
	$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(64, 64, 64)));
	$pdf->Line(9, CROP_TOP_Y, 24, CROP_TOP_Y);
	$pdf->Line(CROP_LEFT_X, 18, CROP_LEFT_X, 32);

	$pdf->Line(FORMAT_W - 9, CROP_TOP_Y, FORMAT_W - 24, CROP_TOP_Y);
	$pdf->Line(FORMAT_W - CROP_LEFT_X, 18, FORMAT_W - CROP_LEFT_X, 32);

	$pdf->Line(9, FORMAT_H - CROP_TOP_Y, 24, FORMAT_H - CROP_TOP_Y);
	$pdf->Line(CROP_LEFT_X, FORMAT_H - 18, CROP_LEFT_X, FORMAT_H - 32);

	$pdf->Line(FORMAT_W - 9, FORMAT_H - CROP_TOP_Y, FORMAT_W - 24, FORMAT_H - CROP_TOP_Y);
	$pdf->Line(FORMAT_W - CROP_LEFT_X, FORMAT_H - 18, FORMAT_W - CROP_LEFT_X, FORMAT_H - 32);
}

//============================================================+
// add a page for the back of the card
$pdf->AddPage();

// define style for border
$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->SetDrawColor(23, 74, 124);
$pdf->SetFillColor(23, 74, 124);
if ($product == "Print")
{
	$pdf->Rect(0, 0, 300, 200, 'DF', $border_style);
}
else
{
	$pdf->Rect(22, 29, 268, 162, 'DF', $border_style);
}

$pdf->SetTextColor(255, 255, 255);

// Slogan
$pdf->SetFont($grotesk_bld,'','10');
$pdf->setFontSpacing(0.4);
$pdf->setFontStretching(110);
$text = 'Intelligent security';
$pdf->writeHTMLCell(0, 0, SLOGAN_ORIGIN_X, SLOGAN_ORIGIN_Y, $text, 0, 0);
$pdf->SetFont($grotesk_bld_ital,'I','10');
$pdf->setFontSpacing(0.5);
$text = 'tailored for you.';
$pdf->writeHTMLCell(0, 0, SLOGAN_ORIGIN_X2, SLOGAN_ORIGIN_Y, $text, 0, 0);
$pdf->SetFont($grotesk_lgt,'','4');
$text = 'SM';
$pdf->writeHTMLCell(0, 0, X_OFFSET + 218, SLOGAN_ORIGIN_Y + 6, $text, 0, 0);

// Website URL + box
$pdf->SetFont($grotesk_lgt,'','7');
$pdf->setFontSpacing(0.2);
$pdf->setFontStretching(120);
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 1, 'color' => array(255, 255, 255)));
$pdf->SetFillColor(23, 74, 124);
$text = 'www.vectorsecurity.com';
$pdf->SetXY(URL_BOX_ORIGIN_X, URL_BOX_ORIGIN_Y, true);
$pdf->Cell(URL_BOX_WIDTH, URL_BOX_HEIGHT, $text, 1, 1, 'C', 1, 0, 0, 0, 'T', 'C');
// Connecting line
$pdf->Line(URL_BOX_ORIGIN_X + URL_BOX_WIDTH, URL_BOX_ORIGIN_Y + 6, X_OFFSET + 206, URL_BOX_ORIGIN_Y + 6);
$pdf->Line(X_OFFSET + 206, URL_BOX_ORIGIN_Y + 6, X_OFFSET + 206, Y_OFFSET + 50);

$pdf->SetFont($grotesk_lgt,'','8');
$pdf->setFontSpacing(0.1);
$pdf->setFontStretching(110);
$text = "Burglar   |   Fire   |   Video   |   Mobile   |   Access Control";
$pdf->writeHTMLCell(0, 0, X_OFFSET + 34, Y_OFFSET + 95, $text, 0, 0);

//============================================================+
// License list at bottom of page
$pdf->SetFont($grotesk_lgt,'','5');
$pdf->setFontSpacing(0);
$pdf->setFontStretching(100);
if ($product_type != "PATROL")
{
	$pdf->SetXY(LICENSE_BOX_ORIGIN_X, LICENSE_BOX_ORIGIN_Y, true);
	// parse csv into array of keys
	$keys = explode(',', $license_list);
	// map keys to values
	$expanded_list = '';
	$count = 0;
	foreach ($keys as $key)
	{
		if ($count > 0)
		{
			$expanded_list .= ', ';
		}

		$key = trim($key);
	//	echo "key: [".$key."]";
	//	echo "arr: ".$license_arr[$key];
		$expanded_list .= $license_arr[$key];
		$count++;
	}
	$pdf->writeHTMLCell(LICENSE_BOX_WIDTH, LICENSE_BOX_HEIGHT, LICENSE_BOX_ORIGIN_X, LICENSE_BOX_ORIGIN_Y, "<p>".$expanded_list."</p>", 0, 0, 1, true, 'R', true);
	//$pdf->writeHTML("<p>".$license_list."</p>", false, false, false, false, 'R');
	//$pdf->Cell(LICENSE_BOX_WIDTH, LICENSE_BOX_HEIGHT, $license_list, 0, 1, 'R', 1, 0, 0, 0, 'T', 'C');
}

//============================================================+
// Alignment grid
if (GRID)
{
	// 10pt grid
	$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(224, 224, 224)));
	// horizontal lines
	for ($i = 10; $i < FORMAT_H; $i += 10)
	{
		$pdf->Line(0, $i, FORMAT_W, $i);
	}

	// vertical lines
	for ($i = 10; $i < FORMAT_W; $i += 10)
	{
		$pdf->Line($i, 0, $i, FORMAT_H);
	}
}

//============================================================+
// Triad printing marks
if (CROP_MARKS)
{
	$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(64, 64, 64)));
	$pdf->Line(9, CROP_TOP_Y, 24, CROP_TOP_Y);
	$pdf->Line(CROP_LEFT_X, 18, CROP_LEFT_X, 32);

	$pdf->Line(FORMAT_W - 9, CROP_TOP_Y, FORMAT_W - 24, CROP_TOP_Y);
	$pdf->Line(FORMAT_W - CROP_LEFT_X, 18, FORMAT_W - CROP_LEFT_X, 32);

	$pdf->Line(9, FORMAT_H - CROP_TOP_Y, 24, FORMAT_H - CROP_TOP_Y);
	$pdf->Line(CROP_LEFT_X, FORMAT_H - 18, CROP_LEFT_X, FORMAT_H - 32);

	$pdf->Line(FORMAT_W - 9, FORMAT_H - CROP_TOP_Y, FORMAT_W - 24, FORMAT_H - CROP_TOP_Y);
	$pdf->Line(FORMAT_W - CROP_LEFT_X, FORMAT_H - 18, FORMAT_W - CROP_LEFT_X, FORMAT_H - 32);
}

//============================================================+
// Javascript section

// print dialog
$js = 'print(true);';

// set javascript
if ($product == "Print")
{
	$pdf->IncludeJS($js);
}

// display mode on web page
$pdf->SetDisplayMode('default', 'TwoPageLeft');

//Close and output PDF document
if ($product == "Print")
{
	$pdf->Output('businesscard.pdf', 'I');
}
else
{
	$pdf->Output('businesscard.pdf', 'D');
}

//============================================================+
// END OF FILE
//============================================================+