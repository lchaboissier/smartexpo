<?php

namespace App\Models;

use CodeIgniter\Model;

class Db_model extends Model
{
    protected $db;
    public function __construct() // Constructeur
    {
        $this->db = db_connect(); //charger la base de données
        // ou
        // $this->db = \Config\Database::connect();
    }

    public function get_all_compte() // Affiche la liste des comptes
    {
        $resultat = $this->db->query("SELECT cpt_email, cpt_statut, cpt_image 
        FROM t_compte_cpt 
        ORDER BY cpt_statut ASC;");
        return $resultat->getResultArray(); // Retourne les résultats de la table t_compte_cpt
    }

    public function get_count_all_compte() // Affiche le nombre total de comptes
    {
        $resultat = $this->db->query("SELECT COUNT(*) AS nbTotalComptes FROM t_compte_cpt;"); // /!\ Définir un ALIAS pour l'appeler correctement sur la vue !
        return $resultat->getRow()->nbTotalComptes; // Retourne le nombre total de comptes
    }

    public function set_compte($cpt_email, $cpt_motdepasse, $cpt_image)
    {
        $sql = "INSERT INTO t_compte_cpt (cpt_email, cpt_motdepasse, cpt_dateCreation, cpt_statut, cpt_image) 
            VALUES (?, SHA2(?, 512), CURDATE(), 'A', ?)";

        $sql2 = "INSERT INTO t_profil_pro (pro_code, pro_nom, pro_prenom, pro_numTel, pro_statut, pro_validite, pro_image, cpt_email) VALUES (NULL, NULL, NULL, NULL, 'G', 'A', ?, ?)";

        return $this->db->query($sql, [$cpt_email, $cpt_motdepasse, $cpt_image]) && $this->db->query($sql2, [$cpt_image, $cpt_email]);
    }

    public function connect_compte($cpt_email, $cpt_motdepasse)
    {
        $sql = "SELECT c.cpt_email, c.cpt_motdepasse, p.pro_image
            FROM t_compte_cpt AS c
            JOIN t_profil_pro AS p ON p.cpt_email = c.cpt_email
            WHERE c.cpt_email='" . $cpt_email . "' AND c.cpt_motdepasse=SHA2('" . $cpt_motdepasse . "', 512);";
        $resultat = $this->db->query($sql);
        if ($resultat->getNumRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_profil_statut($cpt_email) {
        $sql = "SELECT c.cpt_email, p.pro_statut
        FROM t_compte_cpt AS c
        JOIN t_profil_pro AS p ON p.cpt_email = c.cpt_email
        WHERE c.cpt_email='" . $cpt_email . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    public function get_profil($cpt_email) // Afficher un profil
    {
        $requete = "SELECT pro_nom, pro_prenom, pro_numTel, pro_statut, pro_validite, pro_image, cpt_email FROM t_profil_pro WHERE cpt_email='" . $cpt_email . "';";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne d'une actualité
    }

    public function get_all_actualite() // Affiche la liste des actualites
    {
        $resultat = $this->db->query("SELECT act_num, act_titre, act_texte, act_date, act_statut, cpt_email FROM t_actualite_act ORDER BY act_date DESC;");
        return $resultat->getResultArray(); // Retourne les résultats de la table t_actualite_act
    }

    public function get_actualite($numero) // Afficher une actualité
    {
        $requete = "SELECT * FROM t_actualite_act WHERE act_num=" . $numero . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne d'une actualité
    }

    public function set_actualite($saisie)
    {
        $titre = addslashes($saisie['act_titre']);
        $texte = addslashes($saisie['act_texte']);
        $statut = $saisie['act_statut'];
        $sql = "INSERT INTO t_actualite_act VALUES (NULL, '$titre', '$texte', '$statut', CURDATE(), 'compte@mail.fr');";


        return $this->db->query($sql);
    }

    public function get_all_oeuvres() // Affiche la liste des oeuvres
    {
        $resultat = $this->db->query("SELECT o.oeu_num, o.oeu_intitule, o.oeu_dateCreation, o.oeu_description, o.oeu_code, o.oeu_image, GROUP_CONCAT(CONCAT(e.exp_prenom, ' ', e.exp_nom)) AS exposant, GROUP_CONCAT(e.exp_code) AS exp_code 
        FROM t_oeuvre_oeu AS o 
        JOIN t_presentation_pre AS p ON o.oeu_num = p.oeu_num 
        JOIN t_exposant_exp AS e ON e.exp_num = p.exp_num 
        GROUP BY o.oeu_num, o.oeu_intitule, o.oeu_dateCreation, o.oeu_description, o.oeu_code, o.oeu_image");
        return $resultat->getResultArray(); // Retourne les résultats de la table t_oeuvre_oeu
    }

    public function get_oeuvre($code) // Affiche une oeuvre
    {
        $requete = "SELECT o.oeu_intitule, o.oeu_dateCreation, o.oeu_description, o.oeu_image, GROUP_CONCAT(CONCAT(e.exp_prenom, ' ', e.exp_nom)) AS exposant, e.exp_code
            FROM t_oeuvre_oeu AS o
            JOIN t_presentation_pre AS p ON o.oeu_num = p.oeu_num
            JOIN t_exposant_exp AS e ON e.exp_num = p.exp_num
            WHERE o.oeu_code = " . "'" . $code . "'" . " ;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne d'une oeuvre
    }

    public function get_exposant($code) // Affiche un exposant
    {
        $requete = "SELECT exp_nom, exp_prenom, exp_texteBio, exp_siteWeb, exp_code, exp_image FROM t_exposant_exp
            WHERE exp_code = " . "'" . $code . "'" . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne d'un exposant
    }

    public function get_configuration() // Afficher la date de début et fin de l'exposition
    {
        $resultat = $this->db->query("SELECT cfg_intitule, cfg_presentation, cfg_lieu, cfg_dateDebut, cfg_dateFin FROM t_configuration_cfg;");
        return $resultat->getRow(); // Retourne une ligne des données de l'exposition
    }

    public function get_dateVernissage_configuration() // Afficher la date de verinissage de l'exposition
    {
        $resultat = $this->db->query("SELECT DATEDIFF(cfg_dateVernissage, CURDATE()) AS JoursAvantVernissage FROM `t_configuration_cfg` ORDER BY cfg_intitule DESC LIMIT 1;");
        return $resultat->getRow()->JoursAvantVernissage; // Retourne une ligne de la date de vernissage de l'exposition
    }

    public function get_all_commentaire() // Afficher tous les commentaires du livre d'or de l'exposition
    {
        $resultat = $this->db->query("SELECT vst_prenom, vst_nom, vst_email, com_datePublication, com_heurePublication, com_texte, com_statut FROM `t_visiteur_vst` AS v JOIN t_commentaire_com AS c ON c.vst_visiteur = v.vst_num");
        return $resultat->getResultArray(); // Retourne la liste des commentaires du livre d'or
    }
}
