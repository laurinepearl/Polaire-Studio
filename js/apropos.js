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

// Open the Modal
function openModal()
{
	document.getElementById( "myModal" ).style.display = "block";
}

// Close the Modal
function closeModal()
{
	document.getElementById( "myModal" ).style.display = "none";
}

var slideIndex = 1;
showSlides( slideIndex );

// Next/previous controls
function plusSlides( n )
{
	showSlides( slideIndex += n );
}

// Thumbnail image controls
function currentSlide( n )
{
	showSlides( slideIndex = n );
}

function showSlides( n )
{
	var i;
	var slides = document.getElementsByClassName( "mySlides" );
	var dots = document.getElementsByClassName( "demo" );
	var captionText = document.getElementById( "caption" );
	if ( n > slides.length ) { slideIndex = 1; }
	if ( n < 1 ) { slideIndex = slides.length; }
	for ( i = 0; i < slides.length; i++ )
	{
		slides[ i ].style.display = "none";
	}
	for ( i = 0; i < dots.length; i++ )
	{
		dots[ i ].className = dots[ i ].className.replace( " active", "" );
	}
	slides[ slideIndex - 1 ].style.display = "block";
	dots[ slideIndex - 1 ].className += " active";
	captionText.innerHTML = dots[ slideIndex - 1 ].alt;
}