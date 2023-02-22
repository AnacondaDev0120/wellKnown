<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-21
 * Time: 11:20
 */
include "../includes/parse-config.php";
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseFile;
use Parse\ParseObject;
$response = array();
$response["success"] = 0;
$response["message"] = "Unknown request: 404!";

if(isset($_POST["PROVIDER"]) && isset($_POST["PHONE"]) && isset($_POST["ID"])){
    if($_POST["PROVIDER"] == "PHONE"){
        $query = new ParseQuery("_User");
        $query->equalTo("phoneNumber", str_replace("+", "", $_POST["PHONE"]));
        $isUser = $query->first();
        if($isUser != null){
            try{
                $LoggedInUser = ParseUser::logIn($isUser->get("username"), $_POST["ID"]);
                $response["message"] = "Old Account!";
                $response["success"] = 1;
            }catch (Exception $ex){
                $response["message"] = $ex->getMessage();
            }
        }else{
            $user = new ParseUser();
            $username = "user".generateRandomNumber(10);
            $user->set("username", $username);
            $user->set("password", $_POST["ID"]);
            $user->set("email", $username."@fablefrog.com");
            $user->set("phoneNumber", $_POST["PHONE"]);
            try {
                $user->signUp();
                $LoggedInUser = ParseUser::logIn($user->get("username"), $_POST["ID"]);
                $response["success"] = 1;
                // Hooray! Let them use the app now.
            } catch (ParseException $ex) {
                // Show the error message somewhere and let the user try again.
                $response["message"] = "Error: " . $ex->getCode() . " " . $ex->getMessage();
            }
        }
    }
}
else if(isset($_POST["PROVIDER"]) && isset($_POST["EMAIL"])&& isset($_POST["FULL-NAME"]) && isset($_POST["ID"])){
    if($_POST["PROVIDER"] == "GOOGLE"){
        $query = new ParseQuery("_User");
        $query->equalTo("email", str_replace("+", "", $_POST["EMAIL"]));
        $isUser = $query->first();
        if($isUser != null){
            try{
                $LoggedInUser = ParseUser::logIn($isUser->get("username"), $_POST["ID"]);
                $response["message"] = "Old Account!";
                $response["success"] = 1;
            }catch (Exception $ex){
                $response["message"] = $ex->getMessage();
            }
        }else{
            $user = new ParseUser();
            $user->set("username", "user".generateRandomNumber(10));
            $user->set("password", $_POST["ID"]);
            $user->set("email", $_POST["EMAIL"]);
            try {
                $user->signUp();
                $LoggedInUser = ParseUser::logIn($user->get("username"), $_POST["ID"]);
                $response["success"] = 1;
                // Hooray! Let them use the app now.
            } catch (ParseException $ex) {
                // Show the error message somewhere and let the user try again.
                $response["message"] = "Error: " . $ex->getCode() . " " . $ex->getMessage();
            }

            //$response["message"] = "New Account!";
        }
    }
}
else if(isset($_POST["WHICH"])){
    $response["message"] = "Kindly login to continue";

    if($LoggedInUser != null){

         switch ($_POST["WHICH"]){
             case "TRACK-USER":
                 if(isset($_POST["USER"])){
                     $query= new \Parse\ParseQuery("Followings");
                     $query->equalTo("Follower", $LoggedInUser);
                     $query->equalTo("Followed", ParseObject::create("_User", $_POST["USER"], true));
                     $FollowObject = $query->first();
                     if($FollowObject == null){
                         //Not Following
                         $response["isSubscribed"] = true;
                         $FollowObject = new ParseObject("Followings");
                         $FollowObject->set("Follower", $LoggedInUser);
                         $FollowObject->set("Followed", ParseObject::create("_User", $_POST["USER"], true));
                         $FollowObject->save();
                     }else{
                         //Already Following
                         $response["isSubscribed"] = false;
                         $FollowObject->destroy();
                     }
                     $response["success"] = 1;
                     //
                 }
                 break;
             case "SUBSCRIBE-TOPIC":
                 if(isset($_POST["TOPIC"])){
                     $query = new \Parse\ParseQuery("BuzzSubTopics");
                     $query->equalTo("objectId", $_POST["TOPIC"]);
                     $Topic = $query->first(true);
                     if($Topic != null){
                         $FollowedBy = $Topic->get("FollowedBy");
                         if($FollowedBy == null){
                             $FollowedBy = array();
                         }
                         if(in_array($LoggedInUser->getObjectId(), $FollowedBy)){
                             //Remove Subscription
                             $FollowedBy = array_diff($FollowedBy, array($LoggedInUser->getObjectId()));
                             $response["isSubscribed"] = false;
                         }else{
                             //Add To Subscribed
                             $response["isSubscribed"] = true;
                             array_push($FollowedBy, $LoggedInUser->getObjectId());
                         }
                         $response["Subscribers"] = number_shorten(sizeof($FollowedBy), 2);
                         $Topic->setArray("FollowedBy", $FollowedBy);
                         $Topic->save();
                         $response["success"] = 1;
                     }else{
                         $response["message"] = "Unknown topic";
                     }
                     //
                 }
                 break;
             case "UPDATE-PROFILE":
                 if(isset($_POST["userName"])){
                     $LoggedInUser->set("username", $_POST["userName"]);
                     $LoggedInUser->set("fullName", $_POST["fullName"]);
                     $LoggedInUser->set("userBio", $_POST["userBio"]);
                     $LoggedInUser->set("fbLink", $_POST["fbLink"]);
                     $LoggedInUser->set("twitterLink", $_POST["twitterLink"]);
                     $LoggedInUser->set("instaLink", $_POST["instaLink"]);
                     $LoggedInUser->set("linkedinLink", $_POST["linkedinLink"]);
                     $LoggedInUser->save();
                     $response["success"] = 1;
                     $response["message"] = "Profile updated successfully!";
                 }
                 break;
             case "UPLOAD-COVER":
                 if(!empty($_FILES["UserCover"]["name"])){
                     $ext2 = pathinfo($_FILES['UserCover']['name'], PATHINFO_EXTENSION);
                     $d1 = new Datetime();
                     $FileName  = $d1->format('U')."_cover.".$ext2;
                     if(move_uploaded_file($_FILES['UserCover']['tmp_name'], 'TempData/' . $FileName)){
                         $CoverFile = ParseFile::createFromFile('TempData/' . $FileName, "cover.".$ext2);
                         $CoverFile->save();
                         $LoggedInUser->set("CoverImage", $CoverFile);
                         unlink("TempData/".$FileName);
                         unset($image);
                     }
                     $LoggedInUser->save();
                     $response["success"] = 1;
                     $response["message"] = "Cover photo has been changed.";
                 }
                 break;
             case "UPLOAD-PROFILE":
                 if(!empty($_FILES["ProfileImage"]["name"])){
                     $ext2 = pathinfo($_FILES['ProfileImage']['name'], PATHINFO_EXTENSION);
                     $d1 = new Datetime();
                     $FileName  = $d1->format('U')."_avatar.".$ext2;
                     if(move_uploaded_file($_FILES['ProfileImage']['tmp_name'], 'TempData/' . $FileName)){
                         $CoverFile = ParseFile::createFromFile('TempData/' . $FileName, "avatar.".$ext2);
                         $CoverFile->save();
                         $LoggedInUser->set("avatar", $CoverFile->getURL());
                         unlink("TempData/".$FileName);
                         unset($image);
                     }
                     $LoggedInUser->save();
                     $response["success"] = 1;
                     $response["message"] = "Profile picture has been changed.";
                 }
                 break;
         }
    }

}else if(isset($_POST["LOGOUT"])){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    try{
        session_destroy();
        $response = array();
        $response["success"] = 1;
    }catch (Exception $exception){
        $response["success"] = 0;
        $response["message"] = $exception;
    }

    echo json_encode($response);

}
echo json_encode($response);
?>