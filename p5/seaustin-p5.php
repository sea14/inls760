<?php
	//initializing
	$input = "";

	//gpc quotes check
	if(get_magic_quotes_gpc()){

		//magic quotes is on...sanitize, but don't do anything else
		$input = htmlentities(strip_tags($_GET['text']));

	}else{

		//magic quotes isn't on, addslashes
		$input = addSlashes(htmlentities(strip_tags($_GET['text'])));

	}

	//array of words to check against
	$words = array("prevent", "present", "president", "prevalent", "accumulate",
			"actual");

	//look up words
	if(strlen($input) > 0){
	
		$suggested = "";


		//for loop to examine input and check it against our "dictionary"
		for($i=0; $i<count($words); $i++){
				
			if(strtolower($input)==strtolower(substr($words[$i],0,strlen($input)))){

				if($suggested==""){
				
					$suggested=$words[$i];
				}else{
					
					$suggested=$suggested."\n".$words[$i];
					
				}
			}	

		}

	}
	if($suggested == ""){

		$response="Sorry, that isn't on the list!";
		
	}else{
		$response = $suggested."\n";
	}	
	
		echo $response;
		
?>
