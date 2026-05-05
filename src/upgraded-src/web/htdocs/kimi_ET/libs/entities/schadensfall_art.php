<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schadensfall_art
 *
 * @author Ronald
 */
class SchadensfallArt {

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

    public function get_text($sql_valid = FALSE) {
        if (!isset($this->item["text"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["text"]) . "'";
        }
        return $this->item["text"];
    }
    public function set_text($val) { 
        $this->item["text"] = $val;
    }

    public static function load_all() {

        $query = "SELECT * FROM schadensfall_art ORDER BY text";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new SchadensfallArt($item));
        }
        return $result;
    }

    public static function count() {

        $query = "SELECT COUNT(id) as 'count' FROM schadensfall_art";

        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($start, $count, $order = "id ") {

        $query = "SELECT * FROM schadensfall_art ";

        $query .= " ORDER BY $order LIMIT $start, $count";

        try {
            $items = App::$CURRENT->DB->query($query);
            $schadensfall_art = array();
            foreach ($items as $value) {
                array_push($schadensfall_art, new SchadensfallArt($value));
            }

            if (count($schadensfall_art) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $schadensfall_art;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT *
            FROM schadensfall_art
            WHERE id = $id";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($schadensfall_art) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `schadensfall_art`( 
            `text`, 
            `geaendert_am`,
            `geaendert_von`) 

            VALUES (" . $schadensfall_art->get_text(TRUE) . ",
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
    
    public static function update($schadensfall_art, $id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "UPDATE `schadensfall_art` SET
                text = " . $schadensfall_art->text. ",
                geaendert_von = '" . App::$CURRENT->USER->get_name() . "',
                geaendert_am = '" . date("Y-m-d H:i:s") . "'
            WHERE id = " . $id;
        try {
            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            App::$CURRENT->DB->manualClose($con);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
    public static function delete($id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "DELETE FROM `schadensfall_art` 
            WHERE id = " . $id;
        try {
            App::$CURRENT->DB->manualQuery($query, $con, FALSE);
            App::$CURRENT->DB->commit($con);
            App::$CURRENT->DB->manualClose($con);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }
}

