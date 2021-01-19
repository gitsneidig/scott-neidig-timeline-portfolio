<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database_portfolio.php';
 
// instantiate product object
include_once '../objects/project.php';
 
$database = new Database();
$db = $database->getConnection();
 
$project = new Project($db);
 

$projects_insert_arr=array();

// JSON for initial data insert
$string=file_get_contents("../json/portfolio-timeline.json");
$json=json_decode($string, true);


foreach ($json as $key => $jsons) {
    foreach($jsons as $key => $value) {
  
        // set project property values
	if ($key == 'headline') {
		$project->headline = $value;
	}
	if ($key == 'text') {
            $project->text = $value;
        }
	if ($key == 'tag') {
	    $project->tag = $value;
        }
	if ($key == 'asset') {
	  $project->asset = $value['media'];
        }
	if ($key == 'startDate') { 
	    $project->start_date = $value;
	}
	if ($key == 'endDate') {
            $project->end_date = $value;
     	} 
  
    }

    // create project
    if($project->create()){
        echo '{';
        echo '"message": "Project was created."';
    	echo '}';

	$project->headline = null;
	$project->text = null;
	$project->tag = null;
	$project->asset = null;
	$project->start_date = null;
	$project->end_date = null;
    }
  
    // if unable to create the project, tell the user
    else {
    	echo '{';
        echo '"message": "Unable to create project."';
    	echo '}';
    }

}	



?>
