<script>
$(function(){
	// Module Right
	if($('#mosRight').html()!="") $('#mosRight').width(360); else $('#mosRight').width(0);
	
	$('#txt_search').mousedown(function(e) {
		if($(this).val()==$(this).attr('defin')) $(this).val("");
    });
	$('#txt_search').focusout(function(e) {
        if($(this).val()=="") $(this).val($(this).attr('defin'));
    });
	$('#search').submit(function(e) {
		window.location = "?search#" + $('#txt_search').val();
        return false;
    });
	$('#btn_search').click(function(e) {
		window.location = "?search#" + $('#txt_search').val();
    });
});
</script>
<header><center><content>
<?php
$CurrentTime = time();
$IpAddress = $_SERVER['SERVER_ADDR'];
$IdleLimit = 1200; //Second

// เช็ก Online User
$database->query("DELETE FROM dvg_online WHERE timestamp<$CurrentTime-$IdleLimit");
if($database->query("SELECT * FROM dvg_online WHERE ipaddress='$IpAddress' LIMIT 1")) {
	$database->query("UPDATE dvg_online SET timestamp='$CurrentTime' WHERE ipaddress='$IpAddress'");
} else {
	$database->query("INSERT INTO dvg_online (user_id, ipaddress, timestamp) VALUES ('0', '$IpAddress', $CurrentTime)");
}

// ค้นหา Frontpage ของเว็บ
$RequestPage = $_SERVER['REQUEST_URI'];
if($RequestPage=="/") @list($RequestPage) = $database->query("SELECT link FROM dvg_menu WHERE frontpage=1 LIMIT 1");
$_SERVER['REQUEST_URI'] = $request->url($RequestPage);
$NameComponent = $request->level(0);
// ตรวจสอบ component ว่ามีข้อมูลหรือไม่
if(!$database->query("SELECT COUNT(*) FROM dvg_component WHERE name='$NameComponent'")) $NameComponent = "error";
?>
<div align="right">
  <?php foreach($database->query("SELECT * FROM dvg_menu WHERE submenu_id=1 ORDER BY list ASC") as $menu): ?>
  <li class="nav <?php if(count(explode("/?".$request->level(0), $menu['link']))>1) { echo "currented"; $IDMainModule = $menu['menu_id']; } ?>">
  <a href="<?php echo $menu['link']; ?>"><?php echo $menu['subject']; ?></a></li>
  <?php endforeach; ?>
  <search><form id="search"><input type="text" id="txt_search" maxlength="20" value="<?php echo _SEARCH_TEXT; ?>" defin="<?php echo _SEARCH_TEXT; ?>" />
    <input type="button" id="btn_search" value="" />
   </form></search>
</div>
</content></center></header>
<mainbody><div style="background:url(../../images/second-bg.jpg) center 85px no-repeat;">
<center><content>
<online><?php mos::Module("online"); ?></online>
<logo><img src="../images/logo-dvgamer.png" width="438" height="150"/></logo>
<div class="submainmenu">
  <?php foreach($database->query("SELECT * FROM dvg_menu WHERE submenu_id=$IDMainModule") as $submenu): ?>
  <li class="sub <?php if(count(explode("/?".$request->level(0)."!".$request->level(1), $submenu['link']))>1) { echo "selected"; } ?>"><a href="<?php echo $submenu['link']; ?>"><?php echo $submenu['subject']; ?></a></li>
  <?php endforeach; ?>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php foreach($database->query("SELECT * FROM dvg_component WHERE name='$NameComponent' AND public=1") as $com) include_once("component/".$com['filename']); ?></td>
    <td valign="top" id="mosRight"><?php mos::Module("right"); ?></td>
  </tr>
</table>
</content></center>
</div></div></mainbody>
<footer><center><content>
<?php mos::Module("footer"); ?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

</content></center></footer>
