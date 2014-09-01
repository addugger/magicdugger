<!DOCTYPE html>
<html>
	<head>
		<meta charset="ISO-8859-1">
		
		<link rel="stylesheet" href=//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css>
		<link rel="stylesheet" href=css/combobox.css>
		<link rel="stylesheet" href=css/magicdugger.css>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
		<script src="scripts/magicDuggerCombobox.js"></script>
		<script src="index.js"></script>
		
		<title>MagicDugger</title>
	</head>
	<body>
		<?php include_once("scripts/banner.php")?>
		<?php include_once("scripts/menubar.php")?>
		
		<div id="searchDiv">
			<div class="ui-widget">
				<select id="searchCombo"></select>
			</div>
		</div>
		
		<div id="outerResultsDiv">
			<div id="innerResultsDiv">
				<div id="cardImage"></div>
				<div id="cardDetails">
					<table id="detailsTable">
						<tr>
							<th>NON FOILS</th>
							<th>FOILS</th>
						</tr>
						<tr>
							<td><label>HAVE: <span id="haveNonFoils"></span></label></td>
							<td><label>HAVE: <span id="haveFoils"></span></label></td>
						</tr>
						<tr>
							<td><label>WANT: <span id="wantNonFoils"></span></label></td>
							<td><label>WANT: <span id="wantFoils"></span></label></td>
						</tr>
						<tr>
							<td><button id="addNonFoil">ADD</button></td>
							<td><button id="addFoil">ADD</button></td>
						</tr>
						<tr>
							<td><button id="removeNonFoil">REMOVE</button></td>
							<td><button id="removeFoil">REMOVE</button></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>