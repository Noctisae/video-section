<?php
function str_ends_with($haystack, $needle)
{
	return substr_compare($haystack, $needle, -strlen($needle)) 
			=== 0;
}

function ReadFolderDirectoryMyVersion($dir = "./Les simpsons l'integrale")
	{
		$result = array(); 
		$files = scandir($dir);
		foreach ($files as $key => $value)
		{
			if (!in_array($value,array(".","..","css","js","semantic","video-js")))
			{
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
				{
					$result[$value] = ReadFolderDirectoryMyVersion($dir . DIRECTORY_SEPARATOR . $value);
				}
				else
				{
					$result[] = $value;
				}
			}
		}
		return $result; 
	}
?>
<!DOCTYPE html>
	<html>
	<head>
		<!-- Standard Meta -->	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- Site Properties -->
		<title>Section Vidéos</title>
		<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
	
	<div class="ui page grid total" style="padding-left: 0px;padding-right: 0px;height:100%;width:100%">
		
		<div class="row" style="padding : 0px;">
		
		<?php
			$folders = ReadFolderDirectoryMyVersion(".");
			echo'
			<div class="ui item menu" style="height:200px;">';
			
			foreach ($folders as $nom => $saison) {
				if((string)(int)$nom == $nom){
					unset($folders[$nom]);
				}
			}
			uksort($folders, "strnatcmp");
			$size = count($folders);
			$taille = 100.0/(float)$size;
			foreach ($folders as $serie => $saisons) {
				echo'<div class="ui dropdown item" style="width:'.(string)$taille.'%!important;display:flex;align-items: center;
  justify-content: center;" >
						<div class="text">'.$serie.'</div>
						<div class="menu">';
					
				foreach ($saisons as $nom => $saison) {
					uksort($saison, "strnatcmp");
					echo '
						<div class="item">'.$nom.'
							<div class="menu">
						    ';
					foreach ($saison as $episode) {
						if(substr($episode, -5) === '.webm' || substr($episode, -4) === '.mp4'){
							echo'	<div class="item pasassezgrand">
								  		'.$episode.'
									</div>';
						}
					}
					echo '	 </div>
						</div>';
				}


				echo'	</div>
					</div>
				';
			}

		?>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="semantic/dist/semantic.min.js"></script>
	<script type="text/javascript">
		$('.ui.dropdown')
		  .dropdown()
		;
	</script>
	</body>
	</html>