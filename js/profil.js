const onglets = Array.from( document.querySelectorAll( ".onglets" ) );
const contenu = Array.from( document.querySelectorAll( ".contenu" ) );
const illus = document.querySelector( ".illus" );


onglets.forEach( onglet =>
{
  onglet.addEventListener( "click", tabsAnimation );
} );

let index = 0;

function tabsAnimation( e )
{

  illus.style.display = "none";

  const el = e.target;
  onglets[ index ].classList.remove( "active" );
  contenu[ index ].classList.remove( "active-contenu" );

  index = onglets.indexOf( el );

  onglets[ index ].classList.add( "active" );
  contenu[ index ].classList.add( "active-contenu" );

}
