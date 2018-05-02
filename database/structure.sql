/* Base de données du projet web-bdd-php */

/* Destruction des tables si elles existent: */
DROP TABLE IF EXISTS Album            CASCADE;
DROP TABLE IF EXISTS Artiste          CASCADE;
DROP TABLE IF EXISTS Recompense       CASCADE;
DROP TABLE IF EXISTS Musique          CASCADE;
DROP TABLE IF EXISTS Groupe           CASCADE;
DROP TABLE IF EXISTS Utilisateur      CASCADE;
DROP TABLE IF EXISTS Evaluer_Album    CASCADE;
DROP TABLE IF EXISTS Evaluer_Musique  CASCADE;
DROP TABLE IF EXISTS Composer_Album   CASCADE;
DROP TABLE IF EXISTS Composer_Musique CASCADE;
DROP TABLE IF EXISTS Obtenir_Artiste  CASCADE;
DROP TABLE IF EXISTS Assembler_Album  CASCADE;
DROP TABLE IF EXISTS Constituer       CASCADE;
DROP TABLE IF EXISTS Definir          CASCADE;


/* Créations des tables de la bdd */
CREATE TABLE Album(
  idAlbum               SERIAL        CONSTRAINT Al_pk_idAl  PRIMARY KEY,
  nomAlbum              VARCHAR(45)   CONSTRAINT Al_noAl_nn  NOT NULL,
  dateAlbum             DATE          CONSTRAINT Al_daAl_nn  NOT NULL,
  urlPochetteAlbum      TEXT,
  descriptionAlbum      TEXT
);


CREATE TABLE Artiste(
  idArtiste             SERIAL        CONSTRAINT Ar_pk_idAr  PRIMARY KEY,
  nomArtiste            VARCHAR(45)   CONSTRAINT Ar_noAr_nn  NOT NULL,
  prenomArtiste         VARCHAR(45)   CONSTRAINT Ar_prAr_nn  NOT NULL,
  nomScene              VARCHAR(45),
  dateNaissanceArtiste  DATE,
  descriptionArtiste    TEXT,
  urlImageArtiste       TEXT
);


CREATE TABLE Recompense(
  idRecompense 	        SERIAL 		    CONSTRAINT Re_pk_idRe  PRIMARY KEY,
  nomRecompense 	      VARCHAR(45)   CONSTRAINT Re_noRc_NN  NOT NULL,
  dateRecompense        DATE          CONSTRAINT Re_daRc_NN  NOT NULL,
  descriptionRecompense TEXT
);


CREATE TABLE Musique(
  idMusique             SERIAL        CONSTRAINT Mu_pk_idMu  PRIMARY KEY,
  titreMusique          VARCHAR(45)   CONSTRAINT Mu_tiMu_NN  NOT NULL,
  dureeMusique	        INT           CONSTRAINT Mu_duMu_NN  NOT NULL,
  dateMusique	   	      DATE          CONSTRAINT Mu_daMu_NN  NOT NULL,
  descriptionMusique    TEXT
);


CREATE TABLE Groupe(
  idGroupe              SERIAL        CONSTRAINT Gr_pk_idGr  PRIMARY KEY,
  nomGroupe	            VARCHAR(45)   CONSTRAINT Gr_noGr_nn  NOT NULL,
  dateGroupe	          DATE,
  descriptionGroupe     TEXT,
  urlImageGroupe        TEXT
);


CREATE TABLE Utilisateur(
  idUtilisateur         VARCHAR(45)   CONSTRAINT Ut_pk_idUt  PRIMARY KEY,
  motDePasse            VARCHAR(45)   CONSTRAINT Ut_moUt_nn  NOT NULL,
  statut                BOOLEAN       CONSTRAINT Ut_stUt_nn  NOT NULL
);


