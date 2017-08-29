/**
 * @author Joaquin
 */


$(function(){		
	ddsmoothmenu.init({
				mainmenuid: "smoothmenu-ajax",
				orientation: 'h',
				classname: 'ddsmoothmenu',
				contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
				image: ['/controls/menu/down.gif','/controls/menu/down.gif']
				});
	
	var offset = 0; 
	var category = ''; 
				
	LoadingImages();
				
	if(getParameterByName("offset") != '')
	{
		offset = getParameterByName("offset");
	}
				
	var countUrl = "../../../../news/validate.php?operation=count_news";
				
	$.getJSON(countUrl, function(data) 
	{
		var links = '';
		var numberOfCount = data / 10; 
				    
		links += '<br/><center><strong style="black: white;">Paginas </strong><br/>';
        for (var ii = 0; ii < numberOfCount; ii++) 
        {
             links += '<a href="index.php?offset=' + ii * 10 + '&pageperview=10' + '" style="color: black;">' + (ii + 1) + '</a>';
                       
            if(ii < numberOfCount -1)
            {
                links += ' | ';
            }
        }
        
        links += '</center>';
        $("#pages_numbers").html(links);			
	});	
				
	var newsUrl = "../../../../news/validate.php?operation=news";
				
	if(offset != '')
	{
		newsUrl += "&offset=" + offset + "&pageperview=10";
	}
				
	$.getJSON(newsUrl, function(data) 
	{			
		var news = '';
				    
		if(data != null)
		{
			news += '<table style="width:100%">';
		    for (var ii = 0; ii < data.length; ii++) 
	             {
	                news += '<tr>';
		                    		news += '<td collspan="2" style="width:10%">';
			                    		news += '<table>';
			                    			news += '<tr>';
												news += '<td>';
													news += '<input id="delete" type="button" value="Borrar" onclick="Delete(' + data[ii].id + ')" class="GeneralButtons" style="width: 120px;"/>';
												news += '</td>';
											news += '</tr>';	
												news += '<td>';	
			                        				news += '<input id="modificar" type="button" value="Modificar" onclick="Modify(' + data[ii].id + ')" class="GeneralButtons" style="width: 120px;"/>';
			                        			news += '</td>';
			                        		news += '</tr>';
			                        	news += '</table>';	
									news += '</td>';
									news += '<td collspan="2" style="width: 2px; background-color: black;">';
									news += '</td>';
									news += '<td style="width:90%">';
									//view
				                    		 news += '<table>';
					                        	news += '<tr>';
						                       		news += '<td>';
														news += '<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">';
														news += '<tr valign="top">';
															news += '<td style="width:150px;"><img style="width:150px;" src="' + data[ii].image_url + '" alt="' + data[ii].image_comment +'"  onerror="ChangeImg(this)"/></td>';
															news += '<td valign="top">';
																news += '<table>';
																news += '<tr><td style="width:550px;"><strong><font size="6">' + data[ii].title + '</font></strong></td></tr>';
																news += '<tr><td style="width:550px;"><font size=4">' + data[ii].sub_title + '</font></td></tr>';
																news += '<tr><td style="width:550px;">' + data[ii].sub_summary + '</td></tr>';
																news += '<tr><td style="width:550px;">' + data[ii].summary + '</td></tr>';
																news += '</table>';
															news += '</td>';
														news += '</tr>';
														news += '</table>';
														
														news += '<table style="width:700px;" border="0" cellspacing="0" cellpadding="0">';
															if(data[ii].link_1.length >0 ||  data[ii].link_2.length >0 || data[ii].link_3.length >0)
															{
															news += '<tr>';
																news += '<td >';
																	news += '<table border="0"  style="width:700px;" cellspacing="0" cellpadding="0">';
																		news += '<tr style="background: #dcdad5">';
																			news += '<td style="width:20%;"><strong>Links de referencia:</strong> &nbsp;&nbsp;&nbsp;</td>';
																			if(data[ii].link_1.length >0)
																			{
																				news += '<td style="width:20%;text-align: left;"><a href="../../news/preview/preview.php?news_id=' + data[ii].id + '&link=1" target="_blank"><strong>Nota Completa </strong>&nbsp;&nbsp;&nbsp;</a></td>';
																			}
																			if(data[ii].link_2.length >0)
																			{
																				news += '<td style="width:20%;text-align: left;"><a href="../../news/preview/preview.php?news_id=' + data[ii].id + '&link=2" target="_blank"><strong>Relacionado</strong> &nbsp;&nbsp;&nbsp;</a></td>';
																			}
																			if(data[ii].link_3.length >0)
																			{
																				news += '<td style="width:20%;text-align: left;"><a href="../../news/preview/preview.php?news_id=' + data[ii].id + '&link=3" target="_blank"><strong>Formato PDF </strong> &nbsp;&nbsp;&nbsp;</a></td>';
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
																		news += '<td> <strong>Autor:</strong>&nbsp;<a href="../../user/statistics/index.php?id=' + data[ii].user_id + '">' + data[ii].fullname + '</a> &nbsp; &nbsp; &nbsp;</td>';
																		news += '<td> <strong>Año:</strong>&nbsp;' + data[ii].year_coursed + ' &nbsp; &nbsp; &nbsp;</td>';
																		news += '<td> <strong>Localización:</strong>&nbsp;' + data[ii].campus + ' &nbsp; &nbsp; &nbsp;</td>';
																		news += '<td> <strong>Turno:</strong>&nbsp;' + data[ii].turn + ' &nbsp; &nbsp; &nbsp;</td>';
																		news += '<td ><strong>Comisión:</strong>&nbsp;' + data[ii].comission + '</td>';
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
									
									//end view	
									news += '</td>';
								news += '</tr>';			             
	                    }
	                    
	             		news += '</table>';
	             	}
	             	else
	             	{
	             		news += '<table style="width:100%">';
						news += '<tr valign="middle">';
						news += '<td align="center"><br/><br/><br/><br/><br/><strong>No se encuentran noticias cargadas por este usuario.</strong></td>';
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
	 	news += '<table style="width:100%;">';
		news += '<tr valign="middle">';
		news += '<td align="center"><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><img src="/style/images/loading_bar.gif" alt="loading..."><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></td>';
		news += '</tr>';
		news += '</table>';
		$("#news").html(news);
	
	 }	
		
});	

	function Delete(news_id)
	{
		var value = confirm("¿Esta seguro que desea eliminar la nota seleccionada?");
		if(value == true)
		{
			var ajaxOpts = {
							type: "get",
							dataType: 'json',
							url: "../../../../news/validate.php?operation=delete",
							data: "&news_id=" + news_id,
							success: function(data) {
								location.href = 'index.php';
							}
						};
						
			$.ajax(ajaxOpts);
		}
		
	}
	
	function Modify(news_id)
	{
		location.href = "../update/index.php?id=" + news_id;
	}	
	
	function ChangeImg(img)
	{
		img.src = '/style/images/not_available.jpg';
	}