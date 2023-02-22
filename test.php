<?
if(isset($_GET["URL"]) && isset($_GET["effect"])){
    ?>
    <!DOCTYPE html>
    <html>
    <body>
    <audio  id="audio" src="<?php echo $_GET["URL"]?>" style="height: 40px; width: 100%" controls></audio>
    <div class="ml-2 voice-card" onclick="ProcessLoadTransform('troll')" style="cursor:pointer; border-radius: 100%;background-image:url('https://app.fablefrog.com/img/troll.jpeg');height: 100px;width: 100px;background-repeat: no-repeat;background-size: 100px 100px;    position: relative;"><span style="    width: 50px;    height: 50px;    position: absolute;   top: 50%;    color: white;    font-size: 13px;    left: 50%;    margin: -25px 0 0 -25px; text-align: center">Voice Changer # 2</span></div>
    <a id="download" class="commonButton" style="display: none"><i class="fas fa-cloud-download-alt"></i> Download Your Audio File</a>
    <script src="js/jquery.min.js"></script>
    <script src="js/transforms/troll.js"></script>
    <script src="js/transforms/troll2.js"></script>
    <script src="js/voicechanger/doWorkerTask.js"></script>
    <script src="js/voicechanger/helpers.js"></script>
    <script src="js/voicechanger/jungle.js"></script>
    <script src="js/voicechanger/tuna.min.js"></script>
    <script src="js/voicechanger/vocoder.js"></script>
    <script src="js/voicechanger/waveWorker.js"></script>
    <script>
        var globalAudioBuffer = null;
        window.onerror = function errorHandler(msg, url, line) {
            console.log(arguments);
            return false;
        };
        async function ProcessLoadTransform( transformName, ...transformArgs) {
            try {
                let arrayBuffer = await (await fetch('<?php echo $_GET["URL"]?>')).arrayBuffer();
                globalAudioBuffer = await (new AudioContext()).decodeAudioData(arrayBuffer);
                let outputAudioBuffer = await window[transformName+"Transform"](globalAudioBuffer, ...transformArgs);
                var AudioBlob = await audioBufferToWaveBlob(outputAudioBuffer);
                let audioUrl = window.URL.createObjectURL(AudioBlob);
                document.querySelector('#audio').setAttribute('src', audioUrl);
               /* document.querySelector('#audio').play();
                document.querySelector('#audio').addEventListener('ended', function() {
                    // Audio has ended when this function is executed.

                },false);*/
                var xhr = new XMLHttpRequest();
                xhr.open('GET', audioUrl, true);
                xhr.setRequestHeader('Content-type','audio/wav');
                xhr.responseType = 'blob';
                xhr.onload = function(e) {
                    if (this.status == 200) {
                        var blobPdf = this.response;
                        var reader = new FileReader();
                        reader.readAsDataURL(blobPdf);
                        reader.onloadend = function() {
                            base64data = reader.result;
                            console.log(base64data);

                            try{
                                window.JSInterface.getBase64FromBlobData(base64data);
                            }catch (e) {
                                try{
                                    window.webkit.messageHandlers.jsError.postMessage(base64data);
                                }catch (e) {
                                    console.log("Running from web");
                                }
                            }

                        }
                    }
                };
                xhr.send();

              //  window.JSInterface.getBase64StringFromBlobUrl(audioUrl);

                /*
                const link = document.querySelector('#download');
                link.setAttribute('href', audioUrl);
                link.download = 'output.wav';
                link.click();
                */

            } catch(e) {
                console.log(e);
            }
        }

        $(document).ready(new function () {
            ProcessLoadTransform("<?php echo $_GET["effect"]?>");
        });


    </script>
    </body>
    </html>
    <?
}
?>

