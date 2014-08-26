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
//				$.get("scripts/queries/getCardNames.php?term=" + request.term, function(data, request)
//					{
//						alert($.parseJSON(data));
//						request($.parseJSON(data));
//					}
//				);
			},
			minLength: 3
		}
	);
});