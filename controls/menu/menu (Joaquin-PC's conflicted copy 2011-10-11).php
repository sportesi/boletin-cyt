
<?php

CrearMenu();

exit();
		
function CrearMenu()
{
	$site = "www.ees-uai.com.ar";
	$year = date('Y');
	$cuatrimestre = 1;
	
	if(date('m') > 8)
	{
		$cuatrimestre = 2;
	}
	
	$query_str= "?year=" . $year . "&cuatrimestre=" . $cuatrimestre; 
		
	$str = '<div id="smoothmenu-ajax" class="ddsmoothmenu">'; 
	$str = $str .  '<ul>';
	$str = $str .  '<li><a href="http://' . $site . '">Pagina Principal</a></li>';
	$str = $str .  '<li><a href="http://' . $site . '/news/top/">Noticias Tops</a></li>';
	session_start();
	if($_SESSION['valid'] == 'valid'){
		
		//authenticated users
		
		$str = $str .  '<li><a href="#">Configuración de Usuario</a>';
		$str = $str .  '<ul>';
		$str = $str .  '<li><a href="http://' .$site .'/user/update/index.php">Actualizar datos</a></li>';
		$str = $str .  '<li><a href="http://'. $site .'/user/change_password.php">Cambiar Password</a></li>';
		$str = $str .  '</ul>';
		$str = $str .  '</li>';
		
		if($_SESSION['permission'] == 2) //admin
		{
			$str = $str .  '<li><a href="#">Cursos</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="http://' . $site . '/admin/users/report/index.php' . $query_str .'">Reporte</a></li>';
			$str = $str .  '<li><a href="http://' . $site . '/admin/users/validate/index.php' . $query_str . '">Validar Alumnos</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			
			$str = $str .  '<li><a href="#">Administración</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="#">Categorias</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="http://' . $site . '/admin/category/create/index.php">Crear</a></li>';
			$str = $str .  '<li><a href="http://' . $site . '/admin/category/index.php">Listar</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			
		}
		else //user
		{
			session_start();		
			$str = $str .  '<li><a href="http://' . $site .'/user/statistics/index.php?id=' . $_SESSION["user_id"] . '">Rendimiento</a></li>';
			$str = $str .  '<li><a href="#">Noticias</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="http://' . $site . '/news/create/">Crear</a></li>';
			$str = $str .  '<li><a href="http://' . $site . '/news/list/">Lista de noticas por usuario</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
		}
		
		$str = $str .  '<li><a href="http://' . $site . '/login/logout.php">Salir</a></li>';
	}
	else
	{ 
		$str = $str .  '<li><a href="http://' . $site . '/user/register/">Registrase</a></li>';
		$str = $str .  '<li><a href="http://' . $site . '/login/">Ingresar</a></li>';
	}
	$str = $str .  '</ul>';
	$str = $str .  '<br style="clear: left" />';
	$str = $str .  '</div>';
	
	echo $str; 
}
?>


