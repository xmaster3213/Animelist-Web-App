CREATE DATABASE animelist;

USE animelist;

CREATE TABLE account(
    username varchar(20) PRIMARY KEY,
    password varchar(16) NOT NULL,
    email varchar(40) NOT NULL,
    telefono varchar(13),
    immagine varchar(100),
    amministratore BOOLEAN NOT NULL DEFAULT false
);

CREATE TABLE anime(
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    nome varchar(100) NOT NULL,
    studio varchar(50) not null,
    trama varchar(2000),
    durata_episodi int unsigned,
    voto_medio int unsigned,
    data_rilascio date,
    numero_episodi int unsigned, 
    immagine_copertina varchar(100),
    trailer varchar(100)
);

CREATE TABLE lista(
    utente varchar(20) NOT NULL,
    id_anime int unsigned NOT NULL,
    stato enum("COMPLETATO", "VISIONE PIANIFICATA", "IN VISIONE", "ABBANDONATO") NOT NULL,
    data_inizio date,
    data_fine date,
    episodi_visti int unsigned,
    voto int unsigned,

    CONSTRAINT pk_lista
        PRIMARY KEY (utente, id_anime),

    CONSTRAINT check_inizio_le_fine
        CHECK (data_fine >= data_inizio),
    
    CONSTRAINT fk_lista_utente
        FOREIGN KEY (utente) REFERENCES account(username)
            ON DELETE CASCADE
            ON UPDATE CASCADE,

    CONSTRAINT fk_lista_id_anime
        FOREIGN KEY (id_anime) REFERENCES anime(id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
);

CREATE TABLE episodio(
    id_anime int unsigned NOT NULL,
    numero int unsigned NOT NULL,
    titolo varchar(2000) NOT NULL,
    thumbnail varchar(100),

    CONSTRAINT pk_episodio
        PRIMARY KEY (id_anime, numero),

    CONSTRAINT fk_episodio_id_anime
        FOREIGN KEY (id_anime) REFERENCES anime(id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
);

CREATE TABLE doppiatore(
    id int unsigned AUTO_INCREMENT PRIMARY KEY,
    nome varchar(30) NOT NULL,
    immagine varchar(100),
    info TEXT NOT NULL
);

CREATE TABLE personaggio(
    id int unsigned NOT NULL AUTO_INCREMENT,
    id_anime int unsigned NOT NULL,
    id_doppiatore int unsigned,
    nome varchar(100) NOT NULL,
    descrizione TEXT NOT NULL,
    immagine varchar(100),

    CONSTRAINT pk_personaggio
        PRIMARY KEY (id, id_anime),

    CONSTRAINT fk_personaggio_id_anime
        FOREIGN KEY (id_anime) REFERENCES anime(id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION,

    CONSTRAINT fk_personaggio_id_doppiatore
        FOREIGN KEY (id_doppiatore) REFERENCES doppiatore(id)
            ON DELETE SET NULL
            ON UPDATE NO ACTION
);

CREATE TABLE modifica(
    amministratore varchar(20) NOT NULL,
    id_anime int unsigned NOT NULL,
    data date NOT NULL,
    ora time NOT NULL,

    CONSTRAINT pk_modifica
        PRIMARY KEY (amministratore, id_anime, data, ora),

    CONSTRAINT fk_modifica_amministratore
        FOREIGN KEY (amministratore) REFERENCES account(username)
            ON DELETE NO ACTION
            ON UPDATE CASCADE,

    CONSTRAINT fk_modifica_id_anime
        FOREIGN KEY (id_anime) REFERENCES anime(id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
);