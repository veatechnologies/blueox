<?php
include_once(SSF_WP_INCLUDES_PATH."/top-nav.php");

if (!function_exists("ssf_wp_initialize_variables")) { include("../ssf-wp-functions.php"); }
?>
<div class='wrap'>
<?php 

/*
* Upload Markers 
*/
if (isset($_POST['save_super_marker'])) { 
	$distance=$_POST['distance'];
	global $wpdb;
	$wpdb->query($wpdb->prepare("UPDATE ".SSF_WP_TAG_TABLE." SET ssf_wp_distance='".$distance."' WHERE ssf_wp_tag_slug LIKE %s", '%' .$_POST['ssf_wp_category']. '%')); 
	print "<script>location.replace('".str_replace("&upload=", "", $_SERVER['REQUEST_URI'])."');</script>";
}
/*
* Edit/Add Marker's
*/
function ssf_wp_single_marker_info($value,$bgcol){
	$markerId=$value['ssf_wp_cat_id'];
	print "<tr style='background-color:$bgcol' id='ssf_wp_tr_data-$markerId'>";
	$cancel_onclick = "location.href=\"".str_replace("&upload=$markerId", "",$_SERVER['REQUEST_URI'])."\"";
	//$fileName = strtolower(preg_replace('/[^a-zA-Z0-9_.]/', '', $value['ssf_wp_category']));
	$fileName =$value['ssf_wp_cat_id'];
	$file_marker=SSF_WP_UPLOADS_BASE."/images/sprites/markers/".$fileName.".png?".time();
	$dir_marker=SSF_WP_UPLOADS_PATH."/images/sprites/markers/".$fileName.".png";
	if (file_exists($dir_marker)) {
		$markerEdit='<div id="editCmarker" style="display:inline-block;"><img src="'.$file_marker.'" style="max-width:300px;">';
	    $markerEdit_btn="<input type=\"button\" onclick=\"delMarker('$fileName');\" class=\"btn btn-danger\"  value=\"Delete\"></div>";
		$des_marker="disabled='disabled'";
	}
	else
	{
		$markerEdit='';
		$markerEdit_btn='';
		$des_marker='';
	}
	print "<tr style='background-color:$bgcol'>";
	print "<td colspan='4'>";	
	print "<form name='locationForm' method='post' enctype='multipart/form-data'>";
		 print "<div class='input_title'>
			<h3><span class='fa fa-map-marker'>&nbsp;</span> Upload Marker</h3>
			<span class='submit'>
			<input type='submit' name='save_super_marker' value='".__("Save", SSF_WP_TEXT_DOMAIN)."' class='button-primary'> <input type='button' class='ssf-button' value='".__("Cancel", SSF_WP_TEXT_DOMAIN)."' onclick='$cancel_onclick'>
			</span>
			<div class='clearfix'></div>
		</div>";
		//$fileName = strtolower(preg_replace('/[^a-zA-Z0-9_.]/', '', $value['ssf_wp_category']));
		$fileName =$value['ssf_wp_cat_id'];
		print '<div class="option_input option_text">
		<label for="shortname_logo">Categories / Tags</label>
			<input type="hidden" value="'.$fileName.'" name="ssf_wp_category"/>'.$value["ssf_wp_category"].'
			<div class="clearfix"></div>
		</div>';
		print "<div class='option_input option_text'>
		<label for='shortname_logo'>
		Custom Marker</label>
		<input type='file' class='custom_marker' name='ssf_wp_marker' id='ssf_wp_marker'  ".$des_marker." size='13'>".$markerEdit.$markerEdit_btn."
		<small></small>
		<div class='clearfix'></div>
		</div>";
	print "</form></td></tr>";
}
$msg="";
global $wpdb;
$query=$wpdb->get_results("SELECT * FROM ".SSF_WP_TAG_TABLE." WHERE ssf_wp_tag_id!=0 GROUP BY(ssf_wp_tag_slug)", ARRAY_A);
?>
<div class='input_section'>
	<div class='input_title'>
		<h3><span class='fa fa-map-marker'>&nbsp;</span>Assign Distance to Categories</h3>
		<span class='submit'>
		</span>
		<div class='clearfix'></div>
	</div>
<div class='all_options' id='category_loc_table'>
<table class="widefat" cellspacing="0" id="loc_table">
<thead>
	<tr>
		<th><b>Categories / Tags</b></th>
		<th><b>Distance</b></th>
		<th><b>Action</b></th>
	</tr>
</thead>
<tbody>
<?php 
$bgcol="";
if(!empty($query)){
foreach ($query as $row) { 
   print  "<form name='locationForm' method='post' enctype='multipart/form-data'>";
   $bgcol=($bgcol==="" || $bgcol=="#eee")?"#fff":"#eee";	
   print "<tr style='background-color:$bgcol'>";
   print "<td>".$row['ssf_wp_tag_slug']."<input type='hidden' value='".$row['ssf_wp_tag_slug']."' name='ssf_wp_category'/></td>";
   print "<td><input type='number' name='distance' value='".$row['ssf_wp_distance']."'></td>";
   print "<td><input type='submit' name='save_super_marker' value='".__("Save", SSF_WP_TEXT_DOMAIN)."' class='button-primary'></td>";
   print  "</tr>";
   print  "</form>";
 }
}else{ ?>
 <tr>
   <td colspan="5">You have no available Categories / Tags</td>
</tr>
<?php } ?>
 </tbody>
</table>
</div>
<?php include(SSF_WP_INCLUDES_PATH."/ssf-wp-footer.php"); ?>