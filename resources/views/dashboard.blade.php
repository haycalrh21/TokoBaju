<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
@include('template.navbar')
<body>
    @include('template.loading')
    <form method="post" action="{{ route('dashboard') }}"enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

    <div class="my-4 max-w-screen-md border px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">
        <div class="flex flex-col border-b py-4 sm:flex-row sm:items-start">
          <div class="shrink-0 mr-auto sm:py-3">
            <p class="font-medium">Account Details</p>
            <p class="text-sm text-gray-600">Edit your account details</p>
          </div>

        </div>
        <div class="flex flex-col gap-4 py-4  lg:flex-row">
            <!-- Avatar file input -->
            <div class="shrink-0 w-32  sm:py-4">
                <p class="mb-auto font-medium">Avatar</p>
                <p class="text-sm text-gray-600">Change your avatar</p>
            </div>
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">Avatar</p>
                <input type="file" name="avatar" accept="image/*">
            </div>
        </div>
        @auth
        <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">
            <p class="shrink-0 w-32 font-medium">Name</p>
            <input class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" />
        </div>
        <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">
            <p class="shrink-0 w-32 font-medium">Email</p>
            <input class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" />
        </div>
    @endauth


        <div class="flex justify-end py-4 sm:hidden">
          <button class="mr-2 rounded-lg border-2 px-4 py-2 font-medium text-gray-500 focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>
          <button class="rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">Save</button>
        </div>
        <button class="mr-2 hidden rounded-lg border-2 px-4 py-2 font-medium text-gray-500 sm:inline focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>

        <button id="save-button" class="rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">Save</button>


    </div>
    </form>


@if(session('alertMessage'))
    @include('alert.rubahprofil')
@endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function () {
    $("form").on("submit", function (e) {
        e.preventDefault();

        var form = $(this)[0];
        var formData = new FormData(form);

        Swal.fire('Sedang memproses', 'Silakan tunggu...', 'info');

        $.ajax({
            url: "{{ route('lohe') }}", // Ganti route ke 'lohe' sesuai dengan endpoint yang diinginkan
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    Swal.close();
                    Swal.fire('Sukses', 'Data telah diperbarui', 'success');
                }
            },
            error: function (xhr) {
                Swal.close();
                Swal.fire('Error', 'Terjadi kesalahan', 'error');
            }
        });
    });
});

    </script>




    <br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>

@include('template.footer')
</html>
