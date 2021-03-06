<?php
/**
 * FusionForge Plugin FCKeditor Plugin Class
 *
 * Copyright 2005 (c) Daniel A. Pérez <daniel@gforgegroup.com> , <danielperez.arg@gmail.com>
 *
 * This file is part of FusionForge-plugin-fckeditor
 *
 * FusionForge-plugin-fckeditor is free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * FusionForge-plugin-fckeditor is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
 
/**
 * The fckeditorPlugin class. It implements the Hooks for the presentation
 *  of the text editor whenever needed
 *
 */

class fckeditorPlugin extends Plugin {
	function fckeditorPlugin () {
		$this->Plugin() ;
		$this->name = "fckeditor" ;
		$this->text = _("HTML editor");
		$this->hooks[] = "groupisactivecheckbox";
		$this->hooks[] = "groupisactivecheckboxpost";
		$this->hooks[] = "text_editor"; // shows the editor
	}

	/**
	* The function to be called for a Hook
	*
	* @param    String  $hookname  The name of the hookname that has been happened
	* @param    String  $params    The params of the Hook
	*
	*/
	function CallHook ($hookname, &$params) {
		global $group_id;

		if (file_exists ("/usr/share/fckeditor/fckeditor.php")) {
			$use_system_fckeditor = true ;
			require_once("/usr/share/fckeditor/fckeditor.php");
		} else {
			$use_system_fckeditor = false ;
			require_once $GLOBALS['gfplugins'].'fckeditor/www/fckeditor.php';
		}

		if ($hookname == "groupisactivecheckbox") {
			//Check if the group is active
			$group = &group_get_object($group_id);
			echo "<tr>";
			echo "<td>";
			echo ' <input type="checkbox" name="use_fckeditorplugin" value="1" ';
			// checked or unchecked?
			if ( $group->usesPlugin ( $this->name ) ) {
				echo "checked=\"checked\"";
			}
			echo " /><br/>";
			echo "</td>";
			echo "<td>";
			echo "<strong>Use ".$this->text." Plugin (for forums and news)</strong>";
			echo "</td>";
			echo "</tr>";
		} elseif ($hookname == "groupisactivecheckboxpost") {
			$group = &group_get_object($group_id);
			if ( getStringFromRequest('use_fckeditorplugin') == 1 ) {
				$group->setPluginUse ( $this->name );
			} else {
				$group->setPluginUse ( $this->name, false );
			}
		} elseif ($hookname == "text_editor") {
			$group_id=$params['group']; // get the project id
			$project = &group_get_object($group_id);
			if ( (!$project) || (!is_object($project)) || ($project->isError()) || (!$project->isProject()) ) {
				return false;
			}
			if ( $project->usesPlugin ( $this->name ) ) { // only if the plugin is activated for the project show the fckeditor box
				$name = isset($params['name'])? $params['name'] : 'body';
				$oFCKeditor = new FCKeditor($name) ;
				if ($use_system_fckeditor) {
					$oFCKeditor->BasePath = util_make_uri('/fckeditor/');
					$oFCKeditor->Config['CustomConfigurationsPath'] = "/plugins/fckeditor/fckconfig.js"  ;
				} else {
					$oFCKeditor->BasePath = util_make_uri('/plugins/' . $this->name . '/');
				}
				$oFCKeditor->Value = $params['body'];
				if (isset($params['width'])) $oFCKeditor->Width = $params['width'];
				$oFCKeditor->Height = $params['height'];
				$oFCKeditor->ToolbarSet = isset($params['toolbar']) ? $params['toolbar']: 'FusionForge';
				$h = '<input type="hidden" name="_'.$name.'_content_type" value="html" />'."\n";
				$h .= $oFCKeditor->CreateHtml() ;

				// If content is present, return the html code in content.
				if (isset($params['content'])) {
					$params['content'] = $h;
				} else {
					$GLOBALS['editor_was_set_up'] = true;
					echo $h ;
				}
			}
		}
	}
}

// Local Variables:
// mode: php
// c-file-style: "bsd"
// End:

?>
