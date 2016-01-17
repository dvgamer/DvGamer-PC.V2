<?php
class UrlRequest
{
	protected $result;
	protected $value = array();

	public function url($url)
	{
		$this->result = $url;
		$this->value = explode("!", str_replace("/?", "", $this->result));
		return $this->result;
	}
	public function level($index = NULL)
	{
		if($index>-1 && $index<count($this->value))
		{
			return trim($this->value[$index]);
		} elseif(!isset($index)) {
			return $this->value;
		} else {
			return false;
		}
	}
	
	public function path()
	{
		return trim($this->result);
	}
}

class mos 
{
	public static function Module($area)
	{
		$database = new SyncDatabase();
		$req = new UrlRequest();
		$req->url($_SERVER['REQUEST_URI']);
		foreach($database->query("SELECT * FROM dvg_module WHERE area_id=(SELECT area_id FROM dvg_area WHERE name='$area')") as $mod)
		{
			if($database->query("SELECT COUNT(*) FROM dvg_panel WHERE mod_id=$mod[mod_id]")==0)
			{
				include_once("module/".$mod['filename']);
			} else {
				foreach($database->query("SELECT * FROM dvg_panel WHERE mod_id=$mod[mod_id]") as $panel)
				{
					$menu = $database->query("SELECT * FROM dvg_menu WHERE menu_id=$panel[menu_id] LIMIT 1");		
					if(isset($menu['link']) && count(explode($menu['link'], $req->path()))>1) include_once("module/".$mod['filename']);
				}
			}
		}
	}
}
?>