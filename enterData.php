<?php 
	require_once('database.php');

	$sql = 'select * from video_list;';
	$resultList = $dblink->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	if (!$resultList) {
		print_r($dblink->errorInfo());
		exit();
	}

	$json = json_encode($resultList);
	$dblink = NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>数据录入</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php require_once("nav.php");?>
	<div class="body-box">
		<form method="post" action="actionAddDetail.php" id="biaodan">
			<table class="enter-target" cellspacing="0" cellpadding="20">
				<tr>
					<td>平台</td>
					<td>采集日期</td>
				</tr>
				<tr>
					<td>
						<select name="platform" id="platform">
							<option value="1">微博</option>
							<option value="2">腾讯</option>
							<option value="3">爱奇艺</option>
							<option value="4">优酷</option>
							<option value="5">土豆</option>
							<option value="6">A站</option>
							<option value="7">B站</option>
							<option value="8">今日头条</option>
							<option value="9">网易</option>
							<option value="10">搜狐</option>
						</select>
					</td>
					<td>
						<input type="text" name="enter_time" value="<?php echo date('Y-m-d'); ?>">
					</td>
				</tr>
			</table>

			<table class="enter-detail" cellpadding="10" cellspacing="0" id="enter">
				<tr>
					<td>序号</td>
					<td>标题</td>
					<td>上次累计数</td>
					<td>累计数</td>
				</tr>

				<?php 
					$flag = 0;
					foreach ($resultList as $row) {
						$flag++;
				?>
				<tr>
					<td><?php echo $flag; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['weibo']; ?></td>
					<td>
						<input type="text" name="total[]" value="<?php echo $row['weibo']; ?>">
						<input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
					</td>
				</tr>
				<?php 
					}
				?>

				<tr>
					<td colspan="4"><input type="button" value="提交" id="tijiao"></td>
				</tr>
			</table>
		</form>
	</div>
	<script type="text/javascript">
	console.log(document.documentElement.clientWidth);
		window.onload = function()
		{
			var tj = document.getElementById("tijiao");
			var bd = document.getElementById("biaodan");
			tj.onclick = function()
			{
				if (confirm("确定提交？"))
				{
					bd.submit();
				}
			}

			var jsons = <?php echo $json;?>;
			var sl = document.getElementById("platform");
			var datalist = document.getElementById("enter");
			var tdlist = datalist.getElementsByTagName("td");
			
			sl.onchange = function()
			{
				var amount;
				var flag = 6;
				for(var i=0,k=jsons.length;i<k;i++)
				{
					switch(this.value)
					{
						case "1": amount = jsons[i].weibo; break;
						case "2": amount = jsons[i].tengxun; break;
						case "3": amount = jsons[i].aiqiyi; break;
						case "4": amount = jsons[i].youku; break;
						case "5": amount = jsons[i].tudou; break;
						case "6": amount = jsons[i].azhan; break;
						case "7": amount = jsons[i].bzhan; break;
						case "8": amount = jsons[i].jinritoutiao; break;
						case "9": amount = jsons[i].wangyi; break;
						case "10": amount = jsons[i].souhu; break;
						default:return false;
					}
					tdlist[flag].firstChild.nodeValue = amount;
					// console.log(tdlist[flag+1].children[0].value);
					tdlist[flag+1].children[0].value = amount;
					flag = flag+4;

				}
			}
		}
	</script>
</body>
</html>