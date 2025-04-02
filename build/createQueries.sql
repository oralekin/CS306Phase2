CREATE DATABASE IF NOT EXISTS judo_federation;

USE judo_federation;

CREATE TABLE Addresses (
 addId  INT AUTO_INCREMENT PRIMARY KEY,
 street CHAR(40) NOT NULL,
 city CHAR(20) NOT NULL,
 postalCode CHAR(10) NOT NULL,
 province CHAR(30),
 region CHAR(30),
 country CHAR(30) NOT NULL
);
CREATE TABLE Accounts (
 accId  INT AUTO_INCREMENT PRIMARY KEY,
 email  CHAR(40) NOT NULL,
 aPassword  VARCHAR(255) NOT NULL,
 aType  ENUM("Family", "Individual") DEFAULT "Individual" NOT NULL
);
CREATE TABLE Guardians (
 gId  INT AUTO_INCREMENT,
 accId  INT NOT NULL,
 gRole  CHAR(20),
 gName  CHAR(40) NOT NULL,
 email  CHAR(40) NOT NULL,
 phone  CHAR(13) NOT NULL,
 PRIMARY KEY (gId, accId),
 FOREIGN KEY (accId) REFERENCES Accounts ON DELETE CASCADE
);
CREATE TABLE Association (
 ascId  INT AUTO_INCREMENT PRIMARY KEY,
 ascName  CHAR(40) NOT NULL,
 email  CHAR(40) NOT NULL,
 phone  CHAR(13),
 addId  INT NOT NULL,
 FOREIGN KEY (addId) REFERENCES Addresses
);
CREATE TABLE Judoka (
 jId  INT AUTO_INCREMENT PRIMARY KEY,
 jName  CHAR(40) NOT NULL,
 gender  ENUM("Female","Male") DEFAULT "Female" NOT NULL,
 birthday  DATE NOT NULL,
 jWeight  REAL,
 canTeach  BOOLEAN,
 belt  ENUM("white","yellow","orange","green", "blue","brown", "black") DEFAULT "white" NOT NULL,
<<<<<<< HEAD:build/backend/createQueries.sql
 startDate DATE NOT NULL,
=======
 startDate Date NOT NULL,
>>>>>>> e7b2c046f493f207fdc76d3ad6fcced4a39bd978:build/createQueries.sql
 addId INT NOT NULL,
 accId  INT NULL,
 ascId  INT NOT NULL,
 FOREIGN KEY (addId) REFERENCES Addresses,
 FOREIGN KEY (accId) REFERENCES Accounts ON DELETE SET DEFAULT,
 FOREIGN KEY (ascId) REFERENCES Association
);
CREATE TABLE JudoEvents (
 eId  INT AUTO_INCREMENT PRIMARY KEY,
 eName CHAR(40) NOT NULL,
 price  REAL,
 eType  ENUM("Competition", "Stage", "Event") DEFAULT "Event" NOT NULL,
 startDate  DATE NOT NULL,
 endDate  DATE NOT NULL,
 addId  INT NOT NULL,
 ascId  INT NOT NULL,
 FOREIGN KEY (addId) REFERENCES Addresses,
 FOREIGN KEY (ascId) REFERENCES Association ON DELETE CASCADE
);

