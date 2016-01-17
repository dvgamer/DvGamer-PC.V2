<script>
$(function(){
	setInterval(function(){ $.ajax("/?@user!online",{ type: "POST", dataType: "html", success: function(data){ $('#user_online').html(data); } }); }, 60000);
});
</script>
<div id="user_online"><?php $online = $database->query("SELECT COUNT(*) FROM dvg_online LIMIT 1"); echo "+".$online; ?></div>
