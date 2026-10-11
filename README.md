# VAII-Semestralka - Webová aplikácia na predaj prémiového čaju a kávy

**Meno a priezvisko študenta:** Lukáš Török

**Študijná skupina:** 5ZYI23

---

## Stručný opis projektu
Cieľom projektu je vytvoriť modernú, dynamickú webovú aplikáciu typu e-shop zameranú na predaj výberového čaju a kávy. Aplikácia rieši problém nedostatku specializovaných a prehľadných online obchodov, kde by zákazníci mohli jednoducho filtrovať produkty podľa druhu, chuti, krajiny pôvodu alebo spôsobu prípravy.

Hlavným účelom aplikácie je umožniť návštevníkom pohodlne prehliadať katalóg, registrovať sa, spravovať svoj nákupný košík a vytvárať objednávky. Pre administrátora aplikácia predstavuje intuitívny nástroj na správu sortimentu (vrátane nahrávania obrázkov produktov), evidenciu prijatých objednávok a správu používateľských účtov. Aplikácia je navrhnutá tak, aby spĺňala zásady bezpečnosti, responzívneho dizajnu a asynchrónnej komunikácie.

---

## Role v projekte
Aplikácia bude pracovať s nasledujúcimi používateľskými rolami:
1. **Návštevník (Neregistrovaný používateľ):** Môže prehliadať katalóg produktov, využívať dynamické filtrovanie a vyhľadávanie, zobrazovať si detaily produktov a pridávať ich do košíka. Nemôže však dokončiť objednávku ani vidieť históriu nákupov.
2. **Zákazník (Registrovaný používateľ):** Má všetky oprávnenia návštevníka a navyše môže dokončiť objednávku (checkout), spravovať svoj profil, meniť doručovacie adresy a zobrazovať si históriu a stavy svojich objednávok.
3. **Administrátor (Správca):** Zodpovedá za prevádzku obchodu. Má plné CRUD oprávnenia nad entitami *Produkt* a *Kategória* (vrátane uploadu a manažmentu súborov – obrázkov), môže meniť stavy objednávok a spravovať zoznam registrovaných používateľov.

---

## Prípady použitia podľa rolí
**Návštevník:**
* Návštevník vyhľadá konkrétny druh kávy alebo čaju pomocou vyhľadávacieho poľa.
* Návštevník filtruje produkty v katalógu podľa kategórie (napr. "Zelený čaj", "Arabica") bez znovunačítania stránky.
* Návštevník si zobrazí detail produktu s popisom, cenou a dostupnosťou na sklade.

**Zákazník:**
* Zákazník pridá vybraný produkt do košíka.
* Zákazník vyplní doručovacie údaje, skontroluje súhrn objednávky a potvrdí jej vytvorenie.
* Zákazník si v sekcii "Môj účet" zobrazí históriu svojich minulých objednávok a ich aktuálny stav.

**Administrátor:**
* Administrátor vytvorí nový produkt, vyplní jeho parametre a nahrá obrázok produktu na server.
* Administrátor upraví cenu alebo množstvo existujúceho produktu na sklade.
* Administrátor zmení stav objednávky z "Prijatá" na "Odoslaná" alebo "Zrušená".

---

## Plánované entity
Databáza bude obsahovať nasledujúce hlavné entity:

1. **Produkt (`products`)**: Reprezentuje konkrétny čaj alebo kávu.
   * *Atribúty:* `id`, `nazov`, `popis`, `cena`, `mnozstvo_na_sklade`, `obrazok_url`, `typ` (caj/kava).
   * *Vzťahy:* M:N s entitou Kategória, 1:N s entitou PolozkaObjednavky.
2. **Kategória (`categories`)**: Zoskupuje produkty do logických celkov pre jednoduchšie filtrovanie.
   * *Atribúty:* `id`, `nazov`, `popis`.
   * *Vzťahy:* M:N s entitou Produkt.
3. **Objednávka (`orders`)**: Reprezentuje realizovaný nákup zákazníka.
   * *Atribúty:* `id`, `id_pouzivatela`, `datum_vytvorenia`, `celkova_cena`, `stav`, `adresa_dodania`.
   * *Vzťahy:* 1:N s entitou Používateľ, 1:N s entitou PolozkaObjednavky.
