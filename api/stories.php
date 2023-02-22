<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-21
 * Time: 12:00
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', '*');
header('Access-Control-Allow-Headers', 'api-key,content-type');
header('Access-Control-Allow-Credentials', true);
include "../includes/parse-config.php";

include "../api/google-vision/autoload.php";
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Likelihood;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseFile;
use Parse\ParseObject;

putenv("GOOGLE_APPLICATION_CREDENTIALS=../wequestion-indexing-8f5b8584342f.json");

$response = array();
$response["success"] = 0;
$response["message"] = "Unknown request: 404!";

function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1->getCreatedAt()->format('Y-m-d H:i:s'));
    $datetime2 = strtotime($element2->getCreatedAt()->format('Y-m-d H:i:s'));
    return $datetime2 - $datetime1;
}

if(isset($_POST["Name"]) && isset($_POST["Email"]) &&  isset($_POST["Message"])){
    $Name = $_POST["Name"];
    $Email = $_POST["Email"];
    $Message = $_POST["Message"];
    //contact@fablefrog.com

    require_once "PHPMailer/SendEmail.php";
    $SendEmail = new SendEmail();
    $SendEmail->setFrom("no-reply@fablefrog.com");
    $SendEmail->setFromName("FableFrog");
    $SendEmail->setRecipientName("Scott Leong");
    $SendEmail->setReplyTo("no-reply@fablefrog.pk");
    $SendEmail->setReplyToName("FableFrog Robot");
    $SendEmail->setRecipientEmail("fablefrog99999@gmail.com");
    $SendEmail->setSubject("Enquiry from Website {$Email}");
    $EmailData = file_get_contents("common.html");
    $EmailData = str_replace("COMMON_MESSAGE", $Name." ({$Email}) sent you a message \"{$Message}\".", $EmailData);
    $SendEmail->setBody($EmailData);
    $Results = $SendEmail->SendEmailNow2();
    $response["email"] = $Results;



}else if(isset($_POST["WHAT"])){
    switch ($_POST["WHAT"]){

        case "GET-SUB-TOPICS":
            if(isset($_POST["TOPIC-ID"])){
                $response["message"] = "";
                $query = new ParseQuery("BuzzSubTopics");
                $query->equalTo("TopicPointer", ParseObject::create("BuzzTopics", $_POST["TOPIC-ID"], true));
                $query->descending("createdAt");
                $query->limit(500);
                $topics = $query->find();
                foreach ($topics as $topic){
                    $response["success"]  = 1;
                    $response["message"] .= "<a href=\"javascript:;\" class=\"chip postSubTopics\" data-object=\"".$topic->getObjectId()."\" data-name=\"".$topic->get("Title")."\">
                                            <i class=\"fas fa-check mr-2\"></i> ".$topic->get("Title")."
                                        </a>";
                }
            }
            break;
        case "REPORT-FABLE":
            if(isset($_POST["STORY"])){
                $StoryObject = ParseObject::create("Buzz", $_POST["STORY"]);
                $StoryObject->fetch();
                if($StoryObject != null){
                    if($LoggedInUser != null){
                        $reportedBy = $StoryObject->get("reportedBy");
                        if($reportedBy == null){
                            $reportedBy = array();
                        }
                        if(!in_array($LoggedInUser->getObjectId(), $reportedBy)){
                            $response["message"] = "Fable reported successfully!";
                            array_push($reportedBy, $LoggedInUser->getObjectId());
                            $StoryObject->setArray("reportedBy", $reportedBy);
                            $StoryObject->save();
                            $response["isReported"] = true;
                            $response["success"] = 1;
                        }else{
                            $response["isReported"] = false;
                            $reportedBy = array_diff($reportedBy, array($LoggedInUser->getObjectId()));
                            array_push($reportedBy, $LoggedInUser->getObjectId());
                            $StoryObject->setArray("reportedBy", $reportedBy);
                            $StoryObject->save();
                            $response["success"] = 1;
                            $response["message"] = "Fable unreported successfully!";
                        }
                    }else{
                        $response["message"] = "Kindly login to report fables";
                    }

                }
            }
            break;
        case "DELETE-FABLE":
            if(isset($_POST["STORY"])){
                $StoryObject = ParseObject::create("Buzz", $_POST["STORY"]);
                $StoryObject->fetch();
                if($StoryObject != null){
                    if($LoggedInUser != null){
                        $FableUser = $StoryObject->get("userPointer");
                        $FableUser->fetch();
                        if($FableUser->getObjectId() == $LoggedInUser->getObjectId()){
                            $response["message"] = "Fable successfully deleted!";
                            $StoryObject->destroy();
                            $response["success"] = 1;
                        }
                    }else{
                        $response["message"] = "Kindly login to delete fable.";
                    }
                }else{
                    $response["message"] = "Fable not found.";
                }
            }
            break;
        case "STORE-PLAY-COUNT":
            if(isset($_POST["STORY"])){
                $StoryObject = ParseObject::create("Buzz", $_POST["STORY"]);
                $StoryObject->fetch();
                if($StoryObject != null){
                    $playedByCount = $StoryObject->get("playedByCount");
                    if($playedByCount == null ){
                        $playedByCount = 0;
                    }
                    $playedByCount += 1;
                    $StoryObject->set("playedByCount", $playedByCount);
                    $StoryObject->save();
                }
            }
            break;
        case "STORE-STORY":
            //cUQIVOpDX1

            if($LoggedInUser == null){
                $LoggedInUser = ParseUser::create("_User", "cUQIVOpDX1");
                $LoggedInUser->fetch(true);
            }

            if(isset($_POST["FableTitle"])
                && isset($_POST["TOPICS-IDS"])
                && isset($_POST["INTERESTS"])
                && isset($_POST["TOPICS"])
                && isset($_POST["INTERESTS-IDS"])
                && !empty($_FILES["AUDIO"]["name"])
            ){

                $FableObject = new ParseObject("Buzz");
                $FableObject->setArray("likedBy", array());
                $FableObject->set("userPointer", $LoggedInUser);
                $FableObject->set("ContentType", 3);
                $FableObject->setArray("playedBy", array());
                $FableObject->setArray("buzzTopicsIds",  explode(",", $_POST["TOPICS-IDS"]));
                $FableObject->setArray("buzzInterestsIds",  explode(",", $_POST["INTERESTS-IDS"]));
                $FableObject->setArray("buzzInterests",  explode(",", $_POST["INTERESTS"]));
                $FableObject->setArray("buzzTopics", explode(",", $_POST["TOPICS"]));
                $FableObject->setArray("reportedBy", array());
                $FableObject->setArray("blockedBy", array());
                $FableObject->set("postBody", $_POST["FableTitle"]);



                $isImageUploaded = false;
                $FileName = "";
                if(!empty($_FILES["CoverImage"]["name"])){
                    $ext = pathinfo($_FILES['CoverImage']['name'], PATHINFO_EXTENSION);
                    $d1 = new Datetime();
                    $FileName  = $d1->format('U')."_FEATURED.".$ext;
                    if(move_uploaded_file($_FILES['CoverImage']['tmp_name'], 'TempData/' . $FileName)){
                        $isImageUploaded = true;
                    }
                }else {
                    $url = $_POST["COVER-IMAGE-URL"];
                    $path_info = pathinfo($url);
                    $ext = $path_info['extension'];
                    $d1 = new Datetime();
                    $FileName  = $d1->format('U')."_FEATURED.".$ext;
                    if(file_put_contents('TempData/' .$FileName, file_get_contents($url."?auto=compress&fit=crop&h=512&w=900"))){
                        $isImageUploaded = true;
                    }
                }





                try{
                    if($isImageUploaded){
                        try{
                            $imageAnnotator = new ImageAnnotatorClient();
                            $image = file_get_contents('TempData/' . $FileName);
                            $responseGoogle = $imageAnnotator->safeSearchDetection($image);
                            $safe = $responseGoogle->getSafeSearchAnnotation();
                            $adult = $safe->getAdult();
                            $medical = $safe->getMedical();
                            $likelihoodName = [
                                'UNKNOWN',
                                'VERY_UNLIKELY',
                                'UNLIKELY',
                                'POSSIBLE',
                                'LIKELY',
                                'VERY_LIKELY'
                            ];
                            //printf('Adult: '.$likelihoodName[$adult]);
                            /*
                                $spoof = $safe->getSpoof();
                                $violence = $safe->getViolence();
                                $racy = $safe->getRacy();
                            */
                            # names of likelihood from google.cloud.vision.enums

                            if($likelihoodName[$adult] == "POSSIBLE" || $likelihoodName[$adult] == "LIKELY" || $likelihoodName[$adult] == "VERY_LIKELY"){
                                $response["success"] = 0;
                                $response["message"] = "The image you have selected is ".$likelihoodName[$adult]." to be an adult image, kindly try again later!";
                            }else{
                                $FeaturedImage = ParseFile::createFromFile('TempData/' . $FileName, "cover.".$ext);
                                $FeaturedImage->save();
                                $FableObject->set("coverImage", $FeaturedImage);

                                $ext2 = pathinfo($_FILES['AUDIO']['name'], PATHINFO_EXTENSION);
                                $d1 = new Datetime();
                                $FileNameAudio  = $d1->format('U')."_AUDIO.".$ext2;
                                if(move_uploaded_file($_FILES['AUDIO']['tmp_name'], 'TempData/' . $FileNameAudio)){
                                    $AudioFile = ParseFile::createFromFile('TempData/' . $FileNameAudio, "recorder.".$ext2);
                                    $AudioFile->save();
                                    $FableObject->set("audioFile", $AudioFile);
                                    unlink("TempData/".$FileNameAudio);
                                }


                                $FableObject->save();
                                $response["success"] = 1;
                                $pushMessage = "{$_POST["FableTitle"]} was produced successfully!";
                                sendPushNotification($pushMessage, $LoggedInUser, "NEW-FABLE", $FableObject);
                                unlink("TempData/".$FileName);
                            }
                            $imageAnnotator->close();
                        }catch (Exception $exception){
                            $response["message"] = $exception->getMessage();
                        }
                    }else{
                        $FableObject->save();
                        $response["success"] = 1;
                        $pushMessage = "<a href='".SITE_URL."?id=".$FableObject->getObjectId()."'>{$_POST["FableTitle"]} was produced successfully!</a>";
                        sendPushNotification($pushMessage, $LoggedInUser, "NEW-FABLE");
                    }

                }catch (Exception $exception){
                    $response["message"] = $exception->getMessage();
                }
            }

            break;

        case "EDIT-STORY":
            if($LoggedInUser != null){
                if(isset($_POST["EDIT-FABLE-ID"])
                    && isset($_POST["TOPICS-IDS"])
                    && isset($_POST["INTERESTS"])
                    && isset($_POST["TOPICS"])
                    && isset($_POST["INTERESTS-IDS"])
                ){

                    $query = new ParseQuery("Buzz");
                    $query->equalTo("userPointer", $LoggedInUser);
                    $query->equalTo("objectId", $_POST["EDIT-FABLE-ID"]);
                    $FableObject = $query->first();
                    if($FableObject != null){
                        $FableObject->set("userPointer", $LoggedInUser);
                        $FableObject->setArray("buzzTopicsIds",  explode(",", $_POST["TOPICS-IDS"]));
                        $FableObject->setArray("buzzInterestsIds",  explode(",", $_POST["INTERESTS-IDS"]));
                        $FableObject->setArray("buzzInterests",  explode(",", $_POST["INTERESTS"]));
                        $FableObject->setArray("buzzTopics", explode(",", $_POST["TOPICS"]));
                        $FableObject->save();
                        $response["success"] = 1;

                    }

                }
            }else{
                $response["message"] = "Kindly login again to post fables!";
            }


            break;

        case "POST-COMMENT":
            if($LoggedInUser != null) {
                if(isset($_POST["FABLE-ID"]) && isset($_POST["AUDIO-DURATION"])
                    && !empty($_FILES["AUDIO"]["name"])
                ){
                    $StoryObject = ParseObject::create("Buzz", $_POST["FABLE-ID"]);
                    $StoryObject->fetch();
                    if($StoryObject != null){
                        $FableObject = new \Parse\ParseObject("BuzzComments");
                        $FableObject->set("BuzzPointer", $StoryObject);
                        $FableObject->set("CommentUserPointer", $LoggedInUser);
                        $FableObject->set("ContentType", 3);
                        $hoursminsandsecs = date('H:i:s',$seconds);
                        $FableObject->set("AudioLength", $hoursminsandsecs);
                        $ext2 = pathinfo($_FILES['AUDIO']['name'], PATHINFO_EXTENSION);
                        $d1 = new Datetime();
                        $FileName  = $d1->format('U')."_AUDIO.".$ext2;
                        if(move_uploaded_file($_FILES['AUDIO']['tmp_name'], 'TempData/' . $FileName)){
                            $AudioFile = ParseFile::createFromFile('TempData/' . $FileName, "recorder.".$ext2);
                            $AudioFile->save();
                            $FableObject->set("audioFile", $AudioFile);
                            unlink("TempData/".$FileName);
                            unset($image);
                        }
                        try{
                            $FableObject->save();
                            $Owner = $StoryObject->get("userPointer");
                            $Owner->fetch();
                            $pushMessage =  "<a href='".SITE_URL."?id=".$StoryObject->getObjectId()."' >".$Owner->get("username")." left an audio comment on your fable {$StoryObject->get("postBody")}!</a>";
                            sendPushNotification($pushMessage, $Owner, "NEW-COMMENT");

                            $response["commentsCount"] = ($StoryObject->get("commentsCount") +1);
                            $StoryObject->set("commentsCount", ($StoryObject->get("commentsCount") +1));
                            $StoryObject->save();
                            $query = new ParseQuery("BuzzComments");
                            $query->equalTo("BuzzPointer", ParseObject::create("Buzz", $_POST["FABLE-ID"]));
                            $query->limit(200);
                            $query->includeKey("CommentUserPointer");
                            $query->descending("createdAt");
                            $comments = $query->find();
                            if($comments != null){
                                $response["message"] = "<hr/>";
                                foreach ($comments as $comment){
                                    $response["message"] .= '<div class="borderBoxFooter" style="display: flex">
                                                        <img style="width: 50px; height: 40px; border-radius: 50%; object-fit: cover" src="'.($comment->get("CommentUserPointer")->get("avatar") != null ? $comment->get("CommentUserPointer")->get("avatar"): SITE_URL."img/dummy.jpg").'">
                               
                                                        <div class="ml-2" style="border-radius: 10px;height: 5px;width: 100%;margin-right: -10px;">
                                                            <p class="GtSuper" style="margin-top: -15px; font-size: 11px;">'.$comment->get("CommentUserPointer")->get("username").'</p>
                                                            <p style="margin-top: 4px;font-size: 11px;float: right;margin-right: 3%;">'.get_time_ago($comment->getCreatedAt()).'</p>
                                                        </div>
                                                        <div>
                                                            <div class="btn-play-small auto-margin" style="flex-shrink: 0; display: flex; justify-content: center;  align-items: center;">
                                                                <a class="'.$comment->getObjectId().'Btn" data-is-playing="false" href="javascript:;" style="cursor: pointer" onclick="StartPlaying(\''.$comment->get("audioFile")->getURL().'\', \'https://parsefiles.back4app.com/JDHDpDyXmZHpD6jKwVj3Ld2L6LcgZtKBzvQ3VaqM/1628ad58cb10a5fe030cab8d767dbd81_cover.png\', \''.$comment->get("CommentUserPointer")->get("username").'\', \'Comment Posted\', \''.$comment->getObjectId().'\')"><i class="fas fa-play auto-margin '.$comment->getObjectId().'Loader" style="color: white; flex-shrink: 0;"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>';
                                }

                            }else{
                                $response["message"] = "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>Comments not found</h2><p class='mainText col-12'>Be the 1st to leave an audio comment.</p></div>";
                            }
                            $response["success"] = 1;

                            $response["message"] .= "<div class=\"mt-2 midContents\" style=\"padding: 0; width: 100%; min-width: 100%\">
                                                <div class=\"borderBox\" style=\"width: 100%; border: 0; padding: 0; margin-bottom: 0;\">
                                                    <div class=\"borderBoxTextArea\" >
                                                        <div class=\"borderBoxFooter\">
                                                            <div class=\"commentSide\">
                                                                Press the mic icon to start recording...
                                                            </div>
                                                            <div>
                                                                <span class=\"counterText\" onclick=\"PostComment('".$_POST["STORY"]."')\"> <i class=\"fas fa-microphone\" style=\"font-size: 25px\"></i> </span>
                                                                <span class=\"counterText\"> <i class=\"fas fa-paper-plane\" style=\"display: none; font-size: 25px\"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                        }catch (Exception $x){
                            $response["message"] = $x->getMessage();
                        }


                    }else{
                        $response["message"] = "Fable not found!";
                    }

                }
            }else{
                $response["message"] = "Kindly login again to post fables!";
            }


            break;

        case "POST-VOICE":
            if($LoggedInUser != null) {
                if( isset($_POST["AUDIO-DURATION"])
                    && !empty($_FILES["AUDIO"]["name"])
                ){
                    $hoursminsandsecs = date('H:i:s',$seconds);
                    $LoggedInUser->set("AudioLength", $hoursminsandsecs);
                    $ext2 = pathinfo($_FILES['AUDIO']['name'], PATHINFO_EXTENSION);
                    $d1 = new Datetime();
                    $FileName  = $d1->format('U')."_AUDIO.".$ext2;
                    if(move_uploaded_file($_FILES['AUDIO']['tmp_name'], 'TempData/' . $FileName)){
                        $AudioFile = ParseFile::createFromFile('TempData/' . $FileName, "recorder.".$ext2);
                        $AudioFile->save();
                        $LoggedInUser->set("introFile", $AudioFile);
                        unlink("TempData/".$FileName);
                    }
                    try{
                        $LoggedInUser->save();
                        $response["success"] = 1;
                    }catch (Exception $x){
                        $response["message"] = $x->getMessage();
                    }
                }
            }else{
                $response["message"] = "Kindly login again to post fables!";
            }


            break;

        case "GET-COMMENTS":
            if(isset($_POST["STORY"])){
                $query = new ParseQuery("BuzzComments");
                $query->equalTo("BuzzPointer", ParseObject::create("Buzz", $_POST["STORY"]));
                $query->limit(200);
                $query->includeKey("CommentUserPointer");
                $query->descending("createdAt");
                $comments = $query->find();
                if($comments != null){
                    $response["message"] = "<hr/>";
                    $a = 1;
                    foreach ($comments as $comment){
                        $response["message"] .= '<div class="borderBoxFooter col-12" style="display: flex;justify-content: flex-'.($a % 2 == 0 ? "end": "start").';width: 100%;">
                                                        <img onclick="window.location=\''.SITE_URL.'profile/'.$comment->get("CommentUserPointer")->get("username").'\'" style="cursor: pointer; width: 50px; height: 50px; border-radius: 50%; object-fit: cover" src="'.($comment->get("CommentUserPointer")->get("avatar") != null ? $comment->get("CommentUserPointer")->get("avatar"): SITE_URL."img/dummy.jpg").'">
                                                        <div class="ml-3" style="display: flex;">
                                                            <div style=" display:inline;">
                                                            <p class="GtSuper" style="cursor: pointer; margin-top: 3px; font-size: 11px;"  onclick="window.location=\''.SITE_URL.'profile/'.$comment->get("CommentUserPointer")->get("username").'\'">'.$comment->get("CommentUserPointer")->get("username").'</p>
                                                            <p style="margin-top: 4px;font-size: 11px;">'.get_time_ago($comment->getCreatedAt()).'</p>
                                                         </div>
                                                         <div class="ml-3" style=" display:inline; ">
                                                            <div class="btn-play-small auto-margin" style="flex-shrink: 0; display: flex; justify-content: center;  align-items: center; cursor: pointer"  onclick="StartPlaying(\''.$comment->get("audioFile")->getURL().'\', \''.($comment->get("CommentUserPointer")->get("avatar") != null ? $comment->get("CommentUserPointer")->get("avatar"): SITE_URL."img/dummy.jpg").'\', \''.$comment->get("CommentUserPointer")->get("username").'\', \'Comment Posted\', \''.$comment->getObjectId().'\')">
                                                                <a class="'.$comment->getObjectId().'Btn" data-is-playing="false" href="javascript:;" ><i class="fas fa-play auto-margin '.$comment->getObjectId().'Loader" style="color: white; flex-shrink: 0;"></i></a>
                                                            </div>
                                                        </div>
                                                            </div>
                                                        
                                                    </div>';
                        $a++;
                    }

                }else{
                    $response["message"] = "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>Comments not found</h2><p class='mainText col-12'>Be the 1st to leave an audio comment.</p></div>";
                }
                $response["success"] = 1;

                $response["message"] .= "<div class=\"mt-2 midContents\" style=\"padding: 0; width: 100%; min-width: 100%\">
                <div class=\"borderBox\" style=\"width: 100%; border: 0; padding: 0; margin-bottom: 0;\">
                    <div class=\"borderBoxTextArea\" >
                        <div class=\"borderBoxFooter\">
                            <div class=\"commentSide\">
                                Press the mic icon to start recording...
                            </div>
                            <div>
                                <span style='cursor: pointer' class=\"counterText\" onclick=\"PostComment('".$_POST["STORY"]."')\"> <i class=\"fas fa-microphone\" style=\"font-size: 25px\"></i> </span>
                                <span class=\"counterText\"> <i class=\"fas fa-paper-plane\" style=\"display: none; font-size: 25px\"></i></span>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            break;

        case "LIKE":
            if($LoggedInUser != null) {
                if(isset($_POST["STORY"])){
                    $query = new ParseQuery("Buzz");
                    $query->equalTo("objectId", $_POST["STORY"]);
                    $story = $query->first();
                    if($story != null){
                        $likedBy = $story->get("likedBy");
                        if($likedBy == null){
                            $likedBy = array();
                        }
                        if(in_array($LoggedInUser->getObjectId(), $likedBy)){
                            $likedBy = array_diff($likedBy, array($LoggedInUser->getObjectId()));
                            $response["isLiked"] = "NO";
                        }else{
                            $response["isLiked"] = "YES";
                            array_push($likedBy, $LoggedInUser->getObjectId());
                        }
                        $response["likesCount"] = sizeof($likedBy);

                        $story->setArray("likedBy", $likedBy);
                        $story->save();
                        $response["success"] = 1;
                    }else{
                        $response["message"] = "Fable not found: 404!";

                    }
                }
            }else{
                $response["message"] = "Kindly login again to post fables!";
            }

            break;

        case "GET-TOPICS-STORIES":
            if(isset($_POST["TOPIC"])){
                $response["stories"] = "";
                $query = new Parse\ParseQuery("Buzz");
                $query->includeKey("userPointer");
                if(isset($_POST["TYPE"])){
                    switch ($_POST["TYPE"]){
                        case "TOP":
                            $query->descending("playedByCount");
                            break;
                        default:
                            $query->descending("createdAt");
                            break;
                    }
                }
                $query->containedIn("buzzTopicsIds", array($_POST["TOPIC"]));
                if($LoggedInUser != null){
                    $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                    $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                }
                $skip = 0;
                if(isset($_POST["SKIP"])){
                    $skip = $_POST["SKIP"];
                }
                $query->skip($skip);
                $query->limit(LOAD_LIMIT);
                $stories = $query->find();
                foreach ($stories as $story){
                    $response["success"] = 1;

                    $response["stories"] .= GetStoriesHtml($story);

                }
                if(sizeof($stories) >= LOAD_LIMIT ){
                    $response["moreData"] = true;
                }else{
                    $response["moreData"] = false;
                    $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                }
            }

            break;

        case "SEARCH":
            if(isset($_POST["QUERY"]) && isset($_POST["SKIP-COUNT"])){
                $SearchKeyWord = $_POST["QUERY"];
                $response["stories"] = "";

                $query = new Parse\ParseQuery("Buzz");
                $query->includeKey("userPointer");
                $query->matches("postBody",  ".*".strtolower($SearchKeyWord).".*", "i");
                if($LoggedInUser != null){
                    $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                    $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                }
                $skip = $_POST["SKIP-COUNT"];
                $query->skip($skip);
                $query->limit(LOAD_LIMIT);
                $stories = $query->find();

                $query2 = new Parse\ParseQuery("_User");
                $query2->descending("createdAt");
                $query2->matches("username",  ".*".strtolower($SearchKeyWord).".*", "i");
                $query2->skip($skip);
                $query2->limit(LOAD_LIMIT);
                $users = $query2->find(true);


                $Everything = array_merge($users, $stories);
                usort($Everything, 'date_compare');


                foreach($Everything as $story){
                    switch ($story->getClassName()){
                        case "_User":
                            $response["stories"] .= "<div class=\"commonLink mt-2 full-width\">
                                                        <div class=\"imageContents \">
                                                            <img style='border-radius: 50%; width: 50px; height: 50px; object-fit: cover;' src=\"".($story->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("avatar"))."\">
                                                            <div style=\"width: 75%;padding-top: 10px;padding-left: 10px;\">".$story->get("username")."</div>
                                                            <button style=\"height: 35px; float: right\" class=\"btn btn-primary\" onclick=\"window.location='".SITE_URL."profile/".$story->get("username")."'\">View Profile</button>
                                                        </div>
                                                    </div>";
                            break;
                        default:
                            $response["stories"] .= GetStoriesHtml($story);
                            break;
                    }
                    $response["success"] = 1;

                }

                if(sizeof($stories) >= LOAD_LIMIT ){
                    $response["moreData"] = true;
                }else{
                    $response["moreData"] = false;
                    $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                }
            }

            /*
             *
             */
            break;

        case "GET-HOME-STORIES":
            $response["stories"] = "";

            $TYPE = "ALL";
            if(isset($_POST["TYPE"])){
                $TYPE = $_POST["TYPE"];
            }

            switch ($TYPE){
                case "TRACK":
                    $queryFollowers = new ParseQuery("Followings");
                    $queryFollowers->includeKey("Follower");
                    $queryFollowers->includeKey("Followed");
                    $queryFollowers->equalTo("Follower", $LoggedInUser);
                    $queryFollowers->limit(200);
                    $Followed = $queryFollowers->find();
                    $response["moreData"] = false;
                    $response["FollowedCount"] = sizeof($Followed);
                    $AllStories = array();
                    if(sizeof($Followed) > 0 ) {
                        foreach ($Followed as $followed) {
                            $query = new Parse\ParseQuery("Buzz");
                            $query->includeKey("userPointer");
                            $query->descending("createdAt");
                            $query->equalTo("userPointer", $followed->get("Followed"));

                            if ($LoggedInUser != null) {
                                $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                                $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                            }
                            $skip = 0;
                            if (isset($_POST["SKIP"])) {
                                $skip = $_POST["SKIP"];
                            }
                            $query->skip($skip);
                            $query->limit(LOAD_LIMIT);
                            $stories = $query->find();

                            $AllStories = array_merge($AllStories, $stories);

                        }
                        foreach ($stories as $story) {
                            $response["stories"] .= GetStoriesHtml($story);
                        }
                        $response["success"] = 1;
                        usort($AllStories, 'date_compare');

                        if (sizeof($AllStories) >= LOAD_LIMIT) {
                            $response["moreData"] = true;
                        } else {
                            $response["moreData"] = false;
                            $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                        }
                    }else{
                        $response["moreData"] = false;
                        $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>Add Fablers to Your List</h2><p class='mainText col-12'>Try again later</p></div>";
                    }
                    break;
                default:
                    $query = new Parse\ParseQuery("Buzz");
                    $query->includeKey("userPointer");
                    $query->descending("playedByCount");
                    if($LoggedInUser != null){
                        $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                        $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                    }
                    $skip = 0;
                    if(isset($_POST["SKIP"])){
                        $skip = $_POST["SKIP"];
                    }
                    $query->skip($skip);
                    $query->limit(LOAD_LIMIT);
                    $stories = $query->find();

                    $response["storiesCount"] = sizeof($stories);
                    $response["success"] = 1;

                    foreach ($stories as $story){
                        $response["stories"] .= GetStoriesHtml($story);

                    }
                    if(sizeof($stories) >= LOAD_LIMIT ){
                        $response["moreData"] = true;
                    }else{
                        $response["moreData"] = false;
                        $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                    }
                    break;
            }
            break;


        case "GET-USER-STORIES":
            if(isset($_POST["USER"])){
                $response["stories"] = "";
                $query = new Parse\ParseQuery("Buzz");
                $query->includeKey("userPointer");
                $query->descending("createdAt");
                $query->equalTo("userPointer", ParseObject::create("_User", $_POST["USER"], true));

                if($LoggedInUser != null){
                    $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                    $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                }
                $skip = 0;
                if(isset($_POST["SKIP"])){
                    $skip = $_POST["SKIP"];
                }
                $query->skip($skip);
                $query->limit(LOAD_LIMIT);
                $stories = $query->find();

                $response["storiesCount"] = sizeof($stories);
                $response["success"] = 1;

                foreach ($stories as $story){
                    $response["stories"] .= GetStoriesHtml($story);

                }
                if(sizeof($stories) >= LOAD_LIMIT ){
                    $response["moreData"] = true;
                }else{
                    $response["moreData"] = false;
                    if($LoggedInUser != null){
                        if($LoggedInUser->getObjectId() == $_POST["USER"]){
                            $response["stories"] .= "<div class='row topInterests text-center' style='background-color: #817cfe; padding: 20px; cursor:pointer;' onclick='OpenRecordModal()'><h2 class='col-12 subHeading' style='color: white'>".(sizeof($stories) == 0 ? "Add Your First Fable":"Add a Fable")."</h2><p class='mainText col-12' style=' color: white;'>".(sizeof($stories) == 0 ? "Click here to add your first fable":"Click here to add a new fable")."</p></div>";
                        }else{
                            $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                        }
                    }else{
                        $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                    }
                }
            }

            break;

        case "GET-INTEREST-STORIES":
            if(isset($_POST["INTEREST"])){
                $response["stories"] = "";
                $query = new Parse\ParseQuery("Buzz");
                $query->includeKey("userPointer");
                $query->descending("playedByCount");
                if($_POST["INTEREST"] != ""){
                    $query->containedIn("buzzInterestsIds", array($_POST["INTEREST"]));
                }

                if($LoggedInUser != null){
                    $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                    $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                }
                $skip = 0;
                if(isset($_POST["SKIP"])){
                    $skip = $_POST["SKIP"];
                }
                $query->skip($skip);
                $query->limit(LOAD_LIMIT);
                $stories = $query->find();

                $response["storiesCount"] = sizeof($stories);
                $response["success"] = 1;

                foreach ($stories as $story){
                    $response["stories"] .= GetStoriesHtml($story);

                }
                if(sizeof($stories) >= LOAD_LIMIT ){
                    $response["moreData"] = true;
                }else{
                    $response["moreData"] = false;
                    $response["stories"] .= "<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No More Fables Found</h2><p class='mainText col-12'>Try again later</p></div>";
                }
            }

            break;
    }
}
echo json_encode($response);