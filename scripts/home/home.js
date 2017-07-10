$(function(){

	$.getJSON("content/content.php?operation=category", function(data) {
		var links = '<div class="list-group">';
		for (var i = 0; i < data.length; i++)
		{
			links += '<a href="index.php?category=' + data[i].id +  '" class="list-group-item">';
			links += data[i].name + ' <span class="badge">'+data[i].NewsCount+'</span>';
			links += '</a>';
		}
		links += '</div>';

		$("#categories").html(links);
	});

});