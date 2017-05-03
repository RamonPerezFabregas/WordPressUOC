
/**
Es necesario modificar esta url y apuntar a la instalación  de wp
Por ejemplo http://localhost/Wordpress
*/

var BASE_URL='http://localhost/wp';

var app = {

	init: function() {
		app.getPosts();
	},

	getPosts: function() {

		var rootURL = BASE_URL+'/wp-json/wp/v2';
    
		$.ajax({
			type: 'GET',
			url: rootURL + '/movie',//?_jsonp=?', //añadir parámetro jsonp si queremos que funcione en otro dominio
			dataType: 'json',
			success: function(data){
				$.each(data, function(index, value) {
          

					console.log(value);

			      $('ul.post-list').append('<li class="post-list__item">' +
			      //	'<img src="'+value.featured_image.attachment_meta.sizes.medium.url+'" /><br>' +
			      	'<h3><a href="#'+value.id+'">'+value.title.rendered+'</a></h3>'+
              '<p>'+value.content.rendered+'</p>'+
              '<p>'+value.director+'</p>'+
              '<p>'+value.duracio+'</p>'+
              '<p>'+value.nom_genere+'</p>'+
              '<p>'+value.anny+'</p>');
			    });
					 $("ul.post-list").listview("refresh");
			},
			error: function(error){
				console.log(error);
			}

		});

	}

}
