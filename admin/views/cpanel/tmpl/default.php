<?php
/*
 * @package for Joomla 2.5 Native
 * @component SMS by Skebby.it
 * @copyright 2013 Copyright (C) Neonevis Srl www.neonevis.it
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
	defined('_JEXEC') or die('Restricted access');
	$PulituraXSKebby=1; //settare a 0 per far riapparire i riferimenti a neonevis.
	
	
	JHTML::_('behavior.tooltip');
	$option = JRequest::getCmd('option');
	$alt = JText::_( 'NN_AIUTO' );
	$file= JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'help'.'/'."cpanel.html";
	$file1= JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'help'.'/'."com_license.txt";
	$bar=& JToolBar::getInstance( 'toolbar' );
	$bar->appendButton( 'Link', 'print', 'Tools', 'index.php?option='.$option.'&task=tools' );
	$bar->appendButton( 'Popup', 'help', $alt, $file, 550, 400 );
	$bar->appendButton( 'Popup', 'help', JText::_( 'NN_LICENZA' ), $file1, 550, 400 );
	
	require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.'lib'.DS.'version.class.php');
	$ver = new NNVersion;
	$version=$ver->getLongVersion();
	
	$params = &JComponentHelper::getParams( $option );
  $mostracredit=$params->get( 'crediti' );

	require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'assets'.'/'.'lib'.'/'.'sms.class.php');
  $JSMS = new NNSMS();
	$sender_number=$params->get('sender_number'); 
	$sender_string=$params->get('sender_string'); 
	$sms_username=$params->get('sms_username');
  $sms_password=$params->get('sms_password');

  if ($sms_username!="" || !isset($sms_username)){ $credit_result = $JSMS->skebbyGatewayGetCredit($sms_username,$sms_password); }    
  
  $msg_error="";
  if ($sms_username=="" || !isset($sms_username)){
      $msg_error.='    <fieldset class="adminform"> ';
      $msg_error.='    <legend>'.JText::_( "NN_INVIASMS" ).'</legend> ';
      $msg_error.='    <h3>'.JText::_( "NN_PARAMNONCONFIGURATI" ).'</h3>';
      $msg_error.='    </fieldset>';       
    }elseif(!extension_loaded('curl')){
      $msg_error.='    <fieldset class="adminform"> ';
      $msg_error.='    <legend>'.JText::_( "NN_INVIASMS" ).'</legend> ';
      $msg_error.='    <h3>'.JText::_( "NN_CURLNONCARICATE" ).'</h3>';
      $msg_error.='    </fieldset>';  
    }elseif ($credit_result['basic_sms']<=1){
      $msg_error.='    <fieldset class="adminform"> ';
      $msg_error.='    <legend>'.JText::_( "NN_INVIASMS" ).'</legend> ';
      $msg_error.='    <h3>'.JText::_( "NN_CREDITOINSUF" ).'</h3>';
      $msg_error.='    </fieldset>';  	
    }
    ?>
		
<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="610">       

<form name="adminForm" id="adminForm" action="index.php" method="post">
    	<fieldset class="adminform">
    	<legend><?php echo JText::_( 'NN_SMS' ); ?></legend>
       <div>
        <table border="0" cellpadding="5" class="sms_table">
        <?php if ($msg_error!=""){ ?>
            <tr>
                <td colspan="2" class="sms_message"><?php echo $msg_error; ?></td>
            </tr>          
         <?php }elseif ($credit_result['basic_sms']<=1){ ?>
            <tr>
                <td colspan="2" class="sms_message"><?php echo JText::_('NN_CREDITOINSUF'); ?></td>
            </tr>
        <?php } ?>
            <tr>
                <td><label for="method"><?php echo JText::_('NN_TIPOSMS'); ?></label></td>
                <td>
                    <?php echo $this->lists['method']; ?>
                </td>
            </tr>
            <tr>
                <td><label for="recipients"><?php echo JText::_('NN_DESTINATARIO'); ?></label></td>
                <td class="recipient">
                    
                    <div>
                    <span id="recipients">
                        <input type="text" name="recipients[]" value="39" />
                    </span>
                    </div>
                    
                    <div><a href="javascript:;" onclick="addRecipient();"><small><?php echo JText::_('NN_ADDDESTINATARIO'); ?></small></a></div>
                    <?php echo JHTML::tooltip(JText::_('NN_T_DEST'), 'Informazione', 'tooltip.png', '',false); ?>
                </td>
            </tr>
            <tr>
                <td><label for="text"><?php echo JText::_('NN_TESTO'); ?></label></td>
                <td><textarea name="text" id="text" cols="30" rows="10"></textarea></td>
            </tr>
      			<tr>
      				<td></td>
      				<td>
      					<small>
      					<?php echo JText::_('NN_CARRIMANENTI'); ?><span id="leftChars" style="color:#F00;">0</span> /
      					<b id="messageMaxLength">765</b>
      					(<span id="numberOfSMS" style="color:#39b54a;">1</span>)
      					</small>
      				</td>
      			</tr>
            <tr>
                <td><label for="sender_number"><?php echo JText::_('NN_MITNUM'); ?></label></td>
                <td><input type="text" name="sender_number" id="sender_number" value="<?php echo $sender_number; ?>" />
					      <?php echo JHTML::tooltip(JText::_('NN_T_SENDNUM'), 'Informazione', 'tooltip.png', '',false); ?>
                </td>
            </tr>
            <tr>
                <td><label for="sender_string"><?php echo JText::_('NN_MITALFA'); ?></label></td>
                <td><input type="text" name="sender_string" id="sender_string" maxlength="11" value="<?php echo $sender_string; ?>" />
                <?php echo JHTML::tooltip(JText::_('NN_T_MAXCHAR'), 'Informazione', 'tooltip.png', '',false); ?>
                </td>
            </tr>
            <tr>
                <td><label for="user_reference"><?php echo JText::_('NN_USERREF'); ?></label></td>
                <td><input type="text" name="user_reference" id="user_reference" maxlength="10" value="" />
                <?php echo JHTML::tooltip(JText::_('NN_T_MAXCHAR'), 'Informazione', 'tooltip.png', '',false); ?>
                </td>
            </tr>            
            <tr>
                <td><label for="charset"><?php echo JText::_('NN_CHARSET'); ?></label></td>
                <td>
				    	      <?php echo $this->lists['charset']; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" value="<?php echo JText::_('NN_INVIASMS'); ?>" name="submit" />
                </td>
            </tr>
        </table>

       </div>
    	</fieldset>
      <input type="hidden" name="option" value="<?php echo $option; ?>" />
      <input type="hidden" name="task" value="inviasmsanagrafica" />
      <input type="hidden" name="controller" value="skebby" />	
      <?php echo JHTML::_( 'form.token' ); ?>
</form>  

     <!-- fine colonna sx -->
  	</td>
  	<td valign="top"style="border:0px solid #c6c6c6; width:100%; margin: 5px;"> 
    <fieldset class="adminform">
    <?php 
    $taboptions = array('onActive' => 'function(title, description){description.setStyle("display", "block"); title.addClass("open").removeClass("closed");}',
    								'onBackground' => 'function(title, description){ description.setStyle("display", "none"); title.addClass("closed").removeClass("open"); }',
    								'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
    								'useCookie' => true, // this must not be a string. Don't use quotes.
    );
    echo JHtml::_('tabs.start', 'tab_group_id', $taboptions);  
    echo JHtml::_('tabs.panel', JText::_('NN_GENERALE'), 'panel_4_id'); 
    ?>
      <table cellpadding="0" cellspacing="0" border="0" width="95%">
      	<tr>
      		<td valign="top"><img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'.'cloud-sms-business.png'; ?>" alt="Logo" align="left" /> </td>
      	</tr>
      	<?php if($PulituraXSKebby==0) { ?> 
				<tr>
      		<td valign="top"><img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'; ?>logo.png"	alt="Logo" align="left"></td>
      	</tr>
      	<?php } ?>   
      	<tr>
          <td valign="top" width="100%"><br /><strong>Gest. SMS by Skebby.it</strong> Componente di Invio SMS tramite il servizio Skebby.it .
      		<br />
      		<a href="http://www.skebby.it" target="_blank">www.skebby.it</a>.
      		<br />
      		<?php if($PulituraXSKebby==0) { ?>  <?php echo JText::_('NN_DEVELOP'); ?> <a href="http://www.neonevis.it" target="_blank">Neonevis Srl</a>. <?php } ?>
          </td>
      	</tr>
      	<?php if($PulituraXSKebby==0) { ?>  
      	<tr>
          <td valign="top" width="100%"><br /><strong>Neonevis Srl</strong> Componente Joomla! personalizzati.
      		<br />
      		<a href="http://www.neonevis.it" target="_blank">www.neonevis.it</a>
      		<br />
          <a href="mailto:supporto@neonevis.it?body=<?php echo $ver->getLongVersion()." --> ".JURI::base();  ?>">supporto@neonevis.it</a>.
          </td>
      	</tr>
      	<?php } ?>    	
      </table>
      
      <?php if($PulituraXSKebby==0) { ?>
      <?php echo JHtml::_('tabs.panel', JText::_('NN_AIUTO'), 'panel_5_id'); ?>  
      <table cellpadding="0" cellspacing="0" border="0" width="95%">
      	<tr>
      		<td valign="top"><?php echo JText::_('NN_VISIONAILMANUALE'); ?> <a href="http://www.neonevis.it/joomla-space/manuali-download.html" title="Manuali" target="_blank"><?php echo JText::_('NN_SEZMANUALI'); ?></a>  </td>
      	</tr>
      </table>
		  <?php } ?>
		 
    <?php echo JHtml::_('tabs.panel', JText::_('NN_CONTROLLI'), 'panel_6_id'); ?>
    <?php
      $db=& JFactory::getDBO();
      $query = "SELECT params FROM #__extensions WHERE `element` like '%".$option."%'";
      $db->setQuery( $query );    
      $caricati = $db->loadResult();
      if( isset($caricati) ){
       $im_caricato='<img src="'.JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'icons'.'/'.'icon-16-ok.png" />';
       $imt_caricato=JText::_('NN_CONFIGOK');
      }else{
       $im_caricato='<img src="'.JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'icons'.'/'.'icon-16-ko.png" />';
       $imt_caricato=JText::_('NN_CONFIGNONEFFETTUATA'); 
      }    
    ?>  
      <table cellpadding="0" cellspacing="0" border="0" width="95%">
        <tr>
      		<td valign="top"><?php echo JText::_('NN_VERSIONEATTUALE'); ?></td>
      		<td valign="top"><?php echo $ver->getLongVersion(); ?></td>
      	</tr>
        <tr>
      		<td colspan="2">&nbsp;</td>
      	</tr>    	
      	<tr>
      		<td valign="top"><?php echo $im_caricato;?></td>
      		<td valign="top"><?php echo $imt_caricato;?></td>
      	</tr>
      	<tr>
      		<td valign="top" colspan="2">&nbsp;</td>
      	</tr>
  <?php 
  if($ver->getPHPCheck() == 1){
    $v_caricato='<img src="'.JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'icons'.'/'.'icon-16-ko.png" />';
    $vt_caricato=JText::_('NN_AGGIORNAPHP');
  ?>
      	<tr>
      	  <td valign="top"><?php echo $v_caricato;?></td>
      		<td valign="top"><?php echo $vt_caricato;?></td>        
      	</tr>
  <?php } ?>
      	<tr>
      		<td valign="top" colspan="2">&nbsp;</td>
      	</tr>
      	<tr>
      		<td valign="top" colspan="2"><?php echo $ver->getPHPStatus(); ?></td>
      	</tr>
      </table>

  <?php echo JHtml::_('tabs.panel', JText::_('NN_CREDITOSMS'), 'panel_7_id'); ?>
  <?php 
   if($msg_error!=""){
     echo $msg_error;
   }else{
  ?>  
      <table cellpadding="0" cellspacing="0" border="0" width="95%">
      	<tr>
      	<td align="center"><img src="<?php echo JURI::base().'components'.'/'.$option.'/'.'assets'.'/'.'images'.'/'.'cloud-sms-business.png'; ?>" />
      	</td>
      	</tr>
        <tr>
      		<td valign="top"><?php 
      		$credit_result_plus=$credit_result['credit_left']/(($credit_result['credit_left']/$credit_result['classic_sms'])+0.004);
      		
          if($credit_result['status']=='success') {
          	echo JText::_('NN_CREDITORESIDUO') .$credit_result['credit_left']."<br/>";
          	echo JText::_('NN_CLASSICRIMAMENTI') .$credit_result['classic_sms']."<br/>";
          	echo JText::_('NN_PLUSRIMANENTI') .number_format($credit_result_plus,0)."<br/>";
          	echo JText::_('NN_BASICRIMANENTI') .$credit_result['basic_sms']."<br/>";
          }
          if($credit_result['status']=='failed') {
            echo JText::_('NN_INVIOFALLITO');
          }      		
      	?>	
      		</td>
      	</tr>
      	<?php if($PulituraXSKebby==0) { ?> 
      	<tr>
      		<td>
      		<div>&nbsp;</div>
      	  <?php echo JText::_('NN_ACQUISTACREDITO'); 
      	  //@FIXME: sistemare nel file di language!
      	  ?>
					<p>Puoi acquistare credito SMS Cloud registrandoti su <a href="http://www.skebby.it/" title="skebby" target="_blank">www.skebbi.it</a></p>
          <p>Se utilizzi il nostro link Partner potrai ricevere uno <strong>sconto</strong> in funzione del numero di sms acquistati.</p>
          <p><a href="http://www.skebby.it/business/servizi-sms-di-massa/?ac=2876767" title="link partner" target="_blank">http://www.skebby.it/business/servizi-sms-di-massa/?ac=2876767</a></p>
          <p>Per ulteriori sconti contatta il nostro ufficio <a href="http://www.neonevis.it/contatti/6-commerciale.html" title="Commerciale">commerciale</a>.<br />
            Per informazioni tecniche sull'uso degli sms nel nostro componente contatta il nostro <a href="http://www.neonevis.it/contatti/7-supporto-tecnico.html" title="Supporto">supporto tecnico</a>.<br />
            Per problemi tecnici sugli sms contatta il supporto tecnico di skebby a <a href="mailto:supporto@skebby.it" title="Supporto skebby">supporto@skebby.it</a>.
          </p>      	  
      		<div>&nbsp;</div>
      		</td>
      	</tr>
       <?php } ?>	       
      </table>
<?php } ?>        

		<?php if($PulituraXSKebby==0) { ?>
    <?php echo JHtml::_('tabs.panel', JText::_('NN_DONAZIONI'), 'panel_8_id'); ?>     
      <table cellpadding="0" cellspacing="0" border="0" width="95%">
      	<tr>
      		<td valign="top">
      		<p><?php echo JText::_('Mantieni gratuito ed OpenSource lo sviluppo di componenti per Joomla! Fai una donazione... ogni contributo e\' ben accetto.'); ?></p> 
      		<div>
      		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="hosted_button_id" value="W9JJS55KSSLD8">
          <input type="image" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare.">
          <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
          </form>
          </div>
      		</td>
      	</tr>
      </table>
 		<?php } ?>	 

 <?php echo JHtml::_('tabs.end'); ?>
    
    </fieldset> 
  	</td>
	</tr>
</table>
<div>&nbsp;</div>
<div>&nbsp;</div>
<?php if ($mostracredit==1) { ?>
      <table width="100%" class="nn_tabnorm">
      <tr>	
        <td style="text-align:center;">
          Componente  <?php echo $version; ?> - implementazioni ed assistenza su <a href="www.neonevis.it">www.neonevis.it</a>      
        </td>	
	    </tr>
      </table>	
<?php } ?>

