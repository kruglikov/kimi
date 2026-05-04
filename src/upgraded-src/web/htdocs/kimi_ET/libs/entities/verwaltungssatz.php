<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Verwaltungssatz
 *
 * @author Aberl
 */
class Verwaltungssatz {

    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_mandant_id() {
        return $this->item->mandant_id;
    }

    public function set_mandant_id($val, $sql_valid = FALSE) {
        $this->item["mandant_id"] = $val;
    }

    public function get_markt() {
        return $this->item->markt;
    }

    public function set_markt($val, $sql_valid = FALSE) {
        $this->item["markt"] = $val;
    }
    
    public function get_kz_aktuell() {
        return $this->item->kz_aktuell;
    }

    public function set_kz_aktuell($val, $sql_valid = FALSE) {
        $this->item["kz_aktuell"] = $val;
    }
    
    public function get_saldo_gesamt($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["saldo_gesamt"], 2, ".", "");
        }

        return number_format((float) $this->item["saldo_gesamt"], 2, ",", ".");
    }

    public function set_saldo_gesamt($val, $sql_valid = FALSE) {
        //$val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        $this->item["saldo_gesamt"] = $val;
    }    
     
    public function get_saldo_tag($sql_valid = FALSE) {
        if ($sql_valid) {
            return number_format((float) $this->item["saldo_tag"], 2, ".", "");
        }

        return number_format((float) $this->item["saldo_tag"], 2, ",", ".");
    }

    public function set_saldo_tag($val, $sql_valid = FALSE) {
        //$val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        $this->item["saldo_tag"] = $val;
    }    

    public function get_buchungsdatum($sql_valid = FALSE) {

        $date = date_create($this->item->buchungsdatum);
        return date_format($date, "d.m.Y");
    }

   
    public function set_buchungsdatum($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["buchungsdatum"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["buchungsdatum"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    
    
    public function get_stichtag1($sql_valid = FALSE) {
        if (!isset($this->item["stichtag1"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["stichtag1"]) . "'";
        }

        $date = date_create($this->item["stichtag1"]);
        return date_format($date, "d.m.Y");
    }

    public function set_stichtag1($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["stichtag1"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["stichtag1"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    
    public function get_stichtag2($sql_valid = FALSE) {
        if (!isset($this->item["stichtag2"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["stichtag2"]) . "'";
        }

        $date = date_create($this->item["stichtag2"]);
        return date_format($date, "d.m.Y");
    }

    public function set_stichtag2($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["stichtag2"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["stichtag2"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    
    public function get_stichtag3($sql_valid = FALSE) {
        if (!isset($this->item["stichtag3"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["stichtag3"]) . "'";
        }

        $date = date_create($this->item["stichtag3"]);
        return date_format($date, "d.m.Y");
    }

    public function set_stichtag3($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["stichtag3"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["stichtag3"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    
    public function get_stichtag4($sql_valid = FALSE) {
        if (!isset($this->item["stichtag4"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["stichtag4"]) . "'";
        }

        $date = date_create($this->item["stichtag4"]);
        return date_format($date, "d.m.Y");
    }

    public function set_stichtag4($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["stichtag4"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["stichtag4"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    
    public function get_stichtag5($sql_valid = FALSE) {
        if (!isset($this->item["stichtag5"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }

        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["stichtag5"]) . "'";
        }

        $date = date_create($this->item["stichtag5"]);
        return date_format($date, "d.m.Y");
    }

    public function set_stichtag5($val, $sql_valid = FALSE) { {
            if (strlen($val) == 0) {
                $this->item["stichtag5"] = NULL;
                return;
            }

            $date = date_create($val);
            $this->item["stichtag5"] = date_format($date, "Y-m-d H:i:s");
        }
    }
    
    public function __construct($item) {
        $this->item = $item;
    }

    public static function get_aktuell2($mandant_id, $markt) {

        $query = "SELECT * FROM verwaltungssatz"
                . " WHERE mandant_id = $mandant_id AND markt = $markt"
                . " AND kz_aktuell = 'J'"
                ." ORDER BY buchungsdatum desc";
        try {    
        $result = App::$CURRENT->DB->query($query);
        $verwaltungssatz= array();
            
            foreach ($result as $item) {
                array_push($verwaltungssatz, new Verwaltungssatz($item));
            }
            if (count($verwaltungssatz) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $verwaltungssatz;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }

        
        /*
        try {
            return new Verwaltungssatz(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }*/
        
    }
    
    
  public static function get_aktuell($mandant_id, $markt) {

        $query = "SELECT * FROM verwaltungssatz"
                . " WHERE mandant_id = $mandant_id AND markt = $markt"
                . " AND kz_aktuell = 'J'"
                ." ORDER BY buchungsdatum desc";
        try {
            return new Verwaltungssatz(App::$CURRENT->DB->singleObjectQuery($query));
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    
    public static function insert($verwaltungssatz) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `verwaltungssatz`( 
            `mandant_id`, 
            `markt`, 
            `kz_aktuell`, 
            `buchungsdatum`, 
            `saldo_gesamt`, 
            `saldo_tag`, 
            `stichtag1`, 
            `stichtag2`, 
            `stichtag3`, 
            `stichtag4`, 
            `stichtag5`, 
            `geaendert_am`, 
            `geaendert_von`) 

            VALUES (" . $subkonto->get_mandant_id() . ",
                " . $subkonto->get_markt(TRUE) . ",
                " . $subkonto->get_kz_aktuell() . ",
                " . $subkonto->get_buchungsdatum(TRUE) . ",
                " . $subkonto->get_saldo_gesamt(TRUE) . ",
                " . $subkonto->get_saldo_tag(TRUE) . ",
                " . $subkonto->get_stichtag1(TRUE) . ",
                " . $subkonto->get_stichtag2(TRUE) . ",
                " . $subkonto->get_stichtag3(TRUE) . ",
                " . $subkonto->get_stichtag4(TRUE) . ",
                " . $subkonto->get_stichtag5(TRUE) . ",
                    '" . date("Y-m-d H:i:s") . "',
                '" . App::$CURRENT->USER->get_name() . "')";
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

