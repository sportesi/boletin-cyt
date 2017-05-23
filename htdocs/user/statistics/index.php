<?php
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
  	require_once(__ROOT__.'/common/dataAccess/DBSecurityConnections.php');
	
?>	


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<?php
			//Get User to used in the title
			$title_description = '';
			$user_name =  $session->GetSessionValue('login_user');
			
			if($user_name != '') 
			{
				$title_description = ' - Usuario: ' . $user_name;
			}
			echo '<title>EES - UAI - Estadistica de rendimiento de Alumno ' . $title_description .'</title>';
		?>		
		
		<link rel='stylesheet' type='text/css' href="/style/css/general.css" media="screen"/>
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/chart/highcharts-2.1.4/js/highcharts.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/chart/highcharts-2.1.4/js/modules/exporting.js"></script>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		<script type="text/javascript">
			var chart_pie;
			var chart_bar;
			
			$(document).ready(function() {

				ddsmoothmenu.init({
					mainmenuid: "smoothmenu-ajax",
					orientation: 'h',
					classname: 'ddsmoothmenu',
					contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
					image: ['/controls/menu/down.gif','/controls/menu/down.gif']
				});

				chart_pie = new Highcharts.Chart({

					chart: { renderTo: 'container_pie', plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false
					},

					title: { text: 'Aportes realizados por categoria'
					},

					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' <br/> <a href="../../index.php?user_id=<?php echo $_GET["id"]; ?>">Ver</a>';
						}
					},

					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
						}

					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: <?php
									try
									  {
											$id = $_GET["id"];
											$id = stripslashes($id);
											$id = mysql_real_escape_string($id);
											
											$query= "SELECT TT.id,CC.name,TT.total  FROM (SELECT T.id,T.total FROM (SELECT CN.id,CN.total FROM (SELECT C.id,COUNT(*) total FROM Category C, News N WHERE C.id = N.category_id AND N.user_id=" . $id . " AND C.deleted = 0 AND C.status = 1 GROUP BY N.category_id ORDER BY C.Name DESC) CN UNION SELECT C.id,0 total FROM Category C WHERE C.deleted = 0 AND C.status = 1) T GROUP BY T.id) TT, Category CC WHERE TT.id = CC.id";
											
											$rs = $dbSetting->ExecuteQuery($query);
											
											echo '[';
												for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
												{
													$row = mysql_fetch_assoc($rs);
											    	
													echo "['" . $row["name"] . "'," . $row["total"] ."]";	
													
													if($x < $numrows - 1)
													{
														echo ',';	
													}	
												}
											echo ']';
									   }
									   catch (Exception $e)
									   {
										  echo $e;
									   }	
								?> 
					}]
				});

				chart_bar = new Highcharts.Chart({

					chart: {

						renderTo: 'container_bar',

						defaultSeriesType: 'column',

						margin: [ 50, 50, 185, 80]

					},

					title: {

						text: ''

					},

					xAxis: {

						categories: <?php
									try
									  {
											$query= "SELECT * FROM Category WHERE deleted=0 AND status = 1 GROUP BY id";
											
											$rs = $dbSetting->ExecuteQuery($query);
											
											echo '[';
												for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
												{
													$row = mysql_fetch_assoc($rs);
											    	
													echo "'" . $row["name"] . "'";	
													
													if($x < $numrows - 1)
													{
														echo ',';	
													}	
												}
											echo ']';
									   }
									   catch (Exception $e)
									   {
										  echo $e;
									   }	
								?>,

						labels: {

							rotation: -45,

							align: 'right',

							style: {

								 font: 'normal 13px Verdana, sans-serif'

							}

						}

					},

					yAxis: {

						min: 0,

						title: {

							text: 'Cantidad de aportes'

						}

					},

					legend: {

						enabled: false

					},

					tooltip: {

						formatter: function() {

							return '<b>'+ this.x +'</b><br/>'+

								 'Total de aportes: '+ Highcharts.numberFormat(this.y, 1);

						}

					},

				        series: [{

						name: 'Population',

						data: <?php
									try
									  {
											
											$id = $_GET["id"];
											$id = stripslashes($id);
											$id = mysql_real_escape_string($id);
											
											$query= "SELECT T.id,T.total FROM (SELECT CN.id,CN.total FROM (SELECT C.id,COUNT(*) total FROM Category C, News N WHERE C.id = N.category_id AND N.user_id=" . $id . " AND C.deleted = 0 AND C.Status = 1 GROUP BY N.category_id ORDER BY C.Name DESC) CN UNION SELECT C.id,0 total FROM Category C WHERE C.deleted = 0 AND C.status = 1) T GROUP BY T.id";
											
											$rs = $dbSetting->ExecuteQuery($query);
											
											echo '[';
												for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
												{
													$row = mysql_fetch_assoc($rs);
											    	
													echo $row["total"];	
													
													if($x < $numrows - 1)
													{
														echo ',';	
													}	
												}
											echo ']';
									   }
									   catch (Exception $e)
									   {
										  echo $e;
									   }	
								?>,

						dataLabels: {

							enabled: true,

							rotation: -90,

							color: '#FFFFFF',

							align: 'right',

							x: -3,

							y: 10,

							formatter: function() {

								return this.y;

							},

							style: {

								font: 'normal 13px Verdana, sans-serif'

							}

						}			

					}]

				});
			});

	function ConvertUnicodeCharacter(text)
		 {
		    
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

		</script>
	</head>

	<body>
		<div id="smoothmenu1" class="ddsmoothmenu"></div>
		<div>
		<h1>&nbsp;&nbsp;Aportes Realizados</h1>
		<div style="width: 800px; text-align: left;">
			<?php
					try
					 {
							$id = $_GET["id"];
					  		$id = stripslashes($id);
							$id = mysql_real_escape_string($id);
											
							$query= "SELECT CONCAT_WS(',',U.firstname,NULL,U.lastname) 'fullname' FROM User U WHERE U.id=" . $id;
											
							$rs = $dbSetting->ExecuteQuery($query);
																					
							for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
								{
									$row = mysql_fetch_assoc($rs);
											    	
									echo " &nbsp;&nbsp;&nbsp;<strong> Alumno: " . $row["fullname"] . "</strong>";	
													
								}
					 }
					 catch (Exception $e)
					 {
							 echo $e;
					 }	
				?> 
			
		</div>
		<div id="container_pie" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="container_bar" style="width: 800px; height: 400px; margin: 0 auto"></div>
		</div>
		
		<script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-10081016-2']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
		
		</script>
	</body>
</html>
