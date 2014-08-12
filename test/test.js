
$(document).on("ready",
	function()
	{
		$("#testP").text("Modified content");
		
		$.get("test.php",
			function(response)
			{
				$("#test2P").text(response);
			}
		);
	}
);