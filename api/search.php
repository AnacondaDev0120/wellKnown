<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 11/13/21
 * Time: 10:15 AM
 */
header('Content-Type: application/json; charset=utf-8');

include "../includes/parse-config.php";
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseFile;
use Parse\ParseObject;
$response = array();

function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1->getCreatedAt()->format('Y-m-d H:i:s'));
    $datetime2 = strtotime($element2->getCreatedAt()->format('Y-m-d H:i:s'));
    return $datetime2 - $datetime1;
}


if(isset($_GET["qq"])){
    $SearchKeyWord = $_GET["qq"];

    $query = new Parse\ParseQuery("Buzz");
    $query->includeKey("userPointer");
    $query->matches("postBody",  ".*".strtolower($SearchKeyWord).".*", "i");
    if($LoggedInUser != null){
        $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
        $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
    }
    //$skip = $_POST["SKIP-COUNT"];
    // $query->skip($skip);
    $query->limit(100);
    $stories = $query->find();

    $query2 = new Parse\ParseQuery("_User");
    $query2->descending("createdAt");
    $query2->matches("username",  ".*".strtolower($SearchKeyWord).".*", "i");
    // $query2->skip($skip);
    $query2->limit(100);
    $users = $query2->find(true);


    $Everything = array_merge($users, $stories);
    usort($Everything, 'date_compare');
    $response["total_count"] = sizeof($Everything);
    $response["incomplete_results"] = false;
    $response["items"] = array();

    foreach($Everything as $story){
        switch ($story->getClassName()){
            case "_User":
                array_push($response["items"], array("type"=> "user", "id" => $story->getObjectId(), "avatar" => ($story->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("avatar")), "username" => $story->get("username") ));
                // array_push($response["items"], "<div class=\"commonLink mt-2 full-width\"> <div class=\"imageContents \"> <img style='border-radius: 50%; width: 50px; height: 50px; object-fit: cover;' src=\"".."\"><div style=\"width: 75%;padding-top: 10px;padding-left: 10px;\">".."</div><button style=\"height: 35px; float: right\" class=\"btn btn-primary\" onclick=\"window.location='".SITE_URL."profile/".$story->get("username")."'\">View Profile</button></div></div>");
                break;
            default:
                array_push($response["items"], array("type"=> "story", "id" => $story->getObjectId(), "postBody" => $story->get("postBody"), "avatar" => ($story->get("userPointer")->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("userPointer")->get("avatar")), "username" => $story->get("userPointer")->get("username"), "cover" => $story->get("coverImage")->getURL(), "time" => get_time_ago($story->getCreatedAt()) ));
                //array_push($response["items"], "<div class=\"borderBoxBody\" style=\"padding: 0; min-height: 25vh; background-position: center;background-size: cover;border-radius: 1em; margin:0; background-image: url('".$story->get("coverImage")->getURL()."');\"><div style=\"width: 100%; height: 100%; min-height: 25vh; padding: 1em; background: #00000070; border-radius: 1em; display: flex;\"><div class=\"col-8\"><h1 class=\"mainHeading GtSuper whiteText\" style=\" margin-top: 10px;font-size: 1.9rem\">".$story->get("postBody")."</h1><div class=\"whiteText mt-2 mb-2\">Posted: ".get_time_ago($story->getCreatedAt())."</div><div class=\"whiteText mt-2 mb-2\" style=\"text-decoration: none\"><span>Told By: <img style=\"object-fit: cover; border-radius: 50%; width: 30px; height: 30px;\" src=\"".($story->get("userPointer")->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("userPointer")->get("avatar"))."\"></span> <p class=\"ml-3\" style=\" display:inline\">".$story->get("userPointer")->get("username")."</p></div></div></div></div>");
                break;
        }

    }

}else if(isset($_GET["q"])){
    $SearchKeyWord = $_GET["q"];

    $query = new Parse\ParseQuery("Buzz");
    $query->includeKey("userPointer");
    $query->matches("postBody",  ".*".strtolower($SearchKeyWord).".*", "i");
    if($LoggedInUser != null){
        $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
        $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
    }
    //$skip = $_POST["SKIP-COUNT"];
   // $query->skip($skip);
    $query->limit(100);
    $stories = $query->find();

    $query2 = new Parse\ParseQuery("_User");
    $query2->descending("createdAt");
    $query2->matches("username",  ".*".strtolower($SearchKeyWord).".*", "i");
   // $query2->skip($skip);
    $query2->limit(100);
    $users = $query2->find(true);


    $Everything = array_merge($users, $stories);
    usort($Everything, 'date_compare');
    $response["total_count"] = sizeof($Everything);
    $response["incomplete_results"] = false;
    $response["items"] = "";

    $Users = "";
    $Stories = "";

    foreach($Everything as $story){
        switch ($story->getClassName()){
            case "_User":
                $response["items"] .= "<div class=\"commonLink mt-2 full-width\">
                                                        <div class=\"imageContents \">
                                                            <img style='border-radius: 50%; width: 50px; height: 50px; object-fit: cover;' src=\"".($story->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("avatar"))."\">
                                                            <div style=\"width: 75%;padding-top: 10px;padding-left: 10px;\">".$story->get("username")."</div>
                                                            <button style=\"height: 35px; float: right\" class=\"btn btn-primary\" onclick=\"window.location='".SITE_URL."profile/".$story->get("username")."'\">View Profile</button>
                                                        </div>
                                                    </div>";
                break;
            default:
                $response["items"] .= GetStoriesHtml($story);
                break;
        }
    }
}
echo json_encode($response, JSON_PRETTY_PRINT);


?>