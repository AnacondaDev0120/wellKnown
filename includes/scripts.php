<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-18
 * Time: 10:47
 */?>

<style>
    .progress {
        display: block;
        text-align: center;
        width: 0;
        height: 3px;
        background: red;
        transition: width .3s;
    }
    .progress.hide {
        opacity: 0;
        transition: opacity 1.3s;
    }


    #zoomCheck {
        display: none;
    }

    #img02 {
        cursor: zoom-in;
    }

    #zoomCheck:checked ~ label > img {
        transform: scale(2);
        cursor: zoom-out;
    }

</style>


<!-- modal -->
<div id="FullScreenImage"
     class="modal animated bounceIn"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">

    <!-- dialog -->
    <div class="modal-dialog">

        <!-- content -->
        <div class="modal-content">

            <!-- header -->
            <div class="modal-body" style="padding: 0">
                <input type="checkbox" id="zoomCheck">
                <label for="zoomCheck" style="margin: 0">
                    <img  id="img02"  src="https://via.placeholder.com/200">
                </label>
                
              <!--  <figure class="zoom" id="img01" onmousemove="zoom(event)" style="background-image: url()">
                    <img  id="img02"  src="//res.cloudinary.com/active-bridge/image/upload/slide1.jpg" />
                </figure>-->
            </div>

            <!-- footer -->

        </div>
        <!-- content -->

    </div>
    <!-- dialog -->

</div>
<!-- modal -->


<div style="text-align: center">
    <div id="recaptcha-container"></div>
</div>

<div tabindex="-1" class="modal bs-example-modal-sm" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h4>Logout</h4></div>
            <div class="modal-body"> Are you sure you want to logout?</div>
            <div class="modal-footer" style="display: block; width: 100%;">
                <a class="btn btn-warning btn-block logout-btn" style="width: 50%; display: inline; " href="javascript:;">Yes</a>
                <a class="btn btn-success btn-block logout-btn-no" style="width: 50%;   display: inline; " href="javascript:;">No</a>
            </div>
        </div>
    </div>
</div>

<div tabindex="-1" class="modal " id="effectModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h4>Attention</h4></div>
            <div class="modal-body"> Are you sure? Effect cannot be reversed.</div>
            <div class="modal-footer" style="display: block; width: 100%;">
                <a class="btn btn-warning btn-block" id="effect-btn" style="width: 50%; display: inline; " href="javascript:;">Yes</a>
                <a class="btn btn-success btn-block effect-btn-no" style="width: 50%;   display: inline; " href="javascript:;">No</a>
            </div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo SITE_URL?>js/owl.carousel.js<?php echo $AppVersion?>"></script>

<script src="<?php echo SITE_URL?>js/main.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/jquery.jplayer.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/custom.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/intlTelInput.min.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/bs-modal-fullscreen.min.js<?php echo $AppVersion?>"></script>

<script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-auth.js"></script>
<!--<script src="js/login.js"></script>
--><script src="<?php echo SITE_URL;?>js/jquery.toast.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL;?>js/lame.all.js<?php echo $AppVersion?>"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo SITE_URL?>js/ajax-search.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/voicechanger/doWorkerTask.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/voicechanger/helpers.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/voicechanger/jungle.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/voicechanger/tuna.min.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/voicechanger/vocoder.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/voicechanger/waveWorker.js<?php echo $AppVersion?>"></script>



<script src="<?php echo SITE_URL?>js/transforms/troll.js<?php echo $AppVersion?>"></script>
<script src="<?php echo SITE_URL?>js/transforms/troll2.js<?php echo $AppVersion?>"></script>

<style>

    figure.zoom {
        background-position: 50% 50%;
        position: relative;
        width: 100%;
        overflow: hidden;
        cursor: zoom-in;
    }
    figure.zoom img:hover {
        opacity: 0;
    }
    figure.zoom img {
        transition: opacity 0.5s;
        display: block;
        width: 100%;
    }

</style>
<script>
    function OpenLogin(){
        $("#LoginDialog").modal("toggle");

    }

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('<?php echo SITE_URL?>sw.js');
        });
    }

    $("#askModal").on('hidden.bs.modal', function () {
        // do something…
        CoverImageUrl = "";
        $("#ImagesContainer").empty();
        SelectTab("TITLE");
    });


    var CoverImageUrl = "";
    var SearchPage = 1;
    function SelectCoverImageUrl(url) {
        CoverImageUrl = url;
        $("#CoverImage").attr("src", CoverImageUrl);
        $("#CoverTab").css("background-color", "#817CFE");
        $("#CoverTab").css("color", "#fff");
        $("#CovertIcon").removeClass("fa-image");
        $("#CovertIcon").addClass("fa-check-circle");
        $("#ImagesContainer").hide();

    }
    function getPhotos(images) {
        $("#ImagesContainer").empty();
        images.map(image => {
           // console.log(image)
            console.log(image["src"].original);
            $("#ImagesContainer").append("<div class='col-4 mt-2'><img onclick=\"SelectCoverImageUrl('"+image["src"].original+"')\" style='border-radius: 10px; margin: auto; width: 100%; height: 200px; object-fit: cover' src='"+image["src"].original+"?auto=compress&cs=tinysrgb&fit=crop&h=200&w=400'></div>")
        })
    }

    $('body').on('keypress', '#imageSearch', function(args) {
        if (args.keyCode == 13) {
            GetImages();
            return false;
        }
    });

    function GetImages(){

        var imageSearch = $("#imageSearch");
        if(!imageSearch.val()){
            launch_toast("Error", "Kindly enter the search keywords!");
            return;
        }
        $("#ImagesContainer").empty();
        $("#ImagesContainer").append("<div class='col-12'><i style='margin: auto; font-size: 20px' class=\"fas fa-spinner fa-pulse\"></i></div>");

        fetch("https://api.pexels.com/v1/search?query="+imageSearch.val().toLowerCase()+"&per_page=202",{
            headers: {
                Authorization: "563492ad6f91700001000001748aeda50d1f466283d1eeea600c3a2f"
            }
        })
            .then(resp => {
                return resp.json()
            })
            .then(data => {
                getPhotos(data.photos);
            })
    }

    var SelectedTab = "TITLE";
    function SelectTab(Which){
        SelectedTab = Which;
        var TitleContainer = $("#TitleContainer");
        var TopicsContainer = $("#TopicsContainer");
        var SubTopicsContainer = $("#SubTopicsContainer");
        var InterestsContainer = $("#InterestsContainer");
        var CoverContainer = $("#CoverContainer");
        var RecordContainer = $("#RecordContainer");
        $("#PostFableIcon").removeClass("fa-cloud-upload-alt");
        $("#PostFableIcon").addClass("fa-arrow-right");
        $("#PostFableText").html("Continue");
        TitleContainer.hide();
        TopicsContainer.hide();
        SubTopicsContainer.hide();
        InterestsContainer.hide();
        CoverContainer.hide();
        RecordContainer.hide();
        switch(Which){
            case "TITLE":
                TitleContainer.toggleClass("animate__animated animate__backInLeft");
                setTimeout(
                    function()
                    {
                        TitleContainer.toggleClass("animate__animated animate__backInLeft");
                    }, 2000);
                TitleContainer.show();
                break;
            case "RECORDING":
                RecordContainer.toggleClass("animate__animated animate__backInLeft");
                setTimeout(
                    function()
                    {
                        RecordContainer.toggleClass("animate__animated animate__backInLeft");
                    }, 2000);
                RecordContainer.show();

                break;
            case "TOPICS":
                TopicsContainer.show();
                if(SelectedTopics.length > 0){
                    SubTopicsContainer.show();
                    SubTopicsContainer.toggleClass("animate__animated animate__backInLeft");
                    setTimeout(
                        function()
                        {
                            SubTopicsContainer.toggleClass("animate__animated animate__backInLeft");
                        }, 2000);
                }else{
                    SubTopicsContainer.hide();
                }
                TopicsContainer.toggleClass("animate__animated animate__backInLeft");
                setTimeout(
                    function()
                    {
                        TopicsContainer.toggleClass("animate__animated animate__backInLeft");
                    }, 2000);
                break;
            case "INTERESTS":
                InterestsContainer.show();
                InterestsContainer.toggleClass("animate__animated animate__backInLeft");
                setTimeout(
                    function()
                    {
                        InterestsContainer.toggleClass("animate__animated animate__backInLeft");
                    }, 2000);
                break;
            case "COVER":
                CoverContainer.show();
                CoverContainer.toggleClass("animate__animated animate__backInLeft");
                setTimeout(
                    function()
                    {
                        CoverContainer.toggleClass("animate__animated animate__backInLeft");
                    }, 2000);
                $("#PostFableIcon").addClass("fa-cloud-upload-alt");
                $("#PostFableText").html("Post Fable");
                break;


        }
    }

    function SelectEditTab(Which){
        SelectedTab = Which;
        var TopicsContainer = $("#TopicsContainerEdit");
        var InterestsContainer = $("#InterestsContainerEdit");
        TopicsContainer.hide();
        InterestsContainer.hide();
        switch(Which){
            case "TOPICS":
                TopicsContainer.show();
                break;
            case "INTERESTS":
                InterestsContainer.show();
                break;
            default:
                TopicsContainer.show();
                break;
        }
        console.log(Which);
    }

    function DownloadFile(fileName, url, FableId) {
        var DownloadLoader = $("."+FableId+"DownloadLoader");
        DownloadLoader.removeClass("fa-save");
        DownloadLoader.addClass("fa-spinner fa-pulse");
        //Set the File URL.
        $.ajax({
            url: url,
            cache: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 2) {
                        if (xhr.status == 200) {
                            xhr.responseType = "blob";
                        } else {
                            xhr.responseType = "text";
                        }
                    }
                };
                return xhr;
            },
            success: function (data) {
                //Convert the Byte Data to BLOB object.
                var blob = new Blob([data], { type: "application/octetstream" });
                DownloadLoader.addClass("fa-save");
                DownloadLoader.removeClass("fa-spinner fa-pulse");
                //Check the Browser type and download the File.
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, fileName);
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = $("<a />");
                    a.attr("download", fileName);
                    a.attr("href", link);
                    $("body").append(a);
                    a[0].click();
                    $("body").remove(a);
                }
            }
        });
    };
    // Get the modal
    function OpenImage(url, title) {
        $("#FullScreenImage").modal("toggle");
        $("#img02").attr("src", url);

        var modalImg = document.getElementById("img01");
        modalImg.style.backgroundImage = "url('"+url+"')";
    }
    function zoom(e){
        var zoomer = e.currentTarget;
        e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX;
        e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX;
        x = offsetX/zoomer.offsetWidth*100;
        y = offsetY/zoomer.offsetHeight*100;
        zoomer.style.backgroundPosition = x + '% ' + y + '%';
    }




    var isPostingComment = false;
    var isPostingVoice = false;

    function launch_toast(Title, Message) {
        $.toast({
            heading: Title,
            text:Message,
            showHideTransition: 'plain',
            icon: 'warning'
        });
        $(".error-message").each(function () {
            $(this).empty();
            $(this).html("<h3>"+Title+"</h3><p>"+Message+"</p>");
            $(this).show();

        });
        setTimeout(function() {
            $(".error-message").each(function () {
                $(this).hide();
            });
        }, 5000);

    }

    var playerTrack = $("#player-track"),
        albumName = $('#album-name'),
        trackName = $('#track-name'),
        albumArt = $('#album-art'),
        sArea = $('#s-area'),
        seekBar = $('#seek-bar'),
        trackTime = $('#track-time'),
        insTime = $('#ins-time'),
        sHover = $('#s-hover'),
        playPauseButton = $("#play-pause-button"),
        i = playPauseButton.find('i'),
        tProgress = $('#current-time'),
        tTime = $('#track-length'),
        seekT, seekLoc, seekBarPos, cM, ctMinutes, ctSeconds, curMinutes, curSeconds, durMinutes, durSeconds,
        playProgress, bTime, nTime = 0, buffInterval = null, tFlag = false,
        albums = [],
        trackNames = [],
        albumArtworks = ["cover_img"],
        trackUrl = [],
        SelectecCover = "",
        playPreviousTrackButton = $('#play-previous'), playNextTrackButton = $('#play-next'), currIndex = -1;

    function ChangeSpeed() {
        if(playSpeed === 1){
            playSpeed = 1.5
        }else if(playSpeed === 1.5){
            playSpeed = 2
        }else if(playSpeed === 2){
            playSpeed = 2.5
        }else if(playSpeed === 2.5){
            playSpeed = 3
        }else if(playSpeed === 3){
            playSpeed = 1
        }
        audio.playbackRate =  playSpeed;
        $("#play-speed").html((playSpeed == 1 ? "normal":playSpeed+"x"));
    }
    var playSpeed = 1;
    function playPause()
    {
        setTimeout(function()
        {
            if(audio.paused)
            {
                playerTrack.addClass('active');
                albumArt.addClass('active');
                checkBuffering();
                i.attr('class','fas fa-pause');
                $("."+musicLoaderClass).each(function(i, obj) {
                   $(this).addClass("fa-pause");
                    $(this).removeClass("fa-play");
                });
                audio.playbackRate =  playSpeed;
                audio.play();
            }
            else
            {
                playerTrack.addClass('active');
                albumArt.removeClass('active');
                clearInterval(buffInterval);
                albumArt.removeClass('buffering');
                i.attr('class','fas fa-play');
                audio.pause();
                $("."+musicLoaderClass).each(function(i, obj) {
                    $(this).removeClass("fa-pause");
                    $(this).addClass("fa-play");
                });
                $("."+musicBtnClass).each(function(i, obj) {
                    $(this).data("is-playing", false);
                    return;
                });
            }
        },300);
    }


    function showHover(event)
    {
        seekBarPos = sArea.offset();
        seekT = event.clientX - seekBarPos.left;
        seekLoc = audio.duration * (seekT / sArea.outerWidth());

        sHover.width(seekT);

        cM = seekLoc / 60;

        ctMinutes = Math.floor(cM);
        ctSeconds = Math.floor(seekLoc - ctMinutes * 60);

        if( (ctMinutes < 0) || (ctSeconds < 0) )
            return;

        if( (ctMinutes < 0) || (ctSeconds < 0) )
            return;

        if(ctMinutes < 10)
            ctMinutes = '0'+ctMinutes;
        if(ctSeconds < 10)
            ctSeconds = '0'+ctSeconds;

        if( isNaN(ctMinutes) || isNaN(ctSeconds) )
            insTime.text('--:--');
        else
            insTime.text(ctMinutes+':'+ctSeconds);

        insTime.css({'left':seekT,'margin-left':'-21px'}).fadeIn(0);

    }

    function hideHover()
    {
        sHover.width(0);
        insTime.text('00:00').css({'left':'0px','margin-left':'0px'}).fadeOut(0);
    }

    function playFromClickedPos()
    {
        audio.currentTime = seekLoc;
        seekBar.width(seekT);
        hideHover();
    }

    function updateCurrTime()
    {
        nTime = new Date();
        nTime = nTime.getTime();

        if( !tFlag )
        {
            tFlag = true;
            trackTime.addClass('active');
        }

        curMinutes = Math.floor(audio.currentTime / 60);
        curSeconds = Math.floor(audio.currentTime - curMinutes * 60);

        durMinutes = Math.floor(audio.duration / 60);
        durSeconds = Math.floor(audio.duration - durMinutes * 60);

        playProgress = (audio.currentTime / audio.duration) * 100;

        if(curMinutes < 10)
            curMinutes = '0'+curMinutes;
        if(curSeconds < 10)
            curSeconds = '0'+curSeconds;

        if(durMinutes < 10)
            durMinutes = '0'+durMinutes;
        if(durSeconds < 10)
            durSeconds = '0'+durSeconds;

        if( isNaN(curMinutes) || isNaN(curSeconds) )
            tProgress.text('00:00');
        else
            tProgress.text(curMinutes+':'+curSeconds);

        if( isNaN(durMinutes) || isNaN(durSeconds) )
            tTime.text('00:00');
        else
            tTime.text(durMinutes+':'+durSeconds);

        if( isNaN(curMinutes) || isNaN(curSeconds) || isNaN(durMinutes) || isNaN(durSeconds) )
            trackTime.removeClass('active');
        else
            trackTime.addClass('active');


        seekBar.width(playProgress+'%');

        if( playProgress == 100 )
        {
            i.attr('class','fa fa-play');
            $("."+musicLoaderClass).each(function(i, obj) {
                $(this).removeClass("fa-pause");
                $(this).addClass("fa-play");
            });
            $("."+musicBtnClass).each(function(i, obj) {
                $(this).data("is-playing", false);
                return;
            });
            seekBar.width(0);
            tProgress.text('00:00');
            albumArt.removeClass('buffering').removeClass('active');
            clearInterval(buffInterval);
        }
    }

    function checkBuffering()
    {
        clearInterval(buffInterval);
        buffInterval = setInterval(function()
        {
            if( (nTime == 0) || (bTime - nTime) > 1000  )
                albumArt.addClass('buffering');
            else
                albumArt.removeClass('buffering');

            bTime = new Date();
            bTime = bTime.getTime();

        },100);
    }

    function selectTrack(flag)
    {
        currIndex = 0;
        console.log(currIndex);

        if( flag == 0 )
            i.attr('class','fa fa-play');
        else
        {
            albumArt.removeClass('buffering');
            i.attr('class','fa fa-pause');
        }

        seekBar.width(0);
        trackTime.removeClass('active');
        tProgress.text('00:00');
        tTime.text('00:00');

        currAlbum = albums[currIndex];
        currTrackName = trackNames[currIndex];
        currArtwork = albumArtworks[currIndex];

        audio.src = trackUrl[currIndex];

        nTime = 0;
        bTime = new Date();
        bTime = bTime.getTime();

        if(flag != 0)
        {
            audio.play();
            playerTrack.addClass('active');
            albumArt.addClass('active');
            clearInterval(buffInterval);
            checkBuffering();
        }

        albumName.text(currAlbum);
        trackName.text(currTrackName);
        $('#'+currArtwork).attr("src", SelectecCover);
        console.log(currArtwork, currTrackName);
        console.log( trackUrl[currIndex]);
    }

    function initPlayer()
    {
        audio = new Audio();
        audio.loop = false;
        playPauseButton.on('click',playPause);
        sArea.mousemove(function(event){ showHover(event); });
        sArea.mouseout(hideHover);
        sArea.on('click',playFromClickedPos);
        $(audio).on('timeupdate',updateCurrTime);
        playPreviousTrackButton.on('click',function(){ selectTrack(-1);} );
        playNextTrackButton.on('click',function(){ selectTrack(1);});
    }

    var musicLoaderClass = "";
    var musicBtnClass = "";
    initPlayer();
    function StartPlaying(FableUrl, CoverUrl, Fabler, Title, ItemId)
    {


        $("#music-dialog").show();
        if(Title === "Comment Posted" || Title === "Introduction" ){
            $("#PlayerFullImage").hide();
        }else{
            Title = $("."+ItemId+"Title").html();
            $("#PlayerFullImage").show();

            $.ajax({
                url : "<?php echo SITE_URL?>api/stories.php",
                type: "POST",
                data : {
                    'WHAT': "STORE-PLAY-COUNT",
                    'STORY': ItemId,
                }
            }).done(function(response){
                console.log(response);
            }).catch(function(error) {
                console.log(error);
            });
        }
        $("#PlayerFullImage").attr("onclick", "OpenImage('"+CoverUrl+"', '"+Title+"')");
        musicLoaderClass = ItemId+"Loader";
        musicBtnClass = ItemId+"Btn";
        var isPlaying = false;

        $("."+musicBtnClass).each(function(i, obj) {
            isPlaying = $(this).data("is-playing");
            return;
        });
        $(".play-icon").each(function() {
            $(this).removeClass("fa-pause");
            $(this).removeClass("fa-play");
            $(this).addClass("fa-play");
        });

        if(isPlaying){
            playPause();
        }else{
            if(trackUrl[0] === FableUrl){
                playPause();
            }else{
                $("."+musicBtnClass).each(function(i, obj) {
                    $(this).data("is-playing", true);
                    return;
                });
                albums = [];
                albums[0] = Fabler;
                trackNames = [];
                trackNames[0] = Title;
                trackUrl = [];
                trackUrl[0] = FableUrl;
                SelectecCover = CoverUrl;

                selectTrack(0);
                PlaySound();
            }



        }
    }


    function PlaySound() {
        $("#music-dialog").show();
        playPause();
    }

    $("#playerClose").on("click touchend", function () {
        playerTrack.removeClass('active');
        albumArt.removeClass('active');
        clearInterval(buffInterval);
        albumArt.removeClass('buffering');
        i.attr('class','fas fa-play');
        audio.pause();
        audio.currentTime = 0;
        setTimeout(function()
        {
            $("#music-dialog").hide();
        },300);
        $("."+musicLoaderClass).each(function(i, obj) {
            $(this).removeClass("fa-pause");
            $(this).addClass("fa-play");
        });
    });



    function OpenTags(Tags, TagsIds) {
        $("#TagsModal").modal("toggle");
        var tagsContainer = $("#tagsContainer");
        tagsContainer.empty();
        for(var x = 0 ; x < Tags.length ; x++){
            tagsContainer.append('<a href="https://app.fablefrog.com/explore/'+Tags[x]+'/'+TagsIds[x]+'" class="postLink">' +Tags[x] + '<i class="fas fa-chevron-right"></i></a>');
        }
    }


    function OpenComments(Fable) {
      /*  $("#CommentsModal").modal("toggle");*/
        var commentsContainer = $("#"+Fable+"CommentsContainer");
        commentsContainer.css("display", "flex");
        commentsContainer.empty();
        commentsContainer.append("<i class='fa fa-spinner fa-pulse'>");
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "GET-COMMENTS",
                'STORY':Fable,
            }
        }).done(function(response){
            console.log(response);
            var obj = jQuery.parseJSON(response);
            commentsContainer.empty();

            if(obj.success === 1)
            {
                commentsContainer.append(obj.message);
            }else{
                commentsContainer.append("<div class='row topInterests text-center'><h2 class='col-12 subHeading'>Comments not found</h2><p class='mainText col-12'>Be the first one to leave a comments</p></div>");
            }
        }).catch(function(error) {
            console.log(error);
            commentsContainer.empty();
            commentsContainer.append("<div class='row topInterests text-center'><h2 class='col-12 subHeading'>Comments not found</h2><p class='mainText col-12'>Be the first one to leave a comments</p></div>");
        });
    }


    function HandleLike(Story) {
        <?php
        if($LoggedInUser == null){
        ?>
        $("#LoginDialog").modal("toggle");
        <?php
        }else{
        ?>
        var LikesContainer = $("#"+Story+"Likes");
        var LikeIcon = $("#"+Story+"LikeIcon");
        LikeIcon.removeClass("fa-heart");
        LikeIcon.addClass("fa-spinner");
        LikeIcon.addClass("fa-pulse");
        LikeIcon.removeClass("far");
        LikeIcon.addClass("fa");
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "LIKE",
                'STORY':Story,
            }
        }).done(function(response){
            console.log(response);
            var obj = jQuery.parseJSON(response);
            LikeIcon.addClass("fa-heart");
            LikeIcon.removeClass("fa-spinner");
            LikeIcon.removeClass("fa-pulse");
            LikeIcon.addClass("far");
            LikeIcon.removeClass("fa");

            if(obj.success === 1)
            {
                if(obj.isLiked === "YES"){
                    LikeIcon.css("color", "red");
                }else{
                    LikeIcon.css("color", "white");
                }
                LikesContainer.html(obj.likesCount);

            }else{
                launch_toast("Error",obj.message);
            }
        }).catch(function(error) {
            console.log(error);
            LikeIcon.addClass("fa-heart");
            LikeIcon.addClass("far");
            LikeIcon.removeClass("fa");

            LikeIcon.removeClass("fa-spinner");
            LikeIcon.removeClass("fa-pulse");

            launch_toast("Error", error.message);
        });
        <?php
        }
        ?>
    }


    var SelectedTopics = [];
    var SelectedInterests = [];

    var SelectedTopicsIds = [];
    var SelectedInterestsIds = [];

    var SelectedEditTopics = [];
    var SelectedEditInterests = [];

    var SelectedEditTopicsIds = [];
    var SelectedEditInterestsIds = [];

    $(function () {
        $('.InterestsContainer .chip').on("click", function () {
            var element = $(this);
            if(element.hasClass("chip--active")){
                //remove
                SelectedInterests.splice($.inArray(element.data("name"), SelectedInterests), 1);
                SelectedInterestsIds.splice($.inArray(element.data("object"), SelectedInterestsIds), 1);

            }else{
                //add
                SelectedInterests.push(element.data("name"));
                SelectedInterestsIds.push(element.data("object"));
            }
            element.toggleClass("chip--active");
            if(SelectedInterests.length > 0){
                $("#ShowInterestsBtn").css("background-color", "#817CFE");
                $("#ShowInterestsBtn").css("color", "#fff");
                $("#InterestIcon").removeClass("fa-tag");
                $("#InterestIcon").addClass("fa-check-circle");
            }else{
                $("#ShowInterestsBtn").css("background-color", "#f6f2e9");
                $("#ShowInterestsBtn").css("color", "#000000");
                $("#InterestIcon").addClass("fa-tag");
                $("#InterestIcon").removeClass("fa-check-circle");

            }
        });


        $('.TopicsContainer .chip').on("click", function () {
            var SubTopicsContainer = $(".SubTopicsContainer");
            var element = $(this);
            $("#SubTopicsContainer").hide();
            SubTopicsContainer.empty();
            SelectedTopics = [];
            SelectedTopicsIds = [];
            $("#ShowTopicsBtn").css("background-color", "#f6f2e9");
            $("#ShowTopicsBtn").css("color", "#000000");
            $("#TopicIcon").addClass("fa-tag");
            $("#TopicIcon").removeClass("fa-check-circle");
            if(element.hasClass("chip--active")){
               element.removeClass("chip--active");
                $(".postTopics").each(function () {
                    var elem = $(this);
                    elem.removeClass("chip--active");
                    elem.show();
                });


            }else{
                var TopicsLoader = $("#TopicsLoader");
                TopicsLoader.show();
                element.addClass("chip--active");
                $.ajax({
                    url : "<?php echo SITE_URL?>api/stories.php",
                    type: "POST",
                    data : {
                        'WHAT': "GET-SUB-TOPICS",
                        'TOPIC-ID':element.data("object"),
                    }
                }).done(function(response){
                    var obj = jQuery.parseJSON(response);
                    TopicsLoader.hide();
                    if(obj.success === 1)
                    {
                        $("#SubTopicsContainer").show();
                        SubTopicsContainer.html(obj.message);
                    }else{
                        launch_toast("Error",obj.message);
                    }
                }).catch(function(error) {
                    TopicsLoader.hide();

                    launch_toast("Error", error.message);
                });
                $(".postTopics").each(function () {
                    var elem = $(this);
                    if(!elem.hasClass("chip--active")){
                        elem.hide();
                    }else{
                        elem.show();

                    }
                });
            }





        });

        $(document).on("click", '.SubTopicsContainer .chip', function () {
            var element = $(this);
            if(element.hasClass("chip--active")){
                //remove
                SelectedTopics.splice($.inArray(element.data("name"), SelectedTopics), 1);
                SelectedTopicsIds.splice($.inArray(element.data("object"), SelectedTopicsIds), 1);
            }else{
                //add
                SelectedTopicsIds.push(element.data("object"));
                SelectedTopics.push(element.data("name"));
            }
            element.toggleClass("chip--active");
            if(SelectedTopics.length > 0){
                $("#ShowTopicsBtn").css("background-color", "#817CFE");
                $("#ShowTopicsBtn").css("color", "#fff");
                $("#TopicIcon").removeClass("fa-tag");
                $("#TopicIcon").addClass("fa-check-circle");
            }else{
                $("#ShowTopicsBtn").css("background-color", "#f6f2e9");
                $("#ShowTopicsBtn").css("color", "#000000");
                $("#TopicIcon").addClass("fa-tag");
                $("#TopicIcon").removeClass("fa-check-circle");


            }
        });

        $('.EditInterestsContainer .chip').on("click", function () {
            var element = $(this);
            if(element.hasClass("chip--active")){
                //remove
                SelectedEditInterests.splice($.inArray(element.data("name"), SelectedEditInterests), 1);
                SelectedEditInterestsIds.splice($.inArray(element.data("object"), SelectedEditInterestsIds), 1);

            }else{
                //add
                SelectedEditInterests.push(element.data("name"));
                SelectedEditInterestsIds.push(element.data("object"));
            }
            element.toggleClass("chip--active");
            if(SelectedEditInterests.length > 0){
                $("#ShowEditInterestsBtn").css("background-color", "#817CFE");
                $("#ShowEditInterestsBtn").css("color", "#fff");
                $("#EditInterestIcon").removeClass("fa-tag");
                $("#EditInterestIcon").addClass("fa-check-circle");
            }else{
                $("#ShowEditInterestsBtn").css("background-color", "#f6f2e9");
                $("#ShowEditInterestsBtn").css("color", "#000000");
                $("#EditInterestIcon").addClass("fa-tag");
                $("#EditInterestIcon").removeClass("fa-check-circle");

            }
        });

        $('.EditTopicsContainer .chip').on("click", function () {
            var SubTopicsContainer = $(".EditSubTopicsContainer");
            var element = $(this);
            $("#SubTopicsContainerEdit").hide();
            SubTopicsContainer.empty();
            SelectedEditTopics = [];
            SelectedEditTopicsIds = [];
            $("#ShowEditTopicsBtn").css("background-color", "#f6f2e9");
            $("#ShowEditTopicsBtn").css("color", "#000000");
            $("#TopicEditIcon").addClass("fa-tag");
            $("#TopicEditIcon").removeClass("fa-check-circle");

            if(element.hasClass("chip--active")){
                element.removeClass("chip--active");
                $(".EditpostTopics").each(function () {
                    var elem = $(this);
                    elem.removeClass("chip--active");
                    elem.show();
                });
            }else{
                var TopicsLoader = $("#EditTopicsLoader");
                TopicsLoader.show();
                element.addClass("chip--active");
                $.ajax({
                    url : "<?php echo SITE_URL?>api/stories.php",
                    type: "POST",
                    data : {
                        'WHAT': "GET-SUB-TOPICS",
                        'TOPIC-ID':element.data("object"),
                    }
                }).done(function(response){
                    var obj = jQuery.parseJSON(response);
                    TopicsLoader.hide();
                    if(obj.success === 1)
                    {
                        $("#SubTopicsContainerEdit").show();
                        SubTopicsContainer.html(obj.message);
                    }else{
                        launch_toast("Error",obj.message);
                    }
                }).catch(function(error) {
                    TopicsLoader.hide();

                    launch_toast("Error", error.message);
                });
                $(".EditpostTopics").each(function () {
                    var elem = $(this);
                    if(!elem.hasClass("chip--active")){
                        elem.hide();
                    }else{
                        elem.show();

                    }
                });
            }


            /* var element = $(this);
             if(element.hasClass("chip--active")){
                 //remove
                 SelectedEditTopics.splice($.inArray(element.data("name"), SelectedEditTopics), 1);
                 SelectedEditTopicsIds.splice($.inArray(element.data("object"), SelectedEditTopicsIds), 1);
             }else{
                 //add
                 SelectedEditTopicsIds.push(element.data("object"));
                 SelectedEditTopics.push(element.data("name"));
             }
             element.toggleClass("chip--active");
             if(SelectedEditTopics.length > 0){
                 $("#ShowEditTopicsBtn").css("background-color", "#817CFE");
                 $("#ShowEditTopicsBtn").css("color", "#fff");
                 $("#EditTopicIcon").removeClass("fa-tag");
                 $("#EditTopicIcon").addClass("fa-check-circle");
             }else{
                 $("#ShowEditTopicsBtn").css("background-color", "#f6f2e9");
                 $("#ShowEditTopicsBtn").css("color", "#000000");
                 $("#EditTopicIcon").addClass("fa-tag");
                 $("#EditTopicIcon").removeClass("fa-check-circle");
             }*/
        });

        $(document).on("click", '.EditSubTopicsContainer .chip', function () {
            var element = $(this);
            if(element.hasClass("chip--active")){
                //remove
                SelectedEditTopics.splice($.inArray(element.data("name"), SelectedEditTopics), 1);
                SelectedEditTopicsIds.splice($.inArray(element.data("object"), SelectedEditTopicsIds), 1);
            }else{
                //add
                SelectedEditTopicsIds.push(element.data("object"));
                SelectedEditTopics.push(element.data("name"));
            }
            element.toggleClass("chip--active");
            if(SelectedEditTopics.length > 0){
                $("#ShowEditTopicsBtn").css("background-color", "#817CFE");
                $("#ShowEditTopicsBtn").css("color", "#fff");
                $("#EditTopicIcon").removeClass("fa-tag");
                $("#EditTopicIcon").addClass("fa-check-circle");
            }else{
                $("#ShowEditTopicsBtn").css("background-color", "#f6f2e9");
                $("#ShowEditTopicsBtn").css("color", "#000000");
                $("#EditTopicIcon").addClass("fa-tag");
                $("#EditTopicIcon").removeClass("fa-check-circle");
            }
        });
    });



    function ShowTopics() {
        $("#InterestsContainer").hide();
        $("#TopicsContainer").show();
    }
    function ShowInterests() {
        $("#TopicsContainer").hide();
        $("#InterestsContainer").show();
    }

    var AudioBlob = null;
    var isRecorded = false;
    var audioDuration = 0;
    var fableId = "";
    let leftchannel = [];
    let rightchannel = [];
    let recorder = null;
    let recording = false;
    let recordingLength = 0;
    let volume = null;
    let audioInput = null;
    let sampleRate = null;
    let AudioContext = window.AudioContext || window.webkitAudioContext;
    let context = null;
    let analyser = null;
    let canvas = document.querySelector('canvas');
    let canvasCtx = canvas.getContext("2d");
    let micSelect = document.querySelector('#micSelect');
    let stream = null;
    let tested = false;
    var max = 600;
    var count = max + 1;

    (async () => {
        try {
            window.stream = stream = await getStream();
            console.log('Got stream');
        } catch(err) {
            launch_toast("Error", 'Issue getting mic ' + err);
        }
        const deviceInfos = await navigator.mediaDevices.enumerateDevices();


        var mics = [];
        for (let i = 0; i !== deviceInfos.length; ++i) {
            let deviceInfo = deviceInfos[i];
            if (deviceInfo.kind === 'audioinput') {
                console.log(deviceInfo);
                let label = deviceInfo.label || 'Microphone ' + mics.length;
                const option = document.createElement('option');
                option.value = deviceInfo.deviceId;
                option.text = label;
                if(label === "Built-in Microphone" || label === "External Microphone (Built-in)" || label === "Internal Microphone (Built-in)"){
                    option.selected = true;
                    stream = await getStream({ audio: { deviceId: {exact: deviceInfo.deviceId} }, video: false });
                }
                micSelect.appendChild(option);
            }
        }




        function getStream(constraints) {
            if (!constraints) {
                constraints = { audio: true, video: false };
            }
            return navigator.mediaDevices.getUserMedia(constraints);
        }

        setUpRecording();
        function setUpRecording() {
            $('#download').hide();
            context = new AudioContext();
            sampleRate = context.sampleRate;
            // creates a gain node
            volume = context.createGain();
            // creates an audio node from teh microphone incoming stream
            audioInput = context.createMediaStreamSource(stream);
            // Create analyser
            analyser = context.createAnalyser();
            // connect audio input to the analyser
            audioInput.connect(analyser);
            // connect analyser to the volume control
            // analyser.connect(volume);
            let bufferSize = 2048;
            let recorder = context.createScriptProcessor(bufferSize, 2, 2);
            // we connect the volume control to the processor
            // volume.connect(recorder);
            analyser.connect(recorder);
            // finally connect the processor to the output
            recorder.connect(context.destination);
            recorder.onaudioprocess = function(e) {
                // Check
                if (!recording) return;
                // Do something with the data, i.e Convert this to WAV
                let left = e.inputBuffer.getChannelData(0);
                let right = e.inputBuffer.getChannelData(1);
                if (!tested) {
                    tested = true;
                    // if this reduces to 0 we are not getting any sound
                    if ( !left.reduce((a, b) => a + b) ) {
                        launch_toast("Error", "There seems to be an issue with your Mic try using a different device!");
                        // clean up;
                        stop();
                        stream.getTracks().forEach(function(track) {
                            track.stop();
                        });
                        context.close();
                    }
                }
                // we clone the samples
                leftchannel.push(new Float32Array(left));
                rightchannel.push(new Float32Array(right));
                recordingLength += bufferSize;
            };
            visualize();
        }


        function mergeBuffers(channelBuffer, recordingLength) {
            let result = new Float32Array(recordingLength);
            let offset = 0;
            let lng = channelBuffer.length;
            for (let i = 0; i < lng; i++){
                let buffer = channelBuffer[i];
                result.set(buffer, offset);
                offset += buffer.length;
            }
            return result;
        }
        function interleave(leftChannel, rightChannel){
            let length = leftChannel.length + rightChannel.length;
            let result = new Float32Array(length);
            let inputIndex = 0;
            for (let index = 0; index < length; ){
                result[index++] = leftChannel[inputIndex];
                result[index++] = rightChannel[inputIndex];
                inputIndex++;
            }
            return result;
        }

        function writeUTFBytes(view, offset, string){
            let lng = string.length;
            for (let i = 0; i < lng; i++){
                view.setUint8(offset + i, string.charCodeAt(i));
            }
        }
        function start() {
            recording = true;

            count = max + 1;
            counter = setInterval(timer, 1000);
        }


        var counter;
        function timer() {


            if(isPostingVoice && count == 11){
                $('#stop').toggleClass("unClickButton");
                $('#record').toggleClass("unClickButton");
                $('#stop').toggleClass("recording-text");
                $('#record').hide();
                $('#VoiceChangers').hide();

                $('#download').hide();
                $('#stop').show();
                $('.select').hide();
                $('#canvas').show();
                $('#audio').hide();
                //document.querySelector('#msg').style.visibility = 'visible';
                // reset the buffers for the new recording
                leftchannel.length = rightchannel.length = 0;
                recordingLength = 0;

                $("#MicBtn").css("background-color", "#f6f2e9");
                $("#MicBtn").css("color", "#000");
                $("#MicIcon").addClass("fa-microphone");
                $("#MicIcon").removeClass("fa-check-circle");


                if (!context) setUpRecording();
            }else if(count == 601){
                    $('#stop').toggleClass("unClickButton");
                    $('#record').toggleClass("unClickButton");
                    $('#stop').toggleClass("recording-text");
                    $('#record').hide();
                    $('#VoiceChangers').hide();

                    $('#download').hide();
                    $('#stop').show();
                    $('.select').hide();
                    $('#canvas').show();
                    $('#audio').hide();
                    //document.querySelector('#msg').style.visibility = 'visible';
                    // reset the buffers for the new recording
                    leftchannel.length = rightchannel.length = 0;
                    recordingLength = 0;

                    $("#MicBtn").css("background-color", "#f6f2e9");
                    $("#MicBtn").css("color", "#000");
                    $("#MicIcon").addClass("fa-microphone");
                    $("#MicIcon").removeClass("fa-check-circle");


                    if (!context) setUpRecording();

            }



            var recordingTimer =  $("#recordingTimer");
            recordingTimer.show();
            count = count - 1;
            if (count <= 0) {
                clearInterval(counter);
                stop();
                recordingTimer.html(fancyTimeFormat(count)+" - "+fancyTimeFormat(max));
                return;
            }
            recordingTimer.html(fancyTimeFormat(count)+" - "+fancyTimeFormat(max));

            console.log("Recording will begin in " + count + " sec.");
        }

        function fancyTimeFormat(duration)
        {
            // Hours, minutes and seconds
            var hrs = ~~(duration / 3600);
            var mins = ~~((duration % 3600) / 60);
            var secs = ~~duration % 60;

            // Output like "1:01" or "4:03:59" or "123:03:59"
            var ret = "";

            if (hrs > 0) {
                ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
            }

            ret += "" + mins + ":" + (secs < 10 ? "0" : "");
            ret += "" + secs;
            return ret;
        }

        function stop() {
            clearTimeout(counter);
            $('#stop').toggleClass("unClickButton");
            $('#stop').toggleClass("recording-text");
            $('#record').toggleClass("unClickButton");
            $('#record').show();
            $('#VoiceChangers').show();
            $('#download').show();
            $('#stop').hide();

            $("#MicBtn").css("background-color", "#817CFE");
            $("#MicBtn").css("color", "#fff");
            $("#MicIcon").removeClass("fa-microphone");
            $("#MicIcon").addClass("fa-check-circle");


            $("#RecordLabel").html("Record Again");
            $('#canvas').hide();
            $('#audio').show();
            recording = false;
            // document.querySelector('#msg').style.visibility = 'hidden';


            // we flat the left and right channels down
            let leftBuffer = mergeBuffers ( leftchannel, recordingLength );
            let rightBuffer = mergeBuffers ( rightchannel, recordingLength );
            // we interleave both channels together
            let interleaved = interleave ( leftBuffer, rightBuffer );

            ///////////// WAV Encode /////////////////
            // from http://typedarray.org/from-microphone-to-wav-with-getusermedia-and-web-audio/
            //

            // we create our wav file
            let buffer = new ArrayBuffer(44 + interleaved.length * 2);
            let view = new DataView(buffer);



            // RIFF chunk descriptor
            writeUTFBytes(view, 0, 'RIFF');
            view.setUint32(4, 44 + interleaved.length * 2, true);
            writeUTFBytes(view, 8, 'WAVE');
            // FMT sub-chunk
            writeUTFBytes(view, 12, 'fmt ');
            view.setUint32(16, 16, true);
            view.setUint16(20, 1, true);
            // stereo (2 channels)
            view.setUint16(22, 1, true);
            view.setUint32(24, sampleRate, true);
            view.setUint32(28, sampleRate * 4, true);
            view.setUint16(32, 4, true);
            view.setUint16(34, 16, true);
            // data sub-chunk
            writeUTFBytes(view, 36, 'data');
            view.setUint32(40, interleaved.length * 2, true);

            // write the PCM samples
            let lng = interleaved.length;
            let index = 44;
            let volume = 1;
            for (let i = 0; i < lng; i++){
                view.setInt16(index, interleaved[i] * (0x7FFF * volume), true);
                index += 2;
            }

            // our final binary blob
            AudioBlob = new Blob ( [ view ], { type : 'audio/wav' } );

            const audioUrl = URL.createObjectURL(AudioBlob);
            document.querySelector('#audio').setAttribute('src', audioUrl);


            var isConverted = false;
            var audio = $("#audio")[0];
            $("#audio").on("loadedmetadata", function() {
                if(!isConverted){
                    isConverted = true;
                    convertToMP3(AudioBlob);
                }
            });


            console.log(sampleRate, "Size: "+formatBytes(AudioBlob.size));

        }




        // Visualizer function from
        // https://webaudiodemos.appspot.com/AudioRecorder/index.html
        //
        function visualize() {
            WIDTH = canvas.width;
            HEIGHT = canvas.height;
            CENTERX = canvas.width / 2;
            CENTERY = canvas.height / 2;
            let visualSetting = "sinewave";
            console.log(visualSetting);
            if (!analyser) return;
            if(visualSetting === "sinewave") {
                analyser.fftSize = 2048;
                var bufferLength = analyser.fftSize;
                console.log(bufferLength);
                var dataArray = new Uint8Array(bufferLength);
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);
                var draw = function() {
                    drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);

                    canvasCtx.fillStyle = 'rgb(255 255 255)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(129 124 254)';
                    canvasCtx.beginPath();

                    var sliceWidth = WIDTH * 1.0 / bufferLength;
                    var x = 0;

                    for(var i = 0; i < bufferLength; i++) {
                        var v = dataArray[i] / 128.0;
                        var y = v * HEIGHT/2;
                        if(i === 0) {
                            canvasCtx.moveTo(x, y);
                        } else {
                            canvasCtx.lineTo(x, y);
                        }
                        x += sliceWidth;
                    }
                    canvasCtx.lineTo(canvas.width, canvas.height/2);
                    canvasCtx.stroke();
                };
                draw();

            }
        }


        micSelect.onchange = async e => {
            stream.getTracks().forEach(function(track) {
                track.stop();
            });
            context.close();
            stream = await getStream({ audio: { deviceId: {exact: micSelect.value} }, video: false });
            setUpRecording();
        };

        function pause() {
            recording = false;
            context.suspend()
        }

        function resume() {
            recording = true;
            context.resume();
        }

        document.querySelector('#record').onclick = (e) => {
            if($(".select").is(":visible")){
                start();
            }else{
                $(".select").show();
                $("#RecordLabel").html("Start Recording Now");
            }
        };
        document.querySelector('#stop').onclick = (e) => {
            stop();
        }
    })();




    var fileReader = new FileReader();
    function convertToMP3(audioBlob) {
        //audioBlob is the recorded Blob from recordRTC api
        //with FileReader get the dataform like with XMLHttpRequest (maybe the problem?)
        var audioData;
        fileReader = fileReader || new FileReader();
        fileReader.onload = function() {
            audioData = this.result;
            var wav = lamejs.WavHeader.readHeader(new DataView(audioData));
            mp3encoder = new lamejs.Mp3Encoder(wav.channels, wav.sampleRate, 128);
            var leftChunk = []; //one second of silence (get your data from the source you have)
            var rightChunk = []; //one second of silence (get your data from the source you have
            var data = new Int16Array(audioData, wav.dataOffset, wav.dataLen/2);

            for (i = 0; i < data.length; i += 2) {
                leftChunk.push(data[i]);
                rightChunk.push(data[i + 1]);
            }
            var left = new Int16Array(leftChunk);
            var right = new Int16Array(rightChunk);
            var mp3Data = [];

            sampleBlockSize = 1152;

            var mp3buf=[];
            for (var i = 0; i < left.length; i += sampleBlockSize) {
                leftChunk = left.subarray(i, i + sampleBlockSize);
                rightChunk = right.subarray(i, i + sampleBlockSize);
                mp3buf = mp3encoder.encodeBuffer(leftChunk, rightChunk);
                if (mp3buf.length > 0) {
                    mp3Data.push(new Int8Array(mp3buf));
                }
            }
            mp3buf = mp3encoder.flush(); //finish writing mp3
            if (mp3buf.length > 0) {
                mp3Data.push(new Int8Array(mp3buf));
            }
            AudioBlob = new Blob(mp3Data, {
                type: 'audio/mp3'
            });
            console.log(sampleRate, "Size: MP3: "+formatBytes(AudioBlob.size));
            const audioUrl = URL.createObjectURL(AudioBlob);
            document.querySelector('#audio').setAttribute('src', audioUrl);
            const link = document.querySelector('#download');
            link.setAttribute('href', audioUrl);
            link.download = 'output.mp3';
            isRecorded = true;
            $('#download').show();
        };
        fileReader.readAsArrayBuffer(audioBlob);
    }
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    $(".effect-btn-no").on("click touchend", function (e) {
        $("#effectModal").modal("toggle");
    });
    $("#effect-btn").on("click touchend", function (e) {
        ProcessLoadTransform(e, EffectTransformName);
    });


    var EffectTransformName;
    var globalAudioBuffer = null;
    function loadTransform(e, transformName, ...transformArgs) {
        $("#effectModal").modal("toggle");
        EffectTransformName = transformName;

        /*  let audioURL = window.URL.createObjectURL(AudioBlob);
          let arrayBuffer = await (await fetch(audioURL)).arrayBuffer();
          try {
              globalAudioBuffer = await (new AudioContext()).decodeAudioData(arrayBuffer);
              let outputAudioBuffer = await window[transformName+"Transform"](globalAudioBuffer, ...transformArgs);
              AudioBlob = await audioBufferToWaveBlob(outputAudioBuffer);
              let audioUrl = window.URL.createObjectURL(AudioBlob);
              document.querySelector('#audio').setAttribute('src', audioUrl);
              const link = document.querySelector('#download');
              link.setAttribute('href', audioUrl);
              link.download = 'output.wav';
              // convertToMP3(AudioBlob);
              //audioTag.play();
          } catch(e) {
              console.log(e);
              alert("Sorry! There was an error while trying to generate this particular voice.");
          }*/
    }

    async function ProcessLoadTransform(e, transformName, ...transformArgs) {
        $("#effectModal").modal("toggle");
        e.preventDefault();

        let audioURL = window.URL.createObjectURL(AudioBlob);
        let arrayBuffer = await (await fetch(audioURL)).arrayBuffer();
        try {
            globalAudioBuffer = await (new AudioContext()).decodeAudioData(arrayBuffer);
            let outputAudioBuffer = await window[transformName+"Transform"](globalAudioBuffer, ...transformArgs);
            AudioBlob = await audioBufferToWaveBlob(outputAudioBuffer);
            let audioUrl = window.URL.createObjectURL(AudioBlob);
            document.querySelector('#audio').setAttribute('src', audioUrl);
            const link = document.querySelector('#download');
            link.setAttribute('href', audioUrl);
            link.download = 'output.wav';
        } catch(e) {
            console.log(e);
            alert("Sorry! There was an error while trying to generate this particular voice.");
        }
    }

    $(".effect-btn").on("click touchend", function (e) {



    });

    $("#PostFable").on("click touchend", function (e) {
        e.preventDefault();
        if(isPostingComment){
            //Posting a comment
            if(AudioBlob != null){
                $("#FableForm").submit();
            }else{
                launch_toast("Error", "Kindly record an audio");
            }
        }else if(isPostingVoice){
            //Posting a comment
            if(AudioBlob != null){
                $("#FableForm").submit();
            }else{
                launch_toast("Error", "Kindly record an audio");
            }
        }else{
            switch (SelectedTab) {
                case "TITLE":
                    SelectTab("RECORDING");
                    break;
                case "RECORDING":
                    SelectTab("TOPICS");
                    break;
                case "TOPICS":
                    SelectTab("INTERESTS");
                    break;
                case "INTERESTS":
                    SelectTab("COVER");
                    break;
                case "COVER":
                    if(validatePostFable()){
                        if(AudioBlob != null){
                            $("#FableForm").submit();
                        }else{
                            launch_toast("Error", "Kindly record an audio");
                        }
                    }
                    break;
            }
        }
    });


    $("#FableForm").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var PostFableLoader = $("#PostFableLoader");
        PostFableLoader.show();
        $("#PostFable").toggleClass("unClickButton");
        var FableFormData = new FormData(this);
        if(isPostingVoice){
            FableFormData.append("WHAT", "POST-VOICE");
            FableFormData.append("AUDIO-DURATION", audioDuration);
            FableFormData.append("AUDIO", AudioBlob, "recorder.wav");
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    // Upload progress
                    xhr.upload.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            console.log(percentComplete, (Math.round(percentComplete * 100)));
                            PostFableProgress(percentComplete);
                        }
                    }, false);
                    // Download progress
                    xhr.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // Do something with download progress
                            console.log(percentComplete, (Math.round(percentComplete * 100)));
                            PostFableProgress(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                type: "POST",
                url : "<?php echo SITE_URL;?>api/stories.php",
                data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                success: function (data) {
                    PostFableLoader.hide();
                    $("#PostFable").toggleClass("unClickButton");
                    var obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if(obj.success === 1){
                        launch_toast("Success", "Introduction Saved!");
                        $("#askModal").modal("toggle");
                         location.reload(true);
                    }else{
                        launch_toast("Error",obj.message);
                    }
                }
            });
        }else if(!isPostingComment) {
            FableFormData.append("TOPICS-IDS", SelectedTopicsIds);
            FableFormData.append("TOPICS", SelectedTopics);
            FableFormData.append("INTERESTS", SelectedInterests);
            FableFormData.append("INTERESTS-IDS", SelectedInterestsIds);
            FableFormData.append("AUDIO", AudioBlob, "recorder.wav");
            FableFormData.append("WHAT", "STORE-STORY");
            FableFormData.append("COVER-IMAGE-URL", CoverImageUrl);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    // Upload progress
                    xhr.upload.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            console.log(percentComplete, (Math.round(percentComplete * 100)));
                            PostFableProgress(percentComplete);
                        }
                    }, false);
                    // Download progress
                    xhr.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // Do something with download progress
                            console.log(percentComplete, (Math.round(percentComplete * 100)));
                            PostFableProgress(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                type: "POST",
                url : "<?php echo SITE_URL;?>api/stories.php",
                data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                success: function (data) {
                    PostFableLoader.hide();
                    $("#PostFable").toggleClass("unClickButton");
                    var obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if(obj.success === 1){
                        launch_toast("Success", "Fable Saved!");
                        <?php
                        if($LoggedInUser == null){
                        ?>
                        window.location = "<?php echo SITE_URL."profile/anonymous"?>";

                        <?php
                        }else{
                            ?>
                        window.location = "<?php echo SITE_URL."profile/".($LoggedInUser != null?$LoggedInUser->get("username"):"")?>";

                    <?php
                        }
                        ?>
                    }else{
                        launch_toast("Error",obj.message);
                    }
                }
            });
        }
        else{
            FableFormData.append("WHAT", "POST-COMMENT");
            FableFormData.append("AUDIO-DURATION", audioDuration);
            FableFormData.append("FABLE-ID", fableId);
            FableFormData.append("AUDIO", AudioBlob, "recorder.wav");
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    // Upload progress
                    xhr.upload.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            console.log(percentComplete, (Math.round(percentComplete * 100)));
                            PostFableProgress(percentComplete);
                        }
                    }, false);
                    // Download progress
                    xhr.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // Do something with download progress
                            console.log(percentComplete, (Math.round(percentComplete * 100)));
                            PostFableProgress(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                type: "POST",
                url : "<?php echo SITE_URL;?>api/stories.php",
                data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                success: function (data) {
                    PostFableLoader.hide();
                    $("#PostFable").toggleClass("unClickButton");
                    var obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if(obj.success === 1){
                        launch_toast("Success", "Comment Saved!");
                        var commentsContainer = $("#"+fableId+"CommentsContainer");
                        var commentsCount = $("#"+fableId+"CommentsCount");
                        commentsContainer.empty();
                        commentsContainer.append(obj.message);
                        commentsCount.html(obj.commentsCount);
                        $("#askModal").modal("toggle");
                        // location.reload(true);
                    }else{
                        launch_toast("Error",obj.message);
                    }
                }
            });
        }
    });


    $("#EditFable").on("click touchend", function (e) {
        e.preventDefault();
        if(SelectedEditTopics.length == 0){
            launch_toast("Error", "Kindly select fable topics!");
            return;
        }
        if(SelectedEditInterests.length == 0){
            launch_toast("Error", "Kindly select fable interests!");
            return;
        }
        $("#EditFableForm").submit();
    });

    $("#EditFableForm").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var PostFableLoader = $("#EditFableLoader");
        PostFableLoader.show();
        $("#EditFable").toggleClass("unClickButton");
        var FableFormData = new FormData(this);
        FableFormData.append("TOPICS-IDS", SelectedEditTopicsIds);
        FableFormData.append("TOPICS", SelectedEditTopics);
        FableFormData.append("INTERESTS", SelectedEditInterests);
        FableFormData.append("INTERESTS-IDS", SelectedEditInterestsIds);
        FableFormData.append("EDIT-FABLE-ID", SelectedEditFableId);
        FableFormData.append("WHAT", "EDIT-STORY");
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        console.log(percentComplete, (Math.round(percentComplete * 100)));
                        PostFableProgress(percentComplete);
                    }
                }, false);
                // Download progress
                xhr.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        // Do something with download progress
                        console.log(percentComplete, (Math.round(percentComplete * 100)));
                        PostFableProgress(percentComplete);
                    }
                }, false);
                return xhr;
            },
            type: "POST",
            url : "<?php echo SITE_URL;?>api/stories.php",
            data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function (data) {
                PostFableLoader.hide();
                $("#EditFable").toggleClass("unClickButton");
                var obj = jQuery.parseJSON(data);
                console.log(obj);
                if(obj.success === 1){
                    launch_toast("Success", "Fable Updated!");
                    window.location.reload();
                }else{
                    launch_toast("Error",obj.message);
                }
            }
        });
    });

    function PostFableProgress(percentComplete) {
        $('.progress').removeClass('hide');
        if(percentComplete === undefined)
        {
            percentComplete = 0;
            $('.progress').css({
                width: '0%'
            });
        }

        $('.progress').css({
            width: (Math.round(percentComplete * 100)) + '%'
        });
        if(percentComplete == 1){
            setTimeout(function() {
                $('.progress').addClass('hide');
            }, 3000);
        }
    }

    function PostComment(FableObjectId) {
        <?php
        if($LoggedInUser == null){
                        ?>
        $("#LoginDialog").modal("toggle");
        <?php
        }else{
        ?>
        isPostingComment = true;
        fableId = FableObjectId;
        $("#FableActions").hide();
        $("#TitleContainer").hide();
        $("#RecordContainer").show();
        $("#askModalTitle").show();
        $("#askModalTitle").html("Post an Audio-Recorded Reaction");
        $("#PostFableText").html("Post Your Reaction");
        $("#askModal").modal("toggle");
        <?php
        }
        ?>
    }

    function PostIntroVoice() {
        <?php
        if($LoggedInUser == null){
        ?>
        $("#LoginDialog").modal("toggle");
        <?php
        }else{
        ?>

        max = 10;
        count = max + 1;
        isPostingComment = false;
        isPostingVoice = true;
        $("#FableActions").hide();
        $("#TitleContainer").hide();
        $("#RecordContainer").show();
        $("#askModalTitle").show();
        $("#askModalTitle").html("Add a Voice Sample");
        $("#PostFableText").html("Save Now");
        $("#askModal").modal("toggle");
        <?php
        }
        ?>
    }

    function validatePostFable() {
        if($("#FableTitle").val().length == 0){
            SelectTab("TITLE");
            return false;
        }
        if(!isRecorded){
            SelectTab("RECORDING");
            return false;
        }
        if(SelectedTopics.length <= 0){
            SelectTab("TOPICS");
            return false;
        }
        if(SelectedInterests.length <= 0){
            SelectTab("INTERESTS");
            return false;
        }
        if($("#CoverImageInput").get(0).files.length === 0 && CoverImageUrl === ""){
            SelectTab("COVER");
            return false;
        }
        return isRecorded;

    }

    var register_phone_number = document.querySelector("#register_phone_number");
    var instance = window.intlTelInput(register_phone_number, {
        initialCountry: "us",
        preferredCountries: ['us', 'au'],
        utilsScript: "<?php echo SITE_URL?>js/utils.js",
    });

    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyDYkZg2aEuErg8v3CHeGolhTEbLEcGD2sk",
        authDomain: "auth.fablefrog.com",
        projectId: "fablefrog-auth",
        storageBucket: "fablefrog-auth.appspot.com",
        messagingSenderId: "1021054701797",
        appId: "1:1021054701797:web:9693e89d356112927b440c"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // Create a Recaptcha verifier instance globally
    // Calls submitPhoneNumberAuth() when the captcha is verified
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
        "recaptcha-container",
        {
            size: "invisible",
            callback: function(response) {
                submitPhoneNumberAuth();
            }
        }
    );

    function submitPhoneNumberAuth() {
        var phoneNumber = instance.getNumber();
        console.log(phoneNumber);
        if(instance.isValidNumber()){
            $("#SendOtpLoader").show();
            var appVerifier = window.recaptchaVerifier;
            firebase
                .auth()
                .signInWithPhoneNumber($("#country option:selected").val()+phoneNumber, appVerifier)
                .then(function(confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    $("#OTP_CONTAINER").show();
                    $("#SendOtpLoader").hide();
                }).catch(function(error) {
                console.log(error);
                $("#SendOtpLoader").hide();

            });
        }else{
            launch_toast("Error", "Invalid phone number!");
        }

    }

    function submitPhoneNumberAuthCode() {
        // We are using the test code we created before
        // var code = document.getElementById("code").value;
        var register_otp = $("#register_otp");
        // We are using the test phone numbers we created before
        // var phoneNumber = document.getElementById("phoneNumber").value;
        var code = register_otp.val();
        if(code === ""){
            launch_toast("Error", "Kindly enter your OTP!");
            return;
        }
        $("#OtpLoader").show();
        confirmationResult
            .confirm(code)
            .then(function(result) {
                $("#OtpLoader").hide();
                var user = result.user;
                console.log("Phone User", user);
                $("#PhoneLoader").show();
                $.ajax({
                    url : "<?php echo SITE_URL?>api/auth.php",
                    type: "POST",
                    data : {
                        'PROVIDER': "PHONE",
                        'PHONE':user.phoneNumber,
                        'ID':  user.uid
                    }
                }).done(function(response){
                    console.log(response);
                    $("#PhoneLoader").hide();
                    var obj = jQuery.parseJSON(response);
                    if(obj.success === 1)
                    {
                        window.location.reload(true);
                    }else{
                        launch_toast("Error",obj.message);
                    }
                });

            })
            .catch(function(error) {
                console.log(error);
                $("#OtpLoader").hide();
                launch_toast("Error", error.message);

            });
    }

    function HandlePhone() {
        $("#phoneLoginModal").modal("toggle");
    }

    function handleGoogleEmailLogin() {
        var provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider).then(function(result) {
            // This gives you a Google Access Token. You can use it to access the Google API.
            var token = result.credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            console.log("Google User", user);
            $("#GoogleLoader").show();
            $("#GoogleLoginStatus").hide();
            user.providerData.forEach(function (profile) {
                $.ajax({
                    url : "<?php echo SITE_URL?>api/auth.php",
                    type: "POST",
                    data : {
                        'PROVIDER': "GOOGLE",
                        'EMAIL':profile.email,
                        'ID':  user.uid,
                        'FULL-NAME':  profile.displayName,
                        'DP':  profile.photoURL
                    }
                }).done(function(response){
                    console.log(response);
                    $("#GoogleLoader").hide();
                    $("#GoogleLoginStatus").show();
                    var obj = jQuery.parseJSON(response);
                    if(obj.success === 1)
                    {
                        window.location.reload(true);
                    }else{
                        launch_toast("Error",obj.message);
                    }
                });

            });


        }).catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            launch_toast("Error", errorCode+" "+errorMessage);

            // ...
        });
    }


    function OpenRecordModal() {
        max = 600;
        count = max + 1;
        isPostingComment = false;
        isPostingVoice = false;
        $("#FableActions").show();
        $("#FableTitle").show();
        $("#askModalTitle").html("Post a Fable");
        $("#PostFableText").html("Continue");
        $("#askModalTitle").hide();

        $("#askModal").modal("toggle");

    }

    function OpenRecordDialog(Title){
        <?php
        if($LoggedInUser == null){
        ?>
        $("#LoginDialog").modal("toggle");
        <?php
        }else{
        ?>
        max = 600;
        count = max + 1;

        isPostingComment = false;
        isPostingVoice = false;
        $("#FableActions").show();
        $("#FableTitle").show();
        $("#askModalTitle").html("Post a Fable");
        $("#PostFableText").html("Continue");
        $("#askModalTitle").hide();

        $("#askModal").modal("toggle");
        $("#FableTitle").val(Title);
        $("#ShowTitleBtn").css("background-color", "#817CFE");
        $("#ShowTitleBtn").css("color", "#fff");
        $("#TitleIcon").removeClass("fa-quote-right");
        $("#TitleIcon").addClass("fa-check-circle");
        <?php
        }
        ?>
    }

    $("#CoverImageBtn").on("click touchend", function () {
        $('#CoverImageInput').click();
        $('#SearchContainer').hide()
        $("#InterestsContainer").hide();
        $("#TopicsContainer").hide();
    });

    $("#CoverImageInput").change(function(){
        readFableCoverURL(this);
    });

    $('#FableTitle').bind('input', function() {
        if(this.value.length){
            $("#ShowTitleBtn").css("background-color", "#817CFE");
            $("#ShowTitleBtn").css("color", "#fff");
            $("#TitleIcon").removeClass("fa-quote-right");
            $("#TitleIcon").addClass("fa-check-circle");
        }else{
            $("#ShowTitleBtn").css("background-color", "#f6f2e9");
            $("#ShowTitleBtn").css("color", "#000");
            $("#TitleIcon").addClass("fa-quote-right");
            $("#TitleIcon").removeClass("fa-check-circle");
        }
    });
    function readFableCoverURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img, file;
                var _URL = window.URL || window.webkitURL;
                if ((file = input.files[0])) {
                    var objectUrl = _URL.createObjectURL(file);
                    $("#CoverImage").attr("src", objectUrl);
                    $("#CoverTab").css("background-color", "#817CFE");
                    $("#CoverTab").css("color", "#fff");
                    $("#CovertIcon").removeClass("fa-image");
                    $("#CovertIcon").addClass("fa-check-circle");
                    CoverImageUrl = "";
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function ReportFable(FableId) {
        <?php
            if($LoggedInUser != null){
?>
        var ReportLoader = $("#"+FableId+"ReportLoader");
        ReportLoader.show();
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "REPORT-FABLE",
                "STORY": FableId
            }
        }).done(function(response){
            console.log(response);
            ReportLoader.hide();
            var obj = jQuery.parseJSON(response);
            if(obj.isReported){
                $("#"+FableId+"ReportText").html("UnReport");
            }else{
                $("#"+FableId+"ReportText").html("Report");
            }
            launch_toast("Success",obj.message);
        });
        <?php
            }else{
                ?>
            $("#LoginDialog").modal("toggle");

    <?php
            }
        ?>
    }


    function DeleteFable(FableId) {
        <?php
        if($LoggedInUser != null){
        ?>
        var DeleteLoader = $("#"+FableId+"DeleteLoader");
        DeleteLoader.show();
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "DELETE-FABLE",
                "STORY": FableId
            }
        }).done(function(response){
            console.log(response);
            DeleteLoader.hide();
            var obj = jQuery.parseJSON(response);
            if(obj.success == 1){
                launch_toast("Successful!",obj.message);
                $(".Fable"+FableId).each(function () {
                   $(this).remove();
                });
            }else{
                launch_toast("Error",obj.message);

            }
        });
        <?php
        }else{
        ?>
        $("#LoginDialog").modal("toggle");

        <?php
        }
        ?>
    }




    var ShareFableUrl = "";
    var ShareFableTitle = "";

    function ShareFable(FableId) {
        ShareFableTitle = $("."+FableId+"Title").html();
        ShareFableUrl = "<?php echo SITE_URL?>index.php?id="+FableId;
        $("#shareDialog").modal("toggle");
    }

    var SelectedEditFableId = "";
    function EditFable(elem, Tags, TagsIds, Interests, InterestsId) {
        SelectedEditFableId = $(elem).data("fable-id");
        console.log(SelectedEditFableId);
        SelectedEditTopics = Tags;
        SelectedEditTopicsIds = TagsIds;
        SelectedEditInterests = Interests;
        SelectedEditInterestsIds = InterestsId;

        $('.EditTopicsContainer .chip').each(function () {
            var element = $(this);
            for (var x = 0 ; x < SelectedEditTopicsIds.length ; x++){
                if($.inArray(element.data("object"), SelectedEditTopicsIds) > -1){
                    element.addClass("chip--active");
                }
            }
        });
        $('.EditInterestsContainer .chip').each(function () {
            var element = $(this);
            for (var x = 0 ; x < SelectedEditInterestsIds.length ; x++){
                if($.inArray(element.data("object"), SelectedEditInterestsIds) > -1){
                    element.addClass("chip--active");
                }
            }
        });

        if(SelectedEditInterests.length > 0){
            $("#ShowEditInterestsBtn").css("background-color", "#817CFE");
            $("#ShowEditInterestsBtn").css("color", "#fff");
            $("#EditInterestIcon").removeClass("fa-tag");
            $("#EditInterestIcon").addClass("fa-check-circle");
        }else{
            $("#ShowEditInterestsBtn").css("background-color", "#f6f2e9");
            $("#ShowEditInterestsBtn").css("color", "#000000");
            $("#EditInterestIcon").addClass("fa-tag");
            $("#EditInterestIcon").removeClass("fa-check-circle");

        }


        if(SelectedEditTopics.length > 0){
            $("#ShowEditTopicsBtn").css("background-color", "#817CFE");
            $("#ShowEditTopicsBtn").css("color", "#fff");
            $("#EditTopicIcon").removeClass("fa-tag");
            $("#EditTopicIcon").addClass("fa-check-circle");
        }else{
            $("#ShowEditTopicsBtn").css("background-color", "#f6f2e9");
            $("#ShowEditTopicsBtn").css("color", "#000000");
            $("#EditTopicIcon").addClass("fa-tag");
            $("#EditTopicIcon").removeClass("fa-check-circle");
        }

        $("#editFableModal").modal("toggle");

    }


    var input = document.querySelector("input.copyfrom"); // select the input field

    function CopyUrl() {
        input.value = ShareFableUrl;
        input.select(); // select offscreen inputs text
        document.execCommand("copy"); // copy it
        this.focus(); // focus back on original, so we don't see any glitches
        $("#shareDialogTitle").html("Link copied");
        setTimeout(
            function()
            {
                $("#shareDialogTitle").html("Share this");
            }, 5000);

    }

    function ShareWhatsApp() {
        var win = window.open('https://wa.me/?text=Here I found a fable: '+ShareFableTitle+' '+ShareFableUrl, '_blank');
        if (win) {
            win.focus();
        } else {
            //Browser has blocked it
            launch_toast("Error", 'Please allow popups for this website');
        }
    }
    function FacebookShare() {
        var width = 626;
        var height = 436;
        var sharerUrl = 'https://www.facebook.com/sharer.php?u='+ ShareFableUrl + '&t=Here I found a fable: '+ShareFableTitle;
        var l = window.screenX + (window.outerWidth - width) / 2;
        var t = window.screenY + (window.outerHeight - height) / 2;
        var winProps = ['width='+width,'height='+height,'left='+l,'top='+t,'status=no','resizable=yes','toolbar=no','menubar=no','scrollbars=yes'].join(',');
        var win = window.open(sharerUrl, 'fbShareWin', winProps);
    }
    function TwitterShare() {
        var width = 626;
        var height = 436;
        var sharerUrl = 'https://twitter.com/share?url='+ ShareFableUrl + '&text=Here I found a fable: '+ShareFableTitle;
        var l = window.screenX + (window.outerWidth - width) / 2;
        var t = window.screenY + (window.outerHeight - height) / 2;
        var winProps = ['width='+width,'height='+height,'left='+l,'top='+t,'status=no','resizable=yes','toolbar=no','menubar=no','scrollbars=yes'].join(',');
        var win = window.open(sharerUrl, 'fbShareWin', winProps);
    }
    var SkipCountSearch = 0;

    var headerSearch = $("#headerSearch");
    $("#SearchBtn").on("click touchend", function () {
        if(headerSearch.val().length > 0){
            <?php
            if($PageName == "search"){
            ?>
            SkipCountSearch = 0;
            var newurl = "<?php echo SITE_URL."search/"?>"+headerSearch.val();
            window.history.pushState({path:newurl},'',newurl);
            PerformSearch();
            <?php
            }else{
            ?>
            window.location = "<?php echo SITE_URL."search/"?>"+headerSearch.val();
            <?php
            }
            ?>
        }else{
            launch_toast("Error", "Kindly enter the search query!")
        }
    });
    headerSearch.on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            // Do something
            if(headerSearch.val().length > 0){
                <?php
                if($PageName == "search"){
                ?>
                SkipCountSearch = 0;
                var newurl = "<?php echo SITE_URL."search/"?>"+headerSearch.val();
                window.history.pushState({path:newurl},'',newurl);
                PerformSearch();
                <?php
                }else{
                ?>
                window.location = "<?php echo SITE_URL."search/"?>"+headerSearch.val();
                <?php
                }
                ?>
            }else{
                launch_toast("Error", "Kindly enter the search query!")
            }
        }
    });

    $(".log-out").on("click touchend", function (e) {
        $(".bs-example-modal-sm").modal("toggle");
    });
    $(".logout-btn-no").on("click touchend", function (e) {
        $(".bs-example-modal-sm").modal("toggle");
    });

    $(".logout-btn").on("click touchend", function (e) {
        $(".logout-btn").each(function () {
            $(this).append("<i class=\"ml-2 mr-2 fas fa-spinner fa-pulse\"></i>");
        });
        e.preventDefault();
        $.ajax({
            url : "<?php echo SITE_URL?>api/auth.php",
            type: "POST",
            xhrFields: {
                withCredentials: false
            },
            data : {
                'LOGOUT': "YES"
            }
        }).done(function(response){
            window.location.reload(true);
        });
    });


   /*
   $(document).on("click touchend", function (event) {
        console.log("Clicked");
        $(".dotsModal.show").each(function () {
            $(this).toggleClass("show");
            console.log("Clicked and drop down hidden!");

        });
    });
*/

    function HideDropMenu(Id) {
        $("."+Id+"Modal").toggleClass('show');
    }



</script>