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
            <td> 
                @if($pengajuan->status == 'menunggu')
                    Menunggu
                @elseif($pengajuan->status == 'disetujui_kepsek')
                    Disetujui Kepsek
                @elseif($pengajuan->status == 'disetujui')
                    Disetujui Bendahara
                @elseif($pengajuan->status == 'dicairkan')
                    Dicairkan
                    <form action="/pengajuan/{{ $pengajuan->id }}/upload-bukti" 
                        method="POST" 
                        enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="bukti" required>
                        <button type="submit">Upload Bukti</button>
                    </form>
                @elseif($pengajuan->status == 'ditolak')
                    Ditolak
                @elseif($pengajuan->status == 'selesai')
                    Selesai
                @else
                    -
                @endif
            </td>
            <td>{{ $pengajuan->alasan_penolakan ?? '-' }}</td>
        </tr>
    @endforeach
</table>


<form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
