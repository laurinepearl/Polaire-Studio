const onglets = $(".onglets");
const contenu = $(".contenu");
const illus = $(".illus");

onglets.click(function () {

	illus.hide();

	// Onglets
	onglets.removeClass("active");
	$(this).addClass("active")

	// Contenus
	contenu.removeClass("active-contenu");
	$( contenu.get($(this).index()) ).addClass("active-contenu")

})

const search = $("input[type = search]");
const sixieme = $("section.sixieme");

search.on('input', function() {
	const prenom = search.val().toLowerCase()
	if (prenom != "") {

		$("h3.prenom").each( function(index, element) {
			const parent = $(element).parent().parent().parent()

			if (!element.innerHTML.toLowerCase().search(prenom)) {
				parent.show()
			} else {

				parent.hide()
			}
		})
	} else 
	{
		sixieme.show()
	}
	
});