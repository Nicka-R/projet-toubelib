DROP TABLE IF EXISTS "praticien";

CREATE TABLE "praticien" (
    "nom" VARCHAR(255) NOT NULL,
    "prenom" VARCHAR(255) NOT NULL,
    "adresse" TEXT NOT NULL,
    "telephone" VARCHAR(20) NOT NULL,
    "specialite_id" VARCHAR(255) NOT NULL,
    "id" UUID NOT NULL
);

DROP TABLE IF EXISTS "specialite";
CREATE TABLE "specialite" (
    "label" VARCHAR(255) NOT NULL,
    "description" TEXT NOT NULL,
    "id" UUID NOT NULL
);