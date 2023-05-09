@extends('mahasiswas.layout')

@section('content')
<div class="container mt-5">
    <h1>Kartu Hasil Studi (KHS)</h1>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Nama: </b>{{$Mahasiswa->Nama}}</li>
        <li class="list-group-item"><b>Nim: </b>{{$Mahasiswa->Nim}}</li>
        <li class="list-group-item"><b>Kelas: </b>{{$Mahasiswa->Kelas->nama_kelas}}</li>
    </ul>
    <table class="table table-bordered">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
        @foreach ($Mahasiswa->matakuliah as $mahasiswa)
        <tr>
            <td>{{ $mahasiswa->nama_matkul }}</td>
            <td>{{ $mahasiswa->sks }}</td>
            <td>{{ $mahasiswa->semester }}</td>
            <td>{{ $mahasiswa->pivot->nilai }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection