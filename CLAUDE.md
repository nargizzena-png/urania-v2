# Urania Studio — reguli pentru site

## Imagini: alt obligatoriu
- Orice `<img>` nou are atribut `alt`, în română: ce se vede în imagine + „— Urania Studio, Cluj”.
  Exemplu: `alt="Sala Mare cu scenă (Blackbox) — Urania Studio, Cluj"`.
- Imaginile din baza de date (afișe, galerii evenimente) primesc alt generat din titlul evenimentului:
  `Afiș: <titlu> — Urania Studio, Cluj`.
- Doar imaginile pur decorative (iconițe, fundaluri, imaginea din lightbox completată din JS) au `alt=""`.
- `deploy.sh` oprește încărcarea dacă un fișier conține `<img>` fără `alt` și avertizează pentru `alt=""`.

## Formulări interzise
- Nu folosim „închiriere”, „închiriază”, „de închiriat” etc. (și nici „rent” în engleză): conform contractului, „găzduim evenimente”, „tarif per sesiune / pachet”.
