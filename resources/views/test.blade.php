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
    {!! Form::open(['url' => '/result', 'id' => 'formResult']) !!}
    {!! Form::hidden('imageData','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAAXNSR0IArs4c6QAAATtJREFUGBkdkMuSmkAYRk83DESR8TLGUmuSmco+T5BnyLPkifJS2WQxm1Sl4gUUUKQFoen8zv7U+S7q54/vbhCNWH79hp29Ym4t51POIfnH2+9f7P+8EViDrlRAvPpMGI9xzqFwNLURMOV0zPBty/MsRqvJgtHqBeuHdF3H1VyoLmeK45GqOBN5sB4P0LNPX/Aen2iUT9U0HLIDm81f8mTHg9hW05hp5KPHi2caHjCtpapriiIn3W2py4JJ6LOejwn9Hh2EEW2HRF4pTxnZfkd5SNBNyWoSEofSuu/QGg/b9nSy9lLcwS22uvA09CQ2wHM36B3aysqb7WRAKb1STJ4RiOEeGQ81zjY4pdDv0NWQyxVZkmCN4WM8ZDEdoVwDyt6FUqWWbuWZY5pSii2UjOU8YvDBE6AXmxZK8R87TLCxzD7MgQAAAABJRU5ErkJggg==', ['id' => 'imagePost']) !!}
    {!! Form::submit('送信') !!}
    {!! Form::close() !!}
</body>
@endsection
