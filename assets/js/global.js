/**
 * Theme global file.
 *
 */

(function( $ ) {

	/** Menu Responsive **/
    $('nav#menu').mmenu({
        "extensions": [
            "pagedim-black"
            /*"theme-white"*/
        ],
        "offCanvas": {
            "position": "left"
        },
        "searchfield": {
            "search" : false
        }
    });

	// Fire on document ready.
	$( document ).ready( function() {

	});

	$( window ).resize( function() {

	});

})( jQuery );
