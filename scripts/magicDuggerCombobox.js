/*
 * Among other things, the logic for creating the showAllButton was
 * commented out because I needed this to be for a remote source, and the
 * button did nothing for that. If you reuse this for a smaller data
 * set that will be stored locally in its entirety on the page, then
 * you can add this button back in.
 * 
 * The other customization points are the autocomplete creation section,
 * and the _source function.
 * 
 * Other than those things, this code was pretty much grabbed right from
 * the combobox example page from jQuery UI Autocomplete.
 */

(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
//        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .attr("placeholder", "Start typing card name...")  //this line added to add placeholder text to input
          //ui-corner-right was added to below since show all button was removed.  if including
          //that button, remove ui-corner-right
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ui-corner-right" )
          //to customize your underlying autocomplete modify this section
          //(except for the source, for that go to the _source function)
          .autocomplete(
        		{
      			source: $.proxy( this, "_source" ),
      			select: function(event, ui)
      			{
      				$("#searchCombo").attr("data-card-id", ui.item.crdId);
      				$("#searchCombo").attr("data-verse-id", ui.item.verseId);
      				setCrdImg(ui.item.verseId);
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
 
//      _createShowAllButton: function() {
//        var input = this.input,
//          wasOpen = false;
// 
//        $( "<a>" )
//          .attr( "tabIndex", -1 )
//          .attr( "title", "Show All Items" )
//          .tooltip()
//          .appendTo( this.wrapper )
//          .button({
//            icons: {
//              primary: "ui-icon-triangle-1-s"
//            },
//            text: false
//          })
//          .removeClass( "ui-corner-all" )
//          .addClass( "custom-combobox-toggle ui-corner-right" )
//          .mousedown(function() {
//            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
//          })
//          .click(function() {
//            input.focus();
// 
//            // Close if already visible
//            if ( wasOpen ) {
//              return;
//            }
// 
//            // Pass empty string as value to search for, displaying all results
//            input.autocomplete( "search", "" );
//          });
//      },
 
      //to customize the source for your combobox, change this function
      _source: function( request, response ) {
          var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
          $.ajax(
          {
  			url: "scripts/queries/getCardNames.php?term=" + request.term,
  			success: function(data)
  			{
    				var dataObj = $.parseJSON(data);
    				//empty underlying select
  	  			$("#searchCombo").empty();
  	  			//repopulate select
  	  			$.each(dataObj, function(i, card)
  	  			{
  					$("#searchCombo").append($("<option></option>")
  						.val(card["value"])
  						.text(card["label"])
  						.attr("data-card-id", card["crdId"])
  						.attr("data-verse-id", card["verseId"])
  					);
  					
    				});
  		  		//response(dataObj);
  	  			response( $("#searchCombo").children( "option" ).map(function() {
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