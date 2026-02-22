<h1>Dashboard Civitas</h1>

<h3>Daftar Pengajuan Saya</h3>

<a href="{{ url('/pengajuan/create') }}">
    <button>Buat Pengajuan Dana</button>
</a>


@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Jumlah Dana</th>
        <th>Tanggal Dibutuhkan</th>
        <th>Status</th>
        <th>Alasan Penolakan</th>
    </tr>

    @foreach($pengajuans as $pengajuan)
        <tr>
            <td>{{ $pengajuan->judul }}</td>
            <td>{{ $pengajuan->deskripsi }}</td>
            <td>Rp {{ number_format($pengajuan->jumlah_dana) }}</td>
            <td>{{ $pengajuan->tanggal_dibutuhkan }}</td>
            <td>{{ $pengajuan->status ?? 'Menunggu' }}</td>
            <td>{{ $pengajuan->alasan_penolakan ?? '-' }}</td>
        </tr>
    @endforeach
</table>


<form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
