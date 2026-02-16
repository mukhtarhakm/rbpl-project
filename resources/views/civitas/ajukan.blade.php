<h2>Form Pengajuan Dana</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="/pengajuan/store" method="POST">
    @csrf

    <label>Judul</label><br>
    <input type="text" name="judul" value="{{ old('judul') }}">

@error('judul')
    <p style="color:red">{{ $message }}</p>
@enderror
    <br><br>


    <label>Deskripsi</label><br>
    <textarea name="deskripsi">{{ old('deskripsi') }}</textarea>

@error('deskripsi')
    <p style="color:red">{{ $message }}</p>
@enderror
    <br><br>


    <label>Jumlah Dana</label><br>
    <input type="number" name="jumlah_dana" value="{{ old('jumlah_dana') }}">

@error('jumlah_dana')
    <p style="color:red">{{ $message }}</p>
@enderror
    <br><br>


    <label>Tanggal Dibutuhkan</label><br>
    <input type="date" name="tanggal_dibutuhkan" value="{{ old('tanggal_dibutuhkan') }}">

@error('tanggal_dibutuhkan')
    <p style="color:red">{{ $message }}</p>
@enderror
    <br><br>


    <button type="submit">Kirim Pengajuan</button>
</form>
