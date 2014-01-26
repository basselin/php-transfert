<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

$filekey = 'userfile';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Transfert de fichiers</title>
	<meta charset="utf-8" />
	
	<style type="text/css">
	
	body { font-size:14px; font-family:sans-serif; }
	input { font-size:1em; }
	h1 { font-size:1.2em; }
	a { color:blue; text-decoration:none; }
	
	</style>
	<script>
	window.onload = function() {
		var formFile = document.getElementById('form-file');
		var inputFile = document.getElementsByName('<?php echo $filekey ?>')[0];
		formFile.onsubmit = function() {
			if(!inputFile.value) {
				alert('Aucun fichier n\'a \xE9t\xE9 s\xE9lectionn\xE9');
				return false;
			}
		};
	};
	</script>
</head>
<body>
	<h1><a href="./">Transfert de fichiers</a> - Max. <?php echo ini_get('upload_max_filesize'); ?></h1>
	<form action="./" method="post" enctype="multipart/form-data" id="form-file">
		<p>
			<input type="file" name="<?php echo $filekey ?>" />
			<input type="submit" name="submit" value="Envoyer &raquo;" />
		</p>
<?php		if(isset($_POST['submit'])) : ?>
		<hr />
		<p><?php
			// Upload du fichier
			if(isset($_FILES[$filekey]) && is_uploaded_file($_FILES[$filekey]['tmp_name'])) {
				$tmp_name = $_FILES[$filekey]['tmp_name'];
				$name = $_FILES[$filekey]['name'];
				$name = preg_replace('/[^\d\w\. ]/', '-', $name);
				if(move_uploaded_file($tmp_name, "./recup/{$name}")) {
					echo 'Fichier envoy&eacute;';
				} else {
					echo 'Erreur d\'&eacute;criture';
				}
				echo ' <strong>'. htmlspecialchars($tmp_name) .'</strong> ';
				echo '&gt;&gt; <strong>'. htmlspecialchars($name) .'</strong>';
			} else {
				echo 'Aucun fichier s&eacute;lectionn&eacute;';
			}
		?></p>
<?php		endif; ?>
	</form>
</body>
</html>
