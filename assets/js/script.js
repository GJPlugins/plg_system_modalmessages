function modalMessages(dim, close, timeout, speed)
{
	var w = jQuery(window);
	var m = jQuery('#modal-messages');
	var o = jQuery('#messages-overlay');
	var b = jQuery('#messages-close-button');

	var heightRatio = (jQuery(window).height() != 0) ? m.outerHeight() / jQuery(window).height() : 1;
	var widthRatio = (jQuery(window).width() != 0) ? m.outerWidth() / jQuery(window).width() : 1;

	m.css({'display': 'none', 'position': 'fixed', 'margin': '0', 'top': (50 * (1 - heightRatio)) + '%', 'left': (50 * (1 - widthRatio))  + '%'}).fadeIn(speed);

	if (dim) {
    	o.fadeIn(speed);
    	
    	if ((close == "both") || (close == "button")) {
    		b.click(function() { o.fadeOut(speed); m.fadeOut(speed); });
    	}
    	
    	if ((close == "both") || (close == "background")) {
			o.click(function() { o.fadeOut(speed); m.fadeOut(speed); });
		}
    } else {
	   	if ((close == "both") || (close == "button")) {
    		b.click(function() { m.fadeOut(speed); });
    	}
    	
    	if ((close == "both") || (close == "background")) {
			o.click(function() { m.fadeOut(speed); });
		}		
    }
		
	if (timeout) {		
		setTimeout(function() { m.fadeOut(speed); if (dim) o.fadeOut(speed); }, timeout + "000");
	}
   	
}