<?php 
	require_once('database.php');

	$title = $_POST['title'];
	$issuedate = $_POST['issuedate'];

	$sql = "insert into video_list(title,issue_date) value(?,?);";
	$stmt = $dblink->prepare($sql);
	$result = $stmt->execute(array($title,$issuedate));

	if ($result) {
		header("Location: videoDetail.php");
		exit();
	}else{
		print_r($stmt->errorInfo());
	}

	$dblink = NULL;

?>