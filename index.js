/**
 * Javascript page for MagicDugger.com homepage.
 * Include after including jQuery and jQueryUI.
 */

$("body").ready(function()
{
	$("#searchText").autocomplete(
		{
			source: function(request, response)
			{
				$.ajax(
				{
					url: "scripts/queries/getCardNames.php?term=" + request.term,
					success: function(data)
					{
						response($.parseJSON(data));
					}
				});
			},
			select: function(event, ui)
			{
				$("#searchText").attr("data-card-id", ui.item.crdId);
			},
			minLength: 3
		}
	);
});