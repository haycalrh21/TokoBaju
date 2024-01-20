<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pesan</title>
</head>

@include('template.navbar')
<body>
    <!-- Form untuk membuat pesan baru -->
<form action="{{ route('messages.store') }}" method="post">
    @csrf
    <input type="text" name="content" placeholder="Tulis pesan baru">
    <button type="submit">Kirim</button>
</form>

<!-- Menampilkan pesan dan balasannya -->
@foreach($messages as $message)
    <div>
        <p>{{ $message->content }}</p>
        <!-- Menampilkan balasan -->
        @if($message->replies)
            <ul>
                @foreach($message->replies as $reply)
                    <li>{{ $reply->content }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Form untuk membuat balasan -->
        <form action="{{ route('messages.reply', ['messageId' => $message->id]) }}" method="post">
            @csrf
            <input type="text" name="content" placeholder="Balas pesan ini">
            <button type="submit">Balas</button>
        </form>
    </div>
@endforeach

</body>
</html>
