<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center">Data Buku</h1>
    <p class="text-center">Laporan data buku tahun 2022</p>
    <br/>
    <table id="table-data" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>NO</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Penerbit</th>
                <th>Cover</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $item => $book)
                <tr>
                    <td>{{$item+1}}</td>
                    <td>{{$book->judul}}</td>
                    <td>{{$book->penulis}}</td>
                    <td>{{$book->tahun}}</td>
                    <td>{{$book->penerbit}}</td>
                    <td>
                        @if ($book->cover !== null)
                            <img src="{{asset('storage/cover_buku/'.$book->cover)}}" width="100px"/>
                        @else
                        [Gambar tidak tersedia]
                        @endif    
                    </td>  
                </tr>                        
            @empty
                <h4>Data Kosong</h4>
            @endforelse
        </tbody>
    </table>
</body>
</html>