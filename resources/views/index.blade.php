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
    <input id="btnPicture" type="button" disabled="true" value="Take Picture"></input>
    <!-- <img id="image_png" src="#"> -->
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

        navigator.getUserMedia(medias, successCallback, errorCallback);

        var width = 0, height = 0;

        video.addEventListener( "loadedmetadata", function (e) {
            width = this.videoWidth;
            height = this.videoHeight;
        }, false );

        // $.ajaxSetup ({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        function successCallback(stream) {
            video.srcObject = stream;

            var button = document.getElementById("btnPicture");
        	var canvas = document.getElementById("imageCanvas");

            button.disabled = false;
    		button.onclick = function() {
                canvas.width = width;
                canvas.height = height;
    			canvas.getContext("2d").drawImage(video, 0, 0, width, height, 0, 0, width, height);
    			var img = canvas.toDataURL("image/png");

                $('#imagePost').val(img);
                $('#formResult').submit();
                // console.log(img);
                // document.getElementById("image_png").src = img;
                // $.ajax({
                //     url:'/result',
                //     type:'POST',
                //     data:{
                //         'imageData':img
                //     }
                // })
                // .done( (data) => {
                //     console.log('done');
                //     console.log(data);
                // })
                // .fail( (data) => {
                //     console.log('fail');
                //     console.log(data);
                // })
                // .always( (data) => {
                // });
    		};
        };

        function errorCallback(err) {
            alert(err);
        };
    </script>
</body>
@endsection
