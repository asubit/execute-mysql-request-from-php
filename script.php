<?php
/*
The MIT License (MIT)
Copyright 2017 Antoine Subit ©
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

// Define parameters here
$mysql_host     = "127.0.0.1";
$mysql_database = "domotelec";
$mysql_user     = "root";
$mysql_password = "root";
$query = ((isset($_POST['sql']))&&(!empty($_POST['sql'])))? $_POST['sql'] : '';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta charset="utf-8">

        <title>Simple executor SQL</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<!-- Title -->
			<h1 align="center">Execute SQL on "<?php echo $mysql_host; ?>" host</h1>
			<!-- Link to GitHub repository -->
			<p align="center">
				<a href="https://github.com/asubit/execute-mysql-request-from-php" target="_blank">https://github.com/asubit/execute-mysql-request-from-php</a>
			</p>

			<section>
				<!-- MySQL parameters -->
				<article>
					<h2>Database parameters</h2>
					<p>
						<table class="table">
							<tr>
								<th>Host</th>
								<td><?php echo $mysql_host; ?></td>
							</tr>
							<tr>
								<th>Database name</th>
								<td><?php echo $mysql_database; ?></td>
							</tr>
							<tr>
								<th>Database user</th>
								<td><?php echo $mysql_user; ?></td>
							</tr>
							<tr>
								<th>Database password</th>
								<td>*********</td>
							</tr>
						</table>
					</p>
				</article>

				<!-- Test database connection -->
				<?php 
				try {
					$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
				?>
					<div class="alert alert-success" role="alert">Test database connection : OK</div>
				<?php
				} catch (PDOException $e) {
				?>
					<div class="alert alert-danger" role="alert">
						Test database connection : KO<br/>
						<?php $e->getMessage(); ?>
					</div>
					<?php
					exit;
				}
				?>

				<!-- SQL query input box -->
				<article>
					<h2>SQL query input box</h2>
					<p>
						<form action="" method="post" class="form-horizontal">
							<div class="form-group"><textarea name="sql" class="form-control"><?php echo $query; ?></textarea></div>
							<div class="form-group"><input type="submit" value="Executer" class="btn btn-primary"></div>
						</form>
					</p>
				</article>
			</section>
			
			<?php if($query): ?>
			<!-- There is query text -->
			<section>
				<?php $stmt = $db->prepare($query); ?>
				<!-- Prepare query text to SQL -->
				<?php if (!$stmt->execute()): ?>
					<!-- SQL query can't be execute -->
					<div class="alert alert-danger" role="alert">
						SQL query can't be execute.
					</div>
				<?php else: ?>
					<?php
					$results = $stmt->fetchAll();
					$count = count($results);
					?>
					<!-- SQL query is execute -->
					<div class="alert alert-success" role="alert">
						SQL query is execute.<br/>
						<?php echo $count; ?> results.
					</div>
					<!-- SQL results display -->
					<table class="table table-striped"">
						<!-- SQL head -->
						<thead>
							<tr>
								<?php foreach(array_keys($results[0]) as $arrayKey): ?>
									<?php if(!is_numeric($arrayKey)): ?>
										<th><?php echo $arrayKey; ?></th>
									<?php endif; ?>
								<?php endforeach; ?>
							</tr>
						</thead>
						<!-- SQL content -->
						<tbody>
							<?php foreach($results as $result): ?>
								<tr>
									<?php foreach($result as $key => $value): ?>
										<?php if(!is_numeric($key)): ?>
											<td><?php echo $value; ?></td>
										<?php endif; ?>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</section>
			<?php endif; ?>
		</div>
	</body>
</html>
