<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-01
 * Time: 12:35
 */
include "parse-config.php";
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseFile;
use Parse\ParseObject;
$PageName = basename($_SERVER['PHP_SELF']);
$PageName = preg_replace("/\.[^.]+$/", "", $PageName);
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$AppVersion = "?v=1.7.7";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <?php
        switch (strtolower($PageName)){
            case "index":
                if(isset($_GET["id"])){
                    $query = new ParseQuery("Buzz");
                    $query->equalTo("objectId", $_GET["id"]);
                    $query->includeKey("userPointer");
                    $story = $query->first();
                    if($story != null){
                        ?>
                        <meta name="title" content="FableFrog | <?php echo $story->get("postBody")?>">
                        <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                        <!-- Open Graph / Facebook -->
                        <meta property="og:type" content="website">
                        <meta property="og:url" content="<?php echo $actual_link?>">
                        <meta property="og:title" content="FableFrog | <?php echo $story->get("postBody")?>">
                        <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="og:image" content="<?php echo $story->get("coverImage")->getURL()?>">

                        <!-- Twitter -->
                        <meta property="twitter:card" content="summary_large_image">
                        <meta property="twitter:url" content="<?php echo $actual_link?>">
                        <meta property="twitter:title" content="FableFrog | <?php echo $story->get("postBody")?>">
                        <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="twitter:image" content="<?php echo $story->get("coverImage")->getURL()?>">


                        <?php
                    }else{
                        ?>
                        <!-- Primary Meta Tags -->
                        <title>FableFrog | Home</title>
                        <meta name="title" content="FableFrog | Home">
                        <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                        <!-- Open Graph / Facebook -->
                        <meta property="og:type" content="website">
                        <meta property="og:url" content="<?php echo $actual_link?>">
                        <meta property="og:title" content="FableFrog | Home">
                        <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                        <!-- Twitter -->
                        <meta property="twitter:card" content="summary_large_image">
                        <meta property="twitter:url" content="<?php echo $actual_link?>">
                        <meta property="twitter:title" content="FableFrog | Home">
                        <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                        <?php
                    }
                }else{
                    ?>
                    <!-- Primary Meta Tags -->
                    <title>FableFrog | Home</title>
                    <meta name="title" content="FableFrog | Home">
                    <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                    <!-- Open Graph / Facebook -->
                    <meta property="og:type" content="website">
                    <meta property="og:url" content="https://app.fablefrog.com/">
                    <meta property="og:title" content="FableFrog | Home">
                    <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                    <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                    <!-- Twitter -->
                    <meta property="twitter:card" content="summary_large_image">
                    <meta property="twitter:url" content="https://app.fablefrog.com/">
                    <meta property="twitter:title" content="FableFrog | Home">
                    <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                    <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                    <?php
                }

                break;
            case "topics":
                ?>

                <title>FableFrog | Topics</title>
                <meta name="title" content="FableFrog | Topics">
                <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                <!-- Open Graph / Facebook -->
                <meta property="og:type" content="website">
                <meta property="og:url" content="<?php echo $actual_link?>">
                <meta property="og:title" content="FableFrog | Topics">
                <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                <!-- Twitter -->
                <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:url" content="<?php echo $actual_link?>">
                <meta property="twitter:title" content="FableFrog | Topics">
                <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                <?php
                break;
            case "interests":
                ?>

                <title>FableFrog | Topics</title>
                <meta name="title" content="FableFrog | Topics">
                <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                <!-- Open Graph / Facebook -->
                <meta property="og:type" content="website">
                <meta property="og:url" content="<?php echo $actual_link?>">
                <meta property="og:title" content="FableFrog | Topics">
                <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                <!-- Twitter -->
                <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:url" content="<?php echo $actual_link?>">
                <meta property="twitter:title" content="FableFrog | Topics">
                <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                <?php
                break;
            case "suggestions":
                ?>
                <title>FableFrog | Suggestions</title>
                <meta name="title" content="FableFrog | Suggestions">
                <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                <!-- Open Graph / Facebook -->
                <meta property="og:type" content="website">
                <meta property="og:url" content="<?php echo $actual_link?>">
                <meta property="og:title" content="FableFrog | Suggestions">
                <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                <!-- Twitter -->
                <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:url" content="<?php echo $actual_link?>">
                <meta property="twitter:title" content="FableFrog | Suggestions">
                <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                <?php
                break;
            case "contact-us":
                ?>

                <title>FableFrog | Contact Us</title>
                <meta name="title" content="FableFrog | Contact Us">
                <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                <!-- Open Graph / Facebook -->
                <meta property="og:type" content="website">
                <meta property="og:url" content="<?php echo $actual_link?>">
                <meta property="og:title" content="FableFrog | Contact Us">
                <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                <!-- Twitter -->
                <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:url" content="<?php echo $actual_link?>">
                <meta property="twitter:title" content="FableFrog | Contact Us">
                <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                <?php
                break;
            case "404":
                ?>
                <title>FableFrog | Page not found</title>
                <?php
                break;
            case "profile":
                if(isset($_GET["user"])){
                    $query = new \Parse\ParseQuery("_User");
                    $query->equalTo("username", $_GET["user"]);
                    $User = $query->first(true);
                    if($User != null){
                        ?>
                        <title>FableFrog | <?php echo $User->get("username")?></title>
                        <meta name="title" content="FableFrog | <?php echo $User->get("username")?>">
                        <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                        <!-- Open Graph / Facebook -->
                        <meta property="og:type" content="website">
                        <meta property="og:url" content="<?php echo $actual_link?>">
                        <meta property="og:title" content="FableFrog | <?php echo $User->get("username")?>">
                        <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="og:image" content="<?php echo ($User->get("avatar") != null ? $User->get("avatar") : "https://app.fablefrog.com/img/icon-512x512.png")?>">

                        <!-- Twitter -->
                        <meta property="twitter:card" content="summary_large_image">
                        <meta property="twitter:url" content="<?php echo $actual_link?>">
                        <meta property="twitter:title" content="FableFrog | <?php echo $User->get("username")?>">
                        <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="twitter:image" content="<?php echo ($User->get("avatar") != null ? $User->get("avatar") : "https://app.fablefrog.com/img/icon-512x512.png")?>">
                        <?php
                    }else{
                        ?>

                        <title>FableFrog | Profile</title>
                        <meta name="title" content="FableFrog | Profile">
                        <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                        <!-- Open Graph / Facebook -->
                        <meta property="og:type" content="website">
                        <meta property="og:url" content="<?php echo $actual_link?>">
                        <meta property="og:title" content="FableFrog | Profile">
                        <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                        <!-- Twitter -->
                        <meta property="twitter:card" content="summary_large_image">
                        <meta property="twitter:url" content="<?php echo $actual_link?>">
                        <meta property="twitter:title" content="FableFrog | Profile">
                        <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                        <?php
                    }
                }else{
                    ?>
                    <title>FableFrog | Profile</title>
                    <meta name="title" content="FableFrog | Profile">
                    <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                    <!-- Open Graph / Facebook -->
                    <meta property="og:type" content="website">
                    <meta property="og:url" content="<?php echo $actual_link?>">
                    <meta property="og:title" content="FableFrog | Profile">
                    <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                    <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                    <!-- Twitter -->
                    <meta property="twitter:card" content="summary_large_image">
                    <meta property="twitter:url" content="<?php echo $actual_link?>">
                    <meta property="twitter:title" content="FableFrog | Profile">
                    <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                    <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">
                    <?php
                }
                ?>

                <?php
                break;
            case "faq":
                ?>
                <title>FableFrog | FAQs</title>
                <meta name="title" content="FableFrog | FAQs">
                <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                <!-- Open Graph / Facebook -->
                <meta property="og:type" content="website">
                <meta property="og:url" content="<?php echo $actual_link?>">
                <meta property="og:title" content="FableFrog | FAQs">
                <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                <!-- Twitter -->
                <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:url" content="<?php echo $actual_link?>">
                <meta property="twitter:title" content="FableFrog | FAQs">
                <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                <?php
                break;
            case "explore":
                if(isset($_GET["id"])){
                    $query = new \Parse\ParseQuery("BuzzSubTopics");
                    $query->includeKey("TopicPointer");
                    $query->equalTo("objectId", $_GET["id"]);
                    $Topic = $query->first(true);
                    if($Topic != null){
                        ?>
                        <title>FableFrog | <?php echo $Topic->get("Title")?></title>
                        <meta name="title" content="FableFrog | <?php echo $Topic->get("Title")?>">
                        <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                        <!-- Open Graph / Facebook -->
                        <meta property="og:type" content="website">
                        <meta property="og:url" content="<?php echo $actual_link?>">
                        <meta property="og:title" content="FableFrog | <?php echo $Topic->get("Title")?>">
                        <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="og:image" content="<?php echo $Topic->get("CoverImage")->getURL()?>">

                        <!-- Twitter -->
                        <meta property="twitter:card" content="summary_large_image">
                        <meta property="twitter:url" content="<?php echo $actual_link?>">
                        <meta property="twitter:title" content="FableFrog | <?php echo $Topic->get("Title")?>">
                        <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="twitter:image" content="<?php echo $Topic->get("CoverImage")->getURL()?>">

                        <?php
                    }else{
                        ?>
                        <title>FableFrog | Explore</title>
                        <meta name="title" content="FableFrog | Explore">
                        <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                        <!-- Open Graph / Facebook -->
                        <meta property="og:type" content="website">
                        <meta property="og:url" content="<?php echo $actual_link?>">
                        <meta property="og:title" content="FableFrog | Explore">
                        <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                        <!-- Twitter -->
                        <meta property="twitter:card" content="summary_large_image">
                        <meta property="twitter:url" content="<?php echo $actual_link?>">
                        <meta property="twitter:title" content="FableFrog | Explore">
                        <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                        <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                        <?php
                    }
                }else{
                    ?>
                    <title>FableFrog | Explore</title>
                    <meta name="title" content="FableFrog | Explore">
                    <meta name="description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">

                    <!-- Open Graph / Facebook -->
                    <meta property="og:type" content="website">
                    <meta property="og:url" content="<?php echo $actual_link?>">
                    <meta property="og:title" content="FableFrog | Explore">
                    <meta property="og:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                    <meta property="og:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                    <!-- Twitter -->
                    <meta property="twitter:card" content="summary_large_image">
                    <meta property="twitter:url" content="<?php echo $actual_link?>">
                    <meta property="twitter:title" content="FableFrog | Explore">
                    <meta property="twitter:description" content="FableFrog is a new audio-based story-telling platform and community. We take the video element out and instead focus on words alone. It was created to help people find the untold stories of this world; your backstories from school, the backstory behind a photo you took 10 years ago, your favorite memory from childhood.">
                    <meta property="twitter:image" content="https://app.fablefrog.com/img/icon-512x512.png">

                    <?php
                }
                ?>
                <?php
                break;

        }
    ?>

    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="657172218571-q3ma9vatn99bdoatm112mo8haiq4koju.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="theme-color" content="#817CFE" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css<?php echo $AppVersion?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css<?php echo $AppVersion?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/minireset.css/0.0.2/minireset.min.css<?php echo $AppVersion?>"/>
    <link rel="stylesheet" href="<?php echo SITE_URL?>css/style.css<?php echo $AppVersion?>" />
    <link rel="stylesheet" href="<?php echo SITE_URL?>css/owl.carousel.css<?php echo $AppVersion?>" />
    <link rel="stylesheet" href="<?php echo SITE_URL?>css/owl.theme.default.css<?php echo $AppVersion?>" />
    <link rel="stylesheet" href="<?php echo SITE_URL?>css/custom.css<?php echo $AppVersion?>" />
    <link rel="stylesheet" href="<?php echo SITE_URL?>css/intlTelInput.min.css<?php echo $AppVersion?>" />
    <link rel="stylesheet" href="<?php echo SITE_URL?>css/jquery.toast.css<?php echo $AppVersion?>" />
    <link rel="shortcut icon" type="image/png" href="<?php echo SITE_URL?>img/icon.png" />
    <style>
        .four-lines{
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-right: 10px;
        }



        .shimmer{
            text-align: center;
        }
        .shine {
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
            background-repeat: no-repeat;
            background-size: 800px 200px;
            display: inline-block;
            position: relative;

            -webkit-animation-duration: 1s;
            -webkit-animation-fill-mode: forwards;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-name: placeholderShimmer;
            -webkit-animation-timing-function: linear;
        }

        .shineDark {
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #bcbebf 40%, #f6f7f8 100%);
            background-repeat: no-repeat;
            background-size: 800px 200px;
            display: inline-block;
            position: relative;

            -webkit-animation-duration: 1s;
            -webkit-animation-fill-mode: forwards;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-name: placeholderShimmer;
            -webkit-animation-timing-function: linear;
        }
        .shimmer box {
            height: 104px;
            width: 100px;
        }

        .shimmer div {
            display: inline-flex;
            flex-direction: column;
            margin-left: 25px;
            margin-top: 15px;
            vertical-align: top;
        }

        .shimmer lines {
            height: 10px;
            margin-top: 10px;
            width: 90%;
        }

        .shimmer photo {
            display: block!important;
            width: 500px;
            height: 100px;
            margin: auto;
            margin-top: 15px;

        }

        @-webkit-keyframes placeholderShimmer {
            0% {
                background-position: -468px 0;
            }

            100% {
                background-position: 468px 0;
            }
        }

    </style>

    <link rel="manifest" href="<?php echo SITE_URL?>manifest.webmanifest">


    <link href="<?php echo SITE_URL?>img/splashscreens/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="<?php echo SITE_URL?>img/splashscreens/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />


    <link rel="apple-touch-icon" href="<?php echo IMAGES_PATH?>icon-512x512.png">

    <style>
        link[rel="manifest"] {
            --pwacompat-splash-font: 24px YandexSansText-Regular;
        }
    </style>
</head>
