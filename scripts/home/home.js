$(function(){
	LoadingImages();

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
