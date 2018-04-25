$(document).ready(function () {
	$("#category_menu").change(function () {
	var val = $(this).val();
		
		$.post('../includes/query_specifications.php', {kategorie: `${val}`}).done(function (resp) {
			 $("#specification_menu").html(`${resp}`);
		});
	});
});