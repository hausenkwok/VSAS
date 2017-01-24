<?php 
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$time_start = microtime_float();

	function query_lately_detail($dblink,$table)
	{
		$sql = 'select grow from '.$table.' where lately=1;';
		return $dblink->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}

	require_once('database.php');

	$sql = 'select id,title,issue_date,(weibo+tengxun+aiqiyi+youku+tudou+azhan+bzhan+jinritoutiao+souhu+wangyi) as total from video_list;';
	$resultList = $dblink->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	$sql = 'select sum(weibo+tengxun+aiqiyi+youku+tudou+azhan+bzhan+jinritoutiao+souhu+wangyi) from video_list;';
	$totalsum = $dblink->query($sql)->fetch(PDO::FETCH_NUM)[0];

	$tablelist = ['a_weibo','a_tengxun','a_aiqiyi','a_youku','a_tudou','a_azhan','a_bzhan','a_jinritoutiao','a_wangyi','a_souhu'];

	for($i=0,$k=count($tablelist);$i<$k;$i++)
	{
		$rlist = query_lately_detail($dblink,$tablelist[$i]);
		for($y=0,$h=count($rlist);$y<$h;$y++)
		{
			if(!isset($sumlist[$y])){$sumlist[$y]=0;}
			$sumlist[$y] = $sumlist[$y] + $rlist[$y]['grow'];
		}
	}

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
				<td colspan="6">各集总播放量</td>
			</tr>
			<tr class="count-content-head">
				<td>序号</td>
				<td>标题</td>
				<td>发布时间</td>
				<td>总播放量</td>
				<td>总占比</td>
				<td>本次增量</td>
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
				<td><?php echo $sumlist[$flag-1];?></td>
			</tr>

			<?php 
				}
			?>
		</table>
		<p style="text-align: center;margin-top: 20px;">程序运行统计所耗时间：<?php echo round($time,6);?>秒</p>
	</div>
</body>
</html>