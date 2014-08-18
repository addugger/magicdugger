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
		height: 30px;
		margin-right: 0px;
	}

</style>
<div id="menubar" class="ddsmoothmenu">
	<ul>
		<li><a href="/MagicDugger">Home</a></li>
		<li>
			<a href=#>Test</a>
			<ul><li><a href=#>Test Sub</a></li></ul>
		</li>
	</ul>
</div>