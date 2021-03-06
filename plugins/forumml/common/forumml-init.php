<?php

/**
 *
 * This file is part of FusionForge.
 *
 * FusionForge is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * FusionForge is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 * 
 * Portions Copyright 2010 (c) Mélanie Le Bail
 */

global $gfplugins;
require_once $gfplugins.'forumml/include/forummlPlugin.class.php' ;
define('SEARCH__TYPE_IS_LIST', 'forumml');
$forummlPluginObject = new forummlPlugin() ;

register_plugin ($forummlPluginObject) ;

// Local Variables:
// mode: php
// c-file-style: "bsd"
// End:

?>
