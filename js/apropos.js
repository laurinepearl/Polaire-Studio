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


// Bouton de publication.
const quatrieme = $( ".quatrieme" );
const cinquieme = $( ".cinquieme" );

$( ".cinquieme button[type = submit]" ).click( function ()
{
	// Donner un avis.
	cinquieme.fadeOut( 300, function ()
	{
		quatrieme.fadeIn( 250 );
	} );
} );

$( ".quatrieme button[type = button]" ).click( function ()
{
	// Annulation.
	quatrieme.fadeOut( 300, function ()
	{
		cinquieme.fadeIn( 250 );
	} );
} );



// Nombre d'étoiles
$( ".comment li" ).click( function ()
{
	$( "#etoile" ).val( $( this ).find( "i" ).text() );
} );

// Affichage formulaire de connexion.
$( ".form_co" ).click( function ( event )
{
	event.preventDefault();
	showForm();
} );