@extends('layouts.major')

@section('content')

    <head>
        <script>
            if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
                location.reload();
            }
        </script>
        <link rel="author" type="text/html" href="https://plus.google.com/+MuazKhan">
        <meta name="author" content="Muaz Khan">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <script>
            document.createElement('article');
            document.createElement('footer');
        </script>

        <!-- This Library is used to detect WebRTC features -->
        <script src="https://www.webrtc-experiment.com/DetectRTC.js"></script>

        <script src="https://www.webrtc-experiment.com/socket.io.js"> </script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/CodecsHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/RTCPeerConnection-v1.5.js"> </script>
        <script src="https://www.webrtc-experiment.com/webrtc-broadcasting/broadcast.js"> </script>
    </head>
    <div class="container-fluid">
        <div class="video-block section-padding">
    <article>
        <section class="experiment">
            <section>
                <div style="margin: 0 auto;max-width: 500px;">
                    <select id="broadcasting-option" class="form-control" style="color: white;display: none">
                        <option>Audio + Video</option>
                        <option selected>Only Audio</option>
                        <option>Screen</option>
                    </select>
                    <input type="text" id="broadcast-name" class="form-control" placeholder="Enter your name" style="color: white;">
                    <button id="setup-new-broadcast" class="setup btn btn-outline-success" style="margin-top: 8px">Start New Broadcast</button>
                    <button id="stop-broadcast-btn" class="setup btn btn-outline-danger" style="margin-top: 8px;margin-left: 8px;display: none" onclick="window.location.reload()">STOP</button>
                </div>

            </section>

            <!-- list of all available broadcasting rooms -->
            <table style="width: 100%;margin-top: 10px;color: white" id="rooms-list" class="table"></table>

            <!-- local/remote videos container -->
            <div id="videos-container"></div>
        </section>

        <script>

            var config = {
                openSocket: function(config) {
                    var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';

                    config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                    var sender = Math.round(Math.random() * 999999999) + 999999999;

                    io.connect(SIGNALING_SERVER).emit('new-channel', {
                        channel: config.channel,
                        sender: sender
                    });

                    var socket = io.connect(SIGNALING_SERVER + config.channel);
                    socket.channel = config.channel;
                    socket.on('connect', function () {
                        if (config.callback) config.callback(socket);
                    });

                    socket.send = function (message) {
                        socket.emit('message', {
                            sender: sender,
                            data: message
                        });
                    };

                    socket.on('message', config.onmessage);
                },
                onRemoteStream: function(htmlElement) {
                    videosContainer.appendChild(htmlElement);
                    rotateInCircle(htmlElement);
                },
                onRoomFound: function(room) {
                    var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
                    if (alreadyExist) return;

                    if (typeof roomsList === 'undefined') roomsList = document.body;

                    var tr = document.createElement('tr');
                    tr.innerHTML = '<td><strong>' + room.roomName + '</strong> is broadcasting his media!</td>' +
                        '<td><button class="join btn btn-secondary">Join</button></td>';
                    roomsList.appendChild(tr);

                    var joinRoomButton = tr.querySelector('.join');
                    joinRoomButton.setAttribute('data-broadcaster', room.broadcaster);
                    joinRoomButton.setAttribute('data-roomToken', room.broadcaster);
                    joinRoomButton.onclick = function() {
                        this.disabled = true;

                        var broadcaster = this.getAttribute('data-broadcaster');
                        var roomToken = this.getAttribute('data-roomToken');
                        broadcastUI.joinRoom({
                            roomToken: roomToken,
                            joinUser: broadcaster
                        });
                        hideUnnecessaryStuff();
                    };
                },
                onNewParticipant: function(numberOfViewers) {
                    document.title = 'Viewers: ' + numberOfViewers;
                },
                onReady: function() {
                    console.log('now you can open or join rooms');
                }
            };

            function setupNewBroadcastButtonClickHandler() {
                document.getElementById('broadcast-name').disabled = true;
                document.getElementById('setup-new-broadcast').disabled = true;
                document.getElementById('stop-broadcast-btn').style.display = 'inline';

                DetectRTC.load(function() {
                    captureUserMedia(function() {
                        var shared = 'video';
                        if (window.option == 'Only Audio') {
                            shared = 'audio';
                        }
                        if (window.option == 'Screen') {
                            shared = 'screen';
                        }

                        broadcastUI.createRoom({
                            roomName: (document.getElementById('broadcast-name') || { }).value || 'Anonymous',
                            isAudio: shared === 'audio'
                        });
                    });
                    hideUnnecessaryStuff();
                });
            }

            function captureUserMedia(callback) {
                var constraints = null;
                window.option = broadcastingOption ? broadcastingOption.value : '';
                if (option === 'Only Audio') {
                    constraints = {
                        audio: true,
                        video: false
                    };

                    if(DetectRTC.hasMicrophone !== true) {
                        alert('DetectRTC library is unable to find microphone; maybe you denied microphone access once and it is still denied or maybe microphone device is not attached to your system or another app is using same microphone.');
                    }
                }
                if (option === 'Screen') {
                    var video_constraints = {
                        mandatory: {
                            chromeMediaSource: 'screen'
                        },
                        optional: []
                    };
                    constraints = {
                        audio: false,
                        video: video_constraints
                    };

                    if(DetectRTC.isScreenCapturingSupported !== true) {
                        alert('DetectRTC library is unable to find screen capturing support. You MUST run chrome with command line flag "chrome --enable-usermedia-screen-capturing"');
                    }
                }

                if (option != 'Only Audio' && option != 'Screen' && DetectRTC.hasWebcam !== true) {
                    alert('DetectRTC library is unable to find webcam; maybe you denied webcam access once and it is still denied or maybe webcam device is not attached to your system or another app is using same webcam.');
                }

                var htmlElement = document.createElement(option === 'Only Audio' ? 'audio' : 'video');

                htmlElement.muted = true;
                htmlElement.volume = 0;

                try {
                    htmlElement.setAttributeNode(document.createAttribute('autoplay'));
                    htmlElement.setAttributeNode(document.createAttribute('playsinline'));
                    htmlElement.setAttributeNode(document.createAttribute('controls'));
                } catch (e) {
                    htmlElement.setAttribute('autoplay', true);
                    htmlElement.setAttribute('playsinline', true);
                    htmlElement.setAttribute('controls', true);
                }

                var mediaConfig = {
                    video: htmlElement,
                    onsuccess: function(stream) {
                        config.attachStream = stream;

                        videosContainer.appendChild(htmlElement);
                        rotateInCircle(htmlElement);

                        callback && callback();
                    },
                    onerror: function() {
                        if (option === 'Only Audio') alert('unable to get access to your microphone');
                        else if (option === 'Screen') {
                            if (location.protocol === 'http:') alert('Please test this WebRTC experiment on HTTPS.');
                            else alert('Screen capturing is either denied or not supported. Are you enabled flag: "Enable screen capture support in getUserMedia"?');
                        } else alert('unable to get access to your webcam');
                    }
                };
                if (constraints) mediaConfig.constraints = constraints;
                getUserMedia(mediaConfig);
            }

            var broadcastUI = broadcast(config);

            /* UI specific */
            var videosContainer = document.getElementById('videos-container') || document.body;
            var setupNewBroadcast = document.getElementById('setup-new-broadcast');
            var roomsList = document.getElementById('rooms-list');

            var broadcastingOption = document.getElementById('broadcasting-option');

            if (setupNewBroadcast) setupNewBroadcast.onclick = setupNewBroadcastButtonClickHandler;

            function hideUnnecessaryStuff() {
                var visibleElements = document.getElementsByClassName('visible'),
                    length = visibleElements.length;
                for (var i = 0; i < length; i++) {
                    visibleElements[i].style.display = 'none';
                }
            }

            function rotateInCircle(video) {
                video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                setTimeout(function() {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                }, 1000);
            }

        </script>


        <section class="experiment"><small id="send-message"></small></section>
    </article>
        </div>
    </div>

    <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/webrtc-broadcasting" class="fork-left"></a>


    <!-- commits.js is useless for you! It is not part of this WebRTC Experiment. -->
    <script src="https://www.webrtc-experiment.com/commits.js" async> </script>

@endsection