CREATE TABLE Dojo (
 dId  INT AUTO_INCREMENT PRIMARY KEY,
 dName  CHAR(40) NOT NULL,
 addId  INT NOT NULL,
 ascId  INT NOT NULL,
 FOREIGN KEY (addId) REFERENCES Addresses,
 FOREIGN KEY (ascId) REFERENCES Association
);
CREATE TABLE JudoMatch (
 mId  INT AUTO_INCREMENT PRIMARY KEY,
 mTime  REAL NOT NULL,
 mDate  DATE NOT NULL,
 eId  INT NOT NULL,
 FOREIGN KEY (eId) REFERENCES JudoEvents ON DELETE CASCADE
);
CREATE TABLE PlayedScore (
 jId  INT NOT NULL,
 mId  INT NOT NULL,
 forfeit boolean,
 ippon  INT,
 wazari  INT,
 yuko  INT,
 kScore  INT,
 PRIMARY KEY (jId, mId),
 FOREIGN KEY (jId) REFERENCES Judoka,
 FOREIGN KEY (mId) REFERENCES JudoMatch ON DELETE CASCADE
);
CREATE TABLE Request(
 jId  INT,
 eId  INT,
 rStatus ENUM ("Submitted","Rejected","Approved") DEFAULT "Submitted" NOT NULL,
 rDate DATE NOT NULL,
 PRIMARY KEY (jId, eId),
 FOREIGN KEY (jId) REFERENCES Judoka,
 FOREIGN KEY (eId) REFERENCES JudoEvents ON DELETE CASCADE
);
CREATE TABLE StudyIn(
 dId  INT,
 jId  INT,
 PRIMARY KEY (dId, jId),
 FOREIGN KEY (jId) REFERENCES Judoka,
 FOREIGN KEY (dId) REFERENCES Dojo ON DELETE CASCADE
);
CREATE TABLE TeachIn(
 dId  INT,
 jId  INT,
 cAge  ENUM("Kids", "Adult", "Elderly") Default "Kids",
 cLevel  ENUM("Beginner","Intermediate", "Advanced") DEFAULT "Beginner",
 PRIMARY KEY (dId, jId),
 FOREIGN KEY (jId) REFERENCES Judoka,
 FOREIGN KEY (dId) REFERENCES Dojo ON DELETE CASCADE
);


INSERT INTO Addresses (addId, street, city, postalCode, province, region, country) VALUES
  (1, 'Via Roma 42', 'Torino', '20121', 'Torino', 'Lombardia', 'Italy'),
  (2, 'Corso Italia 15', 'Roma', '00187', 'Roma', 'Lazio', 'Italy'),
  (3, 'Via Dante Alighieri 8', 'Firenze', '50122', 'Firenze', 'Toscana', 'Italy'),
  (4, 'Via Garibaldi 23', 'Napoli', '80132', 'Napoli', 'Campania', 'Italy'),
  (5, 'Via Venezia 11', 'Bologna', '40121', 'Bologna', 'Emilia-Romagna', 'Italy'),
  (6, 'Corso Vittorio Emanuele 56', 'Torino', '10123', 'Torino', 'Piemonte', 'Italy'),
  (7, 'Via dei Condotti 35', 'Roma', '00187', 'Roma', 'Lazio', 'Italy'),
  (8, 'Piazza del Duomo 3', 'Milano', '20122', 'Milano', 'Lombardia', 'Italy'),
  (9, 'Via San Lorenzo 19', 'Genova', '16123', 'Genova', 'Liguria', 'Italy'),
  (10, 'Via Toledo 67', 'Napoli', '80134', 'Napoli', 'Campania', 'Italy');
INSERT INTO Accounts (accId, email, aPassword, aType) VALUES
  (1, 'john.doe@example.com', '$2y$10$KIX/UXBLk8dFL5F5hWcE8ePP.rZq7btxNYIkRhIwwh88g4H7wn.yK', 'Individual'),
  (2, 'jane.davis@example.com', '$2y$10$RbM5fWd2O.KQGmVk81adhuVxj9SkeKexTIZBX1EGlUGMea8r2BNTG', 'Family'),
  (3, 'michael.brown@example.com', '$2y$10$JlB02GHPKh8U3PfbX2a6D.vDka3W5s1ahv6fp2HzbQxe2XlDj91Gu', 'Individual'),
  (4, 'alex.wilson@example.com', '$2y$10$UVPqvwz1jX4sBFopQAmM8O2DoH3f5L7B3FybnN7Ghe5i4hNjX.gWi', 'Family'),
  (5, 'emily.jones@example.com', '$2y$10$Tq9bsoq2tcRVhYzj5DiR0ur7RkEjQU7f9Mpe7DTCtXtC8n5eY/A3C', 'Individual'),
  (6, 'chris.anderson@example.com', '$2y$10$7vM>PJm8iEVFcbMdsghFeIe3dHFV.iy.5pC2PTCFsi1ag8WeP92qEK', 'Family'),
  (7, 'sarah.thomas@example.com', '$2y$10$3MtY0Hro.kFvLbcA9ALyAOLcPnmXYgrgBvF/48uOCekIsM.jZ./ly', 'Individual'),
  (8, 'lisa.taylor@example.com', '$2y$10$PmbfPDUMqHhbg.t3U8lEVOVzpYjBp2uDcrG3EUNfJevlEAK3pfbme', 'Family'),
  (9, 'david.white@example.com', '$2y$10$Z5/A4eSPgxM6ysFVPNEuA.rC1c.QnqDmi5Kw9RkGqlRmDajvnG6DC', 'Individual'),
  (10, 'robert.martin@example.com', '$2y$10$Io4yHoqyJHY9XME3/Yq05e1zPMYy5Sfg7MxutFiYH5gQoJnmH/w8m', 'Individual'); 
