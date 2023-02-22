<?php
date_default_timezone_set('America/New_York');
require_once "parse-php-sdk/autoload.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
//session_destroy();
use Parse\ParseClient;
use Parse\ParseException;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseSessionStorage;
$LoggedInUser = null;
$SESSION_LOGGED_IN = "IS_LOGGED_IN";
try{
   // ParseClient::initialize( $AppID, $RestKey, $MasterKey );
    ParseClient::initialize( "JDHDpDyXmZHpD6jKwVj3Ld2L6LcgZtKBzvQ3VaqM", "ErkujXhFnlMan0Urqh0kR4DW18ksKZTk5bT9L610", "8JxU98ziuWU22FQRm2EY7ZgL1hPbTsNXxUBJHj7g" );
    ParseClient::setServerURL('https://parseapi.back4app.com', '/');

    $storage = new ParseSessionStorage();
    ParseClient::setStorage( $storage );
     if(ParseUser::getCurrentUser() != null){
       $LoggedInUser = ParseUser::getCurrentUser();
        $LoggedInUser->fetch();
    }
}catch (Exception $x) {
    echo "Parse Error ".$x->getMessage();
}

if(!defined('IMAGES_PATH')){
    define("IMAGES_PATH", "https://app.fablefrog.com/img/");      // 8 Minutes
}
if(!defined('LOAD_LIMIT')){
    define("LOAD_LIMIT", 5);      // 8 Minutes
}
if(!defined('SITE_URL')){
    define("SITE_URL", "https://app.fablefrog.com/");      // 8 Minutes
}
if(!function_exists('getYoutubeIdFromUrl')){
    function getYoutubeIdFromUrl($url) {
        $parts = parse_url($url);
        if(isset($parts['query'])){
            parse_str($parts['query'], $qs);
            if(isset($qs['v'])){
                return $qs['v'];
            }else if(isset($qs['vi'])){
                return $qs['vi'];
            }
        }
        if(isset($parts['path'])){
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path)-1];
        }
        return false;
    }
}
if(!function_exists('number_shorten')) {
    // Shortens a number and attaches K, M, B, etc. accordingly
    function number_shorten($number, $precision = 2, $divisors = null)
    {
        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = array(
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'K', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            );
        }
        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }
        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        if($number <= 1000){
            return $number;
        }
        return number_format($number / $divisor, $precision) . $shorthand;
    }
}
if(!function_exists('getSmallProfileHexagon')) {
    function getSmallProfileHexagon($User, $isClickAble = true)
    {
        $Badges = 1;
        if($User->get("UserBadges") != null){
            $Badges = sizeof($User->get("UserBadges")) +1;
        }
        return ' 
                  <a class="user-avatar small no-outline" href="'.($isClickAble ? SITE_URL.'profile/'.$User->get("username") : "javascript:;").'">
                   
                    <div class="user-avatar-content">
                      
                      <div class="hexagon-image-30-32" data-src="'.$User->get("UserAvatar")->getURL().'"></div>
                     
                    </div>
                    <div class="user-avatar-progress">
                      
                      <div class="hexagon-progress-40-44"></div>
                    </div>
                    <div class="user-avatar-progress-border">
                      
                      <div class="hexagon-border-40-44" data-profile-strength=".'.$User->get("ProfileStrength").'"></div>
                    </div>
                
                    <div class="user-avatar-badge">
                      <div class="user-avatar-badge-border">
                        
                        <div class="hexagon-22-24"></div>
                      </div>
                      <div class="user-avatar-badge-content">
                        
                        <div class="hexagon-dark-16-18"></div>
                      </div>
                      <p class="user-avatar-badge-text">'.$Badges.'</p>
                    </div>
                  </a>';
    }
}
if(!function_exists('getLargeProfileHexagon')) {
    function getLargeProfileHexagon($User)
    {

    }
}
if(!function_exists('facebook_time_ago')) {
    function facebook_time_ago($time_ago)
    {

        $date = date_format($time_ago,"Y/m/d H:i:s");
        $current_time = time();
        $unix_date = strtotime($date);
        $time_difference = $current_time - $unix_date;
        $seconds = $time_difference;
        $minutes      = round($seconds / 60 );           // value 60 is seconds
        $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks          = round($seconds / 604800);          // 7*24*60*60;
        $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60

        if($seconds <= 60)
        {
            return "Just Now";
        }
        else if($minutes <=60)
        {
            if($minutes==1)
            {
                return "one minute ago";
            }
            else
            {
                return "$minutes minutes ago";
            }
        }
        else if($hours <=24)
        {
            if($hours==1)
            {
                return "an hour ago";
            }
            else
            {
                return "$hours hrs ago";
            }
        }
        else if($days <= 7)
        {
            if($days==1)
            {
                return "yesterday";
            }
            else
            {
                return "$days days ago";
            }
        }
        else if($weeks <= 4.3) //4.3 == 52/12
        {
            if($weeks==1)
            {
                return "a week ago";
            }
            else
            {
                return "$weeks weeks ago";
            }
        }
        else if($months <=12)
        {
            if($months==1)
            {
                return "a month ago";
            }
            else
            {
                return "$months months ago";
            }
        }
        else
        {
            if($years==1)
            {
                return "one year ago";
            }
            else
            {
                return "$years years ago";
            }
        }
    }
}

