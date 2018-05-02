jQuery(function($){
	$('.wordpress_loadmore').click(function()
	{ 
		var button = $(this),
		    data = {
			'action' : 'loadmore',
			'query': wordpress_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			//'max' : wordpress_loadmore_params.max_page,
			'page' : wordpress_loadmore_params.current_page
			
		};

		console.log(wordpress_loadmore_params.ajaxurl);
 
		$.ajax({
			//url : wordpress_loadmore_params.ajaxurl, // AJAX handler
			url : '/wp-admin/admin-ajax.php',
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) 
			{
				console.log("Loading");
				console.log(data);
				
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data )
			{
				console.log("Success");

				if(data) 
				{ 
					console.log("We got data!");

					button.text( 'More posts' ).prev().before(data); // insert new posts
					wordpress_loadmore_params.current_page++;
					
					console.log(wordpress_loadmore_params.current_page);
					console.log(wordpress_loadmore_params.max_page);
					console.log(button.text( 'More posts' ).prev().before(data));
 
					if ( wordpress_loadmore_params.current_page == wordpress_loadmore_params.max_page ) 
					{
						console.log("Last page! Remove button");

						button.remove(); // if last page, remove the button
					}
 
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
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