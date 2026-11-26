@csrf

<div class="grid">
    <div>
        <label for="nama">Nama Tipe</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $type->nama) }}" required>
    </div>
    <div>
        <label for="kode">Kode</label>
        <input type="text" id="kode" name="kode" value="{{ old('kode', $type->kode) }}" required>
    </div>
    <div>
        <label for="durasi_bulan">Durasi Keanggotaan (bulan)</label>
        <input type="number" id="durasi_bulan" name="durasi_bulan" min="1" max="120" value="{{ old('durasi_bulan', $type->durasi_bulan) }}" required>
    </div>
    <div>
        <label for="maks_pinjam">Maksimal Pinjam (buku)</label>
        <input type="number" id="maks_pinjam" name="maks_pinjam" min="1" max="50" value="{{ old('maks_pinjam', $type->maks_pinjam) }}" required>
    </div>
    <div>
        <label for="biaya">Biaya (Rp)</label>
        <input type="number" id="biaya" name="biaya" min="0" value="{{ old('biaya', $type->biaya ?? 0) }}" required>
    </div>
</div>

<p>
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route('membership-types.index') }}" class="btn btn-gray">Batal</a>
</p>
