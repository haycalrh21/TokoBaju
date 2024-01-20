<!-- Menampilkan pesan dari pengguna -->
@extends('admin.template.main')

@section('contents')
<style>
    /* Styling untuk pesan dan balasannya */
    .message-container {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .user-name {
        font-weight: bold;
        color: #007BFF;
    }

    .reply-container {
        margin-top: 10px;
        margin-left: 20px;
    }

    /* Styling untuk formulir balasan */
    .reply-form {
        margin-top: 10px;
    }

    .reply-form textarea {
        width: 100%;
        padding: 5px;
        margin-bottom: 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    .reply-form button {
        background-color: #007BFF;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .admin-reply-container {
        background-color: #f2f2f2;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .admin-reply-content {
        font-weight: bold;
        color: #d9534f;
        margin-left: 80%;
    }

</style>

@foreach($messages as $message)
    <div class="message-container">
        <p><span class="user-name">{{ $message->user->name }}</span>: {{ $message->content }}</p>

        <!-- Menampilkan balasan -->
        @if($message->replies)
            <ul class="reply-container">
                @foreach($message->replies as $reply)
                    <li>
                        @if($reply->is_admin_reply)
                            <div class="admin-reply-container">
                                <span class="admin-reply-content">Admin:</span>
                                {{ $reply->content }}
                            </div>
                        @else
                            {{ $message->user->name }}: {{ $reply->content }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Form untuk memberikan balasan -->
        <form class="reply-form" action="{{ route('admin.messages.reply', ['id' => $message->id]) }}" method="post">
            @csrf
            <textarea name="adminReply" placeholder="Balas pesan"></textarea>
            <button type="submit">Balas</button>
        </form>
    </div>
@endforeach
@endsection
