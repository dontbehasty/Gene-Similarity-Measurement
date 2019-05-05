<html>
	<head>
		<title>GO Terms Results</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>
		<body>
			<div class="mainContainer">
				<div class="headerContainer">
					<div class="header">
						Gene similarity measurement
					</div>
				</div>
				
				<div class="menuContainer">
					<div class="menuItem">
						<button type="button" class="btn"
							onclick="window.location.href='index.html'">HOME
						</button>
						<button type="button" class="btn"
							onclick="window.location.href='geneproduct.html'">GENE PRODUCTS
						</button>
						<button type="button" class="btn"
							onclick="window.location.href='goterm.html'">GO TERMS
						</button>
						<div class="menuItem2">
							<script language = "JavaScript" align="right">
								var now = new Date();
								var dayNames = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
								var monNames = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
								document.write(dayNames[now.getDay()]  + " " + now.getDate() + " " + monNames[now.getMonth()]+ ", " + now.getFullYear());
							</script>
						</div> 
					</div>
				</div>
				
				<div class="topFrame" align="center"><br><br>
					<div class="pageHeader">
						GO Terms - Results
					</div>
				</div>
				
				<div class="middleContainer">
				
				<?php
				$username="root"; // Mysql username
				$password=""; // Mysql password
				$database="assocdb"; // Database name
				
				// Connect to server and select database
				mysql_connect(localhost,$username,$password);
				@mysql_select_db($database) or die("Unable to select database");
				
				// Reads in the values of GO term 1 and GO term 2
				$goterm1 = mysql_real_escape_string($_POST['goterm1']) or die("Please enter a GO term name"); 
				$goterm2 = mysql_real_escape_string($_POST['goterm2']) or die("Please enter a GO term name");
				
				
				// Check GO term 1 exist in database
				$test_go1="SELECT acc FROM term WHERE acc = '$goterm1'";
				$result_1=mysql_query($test_go1) or die(mysql_error());
				$row_1=mysql_fetch_assoc($result_1);
				
				if (mysql_num_rows($result_1)<1){
					die("GO term - $goterm1, is not in the database. Please go back and enter another GO term name.");
				}
				
				// Check GO term 2 exist in database
				$test_go2="SELECT acc FROM term WHERE acc = '$goterm2'";
				$result_2=mysql_query($test_go2) or die(mysql_error());
				$row_2=mysql_fetch_assoc($result_2);
				
				if (mysql_num_rows($result_2)<1){
					die("GO term - $goterm2, is not in the database. Please go back and enter another GO term name.");
				}
				
				
				// Gets GO terms
				$query1="SELECT * FROM term WHERE acc = '$goterm1'";
				$query2="SELECT * FROM term WHERE acc = '$goterm2'";
				$result1=mysql_query($query1) or die(mysql_error());        
				$result2=mysql_query($query2) or die(mysql_error());
				$row1=mysql_fetch_assoc($result1);
				$row2=mysql_fetch_assoc($result2);
				
				
				// Gets the term definition
				$query3="SELECT term_definition FROM term_definition, term WHERE term_definition.term_id=term.id AND acc = '$goterm1'";
				$query4="SELECT term_definition FROM term_definition, term WHERE term_definition.term_id=term.id AND acc = '$goterm2'";
				$result3=mysql_query($query3) or die(mysql_error());
				$result4=mysql_query($query4) or die(mysql_error());
				$row3=mysql_fetch_assoc($result3);
				$row4=mysql_fetch_assoc($result4);

				
				// Gets the term synonym
				$query5="SELECT term_synonym FROM term_synonym, term WHERE term_synonym.term_id=term.id AND acc = '$goterm1'";
				$query6="SELECT term_synonym FROM term_synonym, term WHERE term_synonym.term_id=term.id AND acc = '$goterm2'";
				$result5=mysql_query($query5) or die(mysql_error());
				$result6=mysql_query($query6) or die(mysql_error());
				$row5=mysql_fetch_assoc($result5);
				$row6=mysql_fetch_assoc($result6);

				
				// Gets the distance between two terms
				$query7="SELECT term1_id FROM graph_path, term WHERE graph_path.term1_id=term.id AND acc = '$goterm1'";
				$query8="SELECT term2_id FROM graph_path, term WHERE graph_path.term1_id=term.id AND acc = '$goterm2'";
				$result7=mysql_query($query7) or die(mysql_error());
				$result8=mysql_query($query8) or die(mysql_error());
				$row7=mysql_fetch_assoc($result7);
				$row8=mysql_fetch_assoc($result8);
				
				$query9="SELECT distance FROM graph_path WHERE term1_id = '$row7[term1_id]' AND term2_id = '$row8[term2_id]'";
				$result9=mysql_query($query9) or die(mysql_error());
				$row9=mysql_fetch_assoc($result9);
				
				// Distance between the two terms
				$distance = $row9['distance'];
				
				// Similarity between the two terms
				$similarity1 = exp((-0.20) * $distance);
				$similarity2 = round($similarity1, 2);
				
				mysql_close();
				?>
				
				<table align="center" border="0" cellspacing="0" width="70%">
					<tr align="center">
						<td>
							<h3>The path length (distance) between <p2><?php echo $goterm1; ?></p2> and <p2><?php echo $goterm2; ?></p2> is: <p1><u><?php echo $distance; ?></u></p1> </h3>
						</td>
					</tr>
					<tr align="center">
						<td>
							<h3>The similarity between <p2><?php echo $goterm1; ?></p2> and <p2><?php echo $goterm2; ?></p2> is: <p1><u><?php echo $similarity2; ?></u></p1> </h3>
						</td>
					</tr>
				</table><br><br><br>
				
				<table align="center" border="0" cellspacing="10" width="80%">	
					<tr align="left">
						<td width="15%" valign="top"><b>GO Term:</b></td>
						<td width="30%" valign="top"><b><?php echo $goterm1 ?></b></td>
						<td width="30%" valign="top"><b><?php echo $goterm2 ?></b></td>
					</tr>
					<tr align="left">
						<td width="15%" valign="top"><b>Name:</b></td>
						<td width="30%" valign="top"><?php echo $row1['name'] ?></td>
						<td width="30%" valign="top"><?php echo $row2['name']?></td>
					</tr>
					<tr align="left">
						<td width="15%" valign="top"><b>Term ID:</b></td>
						<td width="30%" valign="top"><?php echo $row1['id'] ?></td>
						<td width="30%" valign="top"><?php echo $row2['id'] ?></td>
					</tr>
					<tr align="left">
						<td width="15%" valign="top"><b>Term Type:</b></td>
						<td width="30%" valign="top"><?php echo $row1['term_type'] ?></td>
						<td width="30%" valign="top"><?php echo $row2['term_type'] ?></td>
					</tr>
					<tr align="left">
						<td width="15%" valign="top"><b>Term Definition:</b></td>
						<td width="30%" valign="top"><?php echo $row3['term_definition'] ?></td>
						<td width="30%" valign="top"><?php echo $row4['term_definition'] ?></td>
					</tr>
					<tr align="left">
						<td width="15%" valign="top"><b>Term Synonym:</b></td>
						<td width="30%" valign="top"><?php echo $row5['term_synonym'] ?></td>
						<td width="30%" valign="top"><?php echo $row6['term_synonym'] ?></td>
					</tr>
				</table>
								
				</div>
				<div class="bottomFrame">
				</div>
				
				<div class="footer">
					Copyright © 2009 Jenny Gow
				</div>
				
			</div>
		</body>
</html>	