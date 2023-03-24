// Pour afficher le menu burger.
const navbar = $( ".navbar" );

$( "#menu-btn" ).click( function ()
{
	navbar.toggleClass( "active" );
} );

// Pour cacher la barre de navigation.
const header = $( ".header" );
let previous_position = window.pageYOffset;

$( window ).scroll( function ()
{
	const current_position = window.pageYOffset;

	if ( previous_position > current_position )
	{
		header.css( "top", "0" );
	}
	else
	{
		header.css( "top", "-100px" );
	}

	previous_position = current_position;
} );

// Pour afficher/cacher le formulaire d'inscription/connexion.
const forLogin = $( "#forLogin" );
const forRegister = $( "#forRegister" );

const loginForm = $( "#loginForm" );
const registerForm = $( "#registerForm" );

const formContainer = $( "#formContainer" );

forLogin.addClass( "active" );
forLogin.click( function ()
{
	forLogin.addClass( "active" );
	forRegister.removeClass( "active" );

	if ( loginForm.hasClass( "toggleform" ) )
	{
		formContainer.css( "transform", "translate( 0 )" );
		formContainer.css( "transition", "transform .5s" );

		registerForm.addClass( "toggleform" );
		loginForm.removeClass( "toggleform" );
	}
} );

forRegister.click( function ()
{
	forLogin.removeClass( "active" );
	forRegister.addClass( "active" );

	if ( registerForm.hasClass( "toggleform" ) )
	{
		formContainer.css( "transform", "translate( -100% )" );
		formContainer.css( "transition", "transform .5s" );

		registerForm.removeClass( "toggleform" );
		loginForm.addClass( "toggleform" );
	}
} );

// Pour afficher/disparaître l'effet d'overlay des formulaires précédents.
function showForm(event)
{
	event.preventDefault();

	const card = $( ".form-wrapper .card" );
	card.toggleClass( "show" );

	const state = card.hasClass( "show" );

	$( ".formContainer" ).css( "display", state ? "flex" : "none" );
	$( "html, body" ).animate( { scrollTop: 0 }, 100 );
}

$( "#displayform, .form_co, #hideform, [data-login = true]" ).click( showForm );

// Validations JavaScript des formulaires.
const form = $( "#registerForm" );
const email = $( "#register_email" );
const prenom = $( "#register_prenom" );
const password = $( "#register_password" );
const confirmation = $( "#register_confirmation" );
const conditions = $( "#conditions" );

function setErrorFor( input, message )
{
	const formControl = input.parent();

	formControl.attr( "class", "form-control error" );
	formControl.find( "small" ).text( message );
}

function setSuccessFor( input )
{
	input.parent().attr( "class", "form-control success" );
}

function isEmail( email )
{
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test( email );
}

function checkInputs()
{
	const emailValue = email.val().trim();
	const prenomValue = prenom.val().trim();
	const passwordValue = password.val().trim();
	const confirmationValue = confirmation.val().trim();

	let state = true;

	if ( emailValue === "" )
	{
		setErrorFor( email, "Le champ email est vide." );
		state = false;
	}
	else if ( !isEmail( emailValue ) )
	{
		setErrorFor( email, "L'email n'est pas valide." );
		state = false;
	}
	else
	{
		setSuccessFor( email );
	}

	if ( prenomValue == "" )
	{
		setErrorFor( prenom, "Le champs du prénom est vide." );
		state = false;
	}
	else
	{
		setSuccessFor( prenom );
	}

	if ( conditions.is( ":checked" ) )
	{
		setSuccessFor( conditions );
	}
	else
	{
		setErrorFor( conditions, "La case n'est pas coché" );
		state = false;
	}

	if ( passwordValue == "" )
	{
		setErrorFor( password, "Le champs du mot de passe est vide." );
		state = false;
	}
	else
	{
		setSuccessFor( password );
	}

	if ( confirmationValue == "" )
	{
		setErrorFor( confirmation, "Le champs de la confirmation du mot de passe est vide." );
		state = false;
	}
	else if ( passwordValue != confirmationValue )
	{
		setErrorFor( confirmation, "Le mot de passe ne corresponds pas." );
		state = false;
	}

	else
	{
		setSuccessFor( confirmation );
	}

	return state;
}




form.submit( function ( event )
{
	if ( !checkInputs() )
	{
		event.preventDefault();
	}
} );

