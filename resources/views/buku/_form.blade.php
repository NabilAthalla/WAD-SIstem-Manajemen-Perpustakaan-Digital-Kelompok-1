<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Judul Buku</label>
        <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">ISBN</label>
        <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $buku->isbn ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Penulis</label>
        <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $buku->penulis ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Penerbit</label>
        <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit', $buku->penerbit ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Tahun Terbit</label>
        <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $buku->tahun ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="kategori_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategoris as $k)
                <option value="{{ $k->id }}" @selected(old('kategori_id', $buku->kategori_id ?? '') == $k->id)>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Stok</label>
        <input type="number" name="stok" min="0" class="form-control" value="{{ old('stok', $buku->stok ?? 0) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Cover (opsional, maks 2 MB)</label>
        <input type="file" name="cover" accept="image/*" class="form-control">
        @if (!empty($buku->cover))
            <img src="{{ asset('storage/' . $buku->cover) }}" class="mt-2 rounded" width="80" alt="cover saat ini">
        @endif
    </div>
</div>