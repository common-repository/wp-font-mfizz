/**
 * WP Font Mfizz
 *
 * @since 1.0.0
 */

/**
 * Reference to JQuery framework
 */ 
var $ = typeof JQuery !== 'undefined' ? JQuery : jQuery;

/**
 * Filters and inserts icons in the text editor WordPress
 */
$( document ).on( 'ready ', function() {
	$( 'body' ).on( 'mousedown', '.wpfm-iconpicker', function(e) {
		e.preventDefault();

	    $( this ).not( ' .initialized' )
    	.addClass( 'initialized' )
    	.iconpicker({
	    	placement: 'bottomLeft',
	    	hideOnSelect: true,
	    	animation: false,
	    	selectedCustomClass: 'selected',
	    	icons: wpfm_vars.fa_icons,
	    	fullClassFormatter: function( val ) {
	    		if ( wpfm_vars.fa_prefix ) {
	    			return wpfm_vars.fa_prefix + val;
	    				
	    		} else {
	    				return val;
	    		}
	    	},
	    });

		$( this ).trigger( 'click' );
	})
	.on( 'click', '.wpfm-iconpicker', function(e) {
		$( this ).find( '.iconpicker-search' ).focus();
	});

	$( document ).on( 'iconpickerSelect', function( e ) {
		var icon = e.iconpickerItem.context.title.replace( '.', '' );
		
		wp.media.editor.insert( '[wpfm_icon name="icon' + icon + '" size="" color=""]' ); // append in the text editor
	});
});

