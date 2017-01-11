<?php 
	require_once('database.php');

	$sql = 'select * from video_list;';
	$resultList = $dblink->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	if (!$resultList) {
		print_r($dblink->errorInfo());
		exit();
	}

	$dblink = NULL;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>查询单集</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php require_once("nav.php");?>
	<div class="body-box video-detail">
		<form action="countDetail.php" method="post">
			<select name="id">
				<?php 
					foreach ($resultList as $row) {
				?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
				<?php 
					}
				?>
			</select>
			<input type="submit" value="查看">
		</form>
	</div>
</body>
</html>