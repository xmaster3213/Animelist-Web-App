<?php

class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if($this->db->connect_error){
            die("Bad connection to DB");
        }
    }

    # Add a new UTENTE to the database, return if the operation was successfull or not
    public function addNewUtente($username, $password, $email, $telefono, $immagine){
        try {
            $stmt = $this->db->prepare("INSERT INTO account (username, password, email, telefono, immagine)
            VALUE (?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss", $username, $password, $email, $telefono, $immagine);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    # Add a new AMMINISTRATORE to the database, return if the operation was successfull or not
    public function addNewAmministratore($username, $password, $email, $telefono, $immagine){
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO account (username, password, email, telefono, immagine, amministratore)
                VALUE (?, ?, ?, ?, ?, true);"
            );
            $stmt->bind_param("sssss", $username, $password, $email, $telefono, $immagine);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function login($username, $password){
        try {
            $stmt = $this->db->prepare(
                "SELECT amministratore
                FROM account
                WHERE username = ?
                AND password = ?;"
            );
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                return null;
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function userExists($username) {
        try {
            $stmt = $this->db->prepare(
                "SELECT 1
                FROM account
                WHERE username = ?;"
            );
            $stmt->bind_param("s", $username);
            $stmt->execute();
            return $stmt->get_result()->num_rows === 1;
        } catch (Exception $e) {
            return false;
        }
    }

    public function editUtente($username, $new_username, $email, $telefono, $immagine) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE account
                SET username = ?, email = ?, telefono = ?, immagine = ?
                WHERE username = ?;"
            );
            $stmt->bind_param("sssss", $new_username, $email, $telefono, $immagine, $username);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function editPassword($username, $password) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE account
                SET password = ?
                WHERE username = ?;"
            );
            $stmt->bind_param("ss", $password, $username);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }
    public function getUtente($username){
        try {
            $stmt = $this->db->prepare(
                "SELECT username, password, email, telefono, immagine
                FROM account
                WHERE username = ?;"
            );
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAnimelistGivenStato($username, $category){
        try {
            $stmt = $this->db->prepare(
                "SELECT anime.id, lista.episodi_visti, lista.voto, anime.nome, anime.immagine_copertina, anime.numero_episodi
                FROM lista
                JOIN anime ON lista.id_anime = anime.id
                WHERE lista.utente = ? AND lista.stato = ?;"
            );
            $stmt->bind_param("ss", $username, $category);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAnime($id){
        try {
            $stmt = $this->db->prepare(
                "SELECT nome, studio, trama, durata_episodi, voto_medio, data_rilascio, numero_episodi, immagine_copertina, trailer
                FROM anime
                WHERE id = ?;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAnimeCharacters($id){
        try {
            // id, id_anime, id_doppiatore, nome, descrizione, immagine : personaggio
            // id, nome, info, immagine : doppiatore
            $stmt = $this->db->prepare(
                "SELECT personaggio.id as charid,
                        doppiatore.id as staffid,
                        personaggio.nome as charname,
                        descrizione as chardesc,
                        personaggio.immagine as charimg,
                        doppiatore.nome as staffname,
                        info as staffinfo,
                        doppiatore.immagine as staffimg
                FROM personaggio LEFT JOIN doppiatore ON personaggio.id_doppiatore = doppiatore.id
                WHERE personaggio.id_anime = ?;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getEpisodes($id){
        try {
            // id_anime, numero, titolo, thumbnail : episodio
            $stmt = $this->db->prepare(
                "SELECT numero, titolo, thumbnail
                FROM episodio
                WHERE id_anime = ?
                ORDER BY numero ASC;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getUtenteLike($user){
        try {
            // id_anime, numero, titolo, thumbnail : episodio
            $user = '%' . $user . '%';
            $stmt = $this->db->prepare(
                "SELECT username, immagine
                FROM account
                WHERE username LIKE ?
                ORDER BY username ASC;"
            );
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAnimeLike($anime){
        try {
            $anime = '%' . $anime . '%';
            $stmt = $this->db->prepare(
                "SELECT nome, immagine_copertina, id
                FROM anime
                WHERE nome LIKE ?
                ORDER BY nome ASC;"
            );
            $stmt->bind_param("s", $anime);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAllAnime(){
        try {
            $stmt = $this->db->prepare(
                "SELECT nome, immagine_copertina, id
                FROM anime
                LIMIT 100"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getListaEntry($idAnime, $username){
        try {
            $stmt = $this->db->prepare(
                "SELECT stato, data_inizio, data_fine, episodi_visti, voto 
                FROM lista
                WHERE utente = ? AND id_anime = ?"
            );
            $stmt->bind_param("si", $username, $idAnime);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteListaEntry($idAnime, $username){
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM lista 
                WHERE utente = ? AND id_anime = ?"
            );
            $stmt->bind_param("si", $username, $idAnime);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            die($e);
            return false;
        }
    }


    public function addOrUpdateListaEntry($utente, $id_anime, $stato, $data_inizio, $data_fine, $episodi_visti, $voto) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO lista (utente, id_anime, stato, data_inizio, data_fine, episodi_visti, voto)
                VALUE (?, ?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE stato=?, data_inizio=?, data_fine=?, episodi_visti=?, voto=?"
            );
            $stmt->bind_param("sisssiisssii", $utente, $id_anime, $stato, $data_inizio, $data_fine, $episodi_visti, $voto,
                                                                  $stato, $data_inizio, $data_fine, $episodi_visti, $voto);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function animeExists($id) {
        try {
            $stmt = $this->db->prepare(
                "SELECT 1
                FROM anime
                WHERE id = ?;"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->num_rows === 1;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAnimeGeneralInfo($idAnime){
        try {
            $stmt = $this->db->prepare(
                "SELECT nome, immagine_copertina, numero_episodi
                FROM anime
                WHERE anime.id = ?"
            );
            $stmt->bind_param("i", $idAnime);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getCharacter($idAnime, $idCharacter){
        try {
            $stmt = $this->db->prepare(
                "SELECT nome, descrizione, immagine, id_doppiatore
                FROM personaggio
                WHERE id = ? AND id_anime = ?"
            );
            $stmt->bind_param("ii", $idCharacter, $idAnime);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function editCharacter($idAnime, $idCharacter, $nome, $descrizione, $immagine, $id_doppiatore) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE personaggio
                SET nome = ?, descrizione = ?, immagine = ?, id_doppiatore = ?
                WHERE id_anime = ? AND id = ?;"
            );
            $stmt->bind_param("sssiii", $nome, $descrizione, $immagine, $id_doppiatore, $idAnime, $idCharacter);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addCharacter($idAnime, $nome, $descrizione, $immagine, $id_doppiatore) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO personaggio (id_anime, nome, descrizione, immagine, id_doppiatore)
                VALUE (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("isssi", $idAnime, $nome, $descrizione, $immagine, $id_doppiatore);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delCharacter($idAnime, $idCharacter) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM personaggio
                WHERE id_anime = ? AND id = ?"
            );
            $stmt->bind_param("ii", $idAnime, $idCharacter);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getActor($id){
        try {
            $stmt = $this->db->prepare(
                "SELECT nome, info, immagine
                FROM doppiatore
                WHERE id = ?"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function editActor($id, $nome, $immagine, $info) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE doppiatore
                SET nome = ?, immagine = ?, info = ?
                WHERE id = ?;"
            );
            $stmt->bind_param("sssi", $nome, $immagine, $info, $id);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addActor($nome, $immagine, $info) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO doppiatore (nome, immagine, info)
                VALUE (?, ?, ?)"
            );
            $stmt->bind_param("sss", $nome, $immagine, $info);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            die('Errore nella query ' . $e);
        }
    }

    public function delActor($id) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM doppiatore
                WHERE id = ?"
            );
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function editAnime($id, $nome, $studio, $trama, $durataEpisodi, $numeroEpisodi, $dataRilascio, $immagineCopertina, $trailer) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE anime
                SET nome = ?, studio = ?, trama = ?, durata_episodi = ?, numero_episodi = ?, data_rilascio = ?, immagine_copertina = ?, trailer = ?
                WHERE id = ?;"
            );
            $stmt->bind_param("ssssssssi", $nome, $studio, $trama, $durataEpisodi, $numeroEpisodi, $dataRilascio, $immagineCopertina, $trailer, $id);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addAnime($nome, $studio, $trama, $durataEpisodi, $numeroEpisodi, $dataRilascio, $immagineCopertina, $trailer) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO anime (nome, studio, trama, durata_episodi, numero_episodi, data_rilascio, immagine_copertina, trailer)
                VALUE (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("ssssssss", $nome, $studio, $trama, $durataEpisodi, $numeroEpisodi, $dataRilascio, $immagineCopertina, $trailer);
            $result = $stmt->execute();
            return $this->db->insert_id;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateVotoMedio($animeid) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE anime
                SET voto_medio = (
                    SELECT AVG(voto)*10
                    FROM lista
                    WHERE id_anime = ?
                )
                WHERE id = ?"
            );
            $stmt->bind_param("ss", $animeid, $animeid);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delAnime($id) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM anime
                WHERE id = ?"
            );
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getEpisode($idAnime, $number){
        try {
            // id_anime, numero, titolo, thumbnail : episodio
            $stmt = $this->db->prepare(
                "SELECT titolo, thumbnail
                FROM episodio
                WHERE id_anime = ? AND numero = ?;"
            );
            $stmt->bind_param("ii", $idAnime, $number);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function editEpisode($idAnime, $numero, $titolo, $thumbnail) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE episodio
                SET titolo = ?, thumbnail = ?
                WHERE id_anime = ? AND numero = ?;"
            );
            $stmt->bind_param("ssii", $titolo, $thumbnail, $idAnime, $numero);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addEpisode($idAnime, $numero, $titolo, $thumbnail) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO episodio (id_anime, numero, titolo, thumbnail)
                VALUE (?, ?, ?, ?)"
            );
            $stmt->bind_param("iiss", $idAnime, $numero, $titolo, $thumbnail);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delEpisode($idAnime, $numero) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM episodio
                WHERE id_anime = ? AND numero = ?"
            );
            $stmt->bind_param("ii", $idAnime, $numero);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getModifiche() {
        try {
            // amministratore, id_anime, data, ora : modifica
            $stmt = $this->db->prepare(
                "SELECT modifica.amministratore, modifica.id_anime, modifica.data, modifica.ora, anime.nome
                FROM modifica LEFT JOIN anime ON modifica.id_anime = anime.id;"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function addModifica($amministratore, $anime) {
        try {
            // amministratore, id_anime, data, ora : modifica
            $stmt = $this->db->prepare(
                "INSERT INTO modifica (amministratore, id_anime, data, ora)
                VALUE (?, ?, CURRENT_DATE(), CURRENT_TIME());"
            );
            $stmt->bind_param("si", $amministratore, $anime);
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            die($e);
            return false;
        }
    }
}




?>