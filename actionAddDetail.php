<?php 
	require_once('database.php');

	$id_list = $_POST['id'];
	$total_list = $_POST['total'];
	$platform = $_POST['platform'];
	$enter_time = $_POST['enter_time'];

	switch ($platform) {
		case '1':
			$platform = 'weibo';
			break;
		case '2':
			$platform = 'tengxun';
			break;
		case '3':
			$platform = 'aiqiyi';
			break;
		case '4':
			$platform = 'youku';
			break;
		case '5':
			$platform = 'tudou';
			break;
		case '6':
			$platform = 'azhan';
			break;
		case '7':
			$platform = 'bzhan';
			break;
		case '8':
			$platform = 'jinritoutiao';
			break;
		case '9':
			$platform = 'wangyi';
			break;
		case '10':
			$platform = 'souhu';
			break;
		default:
			$platform = '指定平台出错！';
			exit($platform);
			break;
	}

	$platform_table = 'a_'.$platform;

	$sql = 'select id,'.$platform.' from video_list';
	$initial_list = $dblink->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	$sql = 'update video_list set '.$platform.'=? where id=?';
	$sql2 = 'insert into '.$platform_table.'(video_id,enter_time,total,grow,lately) value(?,?,?,?,?)';
	$stmt = $dblink->prepare($sql);
	$stmt2 = $dblink->prepare($sql2);

	$dblink->beginTransaction();

	$sql3 = 'update '.$platform_table.' set lately=0';
	$dblink->exec($sql3);

	for($i=0,$k=count($id_list); $i<$k; $i++){
		
		$grow = $total_list[$i] - $initial_list[$i][$platform];

		if ($id_list[$i] != $initial_list[$i]['id']) {
			exit("序列出错！");
		}

		if (!$stmt->execute(array($total_list[$i],$id_list[$i]))) {
			exit("更新videolist出错！");
		}

		if (!$stmt2->execute(array($id_list[$i],$enter_time,$total_list[$i],$grow,1))) {
			exit("插入流水表出错！");
		}
	}

	if ($dblink->commit()) {
		$dblink = NULL;
		header("Location: videoDetail.php");
		exit();
	}else{
		exit("数据提交出错！");
	}
?>