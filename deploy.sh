#!/usr/bin/env bash
# Deploy de fișiere pe uraniastudio.eu (server "hive").
# Folosire:  ./deploy.sh <eticheta> <fisier1> [fisier2 ...]
# Exemplu:   ./deploy.sh instagram includes/footer.php contact.php
# Adaugă --dry-run ca prim argument ca doar să verifici, fără să încarci.
set -euo pipefail
cd "$(dirname "$0")"

HOST=hive
S=/srv/sites/uraniastudio/uraniastudio
P=$S/public_html

DRY=0
if [ "${1:-}" = "--dry-run" ]; then DRY=1; shift; fi
if [ $# -lt 2 ]; then
  echo "Folosire: ./deploy.sh [--dry-run] <eticheta> <fisier1> [fisier2 ...]"; exit 1
fi
LABEL=$1; shift
FILES=("$@")

for f in "${FILES[@]}"; do
  [ -f "$f" ] || { echo "Nu există local: $f"; exit 1; }
done

# 0. Fiecare <img> trebuie să aibă alt. Fără alt = oprire; alt="" = doar avertisment
#    (permis pentru imagini decorative).
ALT_FAIL=0
for f in "${FILES[@]}"; do
  case "$f" in *.php|*.html) ;; *) continue ;; esac
  out=$(perl -0777 -ne 'while (/<img\b((?:<\?.*?\?>|[^>])*)>/gs) { my $t=$1; my $l=1+(substr($_,0,$-[0])=~tr/\n//); if ($t !~ /\balt\s*=/) { print "  FĂRĂ ALT  $ARGV:$l\n" } elsif ($t =~ /\balt\s*=\s*""/) { print "  alt gol   $ARGV:$l (ok doar dacă e decorativă)\n" } }' "$f")
  [ -n "$out" ] && echo "$out"
  echo "$out" | grep -q "FĂRĂ ALT" && ALT_FAIL=1
done
[ $ALT_FAIL = 1 ] && { echo "Oprit: imagini fără alt. Adaugă alt (sau alt=\"\" dacă e decorativă)."; exit 1; }

# 1. Verificare: fișierul de pe server trebuie să fie versiunea anterioară din git
#    (sau deja cea nouă). Altfel cineva l-a modificat direct pe server.
echo "== Verificare server"
PROBLEM=0
for f in "${FILES[@]}"; do
  local_md5=$(md5 -q "$f")
  prev=$(git log -2 --format=%H -- "$f" | tail -1)
  prev_md5=$( [ -n "$prev" ] && git show "$prev:$f" 2>/dev/null | md5 -q || echo none)
  last_md5=$(git show "HEAD:$f" 2>/dev/null | md5 -q || echo none)
  srv_md5=$(ssh -o BatchMode=yes $HOST "sudo md5sum $P/$f 2>/dev/null | cut -d' ' -f1" || true)
  srv_md5=${srv_md5:-lipsă}
  if   [ "$srv_md5" = "$local_md5" ]; then st="deja la zi"
  elif [ "$srv_md5" = "$prev_md5" ] || [ "$srv_md5" = "$last_md5" ]; then st="ok, se actualizează"
  elif [ "$srv_md5" = "lipsă" ]; then st="fișier nou"
  else st="ATENȚIE: modificat pe server!"; PROBLEM=1
  fi
  printf '  %-30s %s\n' "$f" "$st"
done
if [ $PROBLEM = 1 ]; then
  echo "Oprit: unele fișiere au fost schimbate direct pe server. Verifică înainte de a le suprascrie."; exit 1
fi
[ $DRY = 1 ] && { echo "Dry-run: nimic încărcat."; exit 0; }

# 2-5. Backup, încărcare, proprietar și drepturi, verificare md5
echo "== Încărcare"
LIST="${FILES[*]}"
COPYFILE_DISABLE=1 tar --no-xattrs -czf - "${FILES[@]}" 2>/dev/null | ssh -o BatchMode=yes $HOST "
  set -e
  cat > /tmp/urania-deploy.tgz
  B=$S/backup-\$(date +%Y%m%d-%H%M)-$LABEL
  for f in $LIST; do
    if sudo test -f $P/\$f; then sudo mkdir -p \$B/\$(dirname \$f); sudo cp -p $P/\$f \$B/\$f; fi
  done
  echo \"  backup: \$B\"
  sudo tar xzf /tmp/urania-deploy.tgz -C $P --no-same-owner 2>/dev/null
  rm /tmp/urania-deploy.tgz
  for f in $LIST; do
    sudo chown org-uraniastudio:org-uraniastudio $P/\$f
    sudo chmod 670 $P/\$f
  done"

echo "== Verificare după încărcare"
for f in "${FILES[@]}"; do
  srv_md5=$(ssh -o BatchMode=yes $HOST "sudo md5sum $P/$f | cut -d' ' -f1")
  if [ "$srv_md5" = "$(md5 -q "$f")" ]; then echo "  ok  $f"; else echo "  EROARE  $f"; PROBLEM=1; fi
done
[ $PROBLEM = 0 ] && echo "Gata. Verifică https://uraniastudio.eu" || exit 1
