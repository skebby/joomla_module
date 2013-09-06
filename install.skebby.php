<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Ensure this file is included via Joomla Framework
defined('_JEXEC') or die('Restricted access');

/**
 * Executes additional installation processes
 *
 */
function com_install() {

ini_set('max_execution_time',60);
  //ini_set('max_input_time',120);
	$PulituraXSKebby=1; //settare a 0 per far riapparire i riferimenti a neonevis.  
?>
<div align="center">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<?php if($PulituraXSKebby==0) { ?> 
		<td valign="top"><img src="components/com_skebby/assets/images/logo.png"	alt="Logo" align="left"></td>
		<?php } ?>  
		<td valign="top" width="100%">
		<img src="components/com_skebby/assets/images/cloud-sms-business.png" /><br />
		<strong>SMS by Skebby</strong><br />
		Componente di invio SMS tramite il servizio Skebby.it
		<br />
		<a href="http://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GNU General Public License V3</a>.</td>
	</tr>
	<?php if($PulituraXSKebby==0) { ?> 
  <tr>
  	<td colspan="2">
      <div>&nbsp;</div>
      <p>Puoi acquistare credito SMS Cloud registrandoti su <a href="http://www.skebby.it/" title="skebby" target="_self">www.skebbi.it</a></p>
      <p>Se utilizzi il nostro link Partner potrai ricevere uno <strong>sconto</strong> in funzione del numero di sms acquistati.</p>
      <p><a href="http://www.skebby.it/business/servizi-sms-di-massa/?ac=2876767" title="link partner" target="_self">http://www.skebby.it/business/servizi-sms-di-massa/?ac=2876767</a></p> 
      <p>Per ulteriori sconti contatta il nostro ufficio <a href="http://www.neonevis.it/contatti/6-commerciale.html" title="Commerciale">commerciale</a>.<br /> 
      Per informazioni tecniche sull'uso degli sms nel nostro componente contatta il nostro <a href="http://www.neonevis.it/contatti/7-supporto-tecnico.html" title="Supporto">supporto tecnico</a>.<br />
      Per problemi tecnici sugli sms contatta il supporto tecnico di skebby a <a href="mailto:supporto@skebby.it" title="Supporto skebby">supporto@skebby.it</a>.
      </p>
      <div>&nbsp;</div>
    </td>
   </tr> 	
	<?php } ?>     
</table>
</div>
<?php

  changeMenuImage();
  updateLanguage();  
  carica_dati_base();
  
}//end function

function changeMenuImage() {
  $db =& JFactory::getDBO();
  $query = "UPDATE #__menu SET img='components/com_skebby/assets/icons/skebby.png' WHERE link like '%option=com_skebby%' AND parent_id = 1 ";
  $db->setQuery( $query );
  if( !$db->query() ) {
    echo "<br /><br /><span style='color: #FF0000;'>Non posso modificare l'icona</span><br /><br />";
  }
}//end function

function updateLanguage() {
  $percorso=str_replace('com_installer','com_skebby',JPATH_COMPONENT_ADMINISTRATOR);

  //INGLESE
  $language_admin = JPATH_ROOT.'/administrator/language/en-GB/';
  $language_site = JPATH_ROOT.'/language/en-GB/';
  $source_admin = $percorso.'/assets/lang/admin/en-GB/';
  $source_site = $percorso.'/assets/lang/site/en-GB/';  

  if (!file_exists($language_admin) and !is_dir($language_admin)) {
      mkdir($language_admin);         
  }
  if (!file_exists($language_site) and !is_dir($language_site)) {
      mkdir($language_site);         
  }
  if ( is_writable($language_admin)  ){
    if(!file_exists($language_admin.'en-GB.com_skebby.ini')){copy ($source_admin.'en-GB.com_skebby.ini', $language_admin.'en-GB.com_skebby.ini');}
    if(!file_exists($language_admin.'en-GB.com_skebby.sys.ini')){copy ($source_admin.'en-GB.com_skebby.sys.ini', $language_admin.'en-GB.com_skebby.sys.ini');}
  }else {
    echo "<br /><br /><span style='color: #FF0000;'>File Language SITE NOT INSTALLED, please do it manually!</span><br /><br />";
  }
  if ( is_writable($language_site)  ){
    if(!file_exists($language_site.'en-GB.com_skebby.ini')){copy ($source_site.'en-GB.com_skebby.ini', $language_site.'en-GB.com_skebby.ini');}
  }else {
    echo "<br /><br /><span style='color: #FF0000;'>File Language ADMINISTRATOR  NOT INSTALLED, please do it manually!</span><br /><br />";
  }
  
  
  //ITALIANO
  $language_admin = JPATH_ROOT.'/administrator/language/it-IT/';
  $language_site = JPATH_ROOT.'/language/it-IT/';
  $source_admin = $percorso.'/assets/lang/admin/it-IT/';
  $source_site = $percorso.'/assets/lang/site/it-IT/';  

  if (!file_exists($language_admin) and !is_dir($language_admin)) {
      mkdir($language_admin);         
  }
  if (!file_exists($language_site) and !is_dir($language_site)) {
      mkdir($language_site);         
  }
  if ( is_writable($language_admin)  ){
    if(!file_exists($language_admin.'it-IT.com_skebby.ini')){copy ($source_admin.'it-IT.com_skebby.ini', $language_admin.'it-IT.com_skebby.ini');}
    if(!file_exists($language_admin.'it-IT.com_skebby.sys.ini')){copy ($source_admin.'it-IT.com_skebby.sys.ini', $language_admin.'it-IT.com_skebby.sys.ini');}
  }else {
    echo "<br /><br /><span style='color: #FF0000;'>File Lingua SITE NON installato Installare a mano!</span><br /><br />";
  }
  if ( is_writable($language_site)  ){
    if(!file_exists($language_site.'it-IT.com_skebby.ini')){copy ($source_site.'it-IT.com_skebby.ini', $language_site.'it-IT.com_skebby.ini');}
  }else {
    echo "<br /><br /><span style='color: #FF0000;'>File Lingua ADMINISTRATOR NON installato Installare a mano!</span><br /><br />";
  }
  
  
  
}      

function carica_dati_base(){

}   //fine caricamento dati in tabelle


?>
