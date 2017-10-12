<?php
require "admin_check.php";
admin_check();

echo ("<html style='text-align:center;'>");
echo ("<a href='http://deepblue.cs.camosun.bc.ca/~comp19900/admin/home' style='font-size:130%'>Return</a>");
echo ("<p><b>!!!WARNING!!!</b><br/>This page updates only after submitting. After Submitting, the front page updates instantly.<br/>Use Caution.</p>");

echo ('<link rel="stylesheet" type="text/css" href="../css/style.css" />');
echo ('<script src="//code.jquery.com/jquery-1.10.2.js"></script>');
echo ('<style>#button:hover{background-color:grey;}</style>');

$loc = '../';
$file = $loc.'slide.tut';
$contents = file_get_contents($file);

$reg_cont =	'/<start>(.|\n)*?<end>/';
$reg_link =	'/<link>(.|\n)*?<\/link>/';
$reg_img = 	'/<img>(.|\n)*?<\/img>/';
$reg_h2 =	'/<h2>(.|\n)*?<\/h2>/';
$reg_p = 	'/<p>(.|\n)*?<\/p>/';
$reg_sub = 	'/<sub>(.|\n)*?<\/sub>/';

preg_match_all($reg_cont, $contents, $matches);
$num = (count($matches[0]));

echo ("<form action='front_insert.php' method='post' style='text-align:center;'>");

$i = 0;
while ($i < $num){
	$match = ($matches[0][$i]);
	// REGEX
	
	// img
	preg_match_all($reg_img,$match,$fin_img);
	$tmp = $fin_img[0][0];
	$tmp = str_replace('<img>','',$tmp);
	$fin_img = str_replace('</img>','',$tmp);
	
	// link
	preg_match_all($reg_link,$match,$fin_link);
	$tmp = $fin_link[0][0];
	$tmp = str_replace('<link>','',$tmp);
	$fin_link = str_replace('</link>','',$tmp);
	
	// h2
	preg_match_all($reg_h2,$match,$fin_h2);
	$tmp = $fin_h2[0][0];
	$tmp = str_replace('<h2>','',$tmp);
	$fin_h2 = str_replace('</h2>','',$tmp);
	
	// p
	preg_match_all($reg_p,$match,$fin_p);
	$tmp = $fin_p[0][0];
	$tmp = str_replace('<p>','',$tmp);
	$fin_p = str_replace('</p>','',$tmp);
	
	// sub
	preg_match_all($reg_sub,$match,$fin_sub);
	$tmp = $fin_sub[0][0];
	$tmp = str_replace('<sub>','',$tmp);
	$fin_sub = str_replace('</sub>','',$tmp);
	
	//--------------
	echo ('		<div id="button" class="button_'.$i.'" style="border:1px solid black;padding:5px;width:30%;margin:auto;">View Splash Page #'.$i.'</div>');
	echo ('		<div id="splash" class="div_'.$i.'" style="width:60%;margin:auto;display:none;">');
	echo ('			<table>');
	echo ('				<tr>');
	echo ('					<td>');
	echo ('						<img src="../'.trim($fin_img).'" alt=""></img>');
	echo ('						<table style="width:100%;">');
	echo ('							<tr>');
	echo ('								<td style="width:5%;">');
	echo ('									<p>Img:</p>');
	echo ('								</td>');
	echo ('								<td>');
	echo ('									<input type="text" id="img_'.$i.'" name="img_'.$i.'" value="../'.trim($fin_img).'" style="text-align:center;width:100%;"></input>');
	echo ('								</td>');
	echo ('							</tr>');
	echo ('							<tr>');
	echo ('								<td style="width:5%;">');
	echo ('									<p>Link:</p>');
	echo ('								</td>');
	echo ('								<td>');
	echo ('									<input type="text" id="link_'.$i.'" name="link_'.$i.'" value="'.trim($fin_link).'" style="text-align:center;width:100%;"></input>');	
	echo ('								</td>');
	echo ('							</tr>');
	echo ('						</table>');
	echo ('					</td>');
	echo ('					<td>');
	echo ('						<div class="text">');
	echo ('							<h2><input type="text" id="h2_'.$i.'" name="h2_'.$i.'" value="'.trim($fin_h2).'" style="text-align:center;font-weight:bold;font-size:100%;width:100%;"></input></h2>');
	echo ('							<p><textarea id="p_'.$i.'" name="p_'.$i.'" rows="10" style="width:100%;height:50%;">'.trim($fin_p).'</textarea></p>');
	echo ('							<br/>');
	echo ('							<div style="font-size:75%;">');
	echo ('								<p><sub><textarea id="sub_'.$i.'" name="sub_'.$i.'" rows="5" style="width:100%">'.trim($fin_sub).'</textarea></sub></p>');
	echo ('							</div>');
	echo ('						</div>');
	echo ('					</td>');
	echo ('				</tr>');
	echo ('			</table>');
	echo ('		</div>');
	
	echo ("		<script>
				$('.button_".$i."').click(function() {
					$('.div_".$i."').slideToggle('fast');
				});
				</script>");
	//--------------

	$i ++;
}

echo ("<input type='text' id='total' name='total' value='".$i."' readonly style='text-align:center;width:5%;'></input> Total");
echo ("<br/>");
echo ("<input type='submit' style='padding:20px;width:50%;'></input>");
echo ("</form>");

?>