// Affiche l'image en overlay.
const text = $( "#caption" );
const modal = $( "#myModal" );
const image = $( "#img01" );
const gallery = $( ".myImg" );

gallery.click( function ()
{
	modal.css( "display", "flex" );

	image.attr( "src", $( this ).attr( "src" ) );

	text.html( $( this ).attr( "alt" ) );
} );

// Bouton de fermeture de l'image.
$( ".close" ).click( function ()
{
	modal.hide();
} );
