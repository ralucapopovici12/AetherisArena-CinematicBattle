# ⚔️ AETHERIS ARENA | Cinematic Battle Simulator

O aplicație web modernă și premium dezvoltată în **PHP 8.x** folosind framework-ul **Laravel**, construită pe baza unei arhitecturi curate cu **Domain-Driven Design (DDD)**. Aceasta simulează o luptă legendară între **Kratos** și un **Monstru Sălbatic (Hydra/Wild Entity)**, oferind un visualizer cinematic de impact pe frontend și o salvare persistentă a istoricului pe backend (SQLite).

---

## 🎮 Despre Joc & Generarea Aleatorie (Randomized Stats)

La fiecare inițiere a simulatorului, atributele ambilor combatanți sunt generate **aleatoriu în mod dinamic** (pe baza unor intervale clar definite) folosind funcții sigure criptografic în backend-ul PHP. Acest lucru face ca fiecare luptă să fie **unică și imprevizibilă**:
- O viteză sau un noroc mai mare pot decide cine lovește primul și cine evită atacurile critice.
- Abilitățile speciale ale lui Kratos pot răsturna complet cursul bătăliei, chiar și în fața unui monstru cu putere ridicată.

### 📊 Tabelul de Atribute (Minime și Maxime)

Iată intervalele oficiale de generare a caracteristicilor pentru cei doi combatanți:

| Atribut ⚔️ | Interval Kratos (Champion Ascendant) 🛡️ | Interval Monster (Wild Entity) 👹 |
| :--- | :---: | :---: |
| **Sănătate (Health)** | `65` - `100` | `50` - `80` |
| **Putere (Strength)** | `75` - `90` | `55` - `80` |
| **Apărare (Defence)** | `40` - `50` | `50` - `70` |
| **Viteză (Speed)** | `40` - `50` | `40` - `60` |
| **Noroc (Luck)** | `10%` - `20%` (0.1 - 0.2) | `30%` - `45%` (0.3 - 0.45) |

---

## 📁 Structura Proiectului (Organizare și Claritate)

Aplicația principală se află în folderul `battle-game/`. Iată structura principală organizată pe responsabilități:

```
PRACTICA/
├── battle-game/                   # Folderul principal al aplicației Laravel
│   ├── app/
│   │   ├── Domain/                # Logica de business pură (decuplată de framework)
│   │   │   ├── Entities/          # Modelele și regulile de domeniu (Kratos, Monster, Battle, Entity)
│   │   │   ├── Skills/            # Abilitățile speciale (RapidFire, MagicArmour, SkillInterface)
│   │   │   └── Factories/         # Crearea personajelor și generarea de atribute (CharacterFactory)
│   │   ├── Service/               # Serviciile de aplicație
│   │   │   ├── BattleService.php  # Algoritmul și motorul de simulare a luptei
│   │   │   └── BattleServiceInterface.php
│   │   ├── Http/Controllers/      # Controlere de API
│   │   │   └── BattleController.php # Punctul de intrare API pentru simulare
│   │   └── Models/                # Modele Eloquent pentru baza de date (Battle, BattleLog)
│   ├── database/                  # Migrări și baza de date SQLite
│   ├── resources/views/           # Interfața utilizator (welcome.blade.php)
│   ├── routes/                    # Definirea rutelor web și API (web.php)
│   └── tests/                     # Teste Unitare și Feature (PHPUnit)
└── README.md                      # Documentația oficială a proiectului (Acest fișier)
```

---

## ⚙️ Logica Funcțiilor & Arhitectura Codului

### 🛡️ 1. Domain Entities (`app/Domain/Entities`)

*   **`Entity`**: Clasa de bază pentru toate obiectele de domeniu ce au identitate unică (`id`).
*   **`Character`**: Clasa abstractă părinte pentru toate combatantele:
    *   `takeDamage(int $damage)`: Scade viața corect și oprește scăderea la `0`.
    *   `isAlive()`: Verifică starea de viață.
    *   `addSkill(SkillInterface $skill)` / `getSkills()`: Administrează abilitățile speciale ale personajului.
*   **`Kratos` & `Monster`**: Clase specifice ce moștenesc proprietățile generale ale unui `Character`.
*   **`Battle`**: Structura ce memorează starea finală a luptei (câștigătorul, numărul de runde și logurile detaliate).

### ✨ 2. Abilități Speciale (`app/Domain/Skills`)

