<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of status_schadensfall
 *
 * @author Ronald
 */
class StatusSchadensfall {

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
    
    public function get_kurz_text($sql_valid = FALSE) {
        if (!isset($this->item["kurz_text"])) {
            if ($sql_valid) {
                return "NULL";
            } else {
                return NULL;
            }
        }
        if ($sql_valid) {
            return "'" . App::$CURRENT->DB->escape_string($this->item["kurz_text"]) . "'";
        }
        return $this->item["kurz_text"];
    }
    public function set_kurz_text($val) { 
        $this->item["kurz_text"] = $val;
    }

    public static function load_all() {

        $query = "SELECT * FROM status_schadensfall ORDER BY text";
        $result = array();
        $response = App::$CURRENT->DB->query($query);

        foreach ($response as $item) {
            array_push($result, new StatusSchadensfall($item));
        }
        return $result;
    }

    public static function count() {

        $query = "SELECT COUNT(id) as 'count' FROM status_schadensfall";

        return App::$CURRENT->DB->singleObjectQuery($query)->count;
    }

    public static function load_items($start, $count, $order = "id ") {

        $query = "SELECT * FROM status_schadensfall ";

        $query .= " ORDER BY $order LIMIT $start, $count";

        try {
            $items = App::$CURRENT->DB->query($query);
            $statusschadensfall = array();
            foreach ($items as $value) {
                array_push($statusschadensfall, new StatusSchadensfall($value));
            }

            if (count($statusschadensfall) == 0) {
                App::$CURRENT->add_information(MSG_NO_RESULTS);
            }
            return $statusschadensfall;
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function get($id) {

        $query = "SELECT *
            FROM status_schadensfall
            WHERE id = $id";
        try {
            return App::$CURRENT->DB->singleObjectQuery($query);
        } catch (Exception $e) {
            App::$CURRENT->add_error($e->getMessage());
        }
    }

    public static function insert($statusschadensfall) {
        $con = App::$CURRENT->DB->manualOpen();

        $query = "INSERT INTO `status_schadensfall`( 
            `kurz_text`, 
            `text`, 
            `geaendert_am`,
            `geaendert_von`) 

            VALUES (" . $statusschadensfall->get_kurz_text(TRUE) . ",
                " . $statusschadensfall->get_text(TRUE) . ",
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
    
    public static function update($statusschadensfall, $id) {
        $con = App::$CURRENT->DB->manualOpen();
        $query = "UPDATE `status_schadensfall` SET
                kurz_text = " . $statusschadensfall->kurz_text. ",
                text = " . $statusschadensfall->text. ",
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
        $query = "DELETE FROM `status_schadensfall` 
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

?>