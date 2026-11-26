@csrf

<div class="grid">
    <div>
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $member->nama) }}" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" required>
    </div>
    <div>
        <label for="no_telepon">Nomor Telepon</label>
        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $member->no_telepon) }}">
    </div>
    <div>
        <label for="tanggal_lahir">Tanggal Lahir</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $member->tanggal_lahir?->format('Y-m-d')) }}">
    </div>
    <div>
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="L" @selected(old('jenis_kelamin', $member->jenis_kelamin) === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $member->jenis_kelamin) === 'P')>Perempuan</option>
        </select>
    </div>
    <div>
        <label for="membership_type_id">Tipe Keanggotaan</label>
        <select id="membership_type_id" name="membership_type_id" required>
            <option value="">-- Pilih --</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}" @selected((string) old('membership_type_id', $member->membership_type_id) === (string) $type->id)>
                    {{ $type->nama }} ({{ $type->durasi_bulan }} bulan)
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="tanggal_daftar">Tanggal Daftar</label>
        <input type="date" id="tanggal_daftar" name="tanggal_daftar" value="{{ old('tanggal_daftar', $member->tanggal_daftar?->format('Y-m-d')) }}" required>
    </div>
    <div>
        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="aktif" @selected(old('status', $member->status) === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $member->status) === 'nonaktif')>Nonaktif</option>
        </select>
    </div>
</div>

<label for="alamat">Alamat</label>
<textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $member->alamat) }}</textarea>

<p class="muted">Nomor kartu dan masa berlaku dibuat otomatis oleh sistem.</p>

<p>
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route('members.index') }}" class="btn btn-gray">Batal</a>
</p>
