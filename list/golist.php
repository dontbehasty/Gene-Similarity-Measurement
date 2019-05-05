<html>
	<head>
		<title>Gene Products List</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>
		<body>
		<style type="text/css">
			h1 {
			color: white;
			text-align: center;
			}
		</style>
						<table width="100%" align=center border=0>
				<tr bgcolor="#0081C7" width="100%" height="50px" font="arial">
					<td align="center">
						<h1 font color="white">Go Terms List</h1>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<p align="center"><a title="Close Window" href="javascript:close();">Close Window</a></p> <br><br>
						</td>
					</tr>
					<tr>
						<td>
				
				<?php
				$username="root";
				$password="";
				$database="assocdb";
				
				mysql_connect(localhost,$username,$password);
				@mysql_select_db($database) or die( "Unable to select database");				
				
				//display gene products
				$query1="SELECT * FROM term WHERE acc LIKE 'GO:%'";
				$result1=mysql_query($query1) or die(mysql_error());
				$row1 = mysql_fetch_array($result1); 
				
				while($row1 = mysql_fetch_array($result1)) {
  						echo "<table align=center border=1 cellspacing=2 bgcolor=white>";				
  						echo "<tr>";
						echo "<td width=15%>";
						echo $row1['id'];
  						echo "</td>";
	  					echo "<td width=30%>";
						echo $row1['acc'];
  						echo "</td>";
	  					echo "</tr>";
	  					echo "</table>";
					}
					echo "<br>";
					echo "<br>";
				
				mysql_close();
				?>
				
				</td>
					</tr>
				</table>
		</body>
</html>	