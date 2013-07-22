//<![CDATA[
jQuery(document).live('ready',function(){
	jQuery("[class^='slp-sec']").live('click',function(e){
		e.preventDefault();
		var slpClass = '.'+jQuery(this).attr('class')+'-cnt';
		jQuery(slpClass).toggle('slow');
	});
});
//]]>