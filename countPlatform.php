<?php 
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$time_start = microtime_float();

	require_once('database.php');

	function query_platform_sum($dblink,$table)
	{
		$sql = 'select SUM(total) as total,SUM(grow) as grow from '.$table.' where lately=1';
		return $dblink->query($sql)->fetch(PDO::FETCH_ASSOC);
	}

	$wb = query_platform_sum($dblink,'a_weibo');
	$tx = query_platform_sum($dblink,'a_tengxun');
	$qy = query_platform_sum($dblink,'a_aiqiyi');
	$yk = query_platform_sum($dblink,'a_youku');
	$td = query_platform_sum($dblink,'a_tudou');
	$az = query_platform_sum($dblink,'a_azhan');
	$bz = query_platform_sum($dblink,'a_bzhan');
	$tt = query_platform_sum($dblink,'a_jinritoutiao');
	$wy = query_platform_sum($dblink,'a_wangyi');
	$sh = query_platform_sum($dblink,'a_souhu');

	$sumtotal = $wb['total']+$tx['total']+$qy['total']+$yk['total']+$td['total']+
				$az['total']+$bz['total']+$tt['total']+$wy['total']+$sh['total'];

	$perwb = round(($wb['total']/$sumtotal)*100,2).'%';
	$pertx = round(($tx['total']/$sumtotal)*100,2).'%';
	$perqy = round(($qy['total']/$sumtotal)*100,2).'%';
	$peryk = round(($yk['total']/$sumtotal)*100,2).'%';
	$pertd = round(($td['total']/$sumtotal)*100,2).'%';
	$peraz = round(($az['total']/$sumtotal)*100,2).'%';
	$perbz = round(($bz['total']/$sumtotal)*100,2).'%';
	$pertt = round(($tt['total']/$sumtotal)*100,2).'%';
	$perwy = round(($wy['total']/$sumtotal)*100,2).'%';
	$persh = round(($sh['total']/$sumtotal)*100,2).'%';

	$dblink = NULL;

	$time_end = microtime_float();
	$time = $time_end - $time_start;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>平台统计</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php require_once("nav.php");?>
	<div class="body-box">
		<table class="count-platform" cellspacing="0" cellpadding="8">
			<tr>
				<td colspan="4">
					总播放量：<span><?php echo $sumtotal;?></span>&nbsp;次
				</td>
			</tr>
			<tr class="count-platform-head">
				<td>平台</td>
				<td>占比</td>
				<td>总播放量</td>
				<td>本次增量</td>
			</tr>
			<tr>
				<td>微博</td>
				<td><?php echo $perwb;?></td>
				<td><?php echo $wb['total'];?></td>
				<td><?php echo $wb['grow'];?></td>
			</tr>
			<tr>
				<td>腾讯</td>
				<td><?php echo $pertx;?></td>
				<td><?php echo $tx['total'];?></td>
				<td><?php echo $tx['grow'];?></td>
			</tr>
			<tr>
				<td>爱奇艺</td>
				<td><?php echo $perqy;?></td>
				<td><?php echo $qy['total'];?></td>
				<td><?php echo $qy['grow'];?></td>
			</tr>
			<tr>
				<td>优酷</td>
				<td><?php echo $peryk;?></td>
				<td><?php echo $yk['total'];?></td>
				<td><?php echo $yk['grow'];?></td>
			</tr>
			<tr>
				<td>土豆</td>
				<td><?php echo $pertd;?></td>
				<td><?php echo $td['total'];?></td>
				<td><?php echo $td['grow'];?></td>
			</tr>
			<tr>
				<td>A站</td>
				<td><?php echo $peraz;?></td>
				<td><?php echo $az['total'];?></td>
				<td><?php echo $az['grow'];?></td>
			</tr>
			<tr>
				<td>B站</td>
				<td><?php echo $perbz;?></td>
				<td><?php echo $bz['total'];?></td>
				<td><?php echo $bz['grow'];?></td>
			</tr>
			<tr>
				<td>今日头条</td>
				<td><?php echo $pertt;?></td>
				<td><?php echo $tt['total'];?></td>
				<td><?php echo $tt['grow'];?></td>
			</tr>
			<tr>
				<td>网易</td>
				<td><?php echo $perwy;?></td>
				<td><?php echo $wy['total'];?></td>
				<td><?php echo $wy['grow'];?></td>
			</tr>
			<tr>
				<td>搜狐</td>
				<td><?php echo $persh;?></td>
				<td><?php echo $sh['total'];?></td>
				<td><?php echo $sh['grow'];?></td>
			</tr>
		</table>
		<p style="text-align: center;margin-top: 20px;">程序运行统计所耗时间：<?php echo round($time,6);?>秒</p>
	</div>
</body>
</html>