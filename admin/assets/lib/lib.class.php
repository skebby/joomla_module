<?php
class NNlib
{

  function tabpref(){
    require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'version.class.php');
    $tab_prefix = new NNVersion;
    return $tab_prefix->tab_prefix;  
  }
  
	/**
	 * @return Calendarietto
	 * $nomecampo  = nome ed id dell'input txt contenente la data
	 * $valuecampo = valore del campo se valorizzato 
	 * $tipo       = formato data 'dmy' -> italiano o 'ymd' -> inglese    	 
	 */
  function GetDatePiker($nomecampo = '',$valuecampo = '0000-00-00 00:00:00',$tipo = 'dmy', $id = 0){
     $option = JRequest::getCmd('option');
    $format = '%d/%m/%Y';
    if ($nomecampo == ''){ return ''; } 
    if ($valuecampo == '0000-00-00 00:00:00' || $valuecampo == null){ 
      if($tipo == 'dmyh'){$valore = '00/00/0000 00:00';}
      else{$valore = '00/00/0000';}
    }
    else{
      $date = date_create($valuecampo);
      if($tipo == 'dmy'){ 
        $valore = date_format($date,"d/m/Y"); 
        $format = '%d/%m/%Y';
      } else if($tipo == 'dmyh'){
        $valore = date_format($date,"d/m/Y H:i");
        $format = '%d/%m/%Y %H:%M';
      }
    }
    $testo = '';   
    if($tipo == 'dmy' || $tipo == 'dmyh'){
      JHTML::_('behavior.calendar');  
      $testo .= '<input class="input_nn" type="text" id = "'.$nomecampo.$id.'" name = "'.$nomecampo.'" value = "'.$valore.'" />';
      $testo .= '<img class="img_nn" src="'.JURI::root().'administrator/components'.'/'.$option.'/assets/icons/calendar.png" alt="calendar" id="cal_'.$nomecampo.$id.'" />';
      $testo .= '
        <script type="text/javascript">
        Calendar.setup({
        inputField  : "'.$nomecampo.$id.'",              // ID della textbox
        ifFormat    : "'.$format.'", // formattazione data e ora
        showsTime   :    false,             // visualizza orario
        button      : "cal_'.$nomecampo.$id.'"      // ID del bottone
        });
        </script>';
    }else{
      $testo = JHTML::_('calendar', substr($valuecampo, 0 ,10), $nomecampo, $nomecampo, '%Y-%m-%d', array('class'=>'input_nn', 'size'=>'25',  'maxlength'=>'19'));
    }
    return $testo;  			 	  
  }
	
  function mail_debug($msg){	  
    $mail =& JFactory::getMailer();
    $mail->IsHTML(1);
    $config =& JFactory::getConfig();
    $subject = "Debug lib class.php";
    $body = "<br /><br />".$msg;
    $body .= "<br /><br /><br /> addì, ".date("d-m-Y H:i:s") ;
    $mail->addRecipient("debug@neonevis.it");
    $mail->setSubject( $subject );
    $mail->setBody( $body );
    //Invio della mail
    $mail->Send();
	}  
} //Fine classe  
?>