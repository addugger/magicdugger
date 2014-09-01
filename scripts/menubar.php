<link rel="stylesheet" type="text/css" href=/MagicDugger/resources/ddsmoothmenu/ddsmoothmenu.css />
<link rel="stylesheet" type="text/css" href=/MagicDugger/resources/ddsmoothmenu/ddsmoothmenu-v.css />
<script src="/MagicDugger/resources/ddsmoothmenu/ddsmoothmenu.js"></script> <!-- Must include jquery before menubar on a page -->

<script>
$(document).ready(function(){
	ddsmoothmenu.init({
		mainmenuid: "menubar", //menu DIV id
		orientation: "h", //Horizontal or vertical menu: Set to "h" or "v"
		classname: "ddsmoothmenu", //class added to menu's outer DIV
		contentsource: "markup"
	});
});
</script>

<style>
	.ddsmoothmenu {
		height: 32px;
	}

</style>
<div id="menubar" class="ddsmoothmenu">
	<ul>
		<li><a href="/MagicDugger">Home</a></li>
	</ul>
</div>