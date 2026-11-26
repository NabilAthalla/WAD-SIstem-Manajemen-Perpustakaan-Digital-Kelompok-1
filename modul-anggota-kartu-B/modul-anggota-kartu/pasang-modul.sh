#!/usr/bin/env bash
# Memasang modul Anggota & Kartu ke ROOT proyek Laravel tim.
# Pakai:  bash pasang-modul.sh /path/ke/root-laravel   (root = folder yang berisi artisan)
set -euo pipefail

MODUL="$(cd "$(dirname "$0")" && pwd)"
TARGET="${1:-.}"
TARGET="$(cd "$TARGET" && pwd)"

if [ ! -f "$TARGET/artisan" ]; then
  echo "ERROR: '$TARGET' bukan root Laravel (file 'artisan' tidak ada)."
  echo "Jalankan: bash pasang-modul.sh <folder-yang-berisi-artisan>"
  exit 1
fi

echo "Memasang modul ke: $TARGET"
mkdir -p "$TARGET/routes" "$TARGET/resources/views/layouts" "$TARGET/tests/Feature"

cp -R "$MODUL/app/."      "$TARGET/app/"
cp -R "$MODUL/database/." "$TARGET/database/"
cp -R "$MODUL/resources/views/members"          "$TARGET/resources/views/"
cp -R "$MODUL/resources/views/membership-types" "$TARGET/resources/views/"
[ -f "$TARGET/resources/views/layouts/app.blade.php" ] || cp "$MODUL/resources/views/layouts/app.blade.php" "$TARGET/resources/views/layouts/"
cp "$MODUL/routes/anggota.php" "$TARGET/routes/anggota.php"
cp "$MODUL/tests/Feature/MemberModuleTest.php" "$TARGET/tests/Feature/"

# Daftarkan route modul di routes/web.php milik tim (tanpa menimpa isinya).
WEB="$TARGET/routes/web.php"
if [ ! -f "$WEB" ]; then
  cp "$MODUL/routes/web.php" "$WEB"
  echo "routes/web.php dibuat."
elif ! grep -q "anggota.php" "$WEB"; then
  printf "\nrequire __DIR__ . '/anggota.php';\n" >> "$WEB"
  echo "Baris require anggota.php ditambahkan ke routes/web.php."
else
  echo "routes/web.php sudah memuat anggota.php (dilewati)."
fi

cat <<MSG

Selesai. Langkah berikutnya (di folder $TARGET):
  php artisan migrate
  php artisan db:seed --class=MembershipTypeSeeder
  php artisan db:seed --class=MemberSeeder
  php artisan route:list --name=members
  php artisan serve        -> buka http://127.0.0.1:8000/members
MSG
