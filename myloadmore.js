jQuery(function($){
	$('.wordpress_loadmore').click(function()
	{ 
		var button = $(this),
		    data = {
			'action' : 'loadmore',
			'query': wordpress_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'max' : wordpress_loadmore_params.max_page,
			'page' : wordpress_loadmore_params.current_page
			
		};

		console.log(data);

		$.ajax({
			url : wordpress_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) 
			{
				console.log("Loading");
		
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data )
			{
				console.log("Success");

				if(data) 
				{ 
					console.log("We got data!");
					console.log(wordpress_loadmore_params.current_page);
					console.log(wordpress_loadmore_params.max_page);

					button.text( 'More posts' ).prev().before(data); // insert new posts
					wordpress_loadmore_params.current_page++;
 
					if ( wordpress_loadmore_params.current_page == wordpress_loadmore_params.max_page ) 
					{
						console.log("Last page! Remove button");

						button.remove(); // if last page, remove the button
					}
 
				} else {
					
					console.log("No data! Remove button");

					button.remove(); // if no data, remove the button as well
				}
			},
			error: function() 
			{
	            console.log("Error");            
	        }
		});
	});
});