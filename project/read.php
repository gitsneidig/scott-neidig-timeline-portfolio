<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 
// include database and object files
include_once '../config/database_portfolio.php';
include_once '../objects/project.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$project = new Project($db);
 
// query products
$stmt = $project->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // projects array
    $projects_arr=array();
    $projects_arr["timeline"]=array();
    $projects_arr["timeline"]["headline"] = "Scott Neidig&#39;s Web Development Porfolio";
    $projects_arr["timeline"]["type"] = "default";
    $projects_arr["timeline"]["text"] = "View: Timeline";
    $projects_arr["timeline"]["startDate"] = "2012,1,26";

    $project_arr=array();

 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $project_item=array(
	    "headline" => $headline,
            "text" => $text,
            "tag" => $tag,
            "asset" => array("media" => $asset),
            "startDate" => $start_date,
            "endDate" => $end_date
        );
 
        array_push($project_arr, $project_item);
    }


    $footer_arr = array(
        "headline" => "Scott Neidig&#39;s Web Development Porfolio",
	"type" => "default",
	"text" => "View: Timeline<br><br>Scroll horizontally to the left to view past projects sequentially in reverse.<br>Use the timeline navigator below to jump from project to project or focus on specific categories.",
	"startDate" => "2019,3,9",
	"date" => "[]"	
    );

    array_push($project_arr, $footer_arr);

 
    $projects_arr["timeline"]["date"] = $project_arr;

    echo json_encode($projects_arr);
}
 
else{
    echo json_encode(
        array("message" => "No projects found.")
    );
}







?>

