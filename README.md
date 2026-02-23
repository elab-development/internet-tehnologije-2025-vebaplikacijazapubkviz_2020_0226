# Pub Kviz Web Aplikacija
Sistem za upravljanje sezonama i rezultatima pub kvizova

Produkcijska verzija:
https://pub-kviz-frontend-iteh.onrender.com/



---

## 1. O projektu

Vođenje pub kvizova kroz fizičke tabele ili nepregledne dokumente često dovodi do grešaka u sabiranju poena, sporog formiranja rang lista i otežanog praćenja sezonskih rezultata. Ova aplikacija predstavlja centralizovano digitalno rešenje koje automatizuje unos, obradu i prikaz rezultata kroz više sezona.

Sistem omogućava transparentno praćenje plasmana timova, istorije događaja i sastava igrača, uz jasno razdvajanje uloga i pristupa podacima.

---

## 2. Funkcionalni ciljevi

Aplikacija je razvijena sa ciljem da:

- Automatizuje sabiranje poena i generisanje rang lista
- Omogući kreiranje i upravljanje sezonama i pojedinačnim događajima
- Prikaže zbirne sezonske rezultate po timovima
- Evidentira sastav tima za svaki događaj
- Omogući javni pregled rezultata bez potrebe za prijavom
- Integracijom sa Google Calendar servisom omogući čuvanje događaja

---

## 3. Korisničke uloge

### Organizator (Moderator)
- Kreira sezone i događaje
- Unosi rezultate
- Administrira sistem

### Registrovani tim
- Kreira i uređuje tim
- Prijavljuje tim na događaj
- Pregleda sezonski plasman i istoriju nastupa
- Evidentira igrače po događaju

### Gost (neautentifikovani korisnik)
- Pregleda javne rang liste
- Prati sezonske rezultate
- Pregleda istoriju održanih kvizova

---

## 4. Tehnologije

### Backend
- Laravel
- REST API arhitektura
- MySQL (lokalno)
- PostgreSQL (Render cloud)
- Supabase (file storage)
- Google OAuth i Google Calendar API

### Frontend
- React
- JavaScript (ES6+)
- Axios

### DevOps i infrastruktura
- Docker
- Docker Compose
- Git
- Render (cloud deployment)

---

## 5. Pokretanje aplikacije

### 5.1 Lokalno (bez Docker-a)

Backend:

```bash
cd back
composer install
php artisan storage:link
php artisan migrate:fresh --seed
php artisan serve
```

Frontend:

```bash
cd front
npm install
npm start
```

Backend: http://127.0.0.1:8000  
Frontend: http://localhost:3000

---

### 5.2 Pokretanje pomoću Docker-a

Iz root direktorijuma projekta:

```bash
docker compose up --build -d
```

Zaustavljanje kontejnera:

```bash
docker compose down
```

Docker konfiguracija podiže kompletno okruženje (backend, frontend i bazu).

---

## 6. Strategija grananja

Projekat koristi standardnu podelu na stabilnu, razvojnu i funkcionalne grane.

### main
Produkcijska i stabilna verzija aplikacije.

### develop
Razvojna integraciona grana u koju se spajaju sve nove funkcionalnosti.

### Feature grane
- feature/swagger-api – API dokumentacija
- feature/eksterni-api – Integracija sa Google Calendar servisom
- feature/tim-na-dogadjaju – Obrada prijave tima na događaj
- feature/docker – Kontejnerizacija aplikacije

Sve feature grane nastaju iz develop grane i nakon završetka razvoja se vraćaju nazad u nju.

---

## 7. Arhitektura

Aplikacija je implementirana kao full-stack sistem:

- React Single Page Application
- Laravel REST API
- Relaciona baza podataka
- Docker kontejnerizovano okruženje
- Cloud hosting na Render platformi

---

## 8. Preduslovi

Za lokalno pokretanje potrebno je:

- PHP
- Composer
- Node.js
- npm
- Docker (opciono)