if(!function_exists('getMediumProfileHexagon')) {
    function getMediumProfileHexagon($User)
    {
        $Badges = 1;
        if($User->get("UserBadges") != null){
            $Badges = sizeof($User->get("UserBadges")) +1;
        }
        /*
         *  <div class="user-avatar-progress">

                                        <div class="hexagon-progress-100-110" data-profile-strength=".'.$User->get("ProfileStrength").'"></div>
                                    </div>
         */
        return '<a class="user-short-description-avatar user-short-description-avatar-mobile user-avatar medium" style="margin: auto" href="'.SITE_URL.'profile/'.$User->get("username").'">
                                    <div class="user-avatar-border">
                                        
                                        <div class="hexagon-120-132"></div>
                                    </div>

                                   
                                    <div class="user-avatar-content">
    
                                        <div class="hexagon-image-82-90" data-src="'.$User->get("UserAvatar")->getURL().'"></div>
                                    </div>
                                  
                                    <div class="user-avatar-progress-border">
                                        
                                        <div class="hexagon-border-100-110"></div>
                                    </div>
                                    <div class="user-avatar-badge">
                                        <div class="user-avatar-badge-border">
                                            
                                            <div class="hexagon-32-36"></div>
                                        </div>
                                        <div class="user-avatar-badge-content">
                                            
                                            <div class="hexagon-dark-26-28"></div>
                                        </div>
                                        <p class="user-avatar-badge-text">'.$User->get("ProfileStrength").'</p>
                                    </div>
                                </a>';
    }


}
if(!function_exists('getProfileHexaGon')) {
    function getProfileHexaGon($User)
    {
        $Badges = 1;
        if($User->get("UserBadges") != null){
            $Badges = sizeof($User->get("UserBadges")) +1;
        }
        /*
         *  <!-- USER AVATAR PROGRESS -->
      <div class="user-avatar-progress">
        <!-- HEXAGON -->
        <div class="hexagon-progress-40-44" data-profile-strength=".'.$User->get("ProfileStrength").'"></div>
        <!-- /HEXAGON -->
      </div>
      <!-- /USER AVATAR PROGRESS -->
         */
        return '<a class="user-avatar small no-outline online" href="javascript:;">
      <!-- USER AVATAR CONTENT -->
      <div class="user-avatar-content">
        <!-- HEXAGON -->
        <div class="hexagon-image-30-32" data-src="'.$User->get("UserAvatar")->getURL().'"></div>
        <!-- /HEXAGON -->
      </div>
      <!-- /USER AVATAR CONTENT -->
  
     
  
      <!-- USER AVATAR PROGRESS BORDER -->
      <div class="user-avatar-progress-border">
        <!-- HEXAGON -->
        <div class="hexagon-border-40-44"></div>
        <!-- /HEXAGON -->
      </div>
      <!-- /USER AVATAR PROGRESS BORDER -->
  
      <!-- USER AVATAR BADGE -->
      <div class="user-avatar-badge">
        <!-- USER AVATAR BADGE BORDER -->
        <div class="user-avatar-badge-border">
          <!-- HEXAGON -->
          <div class="hexagon-22-24"></div>
          <!-- /HEXAGON -->
        </div>
        <!-- /USER AVATAR BADGE BORDER -->
  
        <!-- USER AVATAR BADGE CONTENT -->
        <div class="user-avatar-badge-content">
          <!-- HEXAGON -->
          <div class="hexagon-dark-16-18"></div>
          <!-- /HEXAGON -->
        </div>
        <!-- /USER AVATAR BADGE CONTENT -->
  
        <!-- USER AVATAR BADGE TEXT -->
        <p class="user-avatar-badge-text">'.$User->get("ProfileStrength").'</p>
        <!-- /USER AVATAR BADGE TEXT -->
      </div>
      <!-- /USER AVATAR BADGE -->
    </a>';
    }


}
if(!function_exists('getForumHexagon')) {
    function getForumHexagon($User)
    {
        $Badges = 1;
        if($User->get("UserBadges") != null){
            $Badges = sizeof($User->get("UserBadges")) +1;
        }
        /*
         *  <!-- USER AVATAR PROGRESS -->
      <div class="user-avatar-progress">
        <!-- HEXAGON -->
        <div class="hexagon-progress-40-44" data-profile-strength=".'.$User->get("ProfileStrength").'"></div>
        <!-- /HEXAGON -->
      </div>
      <!-- /USER AVATAR PROGRESS -->
         */
        return ' <a class="user-avatar no-outline" href="'.SITE_URL.'profile/'.str_replace(" ", "-", $User->get("username")).'">
                  <!-- USER AVATAR CONTENT -->
                  <div class="user-avatar-content">
                    <!-- HEXAGON -->
                    <div class="hexagon-image-68-74" data-src="'.$User->get("UserAvatar")->getURL().'"></div>
                    <!-- /HEXAGON -->
                  </div>
                  <!-- /USER AVATAR CONTENT -->

                  <!-- USER AVATAR PROGRESS -->
                  <div class="user-avatar-progress">
                    <!-- HEXAGON -->
                    <div class="hexagon-progress-84-92"></div>
                    <!-- /HEXAGON -->
                  </div>
                  <!-- /USER AVATAR PROGRESS -->

                  <!-- USER AVATAR PROGRESS BORDER -->
                  <div class="user-avatar-progress-border">
                    <!-- HEXAGON -->
                    <div class="hexagon-border-84-92"></div>
                    <!-- /HEXAGON -->
                  </div>
                  <!-- /USER AVATAR PROGRESS BORDER -->

                  <!-- USER AVATAR BADGE -->
                  <div class="user-avatar-badge">
                    <!-- USER AVATAR BADGE BORDER -->
                    <div class="user-avatar-badge-border">
                      <!-- HEXAGON -->
                      <div class="hexagon-28-32"></div>
                      <!-- /HEXAGON -->
                    </div>
                    <!-- /USER AVATAR BADGE BORDER -->

                    <!-- USER AVATAR BADGE CONTENT -->
                    <div class="user-avatar-badge-content">
                      <!-- HEXAGON -->
                      <div class="hexagon-dark-22-24"></div>
                      <!-- /HEXAGON -->
                    </div>
                    <!-- /USER AVATAR BADGE CONTENT -->

                    <!-- USER AVATAR BADGE TEXT -->
                    <p class="user-avatar-badge-text">'.$Badges.'</p>
                    <!-- /USER AVATAR BADGE TEXT -->
                  </div>
                  <!-- /USER AVATAR BADGE -->
                </a>';
    }


}
if(!function_exists('get_time_ago')) {
    function get_time_ago($date_)
    {
        $date_->setTimezone(new DateTimeZone('America/New_York')); // +04
        $date = date_format($date_,"Y/m/d H:i:s");
        if (empty($date)) {
            return "No date provided";
        }
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        $now = time();
        $unix_date = strtotime($date);
        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }
        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }
        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j].= "s";
        }
        return "$difference $periods[$j] {$tense}";
    }
}
if(!function_exists('htmlToPlainText')) {
    function htmlToPlainText($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);

        return $str;
    }
}
if(!function_exists('clean')) {
    function clean($string) {
        $string = str_replace('!', '', $string); // Replaces all spaces with hyphens.
        $string = str_replace('/', '-', $string); // Replaces all spaces with hyphens.
        $string = str_replace('?', '.', $string); // Replaces all spaces with hyphens.
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
}
if(!function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

if(!function_exists('generateRandomStringCapital')) {

    function generateRandomStringCapital($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}

if(!function_exists('generateRandomNumber')) {
    function generateRandomNumber($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
if(!function_exists('getUserIpAddr2')) {
    function getUserIpAddr2(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
if(!function_exists('validateUrl')) {
    function validateUrl($url){
        if($url == "-" || $url == "-" || $url == "#" || $url == ""){
            return true;
        }
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
if(!function_exists('isValidUrl')) {
    function isValidUrl($url){
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
if(!function_exists('isMobile')) {
    function isMobile(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            return true;
        }
        return false;
    }

}
if(!function_exists('number_shorten')) {

// Shortens a number and attaches K, M, B, etc. accordingly
    function number_shorten($number, $precision = 3, $divisors = null)
    {

        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = array(
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'K', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            );
        }

        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }

        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        return number_format($number / $divisor, $precision) . $shorthand;
    }
}
if(!function_exists('getYoutubeIdFromUrl')) {

    function getYoutubeIdFromUrl($url)
    {
        $parts = parse_url($url);
        if (isset($parts['query'])) {
            parse_str($parts['query'], $qs);
            if (isset($qs['v'])) {
                return $qs['v'];
            } else if (isset($qs['vi'])) {
                return $qs['vi'];
            }
        }
        if (isset($parts['path'])) {
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path) - 1];
        }
        return false;
    }
}
if(!function_exists('saveNotification')) {

    function saveNotification($url, $message, $UserPointer)
    {
        $notification = new ParseObject("Notifications");
        $notification->set("UserPointer", $UserPointer);
        $notification->set("Message",$message);
        $notification->set("ClickAction",$url);
        $notification->save();
    }
}
if(!function_exists('sendPushNotification')) {

    function sendPushNotification($pushMessage, $user, $Type, $FablePointer = null)
    {
        $LoggedInUser = ParseUser::getCurrentUser();
        $notificationObject = new ParseObject("Notifications");
        $notificationObject->set("text", $pushMessage);
        $notificationObject->set("currUser", $LoggedInUser);
        $notificationObject->set("otherUser", $user);
        $notificationObject->set("pushType", $Type);
        $notificationObject->set("FablePointer", $FablePointer);
        $notificationObject->save();
    }
}
if(!function_exists('GetStoriesHtml')) {

    function GetStoriesHtml($story)
    {
        $tags = array();
        $tagsIds = array();
        $tags = $story->get("buzzTopics");
        $tagsIds = $story->get("buzzTopicsIds");
        if($tags == null){
            $tags = array();
            $tagsIds = array();
        }
        $Interests = array();
        $interestsIds = array();
        $Interests = $story->get("buzzInterests");
        $interestsIds = $story->get("buzzInterestsIds");
        if($Interests == null){
            $interestsIds = array();
            $Interests = array();
        }
        $likedBy = $story->get("likedBy");
        if($likedBy == null){
            $likedBy = array();
        }
        $DeleteHtml = "";
        $isLikedByMe = "NO";
        $ReportHtml = "<a href=\"javascript:;\" class=\"editProfileLink\" onclick=\"ReportFable('".$story->getObjectId()."')\"> <i class=\"fas fa-info-circle mr-2 ".$story->getObjectId()."ReportLoader\"></i> <span id='".$story->getObjectId()."ReportText'>Report</span> </a>";
        $LoggedInUser = ParseUser::getCurrentUser();
        if($LoggedInUser != null){

            $reportedBy = $story->get("reportedBy");
            if($reportedBy == null){
                $reportedBy = array();
            }
            if(in_array($LoggedInUser->getObjectId(), $reportedBy)){
                $ReportHtml = "<a href=\"javascript:;\" class=\"editProfileLink\" onclick=\"ReportFable('".$story->getObjectId()."')\"> <i class=\"fas fa-info-circle mr-2 ".$story->getObjectId()."ReportLoader\"></i> <span id='".$story->getObjectId()."ReportText'>UnReport</span> </a>";
            }
            if($LoggedInUser->getObjectId() == $story->get("userPointer")->getObjectId()){
                $DeleteHtml = "<a href=\"javascript:;\" class=\"editProfileLink\" onclick=\"DeleteFable('".$story->getObjectId()."')\"> <i class=\"fas fa-trash mr-2 ".$story->getObjectId()."DeleteLoader\"></i> Delete </a>";
            }
            if(in_array($LoggedInUser->getObjectId(),$likedBy)){
                $isLikedByMe = "YES";
            }
        }
        $TagsHTML = "";
        $tagsClean = $tags;
        $InterestsClean = $Interests;
        $xxx = 0;
        foreach ($tagsClean as $tag){
            $tagsClean[$xxx] = clean($tag);
            $xxx++;
        }
        $xxx = 0;

        foreach ($InterestsClean as $tag){
            $InterestsClean[$xxx] = clean($tag);
            $xxx++;
        }
        if(sizeof($tags) > 5){
            for ($x = 0 ; $x < 4 ; $x++){
                $TagsHTML .= "<a href='https://app.fablefrog.com/explore/".clean($tags[$x])."/".$tagsIds[$x]."' class=\"tooltipBtn small-tab selected-tab\" >".$tags[$x]."</a>";
            }
            $TagsHTML .= '<a href="javascript:;" onclick=\'OpenTags('.json_encode($tagsClean).', '.json_encode($tagsIds).')\' class="plusBtn small-tab disable-tab" >+'.(sizeof($tags) - 3).'</a>';
        }else{
            for ($x = 0 ; $x < sizeof($tags) ; $x++){
                $TagsHTML .= "<a href='https://app.fablefrog.com/explore/".clean($tags[$x])."/".$tagsIds[$x]."' class=\"tooltipBtn small-tab selected-tab\" >".$tags[$x]."</a>";

            }
        }
        $EditHtml = "";
        if($LoggedInUser != null){
            if($LoggedInUser->getObjectId() === $story->get("userPointer")->getObjectId()){
                $EditHtml = '<a href="javascript:;" class="editProfileLink" data-fable-id="'.$story->getObjectId().'" onclick=\'EditFable(this, '.json_encode($tagsClean).', '.json_encode($tagsIds).', '.json_encode($InterestsClean).', '.json_encode($interestsIds).')\'> <i class="fas fa-pencil-alt mr-2"></i> Edit </a>';
            }
        }

        $IntroHtml = "";

        if($story->get("userPointer")->get("introFile") != null){
            $IntroHtml = '<div class="ml-3" style=" display:inline-flex; ">
                                 <div class="btn-play-small auto-margin" style="flex-shrink: 0; display: flex; justify-content: center;  align-items: center; cursor: pointer"  onclick="StartPlaying(\''.$story->get("userPointer")->get("introFile")->getURL().'\', \''.($story->get("userPointer")->get("avatar") != null ? $story->get("userPointer")->get("avatar"): SITE_URL."img/dummy.jpg").'\', \''.$story->get("userPointer")->get("username").'\', \'Introduction\', \''.$story->get("userPointer")->getObjectId().'\')">
                                      <a class="'.$story->get("userPointer")->getObjectId().'Btn" data-is-playing="false" href="javascript:;" ><i class="fas fa-play auto-margin '.$story->get("userPointer")->getObjectId().'Loader" style="color: white; flex-shrink: 0;"></i></a>
                                 </div>
                           </div>';
        }


        return "<div class=\"borderBox Fable".$story->getObjectId()."\" style=\"padding: 0; border: 1px solid rgba(32, 35, 51, 0.09);\">
                        <div class=\"borderBoxBody storyContainerDiv\" style=\"margin:0; background-image: url('".$story->get("coverImage")->getURL()."'); padding: 0; \">
                            <div  class='storyContainerDiv' style=\"width: 100%; height: 100%;  padding: 1em; background: #00000070; border-radius: 1em; display: flex;\">
                                <div class=\"col-8\">
                                    <h1 class=\"mainHeading GtSuper whiteText mainTextTitle ".$story->getObjectId()."Title\" style=\"text-overflow: ellipsis; overflow: hidden; margin-top: 10px; text-align: left;\">".$story->get("postBody")."</h1>
                                    <div class=\"whiteText mt-2 mb-2\">Posted: ".get_time_ago($story->getCreatedAt())."</div>
                                    <a href=\"".SITE_URL."profile/".$story->get("userPointer")->get("username")."\"  class=\"whiteText mt-2 mb-2\" style='text-decoration: none'><span>Told By: <img style=\"object-fit: cover; border-radius: 50%; width: 30px; height: 30px;\" src=\"".($story->get("userPointer")->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("userPointer")->get("avatar"))."\"></span> <p class=\"ml-3\" style=' display:inline'>".$story->get("userPointer")->get("username")."</p></a>
                                     ".$IntroHtml."
                                     <br/>
                                    <div class='horizontalScroll'>".$TagsHTML."</div>
                                </div>
                                <div class=\"auto-margin col-4\" >
                                    <div style=\"float: right; margin-top: -35px\">
                                        <a class=\"mr-3\" onclick=\"HandleLike('".$story->getObjectId()."')\" href=\"javascript:;\" >
                                            <i class=\"far fa-heart\" style=\"font-size: 30px; color: ".($isLikedByMe == "YES" ? "red": "white")."\" id=\"".$story->getObjectId()."LikeIcon\" ></i>
                                            <br/>
                                            <span style=\"    margin-left: 11px;\" id=\"".$story->getObjectId()."Likes\" class=\"whiteText\">".number_shorten(sizeof($likedBy), 2)."</span>
                                        </a>
                                    </div>
                                    <div class=\"btn-play-large auto-margin\"  style=\"cursor: pointer\" onclick=\"StartPlaying('".$story->get("audioFile")->getURL()."', '".$story->get("coverImage")->getURL()."', '".$story->get("userPointer")->get("username")."', '".ucfirst(str_replace("-", " ", clean($story->get("postBody"))))."', '".$story->getObjectId()."')\">
                                        <a class=\"".$story->getObjectId()."Btn\" data-is-playing = \"false\" href=\"javascript:;\">
                                            <i class=\"play-icon fas fa-play auto-margin ".$story->getObjectId()."Loader\" ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"borderBoxTextArea\" style=\"    padding: 0 0.5em 1em 0.5em;\">
                            <div class=\"borderBoxFooter\">
                            <img style=\"object-fit: cover; border-radius: 50%; width: 30px; height: 30px;\" src=\"".($story->get("userPointer")->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("userPointer")->get("avatar"))."\">
                            
                                <div class=\"commentSide replyTo\" style='cursor: pointer' onclick=\"OpenComments('".$story->getObjectId()."')\">  Reply to ".$story->get("userPointer")->get("username")." </div>
                               <span class=\"counterText\" style='cursor: pointer' onclick=\"OpenComments('".$story->getObjectId()."')\"> 
                                        <span id='".$story->getObjectId()."CommentsCount'>".number_shorten($story->get("commentsCount"), 2)."</span> Reactions
                                </span>
                                    <span class=\"counterText\"> 
                                        < ".number_shorten($story->get("playedByCount"), 2)."
                                    </span>
                                    <span class=\"dotsBtnParent\">
                                            <span class=\"dotsBtn\" style='width: 4em'> <i style='font-size: 25px;     color: #c5c5c6;' class=\"fas fa-ellipsis-h\"></i> </span>
                                             <div class=\"dotsModal ".$story->getObjectId()."Modal\">
                                                <a href=\"javascript:;\" class=\"editProfileLink\" onclick=\"HideDropMenu('".$story->getObjectId()."')\" style='width: 40px;   float: right; top: -16px; right: 0;    position: absolute;    font-size: 1em;'> <i class=\"fas fa-times-circle\"></i> </a>
                                                <a href=\"javascript:;\" class=\"editProfileLink\" onclick=\"ShareFable('".$story->getObjectId()."')\"> <i class=\"fas fa-share mr-2\"></i> Share </a>
                                                ".$EditHtml."
                                                ".$ReportHtml."
                                                <a href=\"javascript:;\" class=\"editProfileLink\" onclick=\"DownloadFile('".$story->get("audioFile")->getName()."', '".$story->get("audioFile")->getURL()."', '".$story->getObjectId()."')\"> <i class=\"fas fa-save mr-2 ".$story->getObjectId()."DownloadLoader\"></i> Download </a>
                                                ".$DeleteHtml."
                                             </div>
                                    </span>
                            </div>
                            <div class=\"hideCommentArea row\" id=\"{$story->getObjectId()}CommentsContainer\"></div>
                        </div>
                    </div>";

        /*
          <a href='javascript:;' class=\"counterText\" onclick=\"OpenImage('".$story->get("coverImage")->getURL()."','')\">
                                        <i class=\"fas fa-image\"></i> View Photo
                                    </a>
         */
    }
}