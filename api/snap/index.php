<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2/2/22
 * Time: 2:09 PM
 */
try{

    $response = array();
    require "snapchat.php";
// Log in:
    $snapchat = new Snapchat();
    $response["login"] = $snapchat->login('stackdiv', 'saidi142536');
// Get your feed:
    //$snaps = $snapchat->getSnaps();

// Get your friends' stories:
  //  $response["snaps"] = $snapchat->getFriendStories(true);

    /*
    // Download a specific snap:
    $data = $snapchat->getMedia('122FAST2FURIOUS334r');
    file_put_contents('/home/jorgen/snap.jpg', $data);

    // Download a specific story:
    $data = $snapchat->getStory('[story_media_id]', '[story_key]', '[story_iv]');

    // Download a specific story's thumbnail:
    $data = $snapchat->getStoryThumb('[story_media_id]', '[story_key]', '[thumbnail_iv]');

    // Mark the snap as viewed:
    $snapchat->markSnapViewed('122FAST2FURIOUS334r');

    // Mark the story as viewed:
    $snapchat->markStoryViewed('[story_id]');

    // Screenshot!
    $snapchat->markSnapShot('122FAST2FURIOUS334r');

    // Upload a snap and send it to me for 8 seconds:
    $id = $snapchat->upload(
        Snapchat::MEDIA_IMAGE,
        file_get_contents('/home/jorgen/whatever.jpg')
    );
    $snapchat->send($id, array('jorgenphi'), 8);

    // Upload a video story:
    $id = $snapchat->upload(
        Snapchat::MEDIA_VIDEO,
        file_get_contents('/home/jorgen/whatever.mov')
    );
    $snapchat->setStory($id, Snapchat::MEDIA_VIDEO);*/

// Destroy the evidence:
//$snapchat->clearFeed();

// Find friends by phone number:
//$friends = $snapchat->findFriends(array('18006492568', '7183876962'));

// Get a list of your friends:
  //  $response["friends"] = $snapchat->getFriends();

// Add some people as friends:
  //  $snapchat->addFriends(array('ussaidiqbal'));
    /*
    // Add someone you forgot:
    $snapchat->addFriend('bart');*/

// Get a list of the people you've added:
  //  $response["added"] = $snapchat->getAddedFriends();

    /*
    // Find out who Bill and Bob snap the most:
    $bests = $snapchat->getBests(array('bill', 'bob'));

    // Set Bart's display name:
    $snapchat->setDisplayName('bart', 'Barty');

    // Block Bart:
    $snapchat->block('bart');

    // Unblock Bart:
    $snapchat->unblock('bart');

    // Delete Bart entirely:
    $snapchat->deleteFriend('bart');

    // You only want your friends to be able to snap you:
    $snapchat->updatePrivacy(Snapchat::PRIVACY_FRIENDS);

    // You want to change your email:
    $snapchat->updateEmail('jorgen@example.com');*/

// Log out:
   // $snapchat->logout();
    echo "<pre>";
    print_r($response);
}catch (Exception $exception){
    print_r($exception);
}