<?php 
// This application is to collect English sentences source from internet web.(especially Gutenberg)
// Step 1 : collect
// Step 2 : save
// Step 3 : Show the result
// 
// Load XML file
$xml = new DOMDocument;
$xml->load('memo.xml');

// Load XSL file
$xsl = new DOMDocument;
$xsl->load('memo.xsl');

// Configure the transformer
$proc = new XSLTProcessor;

// Attach the xsl rules
$proc->importStyleSheet($xsl);

// Set parameter for xsl transform
$proc->setParameter('', 'modified', "Modifying");

// The result
echo $proc->transformToXML($xml);
source_collecting($_POST["url"]);

/*************
This application is to collect source from websites.
Before collecting, it check up the URL if it is already collected.
Big logic : check if the URL is marked in "pickup_list.txt" file.

  if not, it registers the URL in "pickup_list.txt" and collect the contents.
derived from web_contents.
***********/
function source_collecting($url){
	// FIRST PART   
	// If the URL is marked in "pickup_list", the program exit.
	// check the URL in "pickup_list.txt"
	// Mark up chceck : Before collecting the source, you should check up the url if it is already collected.	
	$mark_up = ""; 								// for each URL marked in "pickup_list.txt".
	$mark_ups = file_get_contents("../s_collecting_p/pickup_list.txt");
	$count = 0; 								// for file length.
	$delimiter = ""; 							// for checking if the character is ","
	while ($count != strlen($mark_ups)) {
		$delimiter = substr($mark_ups, $count, 1);
		if ($delimiter == ",") {
			if ($url == $mark_up) {
				echo "The URL already exist..";
				echo "The program stopped normally";
				exit(0);
			}
			$mark_up = "";						
		}
		else{
			$mark_up .= $delimiter;
		}
		$count++;
	}	

	// SECOND PART
	//if not the URL marked, it registers the URL in "pickup_list.txt" and collect the contents.
	$source = file_get_contents($url);
	
	if($source){
		//mark up the URL into the "pickup_list.txt" file adding it.
		$pick_up = fopen("../s_collecting_p/pickup_list.txt", "a");
		fputs($pick_up, $url.",");
		fclose($pick_up);
		echo "A new URL marked into pickup_list.txt : ".$url." ; ";

		// Collect the contents in a new file.
		$time = time();
		file_put_contents("../s_collecting_p/guten/web".$time.".txt", $source);
		echo $url." : is collected";
	}
}	