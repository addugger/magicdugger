/**
 * Javascript page for MagicDugger.com homepage.
 * Include after including jQuery and jQueryUI.
 */

//get counts of the given card in collection from db
function getCardCounts(crdId)
{
	$.get("scripts/queries/getCardCounts.php?id=" + crdId, function(results)
		{
			counts = $.parseJSON(results);
			$("#haveNonFoils").text(counts.nonFoilCnt);
			$("#haveFoils").text(counts.foilCnt);
			$("#wantNonFoils").text(counts.nonFoilWantCnt);
			$("#wantFoils").text(counts.foilWantCnt);
		}
	);
}

function setCrdImg(verseId)
{
	//do get just so i can get an http response to see if the image exists
	var url = "https://api.mtgdb.info/content/hi_res_card_images/" + verseId + ".jpg"; //change back to verseId
	$.get(url, function(){})
		.done(function()
		{
			$("#crdImg").attr("src", url);
		})
		.fail(function()
		{
			//if image is unavailable for some reason, set image to card back image
			$("#crdImg").attr("src", "images/cardback.png");
		}
	);
}

$("body").ready(function()
{
	//initialize combobox
	$("#searchCombo").combobox();
	
	//add non-foil card
	$(".updateButton").click(function()
		{
			var buttonId = $(this).attr("id");
			if (buttonId == "addNonFoil")
			{
				var type = "nonFoil";
				var update = "add";
			}
			else if (buttonId == "addFoil")
			{
				var type = "foil";
				var update = "add";
			}
			else if (buttonId == "removeNonFoil")
			{
				var type = "nonFoil";
				var update = "remove";
			}
			else if (buttonId == "removeFoil")
			{
				var type = "foil";
				var update = "remove";
			}
			
			if ($(this))
			
			var crdId = $("#searchCombo").attr("data-card-id");
			$.get("scripts/updates/updateCard.php?type=" + type + "&id=" + crdId +"&update=" + update, function()
				{
					getCardCounts(crdId);
				}
			);
		}
	);
});