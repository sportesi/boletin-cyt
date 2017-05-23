/**
 * @author Joaquin
 */

$(function(){
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu-ajax",
		orientation: 'h',
		classname: 'ddsmoothmenu',
		contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
		image: ['/controls/menu/down.gif','/controls/menu/down.gif']
	});
				    
	 var $container = $('#container');
	
	 $container.isotope({
	   masonry: {
	     columnWidth: 15
	   },
	   sortBy: 'name',
	   getSortData: {
	     number: function( $elem ) {
	       var number = $elem.hasClass('element') ? 
	         $elem.find('.number').text() :
	         $elem.attr('data-number');
	       return parseInt( number, 10 );
	     },
	     alphabetical: function( $elem ) {
	       var name = $elem.find('.name'),
	           itemText = name.length ? name : $elem;
	       return itemText.text();
	     }
	   }
	 });
	
	 
	 var $optionSets = $('#options .option-set'),
	     $optionLinks = $optionSets.find('a');
	
	 $optionLinks.click(function(){
	   var $this = $(this);
	   // don't proceed if already selected
	   if ( $this.hasClass('selected') ) {
	     return false;
	   }
	   var $optionSet = $this.parents('.option-set');
	   $optionSet.find('.selected').removeClass('selected');
	   $this.addClass('selected');
	
	   // make option object dynamically, i.e. { filter: '.my-filter-class' }
	   var options = {},
	       key = $optionSet.attr('data-option-key'),
	       value = $this.attr('data-option-value');
	   // parse 'false' as false boolean
	   value = value === 'false' ? false : value;
	   options[ key ] = value;
	   if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
	     // changes in layout modes need extra logic
	     changeLayoutMode( $this, options )
	   } else {
	     // otherwise, apply new options
	     $container.isotope( options );
	   }
	   
	   return false;
	 });
	
	
	
	 // Sites using Isotope markup
	 var $sites = $('#sites'),
	     $sitesTitle = $('<h2 class="loading"><img src="http://i.imgur.com/qkKy8.gif" />Loading sites using Isotope</h2>'),
	     $sitesList = $('<ul class="clearfix"></ul>');
	   
	 $sites.append( $sitesTitle ).append( $sitesList );
	
	 $sitesList.isotope({
	   layoutMode: 'cellsByRow',
	   cellsByRow: {
	     columnWidth: 290,
	     rowHeight: 400
	   }
	 });
	
	 var ajaxError = function(){
	   $sitesTitle.removeClass('loading').addClass('error')
	     .text('Could not load sites using Isotope :(');
	 };
  
});