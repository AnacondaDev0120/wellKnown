<?php
include "includes/head.php";
  $User = null;

  ?>
  <body>
    <?php
    include "includes/header.php";
    ?>
    <!-- Page Contents -->
    <div class="pageContents tape">
      <!-- Menu Side Start -->
        <?php
        include "includes/side-menu.php"
        ?>
      <!-- Menu Side End -->

        <div class="midContents">

            <div style="padding-bottom: 20px; ">
                <h2 class="subHeading">FAQs</h2>

            </div>

            <style>

                .faq-section {
                    min-height: 100vh;
                }
                .faq-title h2 {
                    position: relative;
                    margin-bottom: 45px;
                    display: inline-block;
                    font-weight: 600;
                    line-height: 1;
                }
                .faq-title h2::before {
                    content: "";
                    position: absolute;
                    left: 50%;
                    width: 60px;
                    height: 2px;
                    background: #817CFE;
                    bottom: -25px;
                    margin-left: -30px;
                }
                .faq-title p {
                    padding: 0 190px;
                    margin-bottom: 10px;
                }

                .faq {
                    background: #FFFFFF;
                    box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.06);
                    border-radius: 4px;
                }

                .faq .card {
                    border: none;
                    background: none;
                    border-bottom: 1px dashed #CEE1F8;
                }

                .faq .card .card-header {
                    padding: 0px;
                    border: none;
                    background: none;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                }

                .faq .card .card-header:hover {
                    background: rgba(233, 30, 99, 0.1);
                    padding-left: 10px;
                }
                .faq .card .card-header .faq-title {
                    width: 100%;
                    text-align: left;
                    padding: 0px;
                    padding-left: 30px;
                    padding-right: 30px;
                    font-weight: 400;
                    font-size: 15px;
                    letter-spacing: 1px;
                    color: #3B566E;
                    text-decoration: none !important;
                    -webkit-transition: all 0.3s ease 0s;
                    -moz-transition: all 0.3s ease 0s;
                    -o-transition: all 0.3s ease 0s;
                    transition: all 0.3s ease 0s;
                    cursor: pointer;
                    padding-top: 20px;
                    padding-bottom: 20px;
                }

                .faq .card .card-header .faq-title .badge {
                    display: inline-block;
                    width: 20px;
                    height: 20px;
                    line-height: 14px;
                    float: left;
                    -webkit-border-radius: 100px;
                    -moz-border-radius: 100px;
                    border-radius: 100px;
                    text-align: center;
                    background: #817CFE;
                    color: #fff;
                    font-size: 12px;
                    margin-right: 20px;
                }

                .faq .card .card-body {
                    padding: 30px;
                    padding-left: 35px;
                    padding-bottom: 16px;
                    font-weight: 400;
                    font-size: 16px;
                    color: #6F8BA4;
                    line-height: 28px;
                    letter-spacing: 1px;
                    border-top: 1px solid #F3F8FF;
                }

                .faq .card .card-body p {
                    margin-bottom: 14px;
                }

                @media (max-width: 991px) {
                    .faq {
                        margin-bottom: 30px;
                    }
                    .faq .card .card-header .faq-title {
                        line-height: 26px;
                        margin-top: 10px;
                    }
                }
            </style>


            <section class="faq-section">
                <div class="container">
                    <div class="row">
                        <!-- ***** FAQ Start ***** -->
                      
                        <div class="col-md-12">
                            <div class="faq" id="accordion">
                                <?php
                                $query = new \Parse\ParseQuery("FAQs");
                                $query->ascending("SortOrder");
                                $questions = $query->find();
                                $a = 1;
                                foreach ($questions as $question) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header" id="Heading<?php echo $question->getObjectId();?>">
                                            <div class="mb-0">
                                                <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse<?php echo $question->getObjectId();?>" data-aria-expanded="true" data-aria-controls="<?php echo $question->getObjectId();?>">
                                                    <span class="badge"><?php echo $a;?></span><?php echo $question->get("Question");?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div id="faqCollapse<?php echo $question->getObjectId();?>" class="collapse" aria-labelledby="Heading<?php echo $question->getObjectId();?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <p><?php echo $question->get("Answer");?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $a++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <div class="rightContents">
            <div class="topInterests">
                <div class="meetHeader">
                    <div>
                        <h2 class="subHeading">Rising Topics</h2>
                        <div class="mainText mt-2"> You may wanna check.. </div>
                    </div>
                    <a href="<?php echo SITE_URL."topics/"?>" class="mainText">View All</a>
                </div>
            </div>

            <?php
            $query = new Parse\ParseQuery("BuzzTopics");
            $query->descending("FollowedBy");
            if($LoggedInUser != null) {
                $query->notContainedIn("FollowedBy", array($LoggedInUser->getObjectId()));
            }
            $query->limit(5);
            $topics = $query->find();
            foreach ($topics as $topic){
                $FollowedBy = $topic->get("FollowedBy");
                if($FollowedBy == null){
                    $FollowedBy = array();
                }
                $isTracking = false;
                if($LoggedInUser != null){
                    if(in_array($LoggedInUser->getObjectId(), $FollowedBy)){
                        $isTracking = true;
                    }
                }
                ?>
                <div class="commonLink mt-2 full-width" >
                    <div class="imageContents ">
                        <div style="width: 80%"><?php echo $topic->get("Title")?></div>
                        <div class="auto-margin lightText" style="display: none" > <i class="fas fa-users"></i>
                            <span id="Subscribers<?php echo $topic->getObjectId()?>"><?php echo number_shorten(sizeof($topic->get("FollowedBy")), 2)?></span>
                        </div>
                        <button style="height: 35px; float: right" class="btn btn-primary" href="javascript:;" onclick="<?php echo ($isTracking ? "":"HandleSubscribe('".$topic->getObjectId()."')")?>" id="SubscribeText<?php echo $topic->getObjectId()?>"><?php echo ($isTracking ? "Tracking":"Track")?></button>
                    </div>
                </div>
                <?php
            }
            ?>



            <?php
            if($LoggedInUser != null){
                ?>
                <div class="topInterests">
                    <div class="meetHeader">
                        <div>
                            <div class="mainText mt-2"> Recently Liked </div>
                        </div>
                    </div>
                </div>
                <?php
                $query = new Parse\ParseQuery("Buzz");
                $query->includeKey("userPointer");
                $query->containedIn("likedBy", array($LoggedInUser->getObjectId()));
                $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                $query->limit(5);
                $stories = $query->find();
                foreach ($stories as $story){
                    ?>
                    <div class="commonLink mt-2 full-width" >
                        <div class="imageContents">
                            <div class="auto-margin" style="cursor: pointer;" onclick="window.location='https://app.fablefrog.com/index.php?id=<?php echo $story->getObjectId()?>'" >
                                <div class="<? echo $story->getObjectId()?>Title"><?php echo $story->get("postBody")?></div>
                                <div class="imageContents">
                                    <div class="auto-margin lightText" style="width: 60px;"> <i class="fas fa-user"></i> <?php echo (strlen($story->get("userPointer")->get("username")) > 5 ? substr($story->get("userPointer")->get("username"), 0, 4)."...":$story->get("userPointer")->get("username"));?> </div>
                                    <div class="auto-margin lightText" style="width: 60px;"> <i class="fas fa-comments"></i> <?php echo number_shorten($story->get("commentsCount"), 2)?> </div>
                                    <div class="auto-margin lightText" style="width: 60px;"> <i class="fas fa-music"></i> <?php echo number_shorten($story->get("playedByCount"), 2);?> </div>
                                </div>
                            </div>
                            <div class="auto-margin" style="display: flex; justify-content: center;  align-items: center; text-align: center; background-image: url('<?php echo $story->get("coverImage")->getURL()?>');background-size: cover; width: 60px; height: 60px; box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px; border-radius: 5px">
                                <div class="btn-play-small auto-margin" style="cursor:pointer;flex-shrink: 0; display: flex; justify-content: center;  align-items: center;" onclick="StartPlaying('<?php echo $story->get("audioFile")->getURL()?>', '<?php echo $story->get("coverImage")->getURL()?>', '<?php echo $story->get("userPointer")->get("username")?>', '<?php echo $story->get("postBody")?>', '<?php echo $story->getObjectId()?>')">
                                    <a class="<?php echo $story->getObjectId()."Btn"?>" data-is-playing = "false" href="javascript:;" ><i class="fas fa-play auto-margin <?php echo $story->getObjectId()."Loader"?>" style="color: white; flex-shrink: 0;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if(sizeof($stories) == 0){
                    echo "<div class='row topInterests text-center  mt-5'><h2 class='col-12 subHeading'>No Liked Fables Found</h2><p class='mainText col-12'>Fables will be displayed here when you start liking them</p></div>";

                }
            }else{
                echo "<div class='row topInterests text-center  mt-5'><h2 class='col-12 subHeading'>No Liked Fables Found</h2><p class='mainText col-12'>Fables will be displayed here when you start liking them</p></div>";

            }
            ?>
        </div>
    </div>

<?php
include "includes/dialogs.php";
include "includes/scripts.php";
?>

  </body>
</html>