4. **PoložkaObjednávky (`order_items`)**: Dekompozičná (asociačná) tabuľka pre vzťah medzi Objednávkou a Produktom.
   * *Atribúty:* `id`, `id_objednavky`, `id_produktu`, `cena_v_case_objednavky`, `pocet_kusov`.
   * *Vzťahy:* N:1 s entitou Objednávka, N:1 s entitou Produkt.

---

## Vzťahy medzi entitami
* **Používateľ 1:N Objednávka:** Jeden registrovaný používateľ môže vytvoriť viacero objednávok, ale každá objednávka je priradená práve jednému používateľovi.
* **Objednávka 1:N PoložkaObjednávky:** Jedna objednávka sa skladá z jednej alebo viacerých položiek (konkrétnych produktov).
* **Produkt M:N Kategória:** Jeden produkt môže byť zaradený do viacerých kategórií (napr. "Darčekové balenia" a "Zelený čaj") a jedna kategória obsahuje viacero produktov. Tento vzťah je riešený pomocou dekompozičnej tabuľky `product_categories`.
* **Produkt 1:N PoložkaObjednávky:** Jeden produkt sa môže vyskytovať vo viacerých položkách rôznych objednávok.

---

## Hlavné stránky aplikácie
1. **Domovská stránka (Homepage):** Úvodná stránka s uvítaním, zoznamom odporúčaných produktov a aktuálnymi akciami.
2. **Katalóg produktov (Catalog):** Dynamická stránka so zoznamom všetkých čajov a káv. Obsahuje bočný panel s filtrami (kategória, cena) a vyhľadávacie pole (s asynchrónnym prekresľovaním výsledkov).
3. **Detail produktu (Product Detail):** Stránka s detailným popisom produktu, parametrami (krajina pôvodu, spôsob prípravy) a tlačidlom na pridanie do košíka.
4. **Košík a Pokladňa (Cart & Checkout):** Sumár vybraných položiek s možnosťou zmeny počtu kusov a formulár na vyplnenie doručovacích údajov a potvrdenie objednávky.
5. **Môj účet (User Dashboard):** Sekcia prístupná len po prihlásení, obsahujúca správu profilu, zoznam adries a históriu objednávok.
6. **Administrácia (Admin Panel):** Rozhranie pre správu databázy (CRUD pre produkty, kategórie a zmenu stavov objednávok), vrátane formulára na upload obrázkov.

---

## Rozdelenie funkcionality

### Základné funkcie
* Registrácia, prihlásenie a odhlásenie používateľov (heslá hashované napr. cez `password_hash`).
* Zobrazenie katalógu a detailu produktu (min. 5 dynamických stránok).
* Nákupný košík a proces vytvorenia objednávky (Checkout).
* Kompletné CRUD operácie nad entitami *Produkt* a *Kategória* v administrácii.
* Práca so súbormi: Upload a manažment obrázkov produktov na server.
* Asynchrónna komunikácia (AJAX): Pridávanie produktu do košíka a dynamické filtrovanie záznamov v katalógu bez znovunačítania stránky.
* Kontrola vstupov na strane klienta (JS) aj servera (PHP) a ošetrenie dopytov voči SQL Injection (pomocou PDO/VAJKO).
* Spustenie aplikácie v prostredí Docker s automatickým importom ukážkových dát (čaje, kávy, kategórie) pri prvom spustení.


### Rozširujúce funkcie 
* **Nadštandardný dizajn:** Vlastné riešenie responzívneho dizajnu s dôrazom na UX/UI, použitie Sass/Less pre organizáciu CSS.
* **JS Framework:** Použitie Vue.js alebo React.js pre vykreslenie a správu stavu Košíka alebo dynamického filtrovania (SPA prístup pre časť aplikácie).
* **HTML5 API:** Využitie Geolokácie pre zobrazenie najbližšieho výdajného miesta na mape priamo v pokladni.
* **Externé API:** Napojenie na externú API službu pre výpočet ceny poštovného podľa zadaného PSČ alebo validáciu IČO/DIČ z verejného registra.
* **Pokročilá kontrola formulárov:** Komplexná validácia na strane klienta pred odoslaním dát na server (napr. kontrola formátu e-mailu, dĺžky hesla, povinných polí).
