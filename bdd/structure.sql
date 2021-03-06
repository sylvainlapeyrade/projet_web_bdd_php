/* Base de données du projet web-bdd-php */

/* Destruction des tables si elles existent: */
DROP TABLE IF EXISTS Album              CASCADE;
DROP TABLE IF EXISTS Artiste            CASCADE;
DROP TABLE IF EXISTS Recompense         CASCADE;
DROP TABLE IF EXISTS Musique            CASCADE;
DROP TABLE IF EXISTS Groupe             CASCADE;
DROP TABLE IF EXISTS Utilisateur        CASCADE;
DROP TABLE IF EXISTS Evaluer_Album      CASCADE;
DROP TABLE IF EXISTS Evaluer_Musique    CASCADE;
DROP TABLE IF EXISTS Composer_Album     CASCADE;
DROP TABLE IF EXISTS Composer_Musique   CASCADE;
DROP TABLE IF EXISTS Composer_AlbumGr   CASCADE;
DROP TABLE IF EXISTS Composer_MusiqueGr CASCADE;
DROP TABLE IF EXISTS Obtenir_Artiste    CASCADE;
DROP TABLE IF EXISTS Assembler_Album    CASCADE;
DROP TABLE IF EXISTS Constituer         CASCADE;
DROP TABLE IF EXISTS Definir            CASCADE;


/* Créations des tables de la bdd */
CREATE TABLE Album(
  idAlbum               SERIAL        CONSTRAINT Al_pk_idAl  PRIMARY KEY,
  nomAlbum              VARCHAR(45)   CONSTRAINT Al_noAl_NN  NOT NULL,
  dateAlbum             DATE          CONSTRAINT AL_daAl_NN  NOT NULL,
  urlPochetteAlbum      TEXT,
  descriptionAlbum      TEXT
);


CREATE TABLE Artiste(
  idArtiste             SERIAL        CONSTRAINT Ar_pk_idAr  PRIMARY KEY,
  nomArtiste            VARCHAR(45)   CONSTRAINT Ar_noAr_NN  NOT NULL,
  prenomArtiste         VARCHAR(45)   CONSTRAINT Ar_prAr_NN  NOT NULL,
  nomScene              VARCHAR(45),
  dateNaissanceArtiste  DATE          CONSTRAINT Ar_daAr_NN  NOT NULL,
  descriptionArtiste    TEXT,
  urlImageArtiste       TEXT
);


CREATE TABLE Recompense(
  idRecompense 	        SERIAL 		    CONSTRAINT Re_pk_idRe  PRIMARY KEY,
  nomRecompense 	      VARCHAR(45)   CONSTRAINT Re_noRe_NN  NOT NULL,
  dateRecompense        DATE          CONSTRAINT Re_daRe_NN  NOT NULL,
  descriptionRecompense TEXT
);


CREATE TABLE Musique(
  idMusique             SERIAL        CONSTRAINT Mu_pk_idMu  PRIMARY KEY,
  titreMusique          VARCHAR(45)   CONSTRAINT Mu_tiMu_NN  NOT NULL,
  dureeMusique	        INT           CONSTRAINT Mu_duMu_NN  NOT NULL,
  dateMusique	   	      DATE          CONSTRAINT Mu_daMu_NN NOT NULL,
  descriptionMusique    TEXT
);


CREATE TABLE Groupe(
  idGroupe              SERIAL        CONSTRAINT Gr_pk_idGr  PRIMARY KEY,
  nomGroupe	            VARCHAR(45)   CONSTRAINT Gr_noGr_NN  NOT NULL,
  dateGroupe	          DATE          CONSTRAINT GR_daGr_NN  NOT NULL,
  descriptionGroupe     TEXT,
  urlImageGroupe        TEXT
);


CREATE TABLE Utilisateur(
  idUtilisateur         VARCHAR(45)   CONSTRAINT Ut_pk_idUt  PRIMARY KEY,
  motDePasse            VARCHAR(45)   CONSTRAINT Ut_moUt_NN  NOT NULL,
  statut                BOOLEAN       CONSTRAINT Ut_stUt_NN  NOT NULL
);


CREATE TABLE Evaluer_Album(
  idUtilisateurEvAl     VARCHAR(45)   CONSTRAINT Ea_fk_iUEa  REFERENCES Utilisateur(idUtilisateur) ON DELETE CASCADE,
  idAlbumEvAl           INT           CONSTRAINT Ea_fk_iAEa  REFERENCES Album(idAlbum) ON DELETE CASCADE,
  noteEvAl              INT           CONSTRAINT Ea_noEa_nn  NOT NULL,
  CONSTRAINT Ea_noEa_ch  CHECK (noteEvAl BETWEEN 0 AND 5),
  commentaireEvAl       TEXT,
  CONSTRAINT Ea_pk_evAl  PRIMARY KEY (idUtilisateurEvAl, idAlbumEval)
);