CREATE TABLE Evaluer_Album(
  idUtilisateurEvAl     VARCHAR(45)   CONSTRAINT Ea_fk_iUEa  REFERENCES Utilisateur(idUtilisateur),
  idAlbumEvAl           INT           CONSTRAINT Ea_fk_iAEa  REFERENCES Album(idAlbum),
  noteEvAl              INT           CONSTRAINT Ea_noEa_nn  NOT NULL,
                                      CONSTRAINT Ea_noEa_ch  CHECK (noteEvAl BETWEEN 0 AND 5),
  commentaireEvAl       TEXT,
                                      CONSTRAINT Ea_pk_evAl  PRIMARY KEY (idUtilisateurEvAl, idAlbumEval)
);


CREATE TABLE Evaluer_Musique(
  idUtilisateurEvMu     VARCHAR(45)   CONSTRAINT Em_fk_iUEm  REFERENCES Utilisateur(idUtilisateur),
  idMusiqueEvMu         INT           CONSTRAINT Em_fk_iMEm  REFERENCES Musique(idMusique),
  noteEvMu              INT           CONSTRAINT Em_noEm_NN  NOT NULL,
                                      CONSTRAINT Em_noEm_CH  CHECK (noteEvMu BETWEEN 0 AND 5),
  commentaireEvMu       TEXT,
                                      CONSTRAINT Em_pk_evMu  PRIMARY KEY (idUtilisateurEvMu, idMusiqueEvMu)
);


CREATE TABLE Composer_Album(
  idAlbumCoAl           INT           CONSTRAINT Ca_fk_ilCo  REFERENCES Album(idAlbum),
  idArtisteCoAl         INT           CONSTRAINT Ca_fk_irCo  REFERENCES Artiste(idArtiste),
							                        CONSTRAINT Ca_pk_coAl  PRIMARY KEY (idAlbumCoAl, idArtisteCoAl)
);


CREATE TABLE Composer_Musique(
  idMusiqueCoMu         INT           CONSTRAINT Cm_fk_iMCo  REFERENCES Album(idAlbum),
  idArtisteCoMu         INT           CONSTRAINT Cm_fk_iACo  REFERENCES Artiste(idArtiste),
                                      CONSTRAINT Cm_pk_coMu  PRIMARY KEY (idMusiqueCoMu, idArtisteCoMu)
);


CREATE TABLE Obtenir_Artiste(
  idRecompenseOa        INT           CONSTRAINT Oa_fk_iROa  REFERENCES Recompense(idRecompense),
  idArtisteOa           INT           CONSTRAINT Oa_fk_iAOa  REFERENCES Artiste(idArtiste),
							                        CONSTRAINT Oa_pk_obAr  PRIMARY KEY (idRecompenseOa, idArtisteOa)
);


CREATE TABLE Assembler_Album(
  idAlbumAa             INT           CONSTRAINT Aa_fk_ilAa  REFERENCES Album(idAlbum),
  idMusiqueAa           INT           CONSTRAINT Aa_fk_iMAa  REFERENCES Musique(idMusique),
  numeroPiste           INT           CONSTRAINT Aa_nuPi_NN  NOT NULL,
                                      CONSTRAINT Aa_pk_AsAl  PRIMARY KEY (idAlbumAa, idMusiqueAa)
);


CREATE TABLE Constituer(
  idGroupeCo            INT           CONSTRAINT Co_fk_iGCo  REFERENCES Groupe(idGroupe),
  idArtisteCo           INT           CONSTRAINT Co_fk_iACo  REFERENCES Artiste(idArtiste),
                                      CONSTRAINT Co_pk_Cons  PRIMARY KEY(idGroupeCo, idArtisteCo)
);


CREATE TABLE Definir(
  idMusiqueDe           INT           CONSTRAINT De_fk_iMDe  REFERENCES Musique(idMusique),
  nomGenre              VARCHAR(45)   CONSTRAINT De_noGe_NU  NOT NULL UNIQUE,
                                      CONSTRAINT De_pk_Defi  PRIMARY KEY(idMusiqueDe, nomGenre)
);