INSERT INTO Guardians (gId, accId, gRole, gName, email, phone) VALUES
  (1, 2, 'Father', 'John Davis', 'john.davis@email.com', '+112345678901'),
  (2, 2, 'Mother', 'Emily Davis', 'emily.davis@email.com', '+112345678902'),
  (3, 2, 'Guardian', 'Michael Brown', 'michael.brown@email.com', '+112345678903'),
  (4, 4, 'Father', 'David Wilson', 'david.wilson@email.com', '+112345678904'),
  (5, 6, 'Mother', 'Sarah Anderson', 'sarah.anderson@email.com', '+112345678905'),
  (6, 6, 'Relative', 'Christopher White', 'chris.white@email.com', '+112345678906'),
  (7, 6, 'Father', 'James Anderson', 'james.anderson@email.com', '+112345678907'),
  (8, 8, 'Guardian', 'Robert Thomas', 'robert.thomas@email.com', '+112345678908'),
  (9, 8, 'Mother', 'Laura Garcia', 'laura.garcia@email.com', '+112345678909'),
  (10, 8, 'Relative', 'William Martinez', 'william.martinez@email.com', '+112345678910');
INSERT INTO Association (ascId, ascName, email, phone, addId) VALUES
  (1, 'Crono Sport Torino', 'info@judomilano.it', '0234567890', 1),
  (2, 'Torino Judo Club', 'info@torinojudo.it', '0115678901', 2),
  (3, 'Firenze Dojo Group', 'info@firenzedojo.it', '0556789012', 3),
  (4, 'Genova Judo Team', 'info@genovajudo.it', '0107890123', 4),
  (5, 'Palermo Judo Academy', 'info@palermojudo.it', '0918901234', 5),
  (6, 'Bologna Judo School', 'info@bolognajudo.it', '0519012345', 6),
  (7, 'Napoli Bushido', 'info@napolibushido.it', '0810123456', 7),
  (8, 'Pisa Samurai Judo', 'info@pisajudo.it', '0501234567', 8),
  (9, 'Verona Judo Center', 'info@veronajudo.it', '0452345678', 9),
  (10, 'Venezia Dojos', 'info@veneziadojos.it', '0413456789', 10);
INSERT INTO Judoka (jId, jName, gender, birthday, jWeight, canTeach, belt, startDate, addId, accId, ascId) VALUES
<<<<<<< HEAD:build/backend/createQueries.sql
  (1, 'John Doe', 'Male', '1990-05-12', 81.2, FALSE, 'black', 1, 1, 2),
  (2, 'Michael Brown', 'Male', '2007-12-10', 90.0, FALSE, 'black', 3, 2, 2),
  (3, 'Daniel Harris', 'Male', '2005-06-24', 81.5, FALSE, 'blue', 3, 2, 2),
  (4, 'Emily Wilson', 'Female', '2000-03-07', 56.8, FALSE, 'blue', 4, 3, 2),
  (5, 'Emma Clark', 'Female', '2001-04-30', 58.7, FALSE, 'orange', 10, 4, 2),
  (6, 'Roberto Bianchi', 'Male', '1991-07-15', 85.3, TRUE, 'black', 9, 5, 2),
  (7, 'Olivia Martinez', 'Female', '1997-11-05', 66.0, FALSE, 'brown', 8, 6, 2),
  (8, 'Sofia Romano', 'Female', '1994-09-22', 62.7, TRUE, 'black', 5, 7, 2),
  (9, 'Marco Rossi', 'Male', '1989-03-18', 92.1, TRUE, 'black', 7, 8, 2),
  (10, 'Sarah Davis', 'Female', '2002-09-15', 60.2, FALSE, 'yellow', 6, 9, 2),
  (11, 'Chris White', 'Male', '1985-02-28', 102.3, FALSE, 'white', 7, 10, 2),
  (12, 'Olivia Martinez', 'Female', '1997-11-05', 66.0, FALSE, 'brown', 8, NULL, 1),
  (13, 'David Wilson', 'Male', '1993-07-19', 78.4, FALSE, 'green', 4, NULL, 1),
  (14, 'Jane Smith', 'Female', '1995-08-21', 63.5, FALSE, 'brown', 2, NULL, 1);