Toate abilitățile implementează contractul **`SkillInterface`**, care definește tipul (Atac/Apărare), șansa de activare și metoda de declanșare:

*   **`Rapid fire`** (Șansă: 15%, Tip: Atac): Exclusiv Kratos. Când se activează, Kratos execută **două lovituri** succesive în cadrul aceleiași runde.
*   **`Magic armour`** (Șansă: 15%, Tip: Apărare): Exclusiv Kratos. Când se activează la primirea unei lovituri, **înjumătățește damage-ul total** rotunjit prin adaos.

### 🏭 3. Character Factory (`app/Domain/Factories`)

*   **`CharacterFactory`**: Centralizează logica de inițializare și asigură respectarea intervalelor oficiale ale atributelor:
    *   **Kratos**: Atribute generate în intervalele din tabel. Adaugă automat abilitățile `Rapid fire` și `Magic armour`.
    *   **Monster**: Atribute generate în intervalele din tabel.

### ⚙️ 4. Motorul de Luptă (`app/Service/BattleService`)

*   `determineFirstAttacker()`: Alege primul atacator pe baza vitezei mai mari; în caz de egalitate, se alege cel cu norocul (luck) mai mare.
*   `simulate()`: Rulează bucla principală de luptă (maximum **15 ture**):
    *   Verifică dacă ambele personaje sunt în viață.
    *   Apelează funcția de atac (`attack()`).
    *   Inversează rolurile la finalul fiecărei runde.
*   `attack()`:
    1. Determină numărul de lovituri (verifică dacă se activează `Rapid fire`).
    2. Rulează fiecare lovitură individual.
    3. Verifică dacă apărătorul a reușit să evite lovitura (noroc / Luck).
    4. Calculează damage-ul brut (`Putere Atacator - Apărare Apărător`).
    5. Aplică eventuale abilități defensive (verifică dacă se activează `Magic armour`).
    6. Scade viața și salvează evenimentele detaliate în logul turei (`defender_health_left`, `damage`, `skills_used`).

---

## 🖥️ Interfața Utilizator (Cinematic Frontend)

Frontend-ul din `resources/views/welcome.blade.php` oferă o experiență cinematică de excepție:
- **Statistici în Timp Real**: Console laterale cu gradiente ce reflectă atributele fiecărui combatant.
- **Bări de viață dinamice**: Animate printr-o curbă bezier fluidă.
- **Efecte de Lovire & Proiectile**: Proiectile laser ce se deplasează cu viteză de la atacator la țintă, urmate de scântei de impact și tremur de ecran (**camera shake**).
- **Controlul Vitezei**: Butoane interactive pentru accelerarea acțiunii: `0.5x`, `1x`, `2x`.
- **Sistem de Istoric Local**: Sidebar culisant ce reține ultimele lupe în browser (`localStorage`), oferind detalii despre cine a câștigat, câte runde au fost și energia rămasă.

---

## 🔧 Comenzi Rulare Locală (Run Locally)

Urmează pașii de mai jos pentru a porni și rula aplicația pe sistemul tău local:

### 1. Navighează în folderul proiectului Laravel
Deschide terminalul și mută-te în directorul aplicației:
```bash
cd battle-game
```

### 2. Instalează dependențele proiectului PHP
Instalează toate pachetele Laravel necesare:
```bash
composer install
```

### 3. Configurează fișierul de mediu (.env)
Copiază configurările implicite de mediu din exemplul predefinit:
```bash
cp .env.example .env
```

### 4. Generarea cheii de securitate a aplicației
Generează o cheie unică de criptare pentru Laravel:
```bash
php artisan key:generate
```

### 5. Configurarea Bazei de Date SQLite locală
Creează fișierul bazei de date SQLite local și execută migrările pentru tabelele `battles` și `battle_logs`:
```bash
# Creează fișierul fizic pentru SQLite
touch database/database.sqlite

# Rulează migrările Laravel
php artisan migrate --force
```

### 6. Pornește serverul local de dezvoltare
Lansează serverul local Laravel:
```bash
php artisan serve
```
Aplicația ta va fi imediat pornită și accesibilă în browser la adresa: **[http://localhost:8000](http://localhost:8000)**!

### 7. Rularea testelor unitare și de feature (PHPUnit)
Pentru a rula și verifica suitele de teste automate:
```bash
php artisan test
```

---
*Proiect realizat cu pasiune pentru calitate, logică solidă de business și o estetică modernă în cadrul stagiului de practică.*
