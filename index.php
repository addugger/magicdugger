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
				<div id="cardImage"><img id="crdImg" src="images/cardback.png"></div>
				<div id="cardDetails">
					<table id="detailsTable">
						<tr>
							<th>NON FOILS</th>
							<th>FOILS</th>
						</tr>
						<tbody>
							<tr>
								<td><label>HAVE: <span id="haveNonFoils"></span></label></td>
								<td><label>HAVE: <span id="haveFoils"></span></label></td>
							</tr>
							<tr>
								<td><label>WANT: <span id="wantNonFoils"></span></label></td>
								<td><label>WANT: <span id="wantFoils"></span></label></td>
							</tr>
							<tr>
								<td class="withButton"><button id="addNonFoil" class="updateButton">ADD</button></td>
								<td class="withButton"><button id="addFoil" class="updateButton">ADD</button></td>
							</tr>
							<tr>
								<td class="withButton"><button id="removeNonFoil" class="updateButton">REMOVE</button></td>
								<td class="withButton"><button id="removeFoil" class="updateButton">REMOVE</button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>