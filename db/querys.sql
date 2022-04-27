-- Crea un nuovo utente
INSERT INTO account (username, password, email, telefono, immagine)
VALUE (?, ?, ?, ?, ?);

-- Creare un nuovo amministratore
INSERT INTO account (username, password, email, telefono, immagine, amministratore)
VALUE (?, ?, ?, ?, ?, true);

-- Dato un utente visualizzare gli attributi del suo account
SELECT username, password, email, telefono, immagine
FROM account
WHERE username = ?;

-- Visualizzare gli utenti filtrandoli per nome
SELECT username, immagine
FROM account
WHERE username LIKE %?%
ORDER BY username ASC;

-- Dato un utente visualizzare gli anime presenti all’interno della sua lista
SELECT anime.id, lista.episodi_visti, lista.voto, anime.nome, anime.immagine_copertina, anime.numero_episodi
FROM lista
JOIN anime ON lista.id_anime = anime.id
WHERE lista.utente = ? AND lista.stato = ?;;

-- Dato un utente e un anime aggiungere l’anime alla lista
INSERT INTO lista (utente, id_anime, stato, data_inizio, data_fine, episodi_visti, voto)
VALUE (?, ?, ?, ?, ?, ?, ?);

-- Dato un utente e un anime visualizzare gli attributi di lista rispettivi a quell’utente con quell’anime
SELECT stato, data_inizio, data_fine, episodi_visti, voto 
FROM lista
WHERE utente = ? AND id_anime = ?

-- Visualizzare gli anime filtrandoli per nome
SELECT nome, immagine_copertina, id
FROM anime
WHERE nome LIKE %?%
ORDER BY nome ASC;

-- Visualizzare un cetro numero di anime
SELECT nome, immagine_copertina, id
FROM anime
LIMIT ?;

-- Dato un anime visualizzare tutte le sue informazioni
SELECT nome, studio, trama, durata_episodi, voto_medio, data_rilascio, numero_episodi, immagine_copertina, trailer
FROM anime
WHERE id = ?;

-- Dato un amministratore aggiungere un anime, registrandone la modifica
INSERT INTO anime (nome, studio, trama, durata_episodi, numero_episodi, data_rilascio, immagine_copertina, trailer)
VALUE (?, ?, ?, ?, ?, ?, ?, ?);

INSERT INTO modifica (amministratore, id_anime, data, ora)
VALUE (?, ?, CURRENT_DATE(), CURRENT_TIME());

-- Dato un amministratore e un anime aggiungere un episodio, registrando che e’ stata effettuata una modifica
INSERT INTO episodio (id_anime, numero, titolo, thumbnail)
VALUE (?, ?, ?, ?);

INSERT INTO modifica (amministratore, id_anime, data, ora)
VALUE (?, ?, CURRENT_DATE(), CURRENT_TIME());

-- Dato un amministratore e un anime aggiungere un personaggio, registrando che e’ stata effettuata una modifica
INSERT INTO personaggio (id_anime, nome, descrizione, immagine, id_doppiatore)
VALUE (?, ?, ?, ?, ?);

INSERT INTO modifica (amministratore, id_anime, data, ora)
VALUE (?, ?, CURRENT_DATE(), CURRENT_TIME());

-- Aggiungere un nuovo doppiatore
INSERT INTO doppiatore (nome, immagine, info)
VALUE (?, ?, ?);

-- Visualizzare le informazioni di un personaggio
SELECT nome, descrizione, immagine, id_doppiatore
FROM personaggio
WHERE id = ? AND id_anime = ?;

-- Visualizzare le informazioni di un doppiatore
SELECT nome, info, immagine
FROM doppiatore
WHERE id = ?;

-- Dato un anime visualizzare i personaggi
SELECT id, nome, descrizione, immagine
FROM personaggio
WHERE id_anime = ?;

-- Dato un anime visualizzare tutti gli episodi
SELECT numero, titolo, thumbnail
FROM episodio
WHERE id_anime = ?
ORDER BY numero ASC;

-- Visualizzare le modifiche effettuate dagli amministratori
SELECT modifica.amministratore, modifica.id_anime, modifica.data, modifica.ora, anime.nome
FROM modifica LEFT JOIN anime ON modifica.id_anime = anime.id;