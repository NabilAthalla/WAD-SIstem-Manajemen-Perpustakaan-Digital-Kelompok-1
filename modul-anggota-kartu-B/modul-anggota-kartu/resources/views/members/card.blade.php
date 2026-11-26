<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ID Card - {{ $member->nomor_kartu }} - LiteraHub</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 30px; font-family: Arial, Helvetica, sans-serif; background: #e5e7eb; text-align: center; }
        .id-card { width: 340px; height: 215px; margin: 0 auto 20px; background: linear-gradient(135deg, #1e3a5f, #0f8a8a); color: #fff; border-radius: 12px; padding: 16px 18px; text-align: left; position: relative; box-shadow: 0 4px 10px rgba(0,0,0,.25); }
        .id-card .head { font-size: 11px; letter-spacing: 1px; text-transform: uppercase; opacity: .85; border-bottom: 1px solid rgba(255,255,255,.4); padding-bottom: 6px; margin-bottom: 10px; }
        .id-card .name { font-size: 18px; font-weight: bold; margin-bottom: 2px; }
        .id-card .type { font-size: 12px; opacity: .9; margin-bottom: 10px; }
        .id-card .row { font-size: 11px; margin-bottom: 3px; }
        .id-card .row span { display: inline-block; width: 78px; opacity: .8; }
        .id-card .number { position: absolute; left: 18px; bottom: 14px; font-family: "Courier New", monospace; font-size: 17px; letter-spacing: 2px; background: rgba(255,255,255,.18); padding: 3px 8px; border-radius: 4px; }
        .id-card .state { position: absolute; right: 18px; bottom: 16px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .actions button, .actions a { display: inline-block; padding: 8px 16px; margin: 0 4px; border: 0; border-radius: 5px; background: #1e3a5f; color: #fff; font-size: 14px; cursor: pointer; text-decoration: none; }
        @@media print {
            body { background: #fff; padding: 0; }
            .actions { display: none; }
            .id-card { box-shadow: none; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="head">Kartu Anggota LiteraHub</div>
        <div class="name">{{ $member->nama }}</div>
        <div class="type">{{ $member->membershipType->nama ?? '-' }}</div>
        <div class="row"><span>Terdaftar</span>: {{ $member->tanggal_daftar?->format('d/m/Y') }}</div>
        <div class="row"><span>Berlaku s.d.</span>: {{ $member->tanggal_berlaku?->format('d/m/Y') }}</div>
        <div class="row"><span>Maks. pinjam</span>: {{ $member->membershipType->maks_pinjam ?? '-' }} buku</div>
        <div class="number">{{ $member->nomor_kartu }}</div>
        <div class="state">{{ $member->isExpired() ? 'Kedaluwarsa' : ucfirst($member->status) }}</div>
    </div>

    <div class="actions">
        <button type="button" onclick="window.print()">Cetak</button>
        <a href="{{ route('members.show', $member) }}">Kembali</a>
    </div>
</body>
</html>
