<?php
  // $Id: clock.php 7968 2011-03-07 13:39:47Z vargenau $
  $ora = isset($GLOBALS['WikiTheme']) ? DATA_PATH . '/' . $GLOBALS['WikiTheme']->_findFile("ora.swf") : "ora.swf";
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="160" height="160" align="middle">
   <param name="movie" value="<?php echo $ora ?>"><param name="quality" value="high">
   <embed src="<?php echo $ora ?>" quality="high" type="application/x-shockwave-flash" width="160" height="160"></embed>
</object>
