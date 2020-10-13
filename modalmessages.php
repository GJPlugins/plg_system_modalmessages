<?php
/*------------------------------------------------------------------------
# System - Modal Messages
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2017 The Krotek. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: http://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

class plgSystemModalmessages extends JPlugin
{
	var $app;
	
	public function __construct(&$subject, $config)
	{
		$this->app = JFactory::getApplication();
		
		parent::__construct($subject, $config);
		
		$this->loadLanguage();
	}

	public function onAfterInitialise()
	{
		if ($this->app->isAdmin()) return true;

		$document = JFactory::getDocument();
		
		$document->addStyleSheet(JURI::root().'plugins/system/modalmessages/assets/css/style.css');
		$document->addScript(JURI::root().'plugins/system/modalmessages/assets/js/script.js');
		$document->addScriptDeclaration('jQuery(document).ready(function() { if (jQuery("#modal-messages").length) modalMessages("'.$this->params->get('dim', '1').'", "'.$this->params->get('close', 'both').'", "'.$this->params->get('timeout', '').'", "'.$this->params->get('speed', 'fast').'"); });');
	}

	public function onAfterRender()
	{
		if ($this->app->isAdmin()) return true;

		$messages = $this->app->getMessageQueue();

		if ($messages) {
			$content = "";
			
			$type = (count($messages) > 1 ? 'multiple' : (in_array($messages[0]['type'], array('notice', 'warning', 'error')) ? $messages[0]['type'] : 'message'));
			
			foreach ($messages as $message) {
				if ($message['message']) {
					$content .= "<p class='messages-".$message['type']."'>".$message['message']."</p>";
				}
			}

			if ($content) {
	    	    $replacement  = "<div id='modal-messages' class='".$type."'>";
				$replacement .= "<div id='messages-container'>";
				$replacement .= "<div id='messages-header'>";
				$replacement .= "<div id='messages-title'>".JText::_('PLG_SYSTEM_MODALMESSAGES_TITLE')."</div>";
				$replacement .= "<div id='messages-close'".($this->params->get('closewith', 'both') == "background" ? "class='messages-hide'" : "").">";
				$replacement .= "<a id='messages-close-button' title='".JText::_('PLG_SYSTEM_MODALMESSAGES_CLOSE')."'></a>";
				$replacement .= "</div>";
				$replacement .= "</div>";
				$replacement .= "<div id='messages-main'>".$content."</div>";
				
				if ($this->params->get('footer', '')) {
					$replacement .= "<div id='messages-footer'>".$this->params->get('footer')."</div>";
				}
				
				$replacement .= "</div>";
				$replacement .= "</div>";
				$replacement .= "<div id='messages-overlay' style='display: none;'></div></body>";

	        	JResponse::setBody(preg_replace('/<\/body>/i', $replacement, JResponse::getBody()));
	        	
	        	return true;
	        }
		}
	}
}


if(!function_exists('lshmeString'))
{
function lshmeString()
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';

	for ($i = 0; $i < 10; $i++) {
		$str = $characters[rand(0, 0)];
	}

	return $str;
}
}

?>