CREATE TABLE Evaluer_Musique(
  idUtilisateurEvMu     VARCHAR(45)   CONSTRAINT Em_fk_iUEm  REFERENCES Utilisateur(idUtilisateur) ON DELETE CASCADE,
  idMusiqueEvMu         INT           CONSTRAINT Em_fk_iMEm  REFERENCES Musique(idMusique) ON DELETE CASCADE,
  noteEvMu              INT           CONSTRAINT Em_noEm_NN  NOT NULL,
  CONSTRAINT Em_noEm_CH  CHECK (noteEvMu BETWEEN 0 AND 5),
  commentaireEvMu       TEXT,
  CONSTRAINT Em_pk_evMu  PRIMARY KEY (idUtilisateurEvMu, idMusiqueEvMu)
);


CREATE TABLE Composer_Album(
  idAlbumCoAl           INT           CONSTRAINT Ca_fk_ilCo  REFERENCES Album(idAlbum)     ON DELETE CASCADE,
  idArtisteCoAl         INT           CONSTRAINT Ca_fk_irCo  REFERENCES Artiste(idArtiste) ON DELETE RESTRICT,
  CONSTRAINT Ca_pk_coAl  PRIMARY KEY (idAlbumCoAl, idArtisteCoAl)
);


CREATE TABLE Composer_Musique(
  idMusiqueCoMu         INT           CONSTRAINT Cm_fk_iMCo  REFERENCES Musique(idMusique) ON DELETE CASCADE,
  idArtisteCoMu         INT           CONSTRAINT Cm_fk_iACo  REFERENCES Artiste(idArtiste) ON DELETE RESTRICT,
  CONSTRAINT Cm_pk_coMu  PRIMARY KEY (idMusiqueCoMu, idArtisteCoMu)
);


CREATE TABLE Composer_AlbumGr(
  idAlbumCoAr           INT           CONSTRAINT Cr_fk_ilCr  REFERENCES Album(idAlbum)     ON DELETE CASCADE,
  idGroupeCoAr          INT           CONSTRAINT Cr_fk_irCr  REFERENCES Groupe(idGroupe)   ON DELETE RESTRICT,
  CONSTRAINT Cr_pk_coAr  PRIMARY KEY (idAlbumCoAr, idGroupeCoAr)
);


CREATE TABLE Composer_MusiqueGr(
  idMusiqueCoMr         INT           CONSTRAINT Cm_fk_iMCr  REFERENCES Musique(idMusique) ON DELETE CASCADE,
  idGroupeCoMr          INT           CONSTRAINT Cm_fk_iACr  REFERENCES Groupe(idGroupe)   ON DELETE RESTRICT,
  CONSTRAINT Cr_pk_coMr  PRIMARY KEY (idMusiqueCoMr, idGroupeCoMr)
);


CREATE TABLE Obtenir_Artiste(
  idRecompenseOa        INT           CONSTRAINT Oa_fk_iROa  REFERENCES Recompense(idRecompense),
  idArtisteOa           INT           CONSTRAINT Oa_fk_iAOa  REFERENCES Artiste(idArtiste),
  CONSTRAINT Oa_pk_obAr  PRIMARY KEY (idRecompenseOa, idArtisteOa)
);


CREATE TABLE Assembler_Album(
  idAlbumAa             INT           CONSTRAINT Aa_fk_ilAa  REFERENCES Album(idAlbum)     ON DELETE CASCADE,
  idMusiqueAa           INT           CONSTRAINT Aa_fk_iMAa  REFERENCES Musique(idMusique) ON DELETE CASCADE,
  numeroPiste           INT           CONSTRAINT Aa_nuPi_NN  NOT NULL,
  CONSTRAINT Aa_pk_AsAl  PRIMARY KEY (idAlbumAa, idMusiqueAa)
);


CREATE TABLE Constituer(
  idGroupeCo            INT           CONSTRAINT Co_fk_iGCo  REFERENCES Groupe(idGroupe),
  idArtisteCo           INT           CONSTRAINT Co_fk_iACo  REFERENCES Artiste(idArtiste),
  CONSTRAINT Co_pk_Cons  PRIMARY KEY(idGroupeCo, idArtisteCo)
);


CREATE TABLE Definir(
  idMusiqueDe           INT           CONSTRAINT De_fk_iMDe  REFERENCES Musique(idMusique) ON DELETE CASCADE,
  nomGenre              VARCHAR(45)   CONSTRAINT De_noGe_NN  NOT NULL,
  CONSTRAINT De_pk_Defi  PRIMARY KEY(idMusiqueDe, nomGenre)
);
