<?php
/*
The MIT License (MIT)
Copyright (c) 2015 Antoine Subit
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>SAVE MY LIFE</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<?php
				# Define parameters here
				$mysql_host     = "localhost";
				$mysql_database = "db_name";
				$mysql_user     = "db_user";
				$mysql_password = "password";
				$query = '';
			?>
			<h1 align="center">Executer du MySQL sur la base "<?php echo $mysql_host; ?>"</h1>
			<p align="center"><a href="https://github.com/asubit/execute-mysql-request-from-php" target="_blank">https://github.com/asubit/execute-mysql-request-from-php</a></p>
			<section>
				<article>
					<h2>Param&egrave;tres de connexion :</h2>
					<p>
						<table class="table">
							<tr>
								<th>Serveur de base de donn&eacute;es</th>
								<td><?php echo $mysql_host; ?></td>
							</tr>
							<tr>
								<th>Nom de la base de donn&eacute;es</th>
								<td><?php echo $mysql_database; ?></td>
							</tr>
							<tr>
								<th>Utilisateur MySQL</th>
								<td><?php echo $mysql_user; ?></td>
							</tr>
							<tr>
								<th>Mot de passe utilisateur</th>
								<td><?php echo $mysql_password; ?></td>
							</tr>
						</table>
					</p>
				</article>
				<?php
					# MySQL avec PDO_MYSQL  
					try {
						$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
						?><div class="alert alert-success" role="alert">Connect&eacute;</div><?php
					} catch (PDOException $e) {
					    ?><div class="alert alert-danger" role="alert">Connexion &agrave; la base de donn&eacute;es impossible avec les parm&egrave; ci-dessus.<br/><?php $e->getMessage(); ?></div><?php
					    die();
					}
				?>
				<article>
					<h2>Formulaire de requ&ecirc;te MySQL</h2>
					<p>
						<form action="" method="post" class="form-horizontal">
							<div class="form-group"><textarea name="sql" class="form-control"><?php echo $query; ?></textarea></div>
							<div class="form-group"><input type="submit" value="Executer" class="btn btn-primary"></div>
						</form>
					</p>
				</article>
			</section>
			
			<section>
				<?php
				//$query = file_get_contents("shop.sql");
				//$query = 'SELECT * FROM  `Reponse`';
				if ((isset($_POST['sql']))&&(!empty($_POST['sql']))) {

					$query = $_POST['sql'];
					$stmt = $db->prepare($query);

					if ($stmt->execute()) {
						$results = $stmt->fetchAll();
						$count = count($results);
						if ($count == 0) {
						?>
							<div class="alert alert-success" role="alert">Requ&ecirc;te &eacute;x&eacute;cut&eacute;e avec succ&egrave;s.<br/>R&eacute;sultat vide.</div>
						<?php
						} else {
						?>
							<div class="alert alert-success" role="alert">Requ&ecirc;te &eacute;x&eacute;cut&eacute;e avec succ&egrave;s.<br/><?php echo $count; ?> r&eacute;sultats &agrave; affich&eacute;s.</div>
						<?php
						}
						?>
						
					 	<article>
					 		<table class="table table-striped">
					 			<tr><th>Ligne</th><th>R&eacute;sultat</th></tr>
							 	<?php
							 	foreach ($results as $key => $value) {
							 	?>
						 		<tr>
						 			<td><?php echo $key; ?></td>
						 			<td>
									 	<table>
									 		<tr><th>Cl&eacute;</th><th>Valeur</th></tr>
										 	<?php
										 	foreach ($value as $subkey => $subvalue) {
										 	?>
									 		<tr>
									 			<td><?php echo $subkey; ?></td>
									 			<td>
									 				<?php 
									 				if(empty($subvalue)){
									 					echo 'NULL';
									 				}else{
									 					echo $subvalue;
									 				} ?>
									 			</td>
									 		</tr>
										 	<?php
											}
											?>
									 	</table>
						 			</td>
						 		</tr>
							 	<?php
								}
								?>
					 		</table>
						</article>
					<?php
					}
					else  {
					    ?><div class="alert alert-danger" role="alert">Erreur lors de l'&eacute;x&eacute;cution de la requ&ecirc;te.</div><?php
					}
				}
				?>
			</section>
		</div>
	</body>
</html>

