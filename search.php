
  <?php
  include "includes/head.php";
  if(isset($_GET["user"])){
      $query = new \Parse\ParseQuery("_User");
      $query->equalTo("username", $_GET["user"]);
      $User = $query->first(true);
  }
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

        /*
             <style>

            #slider-wrap{
                width:100%;
                height:300px;
                position:relative;
                overflow:hidden;
            }

            #slider-wrap ul#slider{
                width:100%;
                height:100%;

                position:absolute;
                top:0;
                left:0;
            }

            #slider-wrap ul#slider li{
                float:left;
                position:relative;
                width:100%;
                height:300px;
            }

            #slider-wrap ul#slider li > div{
                position:absolute;
                top:20px;
                left:35px;
            }

            #slider-wrap ul#slider li > div h3{
                font-size:36px;
                text-transform:uppercase;
            }

            #slider-wrap ul#slider li > div span{
                font-family: Neucha, Arial, sans serif;
                font-size:21px;
            }

            #slider-wrap ul#slider li i{
                text-align:center;
                line-height:400px;
                display:block;
                width:100%;
                font-size:90px;
            }


            .btns{
                position:absolute;
                width:50px;
                height:60px;
                top:50%;
                margin-top:-25px;
                line-height:57px;
                text-align:center;
                cursor:pointer;
                background:rgba(0,0,0,0.1);
                z-index:100;


                -webkit-user-select: none;
                -moz-user-select: none;
                -khtml-user-select: none;
                -ms-user-select: none;

                -webkit-transition: all 0.1s ease;
                -moz-transition: all 0.1s ease;
                -o-transition: all 0.1s ease;
                -ms-transition: all 0.1s ease;
                transition: all 0.1s ease;
            }

            .btns:hover{
                background:rgba(0,0,0,0.3);
            }

            #next{right:-50px; border-radius:7px 0px 0px 7px;}
            #previous{left:-50px; border-radius:0px 7px 7px 7px;}
            #counter{
                top: 30px;
                right:35px;
                width:auto;
                position:absolute;
            }

            #slider-wrap.active #next{right:0px;}
            #slider-wrap.active #previous{left:0px;}


            #pagination-wrap{
                min-width:20px;
                margin-top:350px;
                margin-left: auto;
                margin-right: auto;
                height:15px;
                position:relative;
                text-align:center;
            }

            #pagination-wrap ul {
                width:100%;
            }

            #pagination-wrap ul li{
                margin: 0 4px;
                display: inline-block;
                width:5px;
                height:5px;
                border-radius:50%;
                background:#fff;
                opacity:0.5;
                position:relative;
                top:0;


            }

            #pagination-wrap ul li.active{
                width:12px;
                height:12px;
                top:3px;
                opacity:1;
                box-shadow:rgba(0,0,0,0.1) 1px 1px 0px;
            }




            h1, h2{text-shadow:none; text-align:center;}
            h1{	color: #666; text-transform:uppercase;	font-size:36px;}
            h2{ color: #7f8c8d; font-family: Neucha, Arial, sans serif; font-size:18px; margin-bottom:30px;}




            #slider-wrap ul, #pagination-wrap ul li{
                -webkit-transition: all 0.3s cubic-bezier(1,.01,.32,1);
                -moz-transition: all 0.3s cubic-bezier(1,.01,.32,1);
                -o-transition: all 0.3s cubic-bezier(1,.01,.32,1);
                -ms-transition: all 0.3s cubic-bezier(1,.01,.32,1);
                transition: all 0.3s cubic-bezier(1,.01,.32,1);
            }
        </style>
         */
        ?>
      <!-- Menu Side End -->


        <style>


            .ibtn {
                position: relative;
                display: block;
                width: 100%;
                height: 300px;
                overflow: hidden;
                border-radius: 5px;
            }

            .ibtn:before, .ibtn:after {
                content: '⥪';
                position: absolute;
                top: 50%;
                left: 1rem;
                z-index: 2;
                width: 2rem;
                height: 2rem;
                background: dodgerblue;
                color: white;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                pointer-events: none;
            }

            .ibtn:after {
                content: '⥭';
                left: auto;
                right: 1rem;
            }

            /* I haven't found a way for IE and Edge to let me style inputs that way */
            input[type='radio'] {
                appearance: none;
                -ms-appearance: none;
                -webkit-appearance: none;
                display: block;
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                border-radius: 5px;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                transform: translateX(100%);
                transition: transform ease-in-out 400ms;
                z-index: 1;
            }

            input[type='radio']:focus {
                outline: none;
            }

            input[type='radio']:after {
                content: attr(title);
                position: absolute;
                top: 1rem;
                left: 1rem;
                background-color: rgba(0,0,0,0.4);
                color: white;
                padding: .5rem;
                font-size: 1rem;
                border-radius: 5px;
            }

            input[type='radio']:not(checked):before {
                content: '';
                position: absolute;
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                top: 50%;
                left: calc(-100% + 1rem);
            }

            input[type='radio']:checked:before {
                display: none;
                left: 1rem;
            }

            input[type='radio']:checked {
                transform: translateX(0);
                pointer-event: none;
                z-index: 0;
                box-shadow: -5px 10px 20px -15px rgba(0,0,0,1);
            }

            input[type='radio']:checked + input[type='radio']:before {
                left: -3rem;
            }

            input[type='radio']:checked + input[type='radio'] ~ input[type='radio']:before {
                display: none;
            }
        </style>


            <div class="midContents ">
                <div style="flex-shrink: 0; background: #dbdbdb; padding: 0.7em 1em; display: block; color: var(--themeColor); border-radius: 2em; font-weight: 600; transition: .2s ease-in-out;  margin-bottom: 0.5em;">
                    <i class="fas fa-search" style="margin-right: 0.5em; font-size: 25px" onclick="PerformSearch()"></i>
                    <input style="width: 85%;outline: none;border-color: inherit;-webkit-box-shadow: none;box-shadow: none;background-color: #dbdbdb; border: 1px solid #dbdbdb;" type="text" placeholder="Search something here..." id="SearchInput">
                </div>


                <div id="MainContainer2">



                    <div class="ibtn">
                        <?php
                        $query = new \Parse\ParseQuery("SearchSlider");
                        $query->descending("createdAt");
                        $Slides = $query->find();
                        $x = 0;
                        foreach ($Slides as $slide){
                            echo "<input ".($x == 0 ? "checked" : "")." type=\"radio\" name=\"s\" style=\"background-image: url('".$slide->get("Image")->getURL()."');\" title=\"".$slide->get("Title")."\">";

                            $x++;
                            /*
                             <li data-color="#1abc9c" data-bg="<?php echo ;?>">
                                <div>
                                    <h3><?php echo $slide->get("Title");?></h3>
                                </div>
                            </li>
                             */
                        }
                        ?>

                    </div>

                    <?php
                    $query = new \Parse\ParseQuery("BuzzSubTopics");
                    $query->descending("createdAt");
                    $query->skip(5);

                    $topics = $query->find();
                    foreach ($topics as $topic){
                        $query = new Parse\ParseQuery("Buzz");
                        $query->includeKey("userPointer");
                        $query->descending("playedByCount");

                        $query->containedIn("buzzTopicsIds", array($topic->getObjectId()));
                        if($LoggedInUser != null){
                            $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                            $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                        }
                        $query->skip(10);
                        $stories = $query->find();
                        if(sizeof($stories) > 0){
                            ?>
                            <div class="row mt-2 ml-0 mr-0">
                                <div style="width: 50px">
                                    <img
                                            src="<?php  echo IMAGES_PATH;?>ic_hashtag.png"
                                            style="width: 40px; height: 40px;">

                                </div>
                                <div class="col-7" style="text-align: left">
                                    <h1 class="mainHeading GtSuper grayText" style="font-size: 1.4em; text-align: start;">
                                        <?php echo $topic->get("Title")?>
                                    </h1>
                                    <div class="grayText" style="font-size: 0.7em;">Popular <?php echo $topic->get("Title")?> Fables</div>
                                </div>
                                <div class="col-3" style="float: right; text-align: right">
                                    <div style="    background-color: rgba(32, 35, 51, .05); color: var(--themeColor);    padding: 0.5em 0.8em;    font-size: .8em;    font-weight: 500;    border-radius: 0.7em;    display: inline-block;  text-decoration: none;margin: 1em 0 0.4em 0;">
                                        View All
                                    </div>
                                </div>
                            </div>
                            <div style="overflow-x: scroll; overflow-y: hidden; white-space: nowrap;">

                                <?php
                                foreach ($stories as $story){
                                    echo "<div style='position: relative; display: inline-block; padding: 0.2em 0.2em; width: 100%'>".GetStoriesHtml($story)."</div>";
                                }
                                ?>
                            </div>

                            <?php
                        }


                    }
                    ?>
                </div>



                <div id="FablesContainer"></div>
                <div class='row' id="FablesLoader" style="display: none"><i class='fas fa-spinner fa-pulse auto-margin'></i></div>
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
                            <div class="auto-margin" style="cursor: pointer;" onclick="window.location='https://app.fablefrog.com/index.php?id=<?php echo $story->getObjectId()?>'">
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

      jQuery(document).ready(function() {
          $(window).bind('scroll', function() {
              if ($(window).scrollTop() + $(window).height() > $("#FablesContainer").height() && isMoreDataAvailable) {
                  isMoreDataAvailable = false;
                  setTimeout(function() {
                      console.log("Load More Called");
                      PerformSearch();
                  }, 1000);
              }
          });
      });

      var Request;
      var isMoreDataAvailable  = true;
      function PerformSearch() {
          if(SearchInput.val().length > 0){
              $("#FablesContainer").empty();
              isMoreDataAvailable = false;
              var SaveLoader = $("#FablesLoader");
              SaveLoader.show();
              /*if(Request != null){
                  Request.cancel();
              }*/
              Request = $.ajax({
                  type: "GET",
                  url : "https://app.fablefrog.com/api/search.php?q="+SearchInput.val(),
                  success: function (obj) {
                      SaveLoader.hide();
                      console.log(obj);
                      var Items = obj.items;
                      $("#FablesContainer").append(Items);
                  }
              });
          }else{
              launch_toast("Error", "Kindly enter the search query!")
          }

      }
        /*
      //current position
      var pos = 0;
      //number of slides
      var totalSlides = $('#slider-wrap ul li').length;
      //get the slide width
      var sliderWidth = $('#slider-wrap').width();


      $(document).ready(function(){


          /!*****************
           BUILD THE SLIDER
           *****************!/
          //set width to be 'x' times the number of slides
          $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);

          //next slide
          $('#next').click(function(){
              slideRight();
          });

          //previous slide
          $('#previous').click(function(){
              slideLeft();
          });



          /!*************************
           //!*> OPTIONAL SETTINGS
           ************************!/
              //automatic slider
          var autoSlider = setInterval(slideRight, 3000);

          //for each slide
          $.each($('#slider-wrap ul li'), function() {
              //set its color
              var c = $(this).attr("data-bg");
              $(this).css("background-image","url("+c+")");
              //create a pagination
              console.log(c);
              var li = document.createElement('li');
              $('#pagination-wrap ul').append(li);
          });

          //counter
          countSlides();
          //pagination
          pagination();

          //hide/show controls/btns when hover
          //pause automatic slide when hover
          $('#slider-wrap').hover(
              function(){ $(this).addClass('active'); clearInterval(autoSlider); },
              function(){ $(this).removeClass('active'); autoSlider = setInterval(slideRight, 3000); }
          );



      });//DOCUMENT READY



      /!***********
       SLIDE LEFT
       ************!/
      function slideLeft(){
          pos--;
          if(pos==-1){ pos = totalSlides-1; }
          $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));
          //!*> optional
          countSlides();
          pagination();
      }


      /!************
       SLIDE RIGHT
       *************!/
      function slideRight(){
          pos++;
          if(pos==totalSlides){ pos = 0; }
          $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));
          //!*> optional
          countSlides();
          pagination();
      }




      /!************************
       //!*> OPTIONAL SETTINGS
       ************************!/
      function countSlides(){
      }

      function pagination(){
          $('#pagination-wrap ul li').removeClass('active');
          $('#pagination-wrap ul li:eq('+pos+')').addClass('active');
      }*/

      var MainContainer2 = $("#MainContainer2");
      var FablesContainer = $("#FablesContainer");
      var SearchInput = $("#SearchInput");
      SearchInput.on('keyup', function (e) {
          if (e.key === 'Enter' || e.keyCode === 13) {
              // Do something
              if(SearchInput.val().length > 0){
                  MainContainer2.hide();
                  FablesContainer.show();
                  PerformSearch();
              }else{
                  MainContainer2.show();
                  FablesContainer.hide();
                  launch_toast("Error", "Kindly enter the search query!")
              }
          }
      });
      SearchInput.on('input', function (e) {
          if(SearchInput.val().length == 0){
              MainContainer2.show();
              FablesContainer.hide();
          }
      });


      (function() {
          var $slides = document.querySelectorAll('.slide');
          var $controls = document.querySelectorAll('.slider__control');
          var numOfSlides = $slides.length;
          var slidingAT = 1300; // sync this with scss variable
          var slidingBlocked = false;

          [].slice.call($slides).forEach(function($el, index) {
              var i = index + 1;
              $el.classList.add('slide-' + i);
              $el.dataset.slide = i;
          });

          [].slice.call($controls).forEach(function($el) {
              $el.addEventListener('click', controlClickHandler);
          });

          function controlClickHandler() {
              if (slidingBlocked) return;
              slidingBlocked = true;

              var $control = this;
              var isRight = $control.classList.contains('m--right');
              var $curActive = document.querySelector('.slide.s--active');
              var index = +$curActive.dataset.slide;
              (isRight) ? index++ : index--;
              if (index < 1) index = numOfSlides;
              if (index > numOfSlides) index = 1;
              var $newActive = document.querySelector('.slide-' + index);

              $control.classList.add('a--rotation');
              $curActive.classList.remove('s--active', 's--active-prev');
              document.querySelector('.slide.s--prev').classList.remove('s--prev');

              $newActive.classList.add('s--active');
              if (!isRight) $newActive.classList.add('s--active-prev');


              var prevIndex = index - 1;
              if (prevIndex < 1) prevIndex = numOfSlides;

              document.querySelector('.slide-' + prevIndex).classList.add('s--prev');

              setTimeout(function() {
                  $control.classList.remove('a--rotation');
                  slidingBlocked = false;
              }, slidingAT*0.75);
          };
      }());

  </script>

  </body>
</html>
