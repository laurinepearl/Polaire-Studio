const images = 4;	// Nombre d'images.
let indice = 1;		// Image actuelle.

function next()
{
	if ( indice == images )
		indice = 1;
	else
		indice++;

	document.querySelector( "#show" ).src = `images/caroussel/rea${ indice }.jpeg`;
}

function demarrer()
{
	setInterval( next, 2000 );
}