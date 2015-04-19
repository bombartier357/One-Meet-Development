<?php
set_time_limit(25000);
// Connect to server and select databse.
$con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }		

$state_array = array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY');
$specialty = 'Internal Medicine';
$sub_specialty = 'Not Specified';

foreach($state_array as $state){
	$node_count = 1;
	$node_end = 0;
	while($node_count < 500 && $node_end == 0){
		$html = file_get_contents('http://www.e-physician.info/inc/display.php?state='.$state.'&dename=doctors-physicians-internal-medicine&city=&name=&sortby=i&start='.$node_count); //get the html returned from the following url

		$pokemon_doc = new DOMDocument();

		libxml_use_internal_errors(TRUE); //disable libxml errors

		if(!empty($html)){ //if any html is actually returned

		  $pokemon_doc->loadHTML($html);
		  libxml_clear_errors(); //remove errors for yucky html
		  
		  $pokemon_xpath = new DOMXPath($pokemon_doc);

		  //get all the h2's with an id
		  $pokemon_row = $pokemon_xpath->query('//td');

		  $i = 0;
		  
		  if($pokemon_row->length > 0){
			  foreach($pokemon_row as $row){
				  if($i > 5 && $row->nodeValue != ''){
					
					if($i % 5 == 1){
						//echo "Name:";
						$name = $row->nodeValue;
					}elseif($i % 5 == 2){
						//echo "Address:";
						$address = $row->nodeValue;
					}elseif($i % 5 == 3){
						//echo "Phone:";
						$phone = $row->nodeValue;
					}elseif($i % 5 == 4){
						//echo "Tax:";
						$tax = $row->nodeValue;
					}elseif($i % 5 == 0){
						//echo "NPI:";
						$npi = $row->nodeValue;
					}
					  
					//echo $row->nodeValue."<br/>";
					
					if($i % 5 == 0){
						//echo "</br>";
						
						$check = $con->prepare("SELECT * FROM directory_schema WHERE npi = ?");
						$check->bindValue(1, $npi, PDO::PARAM_STR);
						$check->execute();
						$check_count = $check->rowCount();
						
						if($check_count == 0){
							$result = $con->prepare("INSERT INTO directory_schema SET name = ?, address = ?, phone = ?, state = ?, taxonomy = ?, npi = ?, specialty = ?, sub_specialty = ?");
							$result->bindValue(1, $name, PDO::PARAM_STR);
							$result->bindValue(2, $address, PDO::PARAM_STR);
							$result->bindValue(3, $phone, PDO::PARAM_STR);
							$result->bindValue(4, $state, PDO::PARAM_STR);
							$result->bindValue(5, $tax, PDO::PARAM_STR);
							$result->bindValue(6, $npi, PDO::PARAM_STR);
							$result->bindValue(7, $specialty, PDO::PARAM_STR);
							$result->bindValue(8, $sub_specialty, PDO::PARAM_STR);
							$result->execute();
						}else{
							$row = $check->fetch(PDO::FETCH_ASSOC);
							if($row['sub_specialty'] == 'Not Specified' && $sub_specialty != 'Not Specified'){
								$update = $con->prepare("UPDATE directory_schema SET sub_specialty = ? WHERE npi = ?");
								$update->bindValue(1, $sub_specialty, PDO::PARAM_STR);
								$update->bindValue(2, $npi, PDO::PARAM_STR);
								$update->execute();
							}
						}
					}
				  }
				  
				  
				  
				  $i++;
			  }
		  }
		}
		if (preg_match("/Next/i", $row->nodeValue)) {
			$node_count = $node_count + 100;
		}else{
			$node_end = 1;
		}
	}
}
?>
