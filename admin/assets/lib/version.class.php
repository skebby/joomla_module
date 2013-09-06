<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

/**
 * Version information
 */
class NNVersion
{
	var $PRODUCT 	= '<strong>Gest. SMS by Skebby.it</strong>';
	var $RELEASE 	= '2';
	var $DEV_STATUS = 'Stable';
	var $DEV_LEVEL 	= '0';
	var $BUILD	= '2';
	var $CODENAME 	= 'None';
	var $RELDATE 	= '2013-07-31';
	var $RELTIME 	= '00:00';
	var $RELTZ 	= 'GMT';
	var $COPYRIGHT 	= 'Copyright (C) 2012 Neonevis Srl. All rights reserved.';
	var $URL 	= '<a href="http://www.neonevis.it">Neonevis Srl</a> This is Free Software released under the GNU General Public License V.3.';
  var $tab_prefix='_sk_';

	/**
	 * @return the tab prefix
	 */
	function gettab_prefix()
	{
		return $this->tab_prefix ;
	}
	/**
	 * @return string Long format version
	 */
	function getLongVersion()
	{
		return $this->PRODUCT .' '. $this->RELEASE .'.'. $this->DEV_LEVEL .'.'. $this->BUILD .' '
			. $this->DEV_STATUS
			.' [ '.$this->CODENAME .' ] '. $this->RELDATE .' '
			. $this->RELTIME .' '. $this->RELTZ;
	}

	/**
	 * @return string Short version format
	 */
	function getShortVersion() {
		return $this->PRODUCT .' '.$this->RELEASE .'.'. $this->DEV_LEVEL;
	}
	
  function getActualVersion() {
    return $this->RELEASE .'.'. $this->DEV_LEVEL .'.'. $this->BUILD  ;
	}
	
  function getLastVersion(){
   $option = JRequest::getCmd('option');
    $perc = 'http://www.neonevis.it/components_help/componenti_25.txt';
    if (!$p_file = fopen($perc,"r")) {
      $msg=JText::_( 'NN_VERNOFILECONTROLLO' );
      return $msg;
    } else {
      while(!feof($p_file)){
        $linea = fgets($p_file, 255);
        $myarray = explode(":", $linea);
        if ($myarray[0]==$option){
          $versione=$myarray[1];
          return trim($versione);
        } 

      }
      fclose($p_file);
    }
	}

  function getCheckVersion(){
    $ultima=$this->getLastVersion();
    $attuale=$this->getActualVersion();       
    if ($ultima==$attuale){
      $msg=JText::_( "NN_VERSOK" );    
    }else{
      $msg=JText::_( "NN_VERSNOAGG" );
    }
    return $msg;
  }

  function getPHPStatus(){
    $option = JRequest::getCmd('option');    
    $erro = ini_get('display_errors');
    $shorttag = ini_get('short_open_tag');
    $glob = ini_get('register_globals');
    $magic = ini_get('magic_quotes_gpc');
    $upload = ini_get('file_uploads');
    $maxfile = ini_get('upload_max_filesize');
    $exten = ini_get('extension');

    $im_ok='<img class="img_nn" src="'.JURI::base().'/'.'components'.'/'.$option.'/'.'assets'.'/'.'icons'.'/'.'icon-16-ok.png" />';
    $im_ko='<img class="img_nn" src="'.JURI::base().'/'.'components'.'/'.$option.'/'.'assets'.'/'.'icons'.'/'.'icon-16-ko.png" />';
    
    $phpstatus="<strong>".JText::_("NN_VERPHPINI")."</strong><br/><br/>";
    if ($erro=='ON'){ $phpstatus.= "<div>".$im_ko.JText::_("NN_VERERRORKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERERROROK")."</div>"; }
    if ($shorttag=='OFF'){ $phpstatus.= "<div>".$im_ko.JText::_("NN_VEROTKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VEROTOK")."</div>"; } 
    if ($glob=='ON'){ $phpstatus.= "<div>".$im_ko.JText::_("NN_VERGLOBALKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERGLOBALOK")."</div>"; }
    if ($magic=='OFF'){ $phpstatus.= "<div>".$im_ko.JText::_("NN_VERMQKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERMGOK")."</div>"; }
    if ($upload=='OFF'){ $phpstatus.= "<div>".$im_ko.JText::_("NN_VERFUKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERFUOK")."</div>"; }
    if ($maxfile<='8M'){ $phpstatus.= "<div>".$im_ko.JText::_("NN_VERFSKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERFSOK").$maxfile."</div>"; }
    
    if (!extension_loaded('gd')) {$phpstatus.= "<div>".$im_ko.JText::_("NN_VERGDKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERGDOK")."</div>"; }
    if (!extension_loaded('curl')) {$phpstatus.= "<div>".$im_ko.JText::_("NN_VERCURLKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERCURLOK")."</div>"; }
    if (!extension_loaded('bcmath')) {$phpstatus.= "<div>".$im_ko.JText::_("NN_VERBMKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERBMOK")."</div>"; }
    if (!extension_loaded('iconv')) {$phpstatus.= "<div>".$im_ko.JText::_("NN_VERICVKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERICVOK")."</div>"; }
	  if (!extension_loaded('ioncube')) {$phpstatus.= "<div>".$im_ko.JText::_("NN_VERICKO")."</div>"; }else{ $phpstatus.= "<div>".$im_ok.JText::_("NN_VERICOK")."</div>"; }
      
    return $phpstatus; 
  }
  
  function getPHPCheck(){
    $phpv = phpversion();
    $arr_php = explode(".", $phpv);  
    if($arr_php[0] < '5') return 1;
    if($arr_php[0] == '5' && $arr_php[1] < '2') return 1;
    return 0;  
  } 

}

?>