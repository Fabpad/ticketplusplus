$(document).ready(function () {
	$("#category_menu").change(function () {

		var obj = {kategorie: $(this).val()};
		
		$.post('../includes/query_specifications.php', obj , function (resp) {
			 $("#specification_menu").html(resp);
		});
	});
});