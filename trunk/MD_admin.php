<script src="<?php echo plugin_dir_url( __FILE__ );?>/js/adm_process_groups_json.js"></script>
<?php
    //Array of possible filters function()=>name to show
$options = array(
      //"act1()"=>"Descr option 1",
      //"act2()"=>"Descr option 2",'
);
//read pairs from file
$s=file_get_contents(plugin_dir_path(__FILE__).'filters.txt');
$s=str_replace(array("\n"), '', $s);
$a=explode (",",$s);
foreach ($a as $item){
	$p=explode ("=>",$item);
	$options[$p[0]]=$p[1];
}

function fillAdd($o,$used,$id){
	echo '<select style="width:100%"  id='.$id,'>';
	while (list($key, $val) = each($o)){
			if (!in_array($key,$used)) echo '<option value="'.$key.'">'.$val.'</option>';
			else echo '<option disabled value="'.$key.'">'.$val.'</option>';
	}
	echo '</select>';
}

function fillDelete($o,$used,$id){
	echo '<select style="width:100%"  id='.$id,'>';
	while (list($key, $val) = each($o)){
			if (in_array($key,$used)) echo '<option value="'.$key.'">'.$val.'</option>';
	}
	echo '</select>';
}

if (isset($_POST['submit'])) { //Save was clicked
	update_option( 'MD_groups_json', ($_POST['MD_groups_json'] ));
	$encoded=wp_unslash($_POST['MD_groups_json']);
	$mygroups=json_decode($encoded);
	//echo '<script>alert("submit");</script>';
}
if (!isset($_POST['submit']) && !isset($_POST['newgroup'])) { //Open page
		$encoded=wp_unslash(get_option('MD_groups_json'));
		$mygroups=json_decode($encoded);
	//echo '<script>alert("First");</script>';
}
if (isset($_POST['newgroup'])){ //New group was created
		update_option( 'MD_groups_json', ($_POST['MD_groups_json_t'] ));
		$encoded=wp_unslash($_POST['MD_groups_json_t']);
		$mygroups=json_decode($encoded);
}
?>

<div class="MD_admin">
<h2>Mobile detective</h2>
<div id="info">
<h3>About this plugin</h3>
<p>Author: <a href="http://wpplugins.ml" target="_blank">Leonid N. Malyshev</a></p>
<p>This plugin is used to detect information about the device used by the user.</p>
<ol>
<li>Acording to this information you can display information for a restricted types of devices (eg on Tablets only) or redirect to a proper page.</li>
<li>The plugin stores information about your visitors so you can view statistics (PRO version only)</li>
</ol><p></p>
<p>You should include "[MobDetective params]" or "[MobDetective params]Text to display on success[/MobDetective]" in your post/page text.</p>
<p>Parameters:</p>
<ol>
<li>Filters' names: isMobile, isTablet ... - filters <strong>Full list of possible filters</strong> <a href="<?php echo plugin_dir_url( __FILE__ );?>filters.txt" target="_blank">here</a></li>
<li>Groups' names: Group_name1, Group_name2... (Groups are defined below)</li>
<li>Fail message: output="Text to display on fail" - optional parameter. By default "Failed "+filter/group name will be printed</li>
<li>Redirect: redirect="http://..." - optional parameter to redirect on fail</li>
</ol>
<p>All filters (single or groups) must be true (logical AND) to get positive result. In a group any filter must be true (logical OR).</p>
<p>Simbol "!" can be used as logical NOT. E.g. !isMobile</p>
<p></p>
<p>This plugin uses "Mobile Detect" library <a href="http://mobiledetect.net/" rel="nofollow" target="_blank">mobiledetect.net</a>.</p>
</div>
<p></p>
<div id="Groups">
<h3>Groups</h3>
<p>Groups allow to define custom combinations of device types. Group checks if any (logical OR) member if true.</p>

<!-- Table of groups -->
<table id="GroppsTable">
<thead>
<th>Group</th><th width="20%">Members</th><th colspan="2">Add to group</th><th colspan="2">Delete from group</th><th>Group modifications</th>
</thead>
<tbody>
<?php
	for ($i=0;$i<count($mygroups);$i++){
		echo '<tr id="tr_'.$i.'">';
		for ($j=0;$j<count($mygroups[$i]);$j++)
			echo '<td id="group'.$i."_".$j.'">'.$mygroups[$i][$j]."</td>";
		echo '<td style="min-width:50px">';
		fillAdd($options,explode(", ",$mygroups[$i][1]),"selector_".$i);
		echo '</td><td> <button class="buttons add" onclick="btnAddFunction('.$i.')">Add option</button> </td>';
		echo '<td style="min-width:50px">';
		fillDelete($options,explode(", ",$mygroups[$i][1]),"deleter_".$i);
		echo "</td>";
		echo '<td> <button class="buttons minus" onclick="btnDelFunction('.$i.')">Delete option</button> </td>';
		echo '<td> <button class="buttons delete" onclick="btnDelGrFunction('.$i.',this)">Delete group</button> ';
		echo '<button class="buttons rename" onclick="btnRenGrFunction('.$i.')">Rename group</button';
		echo "</td>";
		echo "</tr>";
	}
?>
</tbody>
</table>
<form action="" method="post">
<?php settings_fields( 'MD-settings-group' ); ?>
<input   type="text"   hidden size="180" id="MD_groups_json_t" name="MD_groups_json_t" value='<?php echo wp_unslash(get_option('MD_groups_json_t')); ?>'>
<p><input type="submit" name="newgroup" class="buttons create" value="Create new group" onclick="getNewGroup()"/></p>
</form>

</div>

<form action="" method="post">
<!-- Form to save changed groups -->
<?php settings_fields( 'MD-settings-group' ); ?>
<!--<form action="" method="post"> -->
<input   type="text" hidden size="180" id="MD_groups_json" name="MD_groups_json" value='<?php echo wp_unslash(get_option('MD_groups_json')); ?>'>
<p class="submit">
    <input type="submit" name = "submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
 </form>
 <script 
    data-callback="http://wpplugins.ml" 
    data-tax="0" 
    data-shipping="0" 
    data-currency="EUR" 
    data-amount="3" 
    data-quantity="1" 
    data-name="Plugin &quot;Mobile Detective&quot;" 
    data-button="donate" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=mln141@mail.ru" async="async"
></script>
</div>
<?php
?>
