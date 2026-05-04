<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kundenhistorie
 *
 * @author Roni
 */
class Kundenhistorie {

    private $item;

    public function __construct($item) {
        $this->item = (array) $item;
        $this->add_informations($item);
    }

    public function add_informations($informations) {
        foreach ($informations as $key => $value) {
            $name = "set_" . $key;

            if (method_exists($this, $name)) {
                $this->$name($value);
            }
        }
    }

    public function get_id() {
        return $this->item["id"];
    }

    public function set_id($val) {
        $this->item["id"] = $val;
    }

    public function get_mandant_id($sql_valid = FALSE) {
        if (!isset($this->item["mandant_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["mandant_id"];
    }

    public function set_mandant_id($val) {
        $this->item["mandant_id"] = $val;
    }

    public function get_kunde_id($sql_valid = FALSE) {
        if (!isset($this->item["kdnr_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        return $this->item["kdnr_id"];
    }

    public function set_kunde_id($val) {
        $this->item["kdnr_id"] = $val;
    }

    public function get_benutzer_id1($sql_valid = FALSE) {
        if (!isset($this->item["benutzer_id1"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["benutzer_id1"];
    }

    public function set_benutzer_id1($val) {
        $this->item["benutzer_id1"] = $val;
    }

    public function get_benutzer_id2($sql_valid = FALSE) {
        if (!isset($this->item["benutzer_id2"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["benutzer_id2"];
    }

    public function set_benutzer_id2($val) {
        $this->item["benutzer_id2"] = $val;
    }

    public function get_text($sql_valid = FALSE) {
        if (!isset($this->item["text"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["text"]) . "'";
        }
        return $this->item["text"];
    }

    public function set_text($val) {
        $this->item["text"] = $val;
    }
    
    public function get_kategorie_id($sql_valid = FALSE) {
        if (!isset($this->item["kategorie_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["kategorie_id"];
    }

    public function set_kategorie_id($val) {
        $this->item["kategorie_id"] = $val;
    }
    
    public function get_anstoss_id($sql_valid = FALSE) {
        if (!isset($this->item["anstoss_id"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }
        return $this->item["anstoss_id"];
    }

    public function set_anstoss_id($val) {
        $this->item["anstoss_id"] = $val;
    }
    
    public function get_geaendert_am($sql_valid = FALSE) {
        if (!isset($this->item["geaendert_am"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["geaendert_am"]) . "'";
        }

        $date = date_create($this->item["geaendert_am"]);
        return date_format($date, "Y-m-d H:i:s");
    }
    

    public function get_benutzer_devis($sql_valid = FALSE) {
        if (!isset($this->item["benutzer_devis"])) {
            if ($sql_valid) {
                return "NULL";
            }
            return NULL;
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["benutzer_devis"]) . "'";
        }
        return $this->item["benutzer_devis"];
    }

    public function set_benutzer_devis($val) {
        $this->item["benutzer_devis"] = $val;
    }
    

    public function get_benutzer1_name($sql_valid = FALSE) {
        return $this->item["benutzer1_name"];
    }

    public function get_benutzer2_name($sql_valid = FALSE) {
        return $this->item["benutzer2_name"];
    }

    public function get_anstoss_text($sql_valid = FALSE) {
        return $this->item["anstoss_text"];
    }

    public function get_kategorie_text($sql_valid = FALSE) {
        return $this->item["kategorie_text"];
    }
    
    
    public static function count($mandant_id, $kdnr) {

        $query = "SELECT COUNT(kh.id) as 'count' FROM kundenhistorie kh
                JOIN kunde k ON k.id = kh.kdnr_id
                JOIN stammdaten sd ON sd.kunde_id = k.id
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";
        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($mandant_id, $kdnr, $start, $count, $order = "kh.geaendert_am DESC, kh.id DESC ") {

        $query = "SELECT kh.*, a.text as 'anstoss_text', kg.text as 'kategorie_text', ben1.name as 'benutzer1_name', ben2.name as 'benutzer2_name'
                FROM kundenhistorie kh
                JOIN kunde k ON k.id = kh.kdnr_id 
		JOIN stammdaten sd ON sd.kunde_id = k.id
                LEFT JOIN anstoss a on a.id = kh.anstoss_id
                LEFT JOIN kategorie kg on kg.id = kh.kategorie_id
                LEFT JOIN benutzer ben1 on ben1.id = kh.benutzer_id1
                LEFT JOIN benutzer ben2 on ben2.id = kh.benutzer_id2
                WHERE sd.mandant_id = $mandant_id AND k.kdnr = '$kdnr'";
        $query .= " ORDER BY $order LIMIT $start, $count";
        try {
            $items = App::$CURRENT->DB->query($query);
            $kundenhistorie = array();
            foreach ($items as $value) {
                array_push($kundenhistorie, new Kundenhistorie($value));
            }

            if (count($kundenhistorie) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $kundenhistorie;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT kh.*, a.text as 'anstoss_text', kg.text as 'kategorie_text'
                FROM kundenhistorie kh
                LEFT JOIN anstoss a on a.id = kh.anstoss_id
                LEFT JOIN kategorie kg on kg.id = kh.kategorie_id
            WHERE kh.id = $id";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($kundenhistorie) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `kundenhistorie`( 
            `mandant_id`, 
            `kdnr_id`, 
            `benutzer_id1`,
            `text`,
            `kategorie_id`,
            `anstoss_id`,
            `geaendert_am`,
            `benutzer_id2`,
            `benutzer_devis`) 

            VALUES (" . $kundenhistorie->get_mandant_id(TRUE) . ",
                " . $kundenhistorie->get_kunde_id(TRUE) . ",
                " . $kundenhistorie->get_benutzer_id1(TRUE) . ",
                " . $kundenhistorie->get_text(TRUE) . ",
                " . $kundenhistorie->get_kategorie_id(TRUE) . ",
                " . $kundenhistorie->get_anstoss_id(TRUE) . ",
                '" . date("Y-m-d H:i:s") . "',
                " . $kundenhistorie->get_benutzer_id2(TRUE) . ",
                " .$kundenhistorie->get_benutzer_devis(TRUE) . ")";

        try {
            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            App::$CURRENT->DB->manualClose($con);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            App::$CURRENT->DB->rollback($con);
            App::$CURRENT->DB->manualClose($con);
        }
    }
}

?>
