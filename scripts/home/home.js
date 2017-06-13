
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
					
		    var links = '';
		    links += '<table>';
	        for (var ii = 0; ii < data.length; ii++) 
	        {
	            links += '<tr><td><a href="index.php?category=' + data[ii].id +  '" class="tag"><span class="tag_name tag_font">' + data[ii].name + '</span><span class="tag_count tag_font">' + data[ii].NewsCount + '</span></a> </tr></td>';
	        }
	       links += '</table>';
	  
	        $("#categories").html(links);
	        
	        $('.tag').hover(function() {
				$(this).stop().animate({ paddingRight: ($('.tag_count', this).outerWidth() - 5) });
				}, function() {
				$(this).stop().animate({ paddingRight: 5 });
			});						
		});
		
		var newsUrl = "news/operation.php?operation=news";
		
		if(category !='')
		{
			newsUrl += "&category=" + category;
		}
		
		if(user_id != '')
		{
			newsUrl += "&user_id=" + user_id;
		}
		
		if(offset != '')
		{
			newsUrl += "&offset=" + offset + "&pageperview=10";
		}
		else
		{
			newsUrl += "&offset=0&pageperview=10";
		}
		
		$.getJSON(newsUrl, function(data) {
					
		    var news = '';
		    
		    if(data != null)
		    {
	    	    for (var ii = 0; ii < data.length; ii++) 
	            {
			if (!data[ii]) {continue;}
	                news += '<table>';
	                	news += '<tr>';
	                    	news += '<td collspan="2" style="width: 2px; background-color: black;">';
							news += '</td>';
							news += '<td>';
								news += '<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">';
								news += '<tr valign="top">';
									news += '<td style="width:150px;"><img style="width:150px;" src="' + data[ii].image_url + '" alt="' + data[ii].image_comment +'"  onerror="ChangeImg(this);"/></td>';
									news += '<td valign="top">';
										news += '<table>';
										news += '<tr><td style="width:700px;"><strong><font size="6">' + ConvertUnicodeCharacter(data[ii].title) + '</font></strong></td></tr>';
										news += '<tr><td style="width:700px;"><font size=4">' + ConvertUnicodeCharacter(data[ii].sub_title) + '</font></td></tr>';
										news += '<tr><td style="width:700px;">' + ConvertUnicodeCharacter(data[ii].sub_summary) + '</td></tr>';
										news += '<tr><td style="width:700px;">' + ConvertUnicodeCharacter(data[ii].summary) + '</td></tr>';
										news += '</table>';
									news += '</td>';
								news += '</tr>';
								news += '</table>';

								news += '<table style="width:700px;" border="0" cellspacing="0" cellpadding="0">';
									if(data[ii].link_1.length >0 ||  data[ii].link_2.length >0 || data[ii].link_3.length >0)
									{
									news += '<tr style="background: #dcdad5">';
										news += '<td>';
											news += '<table border="0"  style="width:700px;" cellspacing="0" cellpadding="0">';
												news += '<tr>';
													news += '<td style="width:20%;"><strong>Links de referencia:</strong> &nbsp;&nbsp;&nbsp;</td>';
													if(data[ii].link_1.length >0)
													{
														news += '<td style="width:20%;text-align: left;"><a href="/news/preview/preview.php?news_id=' + data[ii].id + '&link=1" target="_blank"><strong>Nota Completa </strong>&nbsp;&nbsp;&nbsp;</a></td>';
													}
													if(data[ii].link_2.length >0)
													{
														news += '<td style="width:20%;text-align: left;"><a href="/news/preview/preview.php?news_id=' + data[ii].id + '&link=2" target="_blank"><strong>Relacionado</strong> &nbsp;&nbsp;&nbsp;</a></td>';
													}
													if(data[ii].link_3.length >0)
													{
														news += '<td style="width:20%;text-align: left;"><a href="/news/preview/preview.php?news_id=' + data[ii].id + '&link=3" target="_blank"><strong>Formato PDF </strong> &nbsp;&nbsp;&nbsp;</a></td>';
													}
													news += '<td style="width:100%;"></td>';
												news += '</tr>';
											news += '</table>';
										news += '</td>';
									news += '</tr>';
									}
									news += '<tr>';
										news += '<td>';
											news += '<table border="0"  style="width:700px;" cellspacing="0" cellpadding="0">';
											news += '<tr style="background: #d0e5b3">';
												news += '<td> <strong>Autor:</strong>&nbsp;<a href="user/statistics/index.php?id=' + data[ii].user_id + '">' + ConvertUnicodeCharacter(data[ii].fullname) + '</a> &nbsp; &nbsp; &nbsp;</td>';
												news += '<td> <strong>Año:</strong>&nbsp;' + data[ii].year_coursed + ' &nbsp; &nbsp; &nbsp;</td>';
												news += '<td> <strong>Localización:</strong>&nbsp;' + data[ii].campus + ' &nbsp; &nbsp; &nbsp;</td>';
												news += '<td> <strong>Turno:</strong>&nbsp;' + data[ii].turn + ' &nbsp; &nbsp; &nbsp;</td>';
												news += '<td ><strong>Comisión:</strong>&nbsp;' + data[ii].comission + '</td>';
												news += '<td ><strong>Fecha:</strong>&nbsp;' + data[ii].date + '</td>';
											news += '</tr>';
											news += '</table>';
										news += '</td>';
									news += '</tr>';
								news += '</table>';
							news += '</td>';
							news += '<td collspan="2" style="width: 2px; background-color: #D8D8D8;">';
							news += '</td>';
						news += '</tr>';
					news += '</table>';

					news += '<br/>';
					news += '<br/>';
	            }
	 		}
	 		else
	        {
	         		news += '<table style="width:700px;">';
					news += '<tr valign="middle">';
					news += '<td align="center"><strong>No se encuentran noticias en esta categotia.</strong></td>';
					news += '</tr>';
					news += '</table>';
	        }

	        $("#news").html(news);

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
	 	var news = '';
	 	news += '<table style="width:700px;">';
		news += '<tr valign="middle">';
		news += '<td align="center"><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><img src="/style/images/loading_bar.gif" alt="loading..."></td>';
		news += '</tr>';
		news += '</table>';
		$("#news").html(news);

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
