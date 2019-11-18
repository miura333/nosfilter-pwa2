@extends('layout')
@section('pwa')
<link rel="manifest" href="./manifest.json">
<script>
// service workerが有効なら、service-worker.js を登録します
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./service-worker.js').then(function() { console.log('Service Worker Registered'); });
}
</script>
@endsection

@section('content')
<body class="cameraBody">
    <video id="video" autoplay playsinline></video>
    <div class="cameraSpacer"></div>
    <div class="cameraButtonParent">
        <div class="cameraButtonParent2">
            <input id="btnPicture" type="button" disabled="true" value="OK" class="cameraBtn"></input>
        </div>
    </div>
    <canvas id="imageCanvas" style="display:none;" width="300" height="300"></canvas>
    {!! Form::open(['url' => '/result', 'id' => 'formResult']) !!}
    {!! Form::hidden('imageData', null, ['id' => 'imagePost']) !!}
    {!! Form::close() !!}

    <script>
        const medias = {audio : false, video : {
            facingMode : {
              exact : "environment" // リアカメラにアクセス
            }
        }},
        video  = document.getElementById("video");

        // navigator.getUserMedia(medias, successCallback, errorCallback);
        navigator.mediaDevices.getUserMedia(medias).then(successCallback).catch(errorCallback);

        var width = 0, height = 0;

        video.addEventListener( "loadedmetadata", function (e) {
            width = this.videoWidth;
            height = this.videoHeight;
        }, false );

        function successCallback(stream) {
            video.srcObject = stream;

            var button = document.getElementById("btnPicture");
        	var canvas = document.getElementById("imageCanvas");

            button.disabled = false;
    		button.onclick = function() {
                canvas.width = width;
                canvas.height = height;
    			canvas.getContext("2d").drawImage(video, 0, 0, width, height, 0, 0, width, height);
                // canvas.width = 10;
                // canvas.height = 10;
                // canvas.getContext("2d").drawImage(video, 0, 0, 10, 10, 0, 0, 10, 10);
    			var img = canvas.toDataURL("image/jpeg");
                // console.log(img);

                $('#imagePost').val(img);
                $('#formResult').submit();
    		};
        };

        function errorCallback(err) {
            alert(err);
        };
    </script>
</body>
@endsection
