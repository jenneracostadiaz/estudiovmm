jQuery( document ).ready( function( $ ) {
	$( '.ci-theme-sample-content-notice' ).on( 'click', '.notice-dismiss', function( e ) {
		$.ajax( {
			type: 'post',
			url: ajaxurl,
			data: {
				action: 'ci_theme_dismiss_sample_content',
				nonce: ci_theme_SampleContent.dismiss_nonce,
				dismissed: true
			},
			dataType: 'text',
			success: function( response ) {
				//console.log( response );
			}
		} );
	});
} );