// Pour afficher/montrer le mot de passe en clair.
$( ".eye" ).click( function ()
{
	const input = $( this ).parent().find( "input[name *= password]" );
	const visibility = input.attr( "type" ) == "password" ? false : true;

	if ( visibility )
	{
		input.attr( "type", "password" );
		$( this ).attr( "class", "fa-solid fa-eye-slash" );
	}
	else
	{
		input.attr( "type", "text" );
		$( this ).attr( "class", "fa-solid fa-eye" );
	}
} );

// Pour remonter tout en haut de la page.
$( window ).scroll( function ()
{
	if ( document.body.scrollTop > 200 || document.documentElement.scrollTop > 200 )
	{
		$( "#remonter" ).show();
	}
	else
	{
		$( "#remonter" ).hide();
	}
} );

// Pour réinitialiser le mot de passe.
$( "#mdpforget" ).click( function ( event )
{
	const email = prompt( "Saisissez votre adresse électronique." );

	if ( email == null || email == "" )
	{
		return;
	}

	// On vérifie si l'adresse électronique est valide.
	$.post( "php/reinitialisation.php", { email: email, step: 1 } )
		.done( function ()
		{
			// Si c'est le cas, on demande un nouveau mot de passe.
			const password = prompt( "Saisissez votre nouveau mot de passe." );

			if ( password == null || password == "" )
			{
				return;
			}

			$.post( "php/reinitialisation.php", { email: email, password: password, step: 2 } )
				.done( function ()
				{
					// Finalement, on indique à l'utilisateur que le mot de passe
					//	a été modifié !!!!!!
					alert( "Votre mot de passe a été modifié." );
				} )
				.fail( function ()
				{
					alert( "L'adresse électronique renseignée est invalide." );
				} );
		} )
		.fail( function ()
		{
			// Dans le cas contraire, on indique à l'utilisateur que l'adresse
			//	électronique est invalide.
			alert( "L'adresse électronique renseignée est invalide." );
		} );

	event.preventDefault();
} );

// Pour afficher le message de confirmation lorsque l'utilisateur
//	est connecté/inscris.
const snackbar = $( ".snackbar" );

snackbar.addClass( "show" );

setTimeout( function ()
{
	snackbar.removeClass( "show" );
}, 3000 );

// Bouton de publication.
$(document).on( "click", "#messagerie", function ()
{
	// apparition.
	if ($( ".sixieme" ).is(":visible")) {
		$( ".sixieme" ).fadeOut( 300 );
	} else {
		$( ".sixieme" ).fadeIn( 300 );
		$(".badge").hide();

		messages += Number($(".badge").first().text());
		localStorage.setItem('messages', messages);
	}
} );

$(".container-onglets .onglets:nth-child(2)").click(function(){
	$(".badge").hide();

	messages += Number($(".badge").first().text());
	localStorage.setItem('messages', messages);
})

$(document).on( "click", ".fleche", function ()
{
	// disparition.
	$( ".sixieme" ).fadeOut( 300 );
} );


//bouton entrer pour la messagerie
$(document).on("keydown", "textarea[name = message]", function ( event )
{
	if ( event.keyCode == 13 )
	{
		event.preventDefault();
		$( "button[class = comment_m]" ).click();
	}
} );

// Scroll automatique
setTimeout( function ()
{
	$( ".sixieme article > div:nth-child(2)" ).scrollTop( 200000000 );
}, 2500 );

// Apparition automatique messagerie après envoi message.
if ( window.location.href.includes( "?success=1" ) )
{
	$( ".sixieme" ).fadeIn( 300 );
}

// Notifications
let messages = 0

$.post( "php/notifications.php", function( data ) {
	if (data != "") {
		const json = JSON.parse(data)
		const count = Number(localStorage.getItem('messages'))

		if (json.length > count && count > 0){
			messages = count
		} else {
			messages = json.length
		}

		localStorage.setItem('messages', messages);
	}

	notif()
});

function notif() {
	$.post( "php/notifications.php", function( data ) {
		if (data != "") {
			const json = JSON.parse(data)
			if (messages > json.length) {
				messages = json.length
			}

			if (json.length != messages){

				if (window.location.pathname.search("profil_tatoueur.php") > 0){
					$.post( "dashboard.php", { origine: window.location.pathname }, function( data ) {
						$(".sixieme").remove();
						$(".messagerie > div").append(data)

						$(".badge").text(json.length - messages);
						$(".badge").show();
					})



				} else {
					$.post( "messagerie.php", { origine: window.location.pathname }, function( data ) {
						$(".sixieme").remove();
						$("#messagerie").remove();

						$("body").append(data)

						$(".badge").text(json.length - messages);
						$(".badge").show();
					})
				}
			}
		}
	});
}

setInterval(function () {

	notif()
}, 2000);