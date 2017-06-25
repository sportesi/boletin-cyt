
$(function(){

	ddsmoothmenu.init({
		mainmenuid: "smoothmenu-ajax",
		orientation: 'h',
		classname: 'ddsmoothmenu',
		contentsource: ["smoothmenu1", "controls/menu/menu.php"],
		image: ['controls/menu/down.gif','controls/menu/down.gif']
	});

	var offset = 0;
	var category = '';
	var user_id = '';

	LoadingImages();

	if(getParameterByName("offset") != '')
	{
		offset = getParameterByName("offset");
	}

	if(getParameterByName("category") != '')
	{
		category = getParameterByName("category");
	}

	if(getParameterByName("user_id") != '')
	{
		user_id = getParameterByName("user_id");
	}

	var countUrl = "news/operation.php?operation=count_news";

	if(category !='')
	{
		countUrl += "&category=" + category;
	}

	$.getJSON(countUrl, function(data) {
		var links = '';
		var numberOfCount = data / 10;
		var categoryQS = '';


		if(category !='')
		{
			categoryQS += "category=" + category + '&';
		}

		links += '<div id="paging"><div class="pagination"><ul>';

		for (var ii = 0; ii < numberOfCount; ii++)
		{
			if(offset == ii * 10)
			{
				links += '<li class="active" style="color: rgb(255, 255, 255); background-color: rgb(0, 102, 153);">' + (ii + 1) + '</li>';
			}
			else
			{
				links += '<a href="index.php?' + categoryQS + 'offset=' + ii * 10 + '" style="color: black;">' + '<li class="active">' + (ii + 1) + '</li></a>';
			}


		}
		links += '</ul></div></div></br>';

		// links += '</center>';
		$("#pages_numbers").html(links);
	});

	$.getJSON("content/content.php?operation=category", function(data) {

		var links = '<div class="list-group">';
		for (var ii = 0; ii < data.length; ii++)
		{
			links += '<a href="index.php?category=' + data[ii].id +  '" class="list-group-item">';
			links += data[ii].name + ' <span class="badge">'+data[ii].NewsCount+'</span>';
			links += '</a>';
		}
		links += '</div>';

		$("#categories").html(links);

		$('.tag').hover(function() {
			$(this).stop().animate({ paddingRight: ($('.tag_count', this).outerWidth() - 5) });
		}, function() {
			$(this).stop().animate({ paddingRight: 5 });
		});
	});

	function getParameterByName(name)
	{
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.href);
		if(results == null)
		return "";
		else
		return decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function LoadingImages()
	{
		var categories = '';
		categories += '<table style="width:150px;">';
		categories += '<tr valign="middle">';
		categories += '<td align="center"><br/><br/><br/><img src="/style/images/loading_circle.gif" alt="loading..."><br/><br/><br/></td>';
		categories += '</tr>';
		categories += '</table>';
		$("#categories").html(categories);

	}

});

function ChangeImg(img)
{
	img.src = '/style/images/not_available.jpg';
}

function ConvertUnicodeCharacter(text)
{
	if(text == null) return '';

	var characterArray = [["á","\u00e1"],
	["é","\u00e9"],
	["í","\u00ed"],
	["Ã³","\u00f3"],
	["ú","\u00fa"],
	["Á","\u00c1"],
	["É","\u00c9"],
	["Í","\u00cd"],
	["Ó","\u00d3"],
	["Ú","\u00da"],
	["ñ","\u00da"],
	["Ñ","\u00d1"]];

	for (var j = 0; j < characterArray.length; j++)
	{
		var position =  text.indexOf(characterArray[j][0]);

		if(position > -1)
		{
			text = text.replace(characterArray[j][0],characterArray[j][1]);
		}
	}

	return text;
}
