<?php
require "admin_check.php";
admin_check();

echo ("<html style='text-align:center;'>");

if ($total = $_REQUEST['total']){
	$ultimate = '';
	$i = 0;
	while ($i < $total){
		$img = 	$_REQUEST['img_'.$i];
		$link = $_REQUEST['link_'.$i];
		$h2 = 	$_REQUEST['h2_'.$i];
		$p = 	$_REQUEST['p_'.$i];
		$sub = 	$_REQUEST['sub_'.$i];
		
		
		$final_img = 	"<img>".$img."</img>";
		$final_img = 	str_replace('../','',$final_img);
		$final_link = 	"<link>".$link."</link>";
		$final_h2 = 	"<h2>".$h2."</h2>";
		$final_p = 		"<p>".$p."</p>";
		$final_sub = 	"<sub>".$sub."</sub>";
		
		$final = 		"<start>".$final_img.$final_link.$final_h2.$final_p.$final_sub."<end>";
		$ultimate .= $final;
		
		$i ++;
	}
	$bytes = file_put_contents('../slide.tut',$ultimate);
	
	echo ("<p style='font-size:130%'>Update Successful</p>");
	echo ("<p style='font-size:110%'>".$bytes." bytes</p>");	
}
else {
	echo ("<p style='font-size:130%'>Update Failed</p>");
}

echo ("<a href='http://deepblue.cs.camosun.bc.ca/~comp19900/admin/front' style='font-size:130%'>Return</a>");
echo ("</html>");

?>