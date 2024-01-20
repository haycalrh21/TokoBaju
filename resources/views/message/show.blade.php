<h1>Detail Pesan</h1>

    <p>ID: {{ $message->id }}</p>
    <p>User ID: {{ $message->user_id }}</p>
    <p>Content: {{ $message->content }}</p>
    <p>Status: {{ $message->status }}</p>
    <p><a href="{{ route('message.index') }}">Kembali ke Daftar Pesan</a></p>
