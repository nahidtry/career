<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="assets/stylesheets/video-js.min.css" rel="stylesheet">
    <link href="assets/stylesheets/videojs.record.css" rel="stylesheet">

    <script src="assets/javascript/video.min.js"></script>
    <script src="assets/javascript/RecordRTC.js"></script>
    <script src="assets/javascript/adapter.js"></script>
    <script src="assets/javascript/wavesurfer.min.js"></script>
    <script src="assets/javascript/wavesurfer.microphone.min.js"></script>
    <script src="assets/javascript/videojs.wavesurfer.min.js"></script>

    <script src="assets/javascript/videojs.record.js"></script>

    <style>
        /* change player background color */
        #myAudio {
            background-color: #9FD6BA;
        }
    </style>

</head>

<body style="margin:0; padding:0;">

    <audio style="margin:0; padding:0;" id="myAudio" class="video-js vjs-default-skin"></audio>
    <span style="color:green; width:100%;" id="audioSuccess"></span>
    <span style="color:red; width:100%;" id="audioError"></span>

    <script>
        var player = videojs("myAudio", {
            controls: true,
            width: 520,
            height: 175,
            fluid: false,
            plugins: {
                wavesurfer: {
                    src: "live",
                    waveColor: "#36393b",
                    progressColor: "black",
                    debug: true,
                    cursorWidth: 1,
                    msDisplayMax: 20,
                    hideScrollbar: true
                },
                record: {
                    audio: true,
                    video: false,
                    maxLength: 300,
                    debug: true
                }
            }
        }, function() {
            // print version information at startup
            var msg = 'Using video.js ' + videojs.VERSION +
                ' with videojs-record ' + videojs.getPluginVersion('record') +
                ', videojs-wavesurfer ' + videojs.getPluginVersion('wavesurfer') +
                ', wavesurfer.js ' + WaveSurfer.VERSION + ' and recordrtc ' +
                RecordRTC.version;
            videojs.log(msg);
        });
        // error handling
        player.on('deviceError', function() {
            //console.log('device error:', player.deviceErrorCode);
            document.getElementById('audioError').innerHTML = 'Device Not Found!';
        });
        player.on('error', function(error) {
            //console.log('error:', error);
            document.getElementById('audioError').innerHTML = 'Please Connect your Device!';
        });
        player.on('deviceReady', function() {
            //console.log('device error:', player.deviceErrorCode);
            document.getElementById('audioError').innerHTML = '';
            document.getElementById('audioSuccess').innerHTML = 'Device is Ready. Record your audio NOW!';
    
        });
        // user clicked the record button and started recording
        player.on('startRecord', function() {
            //console.log('started recording!');
            //document.getElementById('audioText').innerHTML = 'Audio Recording Started!';
        });

        player.on('progressRecord', function() {
            //console.log('started recording!');
            document.getElementById('audioSuccess').innerHTML = '';
            document.getElementById('audioError').innerHTML = "Recording is ON";

        });

        // user completed recording and stream is available
        player.on('finishRecord', function() {
            // the blob object contains the recorded data that
            // can be downloaded by the user, stored on server etc.
            //console.log('finished recording: ', player.recordedData);
            //document.getElementById('audioText').innerHTML = 'Audio Recording Finished!';

            var formData = new FormData();
            formData.append('audio', player.recordedData);

            // Execute the ajax request, in this case we have a very simple PHP script
            // that accepts and save the uploaded "video" file
            xhr('upload_files/upload-video.php', formData, function(fName) {
                //console.log("Video succesfully uploaded !", fName);
                document.getElementById('audioError').innerHTML = '';
                document.getElementById('audioSuccess').innerHTML = 'Recording Successfully Saved.You can check your record by click on play button or You can Record Again!';
            });

            // Helper function to send 
            function xhr(url, data, callback) {
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        callback(location.href + request.responseText);
                    }
                };
                request.open('POST', url);
                request.send(data);
            }

        });
    </script>
</body>

</html>