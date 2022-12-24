<!DOCTYPE html>
<html lang="en">

<head>
    <link type="text/css" rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
    <h1 class="text-center">Data Buku</h1>
    <p class="text-center">Laporan data buku tahun 2022</p>
    <br />
    <table id="table-data" class="table table-borderer">
        <thead>
            <tr class="text-center">
                <th>NO</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Kategori Buku</th>
                <th>Penerbit</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @forelse ($books as $item => $book)
            <tr id="table-row{{$book->id}}">
                <td>{{$item+1}}</td>
                <td>{{$book->judul}}</td>
                <td>{{$book->penulis}}</td>
                <td>{{$book->tahun}}</td>
                <td>{{$book->kategori->nama_kategori}}</td>
                <td>{{$book->penerbit}}</td>
            </tr>
            @empty
            <h4>Data Kosong</h4>
            @endforelse
        </tbody>
    </table>
</body>

</html>