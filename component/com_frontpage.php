<h1><?php
foreach($request->level() as $name) {
	if(trim($name)!="") {
		echo "<span ";
		if(!isset($tag)) echo "style=\"color:#FFF\"";
		echo "> » </span>";
		echo strtoupper(trim($name));
	}
	$tag = false;
} ?>
</h1>
