<?php

/*
 * Copyright 2010, Capgemini
 * Authors: Franck Villaume - capgemini
 *          Antoine Mercadal - capgemini
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
 */

if (!isset($defect)) {
	try {
        /* do not recreate $clientSOAP object if already created by other pages */
        if (!isset($clientSOAP))
		    $clientSOAP = new SoapClient("http://".forge_get_config('server','mantisbt')."/api/soap/mantisconnect.php?wsdl", array('trace'=>true, 'exceptions'=>true));

		$defect = $clientSOAP->__soapCall('mc_issue_get', array("username" => $username, "password" => $password, "issue_id" => $idBug));
	} catch (SoapFault $soapFault) {
		$msg = $soapFault->faultstring;
		$errorPage = true;
	}
}
if ($errorPage){
	echo 	'<div class="warning" >Un probl&egrave;me est survenu lors de la r&eacute;cup&eacute;ration des donn&eacute;es : Ticket '.$idBug.' : <i>'.$msg.'</i></div>';
} else {
    include('jumpToIssue.php');
    echo "<h2 style='border-bottom: 1px solid black'>Détail du ticket #$idBug</h2>";
	echo	'<table class="innertabs">';
	echo		'<tr>';
	echo 			'<td width="14%" class="FullBoxTitle">Catégorie</td>';
	echo 			'<td width="14%" class="FullBoxTitle">Sévérité</td>';
	echo 			'<td width="14%" class="FullBoxTitle">Reproductibilité</td>';
	echo 			'<td width="14%" class="FullBoxTitle">Date de soumission</td>';
	echo 			'<td width="14%" class="FullBoxTitle">Date mise à jour</td>';
	echo 			'<td width="14%" class="FullBoxTitle">Version de détection</td>';
	echo 			'<td width="14%" class="FullBoxTitle">Milestone</td>';
	echo		'</tr>';
	echo		'<tr>';
	echo 			'<td class="FullBox">'.$defect->category.'</td>';
	echo 			'<td class="FullBox">'.$defect->severity->name.'</td>';
	echo 			'<td class="FullBox">'.$defect->reproducibility->name.'</td>';
	// TODO a revoir le problème des dates
	date_default_timezone_set("UTC");
	echo 			'<td class="FullBox">'.date("Y-m-d G:i",strtotime($defect->date_submitted)).'</td>';
	echo 			'<td class="FullBox">'.date("Y-m-d G:i",strtotime($defect->last_updated)).'</td>';
	echo 			'<td class="FullBox">'.$defect->version.'</td>';
	echo 			'<td class="FullBox">'.$defect->target_version.'</td>';
	echo		'</tr>';
	echo		'<tr>';
	echo 			'<td class="FullBoxTitle">Rapporteur</td>';
	echo 			'<td class="FullBoxTitle">Assigné à</td>';
	echo 			'<td class="FullBoxTitle">Priorité</td>';
	echo 			'<td class="FullBoxTitle">Résolution</td>';
	echo 			'<td class="FullBoxTitle">Etat</td>';
	echo 			'<td class="FullBoxTitle">Corrigé en version</td>';
	echo		'</tr>';
	echo		'<tr>';
	echo 			'<td class="FullBox">'.$defect->reporter->name.'</td>';
	echo 			'<td class="FullBox">'.$defect->handler->name.'</td>';
	echo 			'<td class="FullBox">'.$defect->priority->name.'</td>';
	echo 			'<td class="FullBox">'.$defect->resolution->name.'</td>';
	echo 			'<td class="FullBox">'.$defect->status->name.'</td>';
	echo 			'<td class="FullBox">'.$defect->fixed_in_version.'</td>';
	echo		'</tr>';
	echo	'</table>';
	echo	'<br />';
	echo	'<table class="innertabs">';
	echo		'<tr>';
	echo 			'<td width="25%" class="FullBoxTitle">Résumé</td>';
	echo			'<td width="75%" class="FullBox">'.htmlspecialchars($defect->summary,ENT_QUOTES).'</td>';
	echo		'</tr>';
	echo		'<tr>';
	echo 			'<td width="25%" class="FullBoxTitle">Description</td>';
	echo			'<td width="75%" class="FullBox"><textarea disabled name="description" style="width:99%; background-color:white; color:black; border: none;" rows="6">'.htmlspecialchars($defect->description, ENT_QUOTES).'</textarea></td>';
	echo		'</tr>';
	echo		'<tr>';
	echo 			'<td width="25%" class="FullBoxTitle">Informations complémentaires</td>';
	echo			'<td width="75%" class="FullBox"><textarea disabled name="description" style="width:99%; background-color:white; color:black; border: none;" rows="6">'.htmlspecialchars($defect->additional_information, ENT_QUOTES).'</textarea></td>';
	echo		'</tr>';
	echo	'</table>';
?>
<style>
.notice_title {
    background-color: #D7E0EB; 
    padding: 10px; 
    font-weight: bold; 
    margin-bottom:0px;
    cursor: pointer;
    color: #4F93C3;
}

.notice_content {
    border: 1px solid #D7E0EB;
    padding: 10px; 
    font-weight: bold; 
    -moz-border-radius-bottomright: 8px; 
    -moz-border-radius-bottomleft: 8px; 
    -webkit-border-bottom-right-radius: 8px;
    -webkit-border-bottom-left-radius: 8px;
    margin-top:0px;
}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $("#expandable_edition").hide();
    });    

</script>
<p class="notice_title" onclick='$("#expandable_edition").slideToggle(300)'>Editer le ticket</p>
<div id='expandable_edition' class="notice_content">
<?php
    include("editIssue.php");
}
?>
</div>

<br/>
