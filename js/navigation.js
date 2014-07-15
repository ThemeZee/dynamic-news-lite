/*! jQuery navigation.js
  Add toggle icon for mobile navigation and dropdown animations for widescreen navigation
  Author: Thomas W (themezee.com)
*/
jQuery(document).ready(function($) {
						
	/** Mobile Footer Navigation */
	/* Add menu icon */
	$('#footernav').after('<h3 id=\"footernav-icon\"></h3>');
	
	/* Add toggle effect */
	$('#footernav-icon').on('click', function(){
		$('#footernav-menu').slideToggle();
		$(this).toggleClass('active');
	});
	
	
	/** Mobile Main Navigation */
	/* Add menu icon */
	$('#mainnav').before('<h3 id=\"mainnav-icon\">' + dynamicnews_navigation_params.menuTitle + '</h3>');
	
	/* Add toggle effect */
	$('#mainnav-icon').on('click', function(){
		$('#mainnav-menu').slideToggle();
		$(this).toggleClass('active');
	});

	/** Widescreen Dropdown Navigation */
	/* Get Screen Size with Listener */ 
	if(typeof matchMedia == 'function') {
		var mq = window.matchMedia('(max-width: 60em)');
		mq.addListener(dynamicnewsWidthChange);
		dynamicnewsWidthChange(mq);
	}
	function dynamicnewsWidthChange(mq) {
		if (mq.matches) {
	
			/* Reset dropdown animations */
			$('#mainnav-menu ul').css({display: 'block'}); // Opera Fix
			$('#mainnav-menu li ul').css({visibility: 'visible', display: 'block'});
			$('#mainnav-menu li').unbind('mouseenter mouseleave');
		
		} else {
			
			/* Add dropdown animations */
			$('#mainnav-menu ul').css({display: 'none'}); // Opera Fix
			$('#mainnav-menu li').hover(function(){
				$(this).find('ul:first').css({visibility: 'visible',display: 'none'}).slideDown(300);
			},function(){
				$(this).find('ul:first').css({visibility: 'hidden'});
			});
			
		}
	}
	
});
	