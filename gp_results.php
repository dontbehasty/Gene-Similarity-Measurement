<html>
	<head>
		<title>Gene Product Results</title>
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
						Gene Product - Results
					</div>
				</div>
				
				<?php
				$username="root"; // Mysql username
				$password=""; // Mysql password
				$database="assocdb"; // Database name
				
				// Connect to server and select database
				mysql_connect(localhost,$username,$password);
				@mysql_select_db($database) or die("Unable to select database");
				
				$gene1 = mysql_real_escape_string($_POST['gene1']) or die("Please enter a gene product name"); 
				$gene2 = mysql_real_escape_string($_POST['gene2']) or die("Please enter a gene product name");
				$ontology = mysql_real_escape_string($_POST['ontology']);
				$datasource = mysql_real_escape_string($_POST['datasource']);

				
				// Check gene product 1 exist in database
				$test_gene1="SELECT symbol FROM gene_product WHERE symbol='$gene1'";
				$result_g1=mysql_query($test_gene1) or die(mysql_error());
				$row_g1=mysql_fetch_assoc($result_g1);
				
				if (mysql_num_rows($result_g1)<1){
					die("Gene product - $gene1, is not in the database. Please go back and enter another gene product name.");
				}
				
				// Check gene product 2 exist in database
				$test_gene2="SELECT symbol FROM gene_product WHERE symbol='$gene2'";
				$result_g2=mysql_query($test_gene2) or die(mysql_error());
				$row_g2=mysql_fetch_assoc($result_g2);
				
				if (mysql_num_rows($result_g2)<1){
					die("Gene product - $gene2, is not in the database. Please go back and enter another gene product name.");
				}
				
				
				// Gets the go terms
				if(($ontology == "all") && ($datasource == "all")){ 
				$query1="SELECT acc FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'";
				
				$query2="SELECT acc FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'";}
				
				
				if(($ontology != "all") && ($datasource != "all")) {
				$query1="SELECT acc FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene1'
				AND speciesdbname='$datasource'
				AND term_type='$ontology'";
				
				$query2="SELECT acc FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene2'
				AND speciesdbname='$datasource'
				AND term_type='$ontology'";}
				
				if(($ontology != "all") && ($datasource == "all")) {
				$query1="SELECT acc FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'
				AND term_type='$ontology'";
				
				$query2="SELECT acc FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'
				AND term_type='$ontology'";}
				
				if(($ontology == "all") && ($datasource != "all")) {
				$query1="SELECT acc FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene1'
				AND speciesdbname='$datasource'";
				
				$query2="SELECT acc FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene2'
				AND speciesdbname='$datasource'";}
				
				$result1=mysql_query($query1) or die(mysql_error());
				$result2=mysql_query($query2) or die(mysql_error());
				$row1=mysql_fetch_array($result1);
				$row2=mysql_fetch_array($result2);
						
				
				// Gets the term names
				if(($ontology == "all") && ($datasource == "all")){
				$query3="SELECT name FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'";
				
				$query4="SELECT name FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'";}
				
				if(($ontology != "all") && ($datasource != "all")) {
				$query3="SELECT name FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene1'
				AND speciesdbname='$datasource'
				AND term_type='$ontology'";
				
				$query4="SELECT name FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene2'
				AND speciesdbname='$datasource'
				AND term_type='$ontology'";}
				
				if(($ontology != "all") && ($datasource == "all")) {
				$query3="SELECT name FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'
				AND term_type='$ontology'";
				
				$query4="SELECT name FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'
				AND term_type='$ontology'";}
				
				if(($ontology == "all") && ($datasource != "all")) {
				$query3="SELECT name FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene1'
				AND speciesdbname='$datasource'";
				
				$query4="SELECT name FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene2'
				AND speciesdbname='$datasource'";}
				
				$result3=mysql_query($query3) or die(mysql_error());
				$result4=mysql_query($query4) or die(mysql_error());
				$row3=mysql_fetch_array($result3);
				$row4=mysql_fetch_array($result4);
				

				// Gets the term type
				if(($ontology == "all") && ($datasource == "all")){
				$query5="SELECT term_type FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'";
				
				$query6="SELECT term_type FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'";}
				
				if(($ontology != "all") && ($datasource != "all")) {
				$query5="SELECT term_type FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene1'
				AND speciesdbname='$datasource'
				AND term_type='$ontology'";
				
				$query6="SELECT term_type FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene2'
				AND speciesdbname='$datasource'
				AND term_type='$ontology'";}
				
				if(($ontology != "all") && ($datasource == "all")) {
				$query5="SELECT term_type FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'
				AND term_type='$ontology'";
				
				$query6="SELECT term_type FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'
				AND term_type='$ontology'";}
				
				if(($ontology == "all") && ($datasource != "all")) {
				$query5="SELECT term_type FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene1'
				AND speciesdbname='$datasource'";
				
				$query6="SELECT term_type FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				JOIN gene_product_count ON gene_product_count.term_id=term.id
				WHERE symbol='$gene2'
				AND speciesdbname='$datasource'";}
				
				$result5=mysql_query($query5) or die(mysql_error());
				$result6=mysql_query($query6) or die(mysql_error());
				$row5=mysql_fetch_array($result5);
				$row6=mysql_fetch_array($result6);

				
				// Put the id results from gene product 1 into a PHP array
				if($ontology == "all"){
				$query7="SELECT term_id FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'";}
				
				else {
				$query7="SELECT term_id FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene1'
				AND term_type='$ontology'";}
				
				$result7=mysql_query($query7) or die(mysql_error());
				while ($row7 = mysql_fetch_array($result7)) {
    				$array1[] = $row7['term_id'];
				}
				
				
				// Put the id results from gene product 2 into a PHP array
				if($ontology == "all"){
				$query8="SELECT term_id FROM term
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'";}
					
				else {
				$query8="SELECT term_id FROM term 
				JOIN association ON association.term_id = term.id
				JOIN gene_product ON association.gene_product_id = gene_product.id
				WHERE symbol='$gene2'
				AND term_type='$ontology'";}
				
				$result8=mysql_query($query8) or die(mysql_error());
				while ($row8 = mysql_fetch_array($result8)) {
    				$array2[] = $row8['term_id'];
				}
				
				
				// Distance similarity between the two gene products
				$array3 = array();
				
				foreach ($array1 as $a) {
    				foreach ($array2 as $b) {
        				$query_distance = "SELECT distance FROM graph_path WHERE term1_id = '".$a."' AND term2_id = '".$b."'";
        				$result_distance = mysql_query($query_distance) or die(mysql_error());
        				while ($row_distance = mysql_fetch_array($result_distance)) {
            				$array3[] = $row_distance['distance'];
        				}
    				}
				}				
				
				// Find the sum of the values in array 3
				$sum = array_sum($array3);
				
				// Find the size of array 3
				$size = sizeof($array3);
				
				// Find the average distance of the values in array 3
				$average = ($sum / $size);
				$distance = round($average, 2);

				// Find the actual simialrity of the genes
				$similarity1 = exp((-0.20) * $average);
				$similarity2 = round($similarity1, 2);
				
				mysql_close();
				?>
				
				<table align="center" border="0" cellspacing="0" width="70%">
					<tr align="center">
						<td><?php 
						echo "<h3>The average path length (distance) between <p2>$gene1</p2> and <p2>$gene2</p2> is: <p1><u>$distance</u></p1></h3>";
						?></td>
					</tr>
					<tr align="center">
						<td><?php 
						echo "<h3>The similarity between <p2>$gene1</p2> and <p2>$gene2</p2> is: <p1><u>$similarity2</u></p1></h3>";
						?></td>
					</tr>
				</table><br><br>
				
				<table align="center" border="4" cellspacing="5" width="85%">
					<tr align="center">
						<td width="50%" colspan="4"><b><u><?php echo $gene1 ?></u></b></td>
					</tr>
					<tr>
						<td width="10%" valign="top"><b>GO Term</b></td>
						<td width="60%" valign="top"><b>Term Name</b></td>
						<td width="15%" valign="top"><b>Term Type</b></td>
					</tr>
					<tr>
						<td>
							<?php
							echo "<table>";
							echo "<tr>";
	  						echo "<td>";
							echo $row1['acc'];
							echo "</td>";
	  						echo "</tr>";
							while($row1 = mysql_fetch_array($result1)) {
								echo "<tr>";
	  							echo "<td>";
								echo $row1['acc'];
	  							echo "</td>";
	  							echo "</tr>";
							}
							echo "</table>";
							?>
						</td>
						<td>
							<?php
							echo "<table>";
							echo "<tr>";
	  						echo "<td>";
							echo $row3['name'];
							echo "</td>";
	  						echo "</tr>";
							while($row3 = mysql_fetch_array($result3)) {
								echo "<tr>";
	  							echo "<td>";
								echo $row3['name'];
								echo "</td>";
	  							echo "</tr>";
							}
							echo "</table>";
							?>
						</td>
						<td>
							<?php
							echo "<table>";
							echo "<tr>";
	  						echo "<td>";
							echo $row5['term_type'];
							echo "</td>";
	  						echo "</tr>";
							while($row5 = mysql_fetch_array($result5)) {
								echo "<tr>";
	  							echo "<td>";
								echo $row5['term_type'];
								echo "</td>";
	  							echo "</tr>";
							}
							echo "</table>";
							?>
						</td>
					</tr>
				</table>
					<br>
					<br>
				<table align="center" border="4" cellspacing="5" width="85%">
					<tr align="center">
						<td width="50%" colspan="4"><b><u><?php echo $gene2 ?></u></b></td>
					</tr>
					<tr>
						<td width="10%" valign="top"><b>GO Term</b></td>
						<td width="60%" valign="top"><b>Term Name</b></td>
						<td width="15%" valign="top"><b>Term Type</b></td>
					</tr>
					<tr>
						<td>
							<?php
							echo "<table>";
							echo "<tr>";
	  						echo "<td>";
							echo $row2['acc'];
							echo "</td>";
	  						echo "</tr>";
							while($row2 = mysql_fetch_array($result2)) {
								echo "<tr>";
		  						echo "<td>";
								echo $row2['acc'];
		  						echo "</td>";
		  						echo "</tr>";
							}
							echo "</table>";
							?>
						</td>
						<td>
							<?php
							echo "<table>";
							echo "<tr>";
	  						echo "<td>";
							echo $row4['name'];
							echo "</td>";
	  						echo "</tr>";
							while($row4 = mysql_fetch_array($result4)) {
								echo "<tr>";
	  							echo "<td>";
								echo $row4['name'];
								echo "</td>";
	  							echo "</tr>";
							}
							echo "</table>";
							?>
						</td>
						<td>
							<?php
							echo "<table>";
							echo "<tr>";
	  						echo "<td>";
							echo $row6['term_type'];
							echo "</td>";
	  						echo "</tr>";
							while($row6 = mysql_fetch_array($result6)) {
								echo "<tr>";
	  							echo "<td>";
								echo $row6['term_type'];
								echo "</td>";
	  							echo "</tr>";
							}
							echo "</table>";
							?>
						</td>
					</tr>
				</table><br><br>
				
				
				<div class="bottomFrame">
				</div>
				
				<div class="footer">
					Copyright © 2009 Jenny Gow
				</div>
				
			</div>
		</body>
</html>	