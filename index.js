/**
 * Javascript page for MagicDugger.com homepage.
 * Include after including jQuery and jQueryUI.
 */

function setCrdImg(verseId)
{
	$("#crdImg").attr("src", "http://api.mtgdb.info/content/hi_res_card_images/" + verseId + ".jpg");
}

$("body").ready(function()
{
	//initialize combobox
	$("#searchCombo").combobox();

});