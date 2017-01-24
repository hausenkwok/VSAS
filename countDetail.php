<?php 
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$time_start = microtime_float();

	require_once('database.php');

	$video_id = $_POST['id'];

	$sql = 'select * from video_list where id=?';
	$stmt = $dblink->prepare($sql);
	$stmt->execute(array($video_id));
	$video_info = $stmt->fetch(PDO::FETCH_ASSOC);

	function query_detail($dblink,$table,$video_id)
	{
		$sql = 'select * from '.$table.' where video_id=? ORDER BY enter_time desc,id desc limit 0,10';
		$stmt = $dblink->prepare($sql);
		$stmt->execute(array($video_id));
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	$wb_list = query_detail($dblink,'a_weibo',$video_id);
	$tx_list = query_detail($dblink,'a_tengxun',$video_id);
	$qy_list = query_detail($dblink,'a_aiqiyi',$video_id);
	$yk_list = query_detail($dblink,'a_youku',$video_id);
	$td_list = query_detail($dblink,'a_tudou',$video_id);
	$az_list = query_detail($dblink,'a_azhan',$video_id);
	$bz_list = query_detail($dblink,'a_bzhan',$video_id);
	$tt_list = query_detail($dblink,'a_jinritoutiao',$video_id);
	$wy_list = query_detail($dblink,'a_wangyi',$video_id);
	$sh_list = query_detail($dblink,'a_souhu',$video_id);

	$wb_total = $wb_list?$wb_list[0]['total']:0;
	$tx_total = $tx_list?$tx_list[0]['total']:0;
	$qy_total = $qy_list?$qy_list[0]['total']:0;
	$yk_total = $yk_list?$yk_list[0]['total']:0;
	$td_total = $td_list?$td_list[0]['total']:0;
	$az_total = $az_list?$az_list[0]['total']:0;
	$bz_total = $bz_list?$bz_list[0]['total']:0;
	$tt_total = $tt_list?$tt_list[0]['total']:0;
	$wy_total = $wy_list?$wy_list[0]['total']:0;
	$sh_total = $sh_list?$sh_list[0]['total']:0;

	$sumtotal = $wb_total+$tx_total+$qy_total+$yk_total+$td_total+
				$az_total+$bz_total+$tt_total+$wy_total+$sh_total;

	if (!$sumtotal) exit("nodata");

	$perwb = round(($wb_total/$sumtotal)*100,2).'%';
	$pertx = round(($tx_total/$sumtotal)*100,2).'%';
	$perqy = round(($qy_total/$sumtotal)*100,2).'%';
	$peryk = round(($yk_total/$sumtotal)*100,2).'%';
	$pertd = round(($td_total/$sumtotal)*100,2).'%';
	$peraz = round(($az_total/$sumtotal)*100,2).'%';
	$perbz = round(($bz_total/$sumtotal)*100,2).'%';
	$pertt = round(($tt_total/$sumtotal)*100,2).'%';
	$perwy = round(($wy_total/$sumtotal)*100,2).'%';
	$persh = round(($sh_total/$sumtotal)*100,2).'%';

	$dblink = NULL;

	$time_end = microtime_float();
	$time = $time_end - $time_start;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>查询单集结果</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php require_once("nav.php");?>
	<div class="body-box">
		<table class="video-detail-result" cellspacing="0" cellpadding="5">
			<tr>
				<td colspan="10" style="font-size: 20px;">
					<?php echo $video_info['title'];?><br>详细数据
				</td>
			</tr>
			<tr class="video-detail-result-hd">
				<td>微博</td>
				<td>腾讯</td>
				<td>爱奇艺</td>
				<td>优酷</td>
				<td>土豆</td>
				<td>A站</td>
				<td>B站</td>
				<td>今日头条</td>
				<td>搜狐</td>
				<td>网易</td>
			</tr>
			<tr>
				<td><?php echo $perwb; ?></td>
				<td><?php echo $pertx; ?></td>
				<td><?php echo $perqy; ?></td>
				<td><?php echo $peryk; ?></td>
				<td><?php echo $pertd; ?></td>
				<td><?php echo $peraz; ?></td>
				<td><?php echo $perbz; ?></td>
				<td><?php echo $pertt; ?></td>
				<td><?php echo $persh; ?></td>
				<td><?php echo $perwy; ?></td>
			</tr>
			<tr>
				<td><?php echo $wb_total; ?></td>
				<td><?php echo $tx_total; ?></td>
				<td><?php echo $qy_total; ?></td>
				<td><?php echo $yk_total; ?></td>
				<td><?php echo $td_total; ?></td>
				<td><?php echo $az_total; ?></td>
				<td><?php echo $bz_total; ?></td>
				<td><?php echo $tt_total; ?></td>
				<td><?php echo $sh_total; ?></td>
				<td><?php echo $wy_total; ?></td>
			</tr>
			<tr>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($wb_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($tx_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($qy_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($yk_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($td_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($az_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($bz_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($tt_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($sh_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
				<td class="video-detail-result-mx">
					<table cellspacing="0" cellpadding="3" class="detail-mx">
						<tr class="video-detail-result-hd">
							<td>日期</td><td>总数</td><td>增数</td>
						</tr>
						<?php 
							foreach ($wy_list as $row) {
								if ($row['total']==0) continue;
						?>
						<tr>
							<td><?php echo date('n.j',strtotime($row['enter_time'])); ?></td>
							<td><?php echo $row['total']; ?></td>
							<td><?php echo $row['grow']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		<p style="text-align: center;margin-top: 20px;">程序运行统计所耗时间：<?php echo round($time,6);?>秒</p>
	</div>
	<script type="text/javascript">
		window.onload = function()
		{
			if(document.getElementsByClassName)
			{
				var cn = document.getElementsByClassName('detail-mx');
				for(var i=0,flag=cn.length;i<flag;i++)
				{
					var trlist = cn[i].getElementsByTagName('tr');
					if(trlist.length == 1) continue;
					trlist[1].children[2].style.backgroundColor="#ffcc00";
				}
			}
		}
	</script>
</body>
</html>