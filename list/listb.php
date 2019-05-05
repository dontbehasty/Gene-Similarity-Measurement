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
						<h1 font color="white">Gene Products List</h1>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<p align="center">
							<a href="lista.php">A</a>&nbsp;
							<a href="listb.php">B</a>&nbsp;
							<a href="listc.php">C</a>&nbsp;
							<a href="listd.php">D</a>&nbsp;
							<a href="liste.php">E</a>&nbsp;
							<a href="listf.php">F</a>&nbsp;
							<a href="listg.php">G</a>&nbsp;
							<a href="listh.php">H</a>&nbsp;
							<a href="listi.php">I</a>&nbsp;
							<a href="listj.php">J</a>&nbsp;
							<a href="listk.php">K</a>&nbsp;
							<a href="listl.php">L</a>&nbsp;
							<a href="listm.php">M</a>&nbsp;
							<a href="listn.php">N</a>&nbsp;
							<a href="listo.php">O</a>&nbsp;
							<a href="listp.php">P</a>&nbsp;
							<a href="listq.php">Q</a>&nbsp;
							<a href="listr.php">R</a>&nbsp;
							<a href="lists.php">S</a>&nbsp;
							<a href="listt.php">T</a>&nbsp;
							<a href="listu.php">U</a>&nbsp;
							<a href="listv.php">V</a>&nbsp;
							<a href="listw.php">W</a>&nbsp;
							<a href="listx.php">X</a>&nbsp;
							<a href="listy.php">Y</a>&nbsp;
							<a href="listz.php">Z</a>&nbsp;
						</p><br>
						
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
				
				echo "<table align=center border=1 cellspacing=2 width=50% bgcolor=white>";
				echo "<tr align=center>";
	  			echo "<td width=50%>";
	  			echo "<b>";
				echo "<u>";
				echo "Symbol";
				echo "</u>";
				echo "</b>";
  				echo "</td>";
	  			echo "</tr>";
	  			echo "</table>";				
				
				//display gene products
				$query1="SELECT * FROM gene_product WHERE symbol LIKE 'b%'";
				$result1=mysql_query($query1) or die(mysql_error());
				$row1 = mysql_fetch_array($result1); 
				
				while($row1 = mysql_fetch_array($result1)) {
  						echo "<table align=center border=1 cellspacing=2 width=50% bgcolor=white>";
						echo "<tr>";
	  					echo "<td width=50%>";
						echo $row1['symbol'];
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