=======
  (1, 'John Doe', 'Male', '1990-05-12', 81.2, FALSE, 'black', '2007-12-10', 1, 1, 2,),
  (2, 'Michael Brown', 'Male', '2007-12-10', 90.0, FALSE, 'black', '2007-12-10', 3, 2, 2,),
  (3, 'Daniel Harris', 'Male', '2005-06-24', 81.5, FALSE, 'blue', '2007-12-10', 3, 2, 2,),
  (4, 'Emily Wilson', 'Female', '2000-03-07', 56.8, FALSE, 'blue', '2006-12-10', 4, 3, 2,),
  (5, 'Emma Clark', 'Female', '2001-04-30', 58.7, FALSE, 'orange', '2008-12-10', 10, 4, 2,),
  (6, 'Roberto Bianchi', 'Male', '1991-07-15', 85.3, TRUE, 'black', '2006-12-10', 9, 5, 2,),
  (7, 'Olivia Martinez', 'Female', '1997-11-05', 66.0, FALSE, 'brown', '2009-12-10', 8, 6, 2,),
  (8, 'Sofia Romano', 'Female', '1994-09-22', 62.7, TRUE, 'black', '1999-12-10', 5, 7, 2,),
  (9, 'Marco Rossi', 'Male', '1989-03-18', 92.1, TRUE, 'black', '1999-12-10', 7, 8, 2,),
  (10, 'Sarah Davis', 'Female', '2002-09-15', 60.2, FALSE, 'yellow', '2005-12-10', 6, 9, 2,),
  (11, 'Chris White', 'Male', '1985-02-28', 102.3, FALSE, 'white', '2004-12-10', 7, 10, 2,),
  (12, 'Olivia Martinez', 'Female', '1997-11-05', 66.0, FALSE, 'brown', '2005-12-10', 8, NULL, 1,),
  (13, 'David Wilson', 'Male', '1993-07-19', 78.4, FALSE, 'green', '2004-12-10', 4, NULL, 1,),
  (14, 'Jane Smith', 'Female', '1995-08-21', 63.5, FALSE, 'brown', '2010-12-10', 2, NULL, 1);
>>>>>>> e7b2c046f493f207fdc76d3ad6fcced4a39bd978:build/createQueries.sql
INSERT INTO JudoEvents (eId, eName, price, eType, startDate, endDate, addId, ascId) VALUES
  (1, 'Judo Grand Prix', 50.0, 'Competition', '2025-08-01', '2025-08-02', 1, 2),
  (2, 'International Judo Camp', 30.0, 'Stage', '2025-04-05', '2025-04-07', 2, 2),
  (3, 'Judo Open Championship', 75.0, 'Competition', '2025-05-15', '2025-05-16', 3, 2),
  (4, 'Judo Beginners Workshop', 20.0, 'Stage', '2025-06-01', '2025-06-02', 4, 2),
  (5, 'Judo Masters Event', 100.0, 'Event', '2025-07-10', '2025-07-12', 5, 2),
  (6, 'Junior Judo Cup', 45.0, 'Competition', '2025-08-20', '2025-08-21', 6, 2),
  (7, 'Judo World Tour', 120.0, 'Event', '2025-09-05', '2025-09-07', 7, 2),
  (8, 'Judo Summer Camp', 40.0, 'Stage', '2025-07-15', '2025-07-17', 8, 2),
  (9, 'National Judo League', 80.0, 'Competition', '2025-10-12', '2025-10-14', 9, 2),
  (10, 'Elite Judo Challenge', 90.0, 'Competition', '2025-12-15', '2025-12-16', 10, 2);


INSERT INTO Dojo (dId, dName, addId, ascId) VALUES
  (1, 'Bushido Judo Club', 1, 1),
  (2, 'Kodokan Training Center', 2, 2),
  (3, 'Samurai Spirit Dojo', 3, 3),
  (4, 'Shogun Judo Academy', 4, 4),
  (5, 'Tatami Warriors Dojo', 5, 5),
  (6, 'Yamato Judo Institute', 6, 6),
  (7, 'Hikari Martial Arts', 7, 7),
  (8, 'Kyoto Judo Club', 8, 8),
  (9, 'Tensho Judo School', 9, 9),
  (10, 'Shinsei Judo Academy', 10, 1);
