<!-- resources/views/message/create.blade.php -->


    <h1>Buat Pesan Baru</h1>

    <form method="post" action="{{ route('message.store') }}">
        @csrf
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" required>
        <br>
        <label for="content">Content:</label>
        <textarea name="content" required></textarea>
        <br>
        <button type="submit">Kirim Pesan</button>
    </form>

