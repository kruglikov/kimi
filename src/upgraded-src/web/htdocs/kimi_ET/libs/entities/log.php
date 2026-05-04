<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of log
 *
 * @author David
 */
class Log {
    private $item;
    
    public function __construct($item) {
        $this->item = $item;
    }
    
    public function get_id() {
        return $this->item["id"];
    }
    
    public function get_objekt($sql_valid = FALSE) {
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["objekt"]) . "'";
        }
        else {
            return $this->item["objekt"];
        }
    }
    public function set_objekt($objekt_typ) {
        $this->item["objekt"] = $objekt_typ;
    }
    
    public function get_objekt_id() {
        return $this->item["objekt_id"];
    }
    public function set_objekt_id($id) {
        $this->item["objekt_id"] = $id;
    }
    
    public function get_logart($sql_valid = FALSE) {
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["logart"]) . "'";
        }
        return $this->item["logart"];
    }
    public function set_logart($logart) {
        $this->item["logart"] = $logart;
    }
    
    public function get_benutzer($sql_valid = FALSE) {
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["benutzer"]) . "'";
        }
        return $this->item["benutzer"];
    }
    public function set_benutzer($user) {
        $this->item["benutzer"] = $user;
    }
    
    public function get_timestamp($sql_valid = FALSE) {
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["timestamp"]) . "'";
        }
        return $this->item["timestamp"];
    }
    public function set_timestamp($time) {
        $this->item["timestamp"] = $time;
    }
    
    public static function insert($log) {
        $query = "INSERT INTO `log`( 
            `objekt`, 
            `objekt_id`, 
            `logart`,
            `timestamp`,
            `benutzer`)
            VALUES (" . $log->get_objekt(TRUE) . ", "
                . $log->get_objekt_id() . ", "
                . $log->get_logart(TRUE) . ", "
                . $log->get_timestamp(TRUE) . ", "
                . $log->get_benutzer(TRUE) . ")";
        
        try {
            $con = new DBConnection();
            $con->set_auto_commit();
            $con->set_query($query);
            $con->execute();
            $con->close();
			// 20160710/Roni
			return TRUE;
        }
        catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
            
            if (isset($con)) {
                $con->rollback();
                $con->close();
            }
			// 20160710/Roni
			return FALSE;
        }
    }
}
