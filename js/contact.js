// Pour afficher le message de confirmation lorsque l'utilisateur
//	a soumis le formulaire de contact.
const snackbar = $( ".snackbar" );

snackbar.addClass( "show" );

setTimeout( function ()
{
	snackbar.removeClass( "show" );
}, 3000 );