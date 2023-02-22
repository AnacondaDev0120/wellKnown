
  <?php
  include "includes/head.php";

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
        <style>
            .mainText h1 {
                font-size: 1.625rem;
                margin-top: 25px;
                margin-bottom: 15px;
                line-height: 1.4;
            }
            .mainText h2 {
                font-size: 1.625rem;
                margin-top: 25px;
                margin-bottom: 15px;
                line-height: 1.4;
            }
            .mainText ul {
                font-size: 1rem;
                list-style-type: disc;
                line-height: 2;
                margin-left: 30px;
                margin-top: 15px;
                margin-bottom: 15px;
            }
            .mainText  p {
                font-size: 1rem;
                margin-bottom: 10px;
            }
            .mainText  a {
                color: black;
            }



            .wrapper {
                width: 100%;
                padding: 2rem;
                background: #fff;

            }

            form,
            input,
            textarea,
            button {
                font-family: inherit;
                font-size: initial;
            }
            .form-group label {
                display: block;
                margin: 2rem 0 0.5rem 0;
            }
            .form-group input[type="text"],
            .form-group input[type="email"],
            .form-group textarea {
                width: 100%;
                padding: 0.5rem 0.8rem;
                border: 1px solid rgba(0, 0, 0, 0.2);
                outline: 0;
                border-radius: 10px;
                transition: border 0.15s;
            }
           
            .form-group textarea {
                resize: vertical;
            }
            .submit {
                font-weight: bold;
                margin-top: 1rem;
                padding: 0.5rem 1.5rem;
                border: none;
                background: #817CFE;
                color: white;
                cursor: pointer;
                transition: background 0.15s;
                border-radius: 10px;
            }
            i {
                margin-right: 0.5rem;
            }
            .submit:hover {
                background: #5b59fe;
            }
            .form-group input[type="text"]:focus,
            .form-group input[type="email"]:focus,
            .form-group textarea:focus {
                border: 1px solid #222;
            }



        </style>


            <div class="midContents ">
                <?php

                if(isset($_GET["success"])){
                    ?>
                    <style>

                        .page_404{ padding:40px 0; background:#fff;
                        }

                        .page_404  img{ width:100%;}

                        .four_zero_four_bg{

/*
                            background-image: url(<?php echo SITE_URL?>img/27573-email-sent.gif);
*/
                            background-position: center;
                        }


                        .four_zero_four_bg h1{
                            font-size:80px;
                        }

                        .four_zero_four_bg h3{
                            font-size:80px;
                        }

                        .link_404{
                            color: #fff!important;
                            padding: 10px 20px;
                            background: #39ac31;
                            margin: 20px 0;
                            display: inline-block;}
                    </style>
                    <section class="page_404">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="col-sm-10 col-sm-offset-1  text-center">

                                        <img style="width: 400px" src ='<?php echo SITE_URL?>img/27573-email-sent.gif'>
                                        <div class="contant_box_404">
                                            <h3 class="h2">
                                                Message Sent
                                            </h3>
                                            <p>Message sent to the team for further consideration</p>
                                            <a class="btn btn-primary" href="<?php echo SITE_URL?>"  ><i class="fa fa-home mr-3"></i>Go to Home</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php
                }else{
                    ?>
                    <div class="wrapper">
                        <h2 class="subHeading">Contact Us</h2>
                        <form id="ContactForm" action="<?php echo SITE_URL?>api/stories.php" method="POST">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="Name" id="name" placeholder="First and Last" required minlength="3" maxlength="25" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="Email" id="email" placeholder="email@company.abc" required />
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="Message" id="message" rows="5" placeholder="Type your message here...." required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="submit"><i class="far fa-paper-plane"></i>Send</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>

            </div>

        <div class="rightContents">
            <div class="grayText">DETAILED INFORMATION</div>
            <?php
            if($LoggedInUser != null){
                ?>
                <div class="blackText mt-3"> <i class="far fa-clock mr-2"></i> On site since <?php echo $LoggedInUser->getCreatedAt()->format("F Y")?> </div>
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
                $query->limit(7);
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

  <script>
      $("#ContactForm").submit(function(e) {

          //prevent Default functionality
          e.preventDefault();
          //get the action-url of the form
          var actionurl = e.currentTarget.action;
          //do your own request an handle the results
          $.ajax({
              url: actionurl,
              type: 'post',
              dataType: 'application/json',
              data: $("#ContactForm").serialize(),
              success: function(data) {
                  console.log(data);
              },
              complete:function(){
                  //launch_toast("Success", "Message sent to the team for further consideration");
                  window.location = "<?php echo SITE_URL?>contact-us.php?success=true";
              }
          });

      });

  </script>

  </body>
</html>
