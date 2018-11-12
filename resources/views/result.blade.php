@extends('layout')
@section('content')
<body class="cameraBody">
    <div class="appHeader">
        <div class="appHeaderTitle">
            <table border="0" width="100%">
                <tr>
                    <td width="20%"><a class="linkBackButtonText" href="/">Back</a></td>
                    <td width="60%">Result</td>
                    <td width="20%"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="appHeaderBorder"></div>

    <img class="object-fit-img" src="{{$imageData}}"><br>
    <!-- <img src="{{$imageData}}" width={{$width}} height={{$height}}> -->
    <p class="downloadText">画像を長押ししてダウンロードしてください。</p>
</body>
@endsection
