-- Drop des tables avec Cascade pour éviter les erreurs de suppression
DROP TABLE IF EXISTS AdressesIP CASCADE;
DROP TABLE IF EXISTS VLANs CASCADE;
DROP TABLE IF EXISTS Clients CASCADE;
DROP TABLE IF EXISTS Sites CASCADE;
DROP TABLE IF EXISTS Util CASCADE;
DROP TABLE IF EXISTS Machines CASCADE;

-- Création de la table Sites
CREATE TABLE IF NOT EXISTS Sites (
    ID_Site SERIAL PRIMARY KEY,
    Nom_Site VARCHAR(255) NOT NULL,
    Plage_Adresse VARCHAR(255) NOT NULL
);

-- Insertion des données dans la table Sites
INSERT INTO Sites (Nom_Site, Plage_Adresse) VALUES
('Groupe 1', '164.166.1.0/24'),
('Groupe 2', '164.166.2.0/24'),
('Groupe 3', '164.166.3.0/24')
ON CONFLICT DO NOTHING; -- Pour éviter les insertions en double

-- Création de la table Clients
CREATE TABLE IF NOT EXISTS Clients (
    ID_Client SERIAL PRIMARY KEY,
    Nom_Client VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    Email_Client VARCHAR(255) NOT NULL,
    ID_Site INT NOT NULL,
    Route_Distinguisher VARCHAR(255) NOT NULL,
    Adresse_reseau VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_Site) REFERENCES Sites(ID_Site)
);

-- Création de la table VLANs
CREATE TABLE IF NOT EXISTS VLANs (
    ID_VLAN SERIAL PRIMARY KEY,
    ID_Client INT NOT NULL,
    Nom_VLAN VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_Client) REFERENCES Clients(ID_Client)   
);

-- Création de la table AdressesIP
CREATE TABLE IF NOT EXISTS AdressesIP (
    ID_AdresseIP SERIAL PRIMARY KEY,
    ID_Client INT NOT NULL,
    Adresse_IP VARCHAR(255) NOT NULL,
    Attribuee BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (ID_Client) REFERENCES Clients(ID_Client)
);

-- Création de la table Util
CREATE TABLE IF NOT EXISTS Util (
    ID_Util SERIAL PRIMARY KEY,
    Nom_Util VARCHAR(50),
    Prenom_Util VARCHAR(50),
    login VARCHAR(50),
    mdp VARCHAR(50),
    Categorie VARCHAR(20) CHECK (Categorie IN ('Administrateur', 'Client')),
    ID_Site INT NOT NULL,
    FOREIGN KEY (ID_Site) REFERENCES Sites(ID_Site)
);

-- Insertion des donnés dans la table Util
INSERT INTO Util (Nom_Util, Prenom_Util, login, mdp, Categorie, ID_Site) VALUES
('Admin1', 'Admin1', 'admin1', 'admin123', 'Administrateur', 1),
('Admin2', 'Admin2', 'admin2', 'admin123', 'Administrateur', 2),
('Admin3', 'Admin3', 'admin3', 'admin123', 'Administrateur', 3)
ON CONFLICT DO NOTHING; -- To avoid duplicate insertions

-- Création de la table Machines
CREATE TABLE IF NOT EXISTS Machines (
    ID_Machine SERIAL PRIMARY KEY,
    ID_Client INT NOT NULL,
    Nom_Machine VARCHAR(255) NOT NULL,
    Adresse_IP VARCHAR(255) NOT NULL,
    Piece VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_Client) REFERENCES Clients(ID_Client)
);
