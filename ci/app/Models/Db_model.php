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
        $resultat = $this->db->query("SELECT p.pro_code, c.cpt_email, p.pro_statut, p.pro_image, p.pro_validite
        FROM t_compte_cpt AS c
        JOIN t_profil_pro AS p ON p.cpt_email = c.cpt_email
        ORDER BY p.pro_statut ASC;");
        return $resultat->getResultArray(); // Retourne les résultats de la table t_compte_cpt
    }

    public function get_compte($cpt_email) // Affiche le compte
    {
        $resultat = $this->db->query("SELECT cpt_email, cpt_motdepasse FROM t_compte_cpt WHERE cpt_email = '" . $cpt_email . "';");
        return $resultat->getRow(); // Retourne le compte
    }

    public function set_compte($cpt_email, $cpt_motdepasse, $pro_image) // Crée un compte dont un profil qui lui est associé
    {
        $sql = "INSERT INTO t_compte_cpt (cpt_email, cpt_motdepasse, cpt_dateCreation) VALUES (?, SHA2(?, 512), CURDATE())";

        $sql2 = "INSERT INTO t_profil_pro VALUES (NULL, NULL, NULL, NULL, 'N', 'D', ?, ?)";

        return $this->db->query($sql, [$cpt_email, $cpt_motdepasse]) && $this->db->query($sql2, [$pro_image, $cpt_email]);
    }


    public function update_statut_compte($pro_statut, $cpt_email) // Met à jour le statut du compte
    {
        $sql = "UPDATE t_profil_pro SET pro_statut = ? WHERE cpt_email = ?";

        return $this->db->query($sql, [$pro_statut, $cpt_email]);
    }

    public function connect_compte($cpt_email, $cpt_motdepasse) // Connexion du compte au BackOffice
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

    public function get_all_profils() // Affiche la liste des profils
    {
        $resultat = $this->db->query("SELECT p.pro_code, p.pro_nom, p.pro_prenom, pro_numTel, p.pro_statut, p.pro_validite, p.cpt_email
        FROM t_profil_pro AS p 
        ORDER BY p.pro_statut ASC;");
        return $resultat->getResultArray(); // Retourne les résultats de la table t_compte_cpt
    }

    public function get_count_all_profils() // Affiche le nombre total de profils
    {
        $resultat = $this->db->query("SELECT COUNT(*) AS nbTotalProfils FROM t_profil_pro;"); // /!\ Définir un ALIAS pour l'appeler correctement sur la vue !
        return $resultat->getRow()->nbTotalProfils; // Retourne le nombre total de profils
    }

    public function get_profil_statut($cpt_email) // Récupère le statut du profil
    {
        $sql = "SELECT c.cpt_email, p.pro_statut, p.pro_validite
        FROM t_compte_cpt AS c
        JOIN t_profil_pro AS p ON p.cpt_email = c.cpt_email
        WHERE c.cpt_email='" . $cpt_email . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    public function get_profil($cpt_email) // Afficher un profil
    {
        $requete = "SELECT pro_code, pro_nom, pro_prenom, pro_numTel, pro_statut, pro_validite, pro_image, cpt_email FROM t_profil_pro WHERE cpt_email='" . $cpt_email . "';";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne de profil
    }

    public function get_id_profil($id_profil) // Récupère l'id d'un profil
    {
        $requete = "SELECT * FROM t_profil_pro WHERE pro_code='" . $id_profil . "';";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne de profil
    }

    public function get_pro_code($pro_code) // Récupère l'id d'un profil
    {
        $requete = "SELECT pro_code, pro_nom, pro_prenom, pro_numTel, pro_statut, pro_validite, pro_image, cpt_email FROM t_profil_pro WHERE pro_code=?";
        $resultat = $this->db->query($requete, [$pro_code]);
        return $resultat->getRow();
    }

    public function update_statut_profil($pro_validite, $pro_code) // Met à jour le statut d'un profil
    {
        $sql = "UPDATE t_profil_pro SET pro_validite = ? WHERE pro_code = ?";

        return $this->db->query($sql, [$pro_validite, $pro_code]);
    }

    public function get_all_actualite() // Affiche la liste des actualités
    {
        $resultat = $this->db->query("SELECT act_num, act_titre, act_texte, act_date, act_statut, cpt_email FROM t_actualite_act ORDER BY act_date DESC;");
        return $resultat->getResultArray(); // Retourne les résultats de la table t_actualite_act
    }

    public function get_count_all_actualites() // Affiche le nombre total de profils
    {
        $resultat = $this->db->query("SELECT COUNT(*) AS nbTotalActus FROM t_actualite_act;"); // /!\ Définir un ALIAS pour l'appeler correctement sur la vue !
        return $resultat->getRow()->nbTotalActus; // Retourne le nombre total de profils
    }

    public function get_actualite($numero) // Afficher une actualité
    {
        $requete = "SELECT * FROM t_actualite_act WHERE act_num=" . $numero . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow(); // Retourne une ligne d'une actualité
    }

    public function set_actualite($saisie) // Crée une actualité
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

    public function get_configuration() // Afficher les informations de l'exposition
    {
        $resultat = $this->db->query("SELECT cfg_intitule, cfg_presentation, cfg_lieu, cfg_dateDebut, cfg_dateFin, cfg_dateVernissage FROM t_configuration_cfg;");
        return $resultat->getRow(); // Retourne une ligne des données de l'exposition
    }

    public function get_dateVernissage_configuration() // Afficher le nombre de jours de la date de verinissage de l'exposition
    {
        $resultat = $this->db->query("SELECT DATEDIFF(cfg_dateVernissage, CURDATE()) AS JoursAvantVernissage FROM `t_configuration_cfg` ORDER BY cfg_intitule DESC LIMIT 1;");
        return $resultat->getRow()->JoursAvantVernissage; // Retourne une ligne de la date de vernissage de l'exposition
    }

    public function get_count_all_tickets() // Récupère le nombre de tickets visiteur
    {
        $resultat = $this->db->query("SELECT COUNT(*) AS nbTotalTicketsVst FROM t_visiteur_vst;");
        return $resultat->getRow()->nbTotalTicketsVst;
    }

    public function get_visiteurs_commentaire() // Affiche la liste des ticket visiteurs avec un commentaire associé
    {
        $resultat = $this->db->query("SELECT v.vst_num, v.vst_nom, v.vst_prenom, v.vst_email, v.vst_dateVisite, v.vst_heureVisite, v.vst_lieuResidence, c.com_texte
        FROM t_visiteur_vst AS v
        LEFT JOIN t_commentaire_com AS c ON v.vst_num = c.vst_visiteur;");
        return $resultat->getResultArray();
    }

    public function delete_visiteur_commentaire($id_vst) // Supprime toutes les données d'un ticket visiteur et le commentaire associé
    {
        $requete1 = "DELETE FROM t_commentaire_com WHERE vst_visiteur = ?";
        $resultat1 = $this->db->query($requete1, [$id_vst]);

        $requete2 = "DELETE FROM t_visiteur_vst WHERE vst_num = ?";
        $resultat2 = $this->db->query($requete2, [$id_vst]);

        // Vérifie si des lignes ont été affectées dans les deux tables
        if ($resultat1 && $resultat2 && $this->db->affectedRows() > 0) {
            return true; // Retourne true si des lignes ont été affectées
        } else {
            return false; // Retourne false si aucune ligne n'a été affectée
        }
    }

    public function get_all_commentaire() // Afficher tous les commentaires du livre d'or de l'exposition
    {
        $resultat = $this->db->query("SELECT vst_prenom, vst_nom, vst_email, com_datePublication, com_heurePublication, com_texte, com_statut FROM `t_visiteur_vst` AS v JOIN t_commentaire_com AS c ON c.vst_visiteur = v.vst_num");
        return $resultat->getResultArray(); // Retourne la liste des commentaires du livre d'or
    }

    public function get_count_all_commentaires() // Affiche le nombre total de commentaires du livre d'or
    {
        $resultat = $this->db->query("SELECT COUNT(*) AS nbTotalCommentaires FROM t_visiteur_vst;");
        return $resultat->getRow()->nbTotalCommentaires;
    }
}
