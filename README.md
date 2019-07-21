# Gene Similarity Measurement
This is a web based system that measures the similarity between genes. 

The system uses a database which is available from the Gene Ontology consortium website.
This database contains annotations of genes and gene products to terms in the Gene Ontology.
The system is also based on a similarity method that was created by Anurag Nagar and Hisham Al-Mubaid. 
This method measures similarity by calculating the path length (distance) between the two gene products or GO terms.
<br><br>
For this project there is going to be two separate similarity methods.
The first method will measure the similarity between gene ontology terms and the second method will measure the similarity between gene products.
<br>

# Similarity by Path Length (distance)
After researching the different ways of measuring the similarity betweens genes, it has been decided that path length between GO terms will be used to calculate the similarity for the purposed system. The method was designed by Anurag Nagar and Hisham Al-Mubaid. The smaller the path length (distance) is, then the more similar the two genes are.
<br>

# Similarity between Gene Products
<img src="/screenshots/writeup1.png"/>
<img src="/screenshots/writeup2.png"/>
<img src="/screenshots/writeup3.png"/>
<img src="/screenshots/writeup4.png"/>
<img src="/screenshots/writeup5.png"/>
<br>

# Implementation of the Database
There are several databases available from Gene Ontology website. For this system the association database (assocdb) was used. This database contains both the GO vocabulary and associations between GO terms and gene products. The information contained in this database will help to measure the similarity between genes. 
<br>

<div align="center">
    <img src="/screenshots/image8.jpg" width="600"/>
</div>

<br>
The assocdb database contains many tables but the main tables that will be used for this system are:
<ul>
  <li>Association (id, term_id, gene_product_id, is_not, role_group)
  <li>Gene_product (id, symbol, dbxref_id, species_id, full_name)
  <li>Gene_product_count (term_id, code, speciesdnname, product_count)
  <li>Graph_path (term1_id, term2_id, distance)
  <li>Term (id, name, term_type, acc, is_obsolete, is_root)
  <li>Term2term (relationship_type_id, term1_id, term2_id)
  <li>Term_dbxref (term_id, dbxref_id, is_for_definition)
  <li>Term_definition (term_id, term_definition, dbxref_id, term_comment, reference)
  <li>Term_synonym (term_id, term_synonym, acc_synonym)
</ul>
<br>

# Implementation of GO Terms Similarity Method
Path length (distance) is being used to measure the similarity between GO terms, so distance was looked up in the database. Distance was found in the graph_path table along with term1_id and term2_id. Therefore term1_id is set to the value that is read in from goterm1. Term2_id is then set to the value that is read in from goterm2. Once term1_id and term2_id have been set the distance between the two terms can then been found.
<br><br>
Now that the distance has been found between the two terms, the actual similarity can be worked out. This is done by using the following equation: Sim (GOx , GOy) = e − f *PL(GOx,GOy).
<br>

```php
// Finds term id’s for the inputted GO terms
$query7="SELECT term1_id FROM graph_path, term WHERE graph_path.term1_id=term.id AND acc = '$goterm1'";
$query8="SELECT term2_id FROM graph_path, term WHERE graph_path.term1_id=term.id AND acc = '$goterm2'";
$result7=mysql_query($query7) or die(mysql_error());
$result8=mysql_query($query8) or die(mysql_error());
$row7= mysql_fetch_assoc($result7);
$row8= mysql_fetch_assoc($result8);

// Find distance between the two terms
$query9="SELECT distance FROM graph_path WHERE term1_id = '$row7[term1_id]' AND term2_id = '$row8[term2_id]'";
$result9=mysql_query($query9) or die(mysql_error());
$row9 = mysql_fetch_assoc($result9);				
$distance = $row9['distance'];
				
// Similarity between the two terms
$similarity1 = exp((-0.20) * $distance);
$similarity2 = round($similarity1, 2);
```

<div align="center">
  <img src="/screenshots/image2.png" width="600"/> &nbsp
  <img src="/screenshots/image3.png" width="600"/>
</div>
<br>

# Implementation of Gene Products Similarity Method
Path length (distance) was also used to measure the similarity between gene products. However finding the path length between gene products is just not as easy as finding the path length between GO terms. However each gene product has a set of GO terms associated with it and these terms can be used to find the path length. 
<br><br>
In order to find the average path length (distance) following equation can be used:
<img src="/screenshots/writeup6.png"/>
<br>

```php
// Gets associated term ID’s for gene product 1
$query7=SELECT id FROM term
JOIN association ON association.term_id = term.id
JOIN gene_product ON association.gene_product_id = gene_product.id
WHERE symbol='$gene1'";

// Gets associated term ID’s for gene product 2
$query8=SELECT id FROM term
JOIN association ON association.term_id = term.id
JOIN gene_product ON association.gene_product_id = gene_product.id
WHERE symbol='$gene2'";
```

```php
// Put results from gene product 1 into array 1
$result7=mysql_query($query7) or die(mysql_error());
while ($row7 = mysql_fetch_array($result7)) {
$array1[] = $row7['term_id'];
}

// Put results from gene product 2 into array 2
$result8=mysql_query($query8) or die(mysql_error());
while ($row8 = mysql_fetch_array($result8)) {
$array2[] = $row8['term_id'];
}
```
<br>
Now that the GO terms id’s have been found, the distance between the two sets of GO terms can be found. The best way to find the distance between the two GO term sets is to take the first GO term from array 1 ($array1[]) and execute the distance query between it and all the GO terms in array 2 ($array2[]). The results from this are stored in a third array ($array3[]).  After the distance query has been executed for term 1 in array 1 and all the terms in array 3, the system then moves on and does the same for the rest of the GO terms in array 1. 
<br>
It does this by using two ‘foreach’ loops. The first ‘foreach’ loop is used to go through the values in array 1. The second ‘foreach’ loop is inside the first loop and is used to go through the values in array 2. Inside the second loop is the distance query where the results are stored into array 3.
<br>

```php
foreach ($array1 as $a) {
foreach ($array2 as $b) {
$query_distance = "SELECT distance FROM graph_path WHERE term1_id = '".$a."' AND term2_id = '".$b."'";
        		$result_distance = mysql_query($query_distance) or die(mysql_error());
        		while ($row_distance = mysql_fetch_array($result_distance)) {
            			$array3[] = $row_distance['distance'];
        		}
    	}
}
```

<br>
Now that the path length has been found between all the GO terms associated with gene product 1 and all the GO terms associated with gene product 2, the average path length needs to be calculated. This is done by adding up all the path lengths (distances) that are stored in array 3 and dividing that by the number of actual values in array 3. PHP has built in functions for finding the sum of number in an array. This function is called array_sum(). PHP also have a built in function for find out the number of values in an array. This function is called sizeof(). 
With the used of these two functions the average path length can now be calculated. The average path length will also be rounded to two decimal places, to keep the values displayed short. 
<br>

```php
// Find the sum of the values in array 3
$sum = array_sum($array3);
				
// Find the size of array 3
$size = sizeof($array3);
				
// Find the average distance of the values in array 3
$average = ($sum / $size);
$distance = round($average, 2);
```

<br>
Now that the average path length (distance) has been found between the two gene products, the actual similarity can be worked out. This is done by using the following equation: Sim (Gp , Gq) = e –f * PL (Gp, Gq)
<br>

```php
// Similarity between the two terms
$similarity1 = exp((-0.20) * $distance);
$similarity2 = round($similarity1, 2);
```

<br>
<div align="center">
  <img src="/screenshots/image5.png" width="600"/> &nbsp
  <img src="/screenshots/image6.png" width="600"/>
</div>
