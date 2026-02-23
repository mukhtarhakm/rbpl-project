<h1>Dashboard Bendahara</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Judul</th>
        <th>Jumlah Dana</th>
        <th>Aksi</th>
    </tr>

    @foreach($pengajuans as $pengajuan)
    <tr>
        <td>{{ $pengajuan->judul }}</td>
        <td>Rp {{ number_format($pengajuan->jumlah_dana) }}</td>
        <td>
            <form action="/pengajuan/{{ $pengajuan->id }}/cairkan" method="POST">
                @csrf
                <button type="submit">Cairkan Dana</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>


<form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
