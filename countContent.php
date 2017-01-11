<?php 
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$time_start = microtime_float();

	require_once('database.php');

	$sql = 'select id,title,issue_date,(weibo+tengxun+aiqiyi+youku+tudou+azhan+bzhan+jinritoutiao+souhu+wangyi) as total from video_list;';
	$resultList = $dblink->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	$sql = 'select sum(weibo+tengxun+aiqiyi+youku+tudou+azhan+bzhan+jinritoutiao+souhu+wangyi) from video_list;';
	$totalsum = $dblink->query($sql)->fetch(PDO::FETCH_NUM)[0];

	$dblink = NULL;

	$time_end = microtime_float();
	$time = $time_end - $time_start;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>统计内容</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php require_once("nav.php");?>
	<div class="body-box">
		<table class="count-content" cellspacing="0" cellpadding="10">
			<tr>
				<td colspan="5">各集总播放量</td>
			</tr>
			<tr class="count-content-head">
				<td>序号</td>
				<td>标题</td>
				<td>发布时间</td>
				<td>总播放量</td>
				<td>总占比</td>
			</tr>
			<?php 
				$flag = 0;
				foreach ($resultList as $row) {
					$flag++;
			?>

			<tr>
				<td><?php echo $flag;?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['issue_date'];?></td>
				<td><?php echo $row['total'];?></td>
				<td><?php echo round(($row['total']/$totalsum)*100,2).'%';?></td>
			</tr>

			<?php 
				}
			?>
		</table>
		<p style="text-align: center;margin-top: 20px;">程序运行统计所耗时间：<?php echo round($time,6);?>秒</p>
	</div>
</body>
</html>