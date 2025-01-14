-- Vytvoření databáze
CREATE DATABASE IF NOT EXISTS MereniSpotreby;
USE MereniSpotreby;

-- Tabulka: Firmy
CREATE TABLE IF NOT EXISTS Firmy (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NazevFirmy VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Telefon VARCHAR(20),
    Adresa VARCHAR(255),
    Heslo VARCHAR(255) NOT NULL,
    TypPracovnika ENUM('technicky zdatný', 'méně zdatný') NOT NULL
);

-- Tabulka: Zákazníci
CREATE TABLE IF NOT EXISTS Zakaznici (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Firma_ID INT NOT NULL,
    Jmeno VARCHAR(100) NOT NULL,
    Prijmeni VARCHAR(100) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Telefon VARCHAR(20),
    Heslo VARCHAR(255) NOT NULL,
    Status ENUM('aktivní', 'zablokovaný') NOT NULL,
    FOREIGN KEY (Firma_ID) REFERENCES Firmy(ID) ON DELETE CASCADE
);

-- Tabulka: Nemovitosti
CREATE TABLE IF NOT EXISTS Nemovitosti (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Zakaznik_ID INT NOT NULL,
    Adresa VARCHAR(255) NOT NULL,
    TypNemovitosti VARCHAR(100),
    FOREIGN KEY (Zakaznik_ID) REFERENCES Zakaznici(ID) ON DELETE CASCADE
);

-- Tabulka: Měřidla
CREATE TABLE IF NOT EXISTS Meridla (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nemovitost_ID INT NOT NULL,
    TypMeridla VARCHAR(100) NOT NULL,
    CisloMeridla VARCHAR(100) NOT NULL UNIQUE,
    FOREIGN KEY (Nemovitost_ID) REFERENCES Nemovitosti(ID) ON DELETE CASCADE
);

-- Tabulka: Odečty
CREATE TABLE IF NOT EXISTS OdecTy (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Meridlo_ID INT NOT NULL,
    Datum DATE NOT NULL,
    Hodnota DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (Meridlo_ID) REFERENCES Meridla(ID) ON DELETE CASCADE
);

-- Tabulka: Události
CREATE TABLE IF NOT EXISTS Udalosti (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Zakaznik_ID INT NOT NULL,
    TypUdalosti ENUM('spotřeba překročí hodnotu', 'průměr', 'měsíční přehled', 'zbývající spotřeba') NOT NULL,
    Hodnota DECIMAL(10, 2),
    Aktivni BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (Zakaznik_ID) REFERENCES Zakaznici(ID) ON DELETE CASCADE
);




-- Tabulka: Role
CREATE TABLE IF NOT EXISTS Role (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nazev VARCHAR(100) NOT NULL UNIQUE,
    Popis TEXT
);

-- Vložení rolí do tabulky Role
INSERT INTO Role (Nazev, Popis) VALUES
('Administrátor', 'Má plný přístup ke všem funkcím aplikace. Může spravovat firmy, zákazníky, nemovitosti, měřidla, odečty a události.'),
('Zaměstnanec firmy', 'Může spravovat zákazníky a jejich nemovitosti, ale nemá přístup k administrativním funkcím.'),
('Zákazník', 'Může přistupovat pouze k vlastním datům a spravovat své události.'),
('Technická podpora', 'Může pomáhat zákazníkům a zaměstnancům firmy, ale nemá přístup k citlivým datům.');

-- Tabulka: Uživatelé
CREATE TABLE IF NOT EXISTS Uzivatele (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Heslo VARCHAR(255) NOT NULL,
    Role_ID INT NOT NULL,
    FOREIGN KEY (Role_ID) REFERENCES Role(ID) ON DELETE CASCADE
);

-- Příklad vložení uživatelů
INSERT INTO Uzivatele (Email, Heslo, Role_ID) VALUES
('admin@firma.cz', 'sifrovane_heslo_admin', 1),  -- Administrátor
('zamestnanec@firma.cz', 'sifrovane_heslo_zamestnanec', 2),  -- Zaměstnanec firmy
('zakaznik@firma.cz', 'sifrovane_heslo_zakaznik', 3),  -- Zákazník
('podpora@firma.cz', 'sifrovane_heslo_podpora', 4);  -- Technická podpora



-- Tabulka: Uživatelé (rozšířená o potřebné parametry)
CREATE TABLE IF NOT EXISTS Uzivatele (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Heslo VARCHAR(255) NOT NULL,
    Role_ID INT NOT NULL,
    Jmeno VARCHAR(100),
    Prijmeni VARCHAR(100),
    Telefon VARCHAR(20),
    Firma_ID INT,
    FOREIGN KEY (Role_ID) REFERENCES Role(ID) ON DELETE CASCADE,
    FOREIGN KEY (Firma_ID) REFERENCES Firmy(ID) ON DELETE SET NULL
);

-- Vložení příkladu firmy
INSERT INTO Firmy (NazevFirmy, Email, Telefon, Adresa, Heslo, TypPracovnika) VALUES
('Firma A', 'kontakt@firmaa.cz', '123456789', 'Adresa 1, Město', 'sifrovane_heslo_firma', 'technicky zdatný');
INSERT INTO Uzivatele (Email, Heslo, Role_ID, Jmeno, Prijmeni, Telefon, Firma_ID) VALUES
('admin@firma.cz', 'sifrovane_heslo_admin', 1, 'Jan', 'Novák', '123456789', NULL),  -- Administrátor
('zamestnanec@firma.cz', 'sifrovane_heslo_zamestnanec', 2, 'Petr', 'Svoboda', '987654321', 1),  -- Zaměstnanec firmy
('zakaznik@firma.cz', 'sifrovane_heslo_zakaznik', 3, 'Eva', 'Kovářová', '456789123', NULL),  -- Zákazník
('podpora@firma.cz', 'sifrovane_heslo_podpora', 4, 'Martin', 'Dvořák', '321654987', NULL);  -- Technická podpora


