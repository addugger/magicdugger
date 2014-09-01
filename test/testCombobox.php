<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Autocomplete - Combobox</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  </style>
  <script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
//         this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";

        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete(
        		{
      			source: $.proxy( this, "_source" ),
      			select: function(event, ui)
      			{
      				$("#combobox").attr("data-card-id", ui.item.crdId);
      				$("#combobox").attr("data-verse-id", ui.item.verseId);
      			},
      			minLength: 3
        		}
          )
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
//       _createShowAllButton: function() {
//         var input = this.input,
//           wasOpen = false;
 
//         $( "<a>" )
//           .attr( "tabIndex", -1 )
//           .attr( "title", "Show All Items" )
//           .tooltip()
//           .appendTo( this.wrapper )
//           .button({
//             icons: {
//               primary: "ui-icon-triangle-1-s"
//             },
//             text: false
//           })
//           .removeClass( "ui-corner-all" )
//           .addClass( "custom-combobox-toggle ui-corner-right" )
//           .mousedown(function() {
//             wasOpen = input.autocomplete( "widget" ).is( ":visible" );
//           })
//           .click(function() {
//             input.focus();
 
//             // Close if already visible
//             if ( wasOpen ) {
//               return;
//             }
 
//             // Pass empty string as value to search for, displaying all results
//             input.autocomplete( "search", "" );
//           });
//       },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        $.ajax(
		{
			url: "../scripts/queries/getCardNames.php?term=" + request.term,
			success: function(data)
			{
  				var dataObj = $.parseJSON(data);
  				//empty underlying select
	  			$("#combobox").empty();
	  			//repopulate select
	  			$.each(dataObj, function(i, card)
	  			{
					$("#combobox").append($("<option></option>")
						.val(card["value"])
						.text(card["label"])
						.attr("data-card-id", card["crdId"])
						.attr("data-verse-id", card["verseId"])
					);
					
  				});
		  		//response(dataObj);
	  			response( $("#combobox").children( "option" ).map(function() {
	  	        var text = $( this ).text();
	  	        if ( this.value && ( !request.term || matcher.test(text) ) )
	  	          return {
	  	            label: text,
	  	            value: text,
	  	            crdId: this.getAttribute("data-card-id"),
	  	            verseId: this.getAttribute("data-verse-id"),
	  	            option: this
	  	          };
	  	      }) );
			}
		});
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#combobox" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label>Your preferred programming language: </label>
  <select id="combobox">
  </select>
</div>
<button id="toggle">Show underlying select</button>
 
 
</body>
</html>