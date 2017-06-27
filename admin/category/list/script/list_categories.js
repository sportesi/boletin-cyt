/**
 * @author Joaquin
 */

$(document).ready(function()
{
	ddsmoothmenu.init({
					mainmenuid: "smoothmenu-ajax",
					orientation: 'h',
					classname: 'ddsmoothmenu',
					contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
					image: ['/controls/menu/down.gif','/controls/menu/down.gif']
				});

	var oTable = $('#example').dataTable({ "bSort": true, "sPaginationType": "full_numbers" });



});

	function Delete(category_id)
	{
		var url = "../operation.php?operation=delete&category_id=" + category_id;

		var value = confirm("¿Esta seguro que desea eliminar esta Categorias (el borrado es lógico, esto implica que esta categoría no va a poder ser utilizada al crear nuevas noticias)?");
		if(value == true)
		{
			$.getJSON(url, function(data)
			{
		         if(data.successful == 'true')
		         {
					location.href = "index.php";
				 }
			});

			var button = document.getElementById("button_delete_" + category_id);
	        button.style.display = 'none';
		 }
	}

	function ChangeStatus(category_id,status)
	{
		var url = "../operation.php?operation=update&category_id=" + category_id + "&status=" + status;

		var value = confirm("¿Esta seguro de Habilitar o Deshabilitar esta Categoría (Habilita o Deshabilita la Categoría para poder ser utilizada en la creación de Noticias)?");
		if(value == true)
		{
			$.getJSON(url, function(data)
			{
		       if(data.successful == 'true')
		       {
				  location.href = "index.php";
			   }
			});

			var button = document.getElementById("button_change_" + category_id);
	        button.style.display = 'none';

		}
	}
