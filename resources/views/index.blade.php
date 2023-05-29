<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="get">
        @csrf
        <input type="text" name="search" placeholder="Cari nama...">
        <button type="submit">Cari</button>
    </form>
    <br>
    <a href="{{route('add')}}">Tambah Data Baru</a>
    <a href="{{route('trash')}}">Lihat Data Terhapus</a>
    @if (Session::get('success'))
        <p style="padding: 5px 10px; background: green; color: white; margin: 10px">{{session::get('success')}}</p>
    @endif
    @foreach ($students as $student)
    <ol>
        <li>NIS : {{ $student['nis'] }}</li>
        <li>Rombel : {{ $student['rombel'] }}</li>
        <li>Nama : {{ $student['nama'] }}</li>
        <li>Rayon : {{ $student['rayon'] }}</li>
        <li>Aksi : <a href="{{route('edit', $student['id'])}}">Edit</a> ||
            <form action="{{route('delete', $student['id'])}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </li>
    </ol>
    @endforeach
</body>
</html>