INSERT INTO JudoMatch (mId, mTime, mDate, eId) VALUES
  (1, 3.42, '2025-08-01', 1),
  (2, 2.18, '2025-08-01', 1),
  (3, 1.56, '2025-08-01', 1),
  (4, 2.45, '2025-08-01', 1),
  (5, 3.21, '2025-08-01', 1),
  (6, 1.48, '2025-08-02', 1),
  (7, 2.32, '2025-08-02', 1),
  (8, 3.55, '2025-08-02', 1),
  (9, 2.07, '2025-08-02', 1),
  (10, 1.59, '2025-08-02', 1),
  (11, 3.12, '2025-08-02', 1);
INSERT INTO PlayedScore (jId, mId, ippon, wazari, yuko, kScore, forfeit) VALUES
  (1, 1, 1, 0, 0, NULL,FALSE),  
  (2, 1, 0, 1, 0, NULL,FALSE),
  (1, 2, 1, 1, 3, NULL,FALSE),  
  (3, 2, 0, 0, 0, NULL,FALSE), 
  (1, 3, 0, 2, 0, NULL,FALSE),  
  (4, 3, 0, 1, 0, NULL,FALSE),
  (2, 4, 0, 0, 0, NULL,FALSE),  
  (3, 4, 1, 0, 0, NULL,FALSE), 
  (2, 5, 1, 0, 0, NULL,FALSE),  
  (4, 5, 0, 1, 0, NULL,FALSE),
  (3, 6, 0, 1, 0, NULL,FALSE),  
  (4, 6, 1, 0, 0, NULL,FALSE),  
  (10, 7, 0, 1, 0, NULL, FALSE),
  (9, 7, 0, 2, 5, NULL, FALSE),  
  (10, 8, 0, 1, 4, NULL, TRUE), 
  (8, 8, 0, 0, 0, NULL, FALSE),  
  (8, 9, 0, 1, 0, NULL, FALSE),
  (9, 9, 0, 0, 0, NULL, TRUE),  
  (6, 10, NULL, NULL, NULL, 100, FALSE), 
  (7, 10, NULL, NULL, NULL, 100, FALSE);  
INSERT INTO Request (jId, eId, rStatus, rDate) VALUES 
  (1, 1, "Approved", "2025-06-02"),
  (2, 1, "Approved", "2025-06-02"),
  (1, 4, "Approved", "2025-06-02"),
  (3, 1, "Approved", "2025-06-02"),
  (1, 9, "Approved", "2025-06-02"),
  (5, 1, "Approved", "2025-06-02"),
  (2, 2, "Approved", "2025-06-02"),
  (3, 2, "Approved", "2025-06-02"),
  (4, 1, "Approved", "2025-06-02"),
  (3, 6, "Approved", "2025-06-02"),
  (4, 6, "Approved", "2025-06-02"),
  (10,8, "Approved", "2025-06-02"),
  (9, 1, "Approved", "2025-06-02"),
  (10,1, "Approved", "2025-06-02"),
  (8, 7, "Approved", "2025-06-02"),
  (8, 10, "Approved", "2025-06-02"),
  (9, 10, "Approved", "2025-06-02"),
  (6, 1, "Approved", "2025-06-02"),
  (7, 1, "Approved", "2025-06-02"),
  (11,1, "Rejected", "2025-06-02"),
  (11,2, "Rejected", "2025-06-02"),
  (8, 1, "Submitted", "2025-06-02"),
  (7, 6, "Submitted", "2025-06-02");
INSERT INTO StudyIn (jId, dId) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6),
  (7, 7),
  (8, 8),
  (9, 9),
  (10,10);
INSERT INTO TeachIn (jId, dId, cAge, cLevel) VALUES
  (6, 1, "Kids", "Beginner"),
  (6, 2, "Kids","Intermediate"),
  (6, 3, "Kids","Advanced"),
  (6, 4, "Adult","Beginner"),
  (8, 5, "Adult","Intermediate"),
  (8, 6, "Adult","Advanced"),
  (8, 7, "Elderly","Beginner"),
  (9, 8, "Elderly","Intermediate"),
  (9, 9, "Elderly","Advanced"),
  (9,10, "Kids","Advanced");
