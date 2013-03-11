$(document).on("ready", init);

function init () {
	$("#showcont").click(function () {
		$("#fromadd").toggle("slow");
		$(".icon-plus").toggleClass("icon-minus");
	});
}

