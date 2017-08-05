<?php	
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
			
	CrearMenu($session);

	exit();
		
		
function CrearMenu($session)
{
	$site = curPageURL();
	$year = date('Y');
	$cuatrimestre = 1;
	
	if(date('m') > 8)
	{
		$cuatrimestre = 2;
	}
	
	$query_str= "?year=" . $year . "&cuatrimestre=" . $cuatrimestre; 
		
	$str = '<div id="smoothmenu-ajax" class="ddsmoothmenu">'; 
	$str = $str .  '<ul>';
	$str = $str .  '<li><a href="' . $site . '">Pagina Principal</a></li>';
	$str = $str .  '<li><a href="' . $site . '/news/top/">Noticias Top</a></li>';
	
	//Check if the user is still login
	if($session->GetSessionValue('valid') == 'valid')
	{		
		//authenticated users
		
		$str = $str .  '<li><a href="#">Configuración de Usuario</a>';
		$str = $str .  '<ul>';
		$str = $str .  '<li><a href="' .$site .'/user/update/index.php">Actualizar datos</a></li>';
		$str = $str .  '<li><a href="'. $site .'/user/change-password/index.php">Cambiar Password</a></li>';
		$str = $str .  '</ul>';
		$str = $str .  '</li>';
		
		if($session->GetSessionValue('permission') == 2) //admin
		{
			$str = $str .  '<li><a href="#">Cursos</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="' . $site . '/admin/users/report/courses/index.php' . $query_str .'">Reporte</a></li>';
			$str = $str .  '<li><a href="' . $site . '/admin/users/validate/index.php' . $query_str . '">Validar Alumnos</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			
			$str = $str .  '<li><a href="#">Administración</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="#">Categorias</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="' . $site . '/admin/category/create/index.php">Crear</a></li>';
			$str = $str .  '<li><a href="' . $site . '/admin/category/list/index.php">Listar</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			$str = $str .  '<li><a href="#">Noticias</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="' . $site . '/admin/users/news/list/index.php?offset=0&pageperview=10">Listar</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
			
		}
		else //user
		{	
			$str = $str .  '<li><a href="' . $site .'/user/statistics/index.php?id=' . $session->GetSessionValue('user_id') . '">Rendimiento</a></li>';
			$str = $str .  '<li><a href="#">Noticias</a>';
			$str = $str .  '<ul>';
			$str = $str .  '<li><a href="' . $site . '/news/create/">Crear</a></li>';
			$str = $str .  '<li><a href="' . $site . '/news/list/">Lista de noticas por usuario</a></li>';
			$str = $str .  '</ul>';
			$str = $str .  '</li>';
		}
		
		$str = $str .  '<li><a href="' . $site . '/login/logout.php">Salir</a></li>';
	}
	else
	{ 
		$str = $str .  '<li><a href="' . $site . '/user/register/">Registrarse</a></li>';
		$str = $str .  '<li><a href="' . $site . '/login/">Ingresar</a></li>';
	}
	$str = $str .  '</ul>';
	$str = $str .  '<br style="clear: left" />';
	$str = $str .  '</div>';
	
	echo $str; 
}


function curPageURL() {
	 $pageURL = 'http';
	 
	 if (!empty($_SERVER["HTTPS"])) 
	 {
	 	if($_SERVER["HTTPS"] == "on")
	 	{
	 		$pageURL .= "s";
		}
	 }
	 
	 $pageURL .= "://";
	 
	 if ($_SERVER["SERVER_PORT"] != "80") 
	 {
	 	 $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
	 } 
	 else 
	 {
	 	 $pageURL .= $_SERVER["SERVER_NAME"];
	 }
	 
	 return $pageURL;
}

?>


