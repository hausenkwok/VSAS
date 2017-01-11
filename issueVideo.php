<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>单集录入</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php require_once("nav.php");?>
	<div class="body-box">
		<form method="post" action="actionAddContent.php" id="biaodan">
			<table class="issue-video" cellpadding="10">
				<tr>
					<td>视频标题：</td>
					<td><input type="text" name="title"></td>
				</tr>
				<tr>
					<td>发布日期：</td>
					<td><input type="text" name="issuedate" value="<?php echo date('Y-m-d'); ?>"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input class="issue-video-bt" type="button" id="tijiao" value="提交" style="width: 300px;height: 50px;">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<script type="text/javascript">
		var tj = document.getElementById("tijiao");
		var bd = document.getElementById("biaodan");
		tj.onclick = function(){
			
			if (confirm("确定提交？")) {
				bd.submit();
			}
		}
	</script>
</body>
</html>