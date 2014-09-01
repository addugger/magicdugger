/**
 * Javascript page for MagicDugger.com homepage.
 * Include after including jQuery and jQueryUI.
 */

$("body").ready(function()
{
	//initialize search button as disabled
//	$("#searchButton").prop("disabled", true);
	
	//initialize card name autocomplete
//	$("#searchText").autocomplete(
//		{
//			source: function(request, response)
//			{
//				$.ajax(
//				{
//					url: "scripts/queries/getCardNames.php?term=" + request.term,
//					success: function(data)
//					{
//						response($.parseJSON(data));
//					}
//				});
//			},
//			select: function(event, ui)
//			{
//				$("#searchText").attr("data-card-id", ui.item.crdId);
//				$("#searchText").attr("data-verse-id", ui.item.verseId);
//			},
//			minLength: 3
//		}
//	);
	
	//initialize combobox
	$("#searchCombo").combobox();
	//autocomplete is set up during combobox initialization, but need
	//to add the options after the fact.
//	$("#searchText").autocomplete("source", function(request, response)
//		{
//			$.ajax(
//			{
//				url: "scripts/queries/getCardNames.php?term=" + request.term,
//				success: function(data)
//				{
//					response($.parseJSON(data));
//				}
//			});
//		}
//	);
//	$("#searchText").autocomplete("select", function(event, ui)
//		{
//			$("#searchText").attr("data-card-id", ui.item.crdId);
//			$("#searchText").attr("data-verse-id", ui.item.verseId);
//		}
//	);
//	$("#searchText").autocomplete("minLength", 3);
	
	//add keyup handler to search text to control whether search
	//button should be enabled
//	$("#searchText").on("keyup", function()
//		{
//			var id = $(this).attr("data-card-id");
//			var disable = true;
//			if (id != null && id != "")
//			{
//				disable = false;
//			}
//			if ($("#searchButton").prop("disablled") != disable)
//			{
//				$("#searchButton").prop("disabled", disable);
//			}
//		}
//	);
});