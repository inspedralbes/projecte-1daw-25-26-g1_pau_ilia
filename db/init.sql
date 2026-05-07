USE gi3p_db;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS actuacions;
DROP TABLE IF EXISTS incidencies;
DROP TABLE IF EXISTS tipos_incidencia;
DROP TABLE IF EXISTS tecnics;
DROP TABLE IF EXISTS departaments;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE departaments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE tecnics(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE tipos_incidencia(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE incidencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL, -- This was missing in your INSERT
    departament_id INT NOT NULL,
    data_incidencia DATE NOT NULL,
    descripcio VARCHAR(255) NOT NULL,
    tecnic_id INT NULL,
    tipus_id INT NULL,
    prioritat ENUM('Alta', 'Mitjana', 'Baixa') NULL,
    estado ENUM('Registrat', 'En Proces', 'Finalitzat') DEFAULT 'Registrat', -- You used 'resolta' in INSERT
    data_finalitzacio DATE NULL,
    FOREIGN KEY (departament_id) REFERENCES departaments(id) ON DELETE CASCADE,
    FOREIGN KEY (tecnic_id) REFERENCES tecnics(id) ON DELETE SET NULL,
    FOREIGN KEY (tipus_id) REFERENCES tipos_incidencia(id) ON DELETE SET NULL
);

CREATE TABLE actuacions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incidencia_id INT NOT NULL,
    data_actuacio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    descripcio TEXT NOT NULL,
    tecnic_id INT NULL,
    temps_minuts VARCHAR(30) NOT NULL,
    visible_usuari ENUM('Si', 'No') DEFAULT 'No',
    FOREIGN KEY (incidencia_id) REFERENCES incidencies(id) ON DELETE CASCADE,
    FOREIGN KEY (tecnic_id) REFERENCES tecnics(id) ON DELETE SET NULL
);

INSERT INTO departaments (nom) VALUES 
('Ciencies naturals'), ('Matematiques'), ('Informatica'), ('Llengues estrangeres'), ('Direccio');

INSERT INTO tecnics (nom) VALUES 
('Joan Tècnic'), ('Maria Sistemes'), ('Pere Xarxes');

INSERT INTO tipos_incidencia (nom) VALUES 
('Maquinari (Hardware)'), ('Programari (Software)'), ('Xarxa / Connexió'), ('Manteniment general');

INSERT INTO incidencies (title, departament_id, data_incidencia, descripcio, tecnic_id, tipus_id, prioritat, estado, data_finalitzacio) VALUES 
('Error Impressora', 1, '2024-03-01', 'No funciona la impressora del departament', NULL, NULL, NULL, 'Registrat', NULL),
('Projector Aula 3', 2, '2024-03-02', 'El projector de l''aula 3 no s''encén', 1, 1, 'Alta', 'En Proces', NULL),
('Caiguda Internet', 3, '2024-03-03', 'No hi ha internet als ordinadors dels alumnes', 3, 3, 'Alta', 'Finalitzat', '2024-03-04'),
('Instal·lació Office', 4, '2024-03-04', 'Necessitem instal·lar l''Office al portàtil nou', 2, 2, 'Baixa', 'Registrat', NULL);

INSERT INTO actuacions (incidencia_id, data_actuacio, descripcio, temps_minuts, visible_usuari) VALUES 
(2, '2024-03-02 10:00:00', 'Es revisa el cablejat d''alimentació. El cable està trencat.', '15', 'Si'),
(2, '2024-03-02 12:30:00', 'S''ha demanat un cable nou a proveïdors. Restem a l''espera.', '10', 'Si'),
(3, '2024-03-03 09:15:00', 'Es reinicia el switch de la planta baixa.', '20', 'Si'),
(3, '2024-03-03 10:00:00', 'Es canvia el port del router que estava fallant.', '45', 'Si'),
(3, '2024-03-04 08:00:00', 'S''aprofita per reconfigurar la VLAN (Nota interna per a tècnics).', '60', 'Si'),
(4, '2024-03-05 11:00:00', 'Es comença la descàrrega i instal·lació del paquet ofimàtic.', '30', 'Si');