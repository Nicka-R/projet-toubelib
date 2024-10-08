INSERT INTO specialite (label, description)
VALUES ('Dentiste', 'Spécialiste des dents');


INSERT INTO praticien (nom, prenom, adresse, telephone, specialite_id)
VALUES ('Dupont', 'Jean', '123 Rue de la Paix', '0123456789', '2c32af3a-f1c1-4e85-ab1d-890dcac332fb');

INSERT INTO patientAdmin (nom, prenom, nss, date_naissance, adresse, mail, medecin_traitant)
VALUES ('Georges', 'Victor', '123456789012345', '1990-01-01', '123 Rue de la Paix', 'victorgeorges54@gmail.com', 'Michel');