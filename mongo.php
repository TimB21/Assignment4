<?php

require_once 'vendor/autoload.php';
require_once('formModel.lib');
require_once('inputTags.lib');

//use Exception; // In the global namespace, so this is not needed
use MongoDB\Client;
use MongoDB\Driver\ServerApi;

// Steps of aggregation pipeline
$steps = array();
$steps[] = "match";
$steps[] = "project";
$steps[] = "group";
$steps[] = "sort";

// Will represent a MQL query
$query = array();

?>
<CENTER>
<?=buildFormStart('queryform','mongo.php')?>

<TABLE>
<?php
foreach($steps as $step) {
	// Retrieve previously submitted query data
	$query[$step] = empty($_REQUEST[$step]) ? NULL : $_REQUEST[$step];
	echo '<TR><TD align="right">';
	echo '$'.$step;
	echo "</TD><TD>";
	echo buildText($step,empty($query[$step]) ? "" : htmlentities($query[$step]),55,2048);
	echo "</TD></TR>";
}
?>
</TABLE>

<?=buildSubmit('submit','Submit Query')?>
<?=buildFormEnd()?>
</CENTER>
<?php

// Connection string for my MongoDB database
$uri = "mongodb+srv://student:SUstudent_in_DatabaseFall2023@schrumsu.tbf3xyo.mongodb.net/?retryWrites=true&w=majority";

if(!empty($query)) {

	// Specify Stable API version 1
	$apiVersion = new ServerApi(ServerApi::V1);

	// Create a new client and connect to the server
	$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

	// Select the database and collection
	$database = $client->selectDatabase("sample_airbnb");
	$collection = $database->selectCollection("listingsAndReviews");

	// Contains all queries within the aggregation pipeline
	$pipeline = array();

	foreach($steps as $step) {

		if(!empty($query[$step])) {
			// The user has to enter validly formatted JSON queries for the decode to work
			$decoded = json_decode($query[$step], true);
			echo '<BR><BR>$'.$step.':<BR>';
			var_dump($decoded); // For debugging
			$pipeline[] = ['$'.$step => $decoded];
		}
	}

	echo '<BR><BR>Full Pipeline</BR>';
	var_dump($pipeline); // For debugging

	if(!empty($pipeline)) {
		// Send query to MongoDB
		$queryResult = $collection->aggregate($pipeline);

		$divNum = 0;
		// Display the results
		foreach ($queryResult as $document) {
			// The JavaScript code neatly displays the JSON objects using the renderjson.js library
?>

	<div id="test<?= $divNum ?>"></div>
	<HR>
	<script type="text/javascript" src="renderjson.js"></script>
	<script>
	var example = <?= json_encode($document) ?>;

	renderjson.set_show_to_level(1);
	document.getElementById("<?= "test".$divNum ?>").appendChild(renderjson(example));
	</script>

<?php
			$divNum++;
		}
	}
}
?>


