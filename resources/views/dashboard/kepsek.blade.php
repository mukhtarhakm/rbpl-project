<h1>Dashboard Kepala Sekolah</h1>

<h2>Persetujuan Dana</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Jumlah Dana</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($pengajuans as $pengajuan)
    <tr>
        <td>{{ $pengajuan->judul }}</td>
        <td>{{ $pengajuan->deskripsi }}</td>
        <td>Rp {{ number_format($pengajuan->jumlah_dana) }}</td>
        <td>{{ $pengajuan->status }}</td>
        <td>
            @if($pengajuan->status == 'menunggu')
                <form action="/pengajuan/{{ $pengajuan->id }}/approve" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Setujui</button>
                </form>

                <form action="/pengajuan/{{ $pengajuan->id }}/reject" method="POST" style="display:inline;">
                    @csrf
                    <input type="text" name="alasan_penolakan" placeholder="Alasan penolakan">
                    <button type="submit">Tolak</button>
                </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>

<form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
