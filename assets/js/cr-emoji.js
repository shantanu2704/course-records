jQuery( 'document' ).ready( function ( $ ) {
    emojify.setConfig( { "img_dir": "https://www.webpagefx.com/tools/emoji-cheat-sheet/graphics/emojis/" } );
    emojify.run( document.getElementById( 'cr-reactions' ) );
} );