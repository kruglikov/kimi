<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author David
 */
class DB {

    private $last_identifier;
    private static $USERNAME = CONF_MYSQL_USER;
    private static $PASSWORT = CONF_MYSQL_PASSWORD;
    private static $HOST = CONF_MYSQL_SERVER;
    private static $DB_NAME = CONF_MYSQL_DB;

    public function query_insert_return_id($query) {
        $identifier = mysqli_connect(self::$HOST, self::$USERNAME, self::$PASSWORT) or die(mysqli_error());
        mysqli_select_db($identifier, self::$DB_NAME) or throw_exception("$query<br />" . mysqli_error($identifier));
        mysqli_set_charset($identifier, "utf8");

        mysqli_query($identifier, $query) or throw_exception("$query<br />" . mysqli_error($identifier));

        $id = mysqli_insert_id($identifier);
        mysqli_close($identifier);

        return $id;
    }

    public function query($query, $fetch = TRUE) {
        $results = array();
        $identifier = mysqli_connect(self::$HOST, self::$USERNAME, self::$PASSWORT) or die(mysqli_error());

        mysqli_select_db($identifier, self::$DB_NAME) or throw_exception("$query<br />" . mysqli_error($identifier));
        mysqli_set_charset($identifier, "utf8");
        $dbres = mysqli_query($identifier, $query) or throw_exception("$query<br />" . mysqli_error($identifier));

        if ($dbres != false && $fetch) {
            while ($row = mysqli_fetch_object($dbres)) {
                array_push($results, $row);
            }
        }

        mysqli_close($identifier);

        return $results;
    }

    public function singleObjectQuery($query) {
        $results = $this->query($query);

        if (count($results) != 1) {
            return;
        }
        return $results[0];
    }

    public function manualOpen() {
        $identifier = mysqli_connect(self::$HOST, self::$USERNAME, self::$PASSWORT) or throw_exception(mysqli_error($identifier));
        mysqli_select_db($identifier, self::$DB_NAME) or throw_exception("$query<br />" . mysqli_error($identifier));
        mysqli_set_charset($identifier, "utf8");
        mysqli_query($identifier, "START TRANSACTION") or throw_exception(mysqli_error($identifier));

        $this->last_identifier = $identifier;

        return $identifier;
    }

    public function manualClose($identifier) {
        if ($this->last_identifier == $identifier) {
            unset($this->last_identifier);
        }

        mysqli_close($identifier) or throw_exception(mysqli_error($identifier));
    }

    public function manualQuery($query, $identifier, $fetch = TRUE) {
        $resource = mysqli_query($identifier, $query) or throw_exception("$query<br />" . mysqli_error($identifier));

        if (!$fetch) {
            return;
        }

        $result = array();

        while ($item = mysqli_fetch_object($resource)) {
            array_push($result, $item);
        }

        return $result;
    }

    public function manualQueryReturningId($query, $identifier) {
        mysqli_query($identifier, $query) or throw_exception("$query<br />" . mysqli_error($identifier));
        $id = mysqli_insert_id($identifier);

        return $id;
    }

    public function commit($identifier) {
        mysqli_query($identifier, "COMMIT") or throw_exception(mysqli_error($identifier));
    }

    public function rollback($identifier) {
        mysqli_query($identifier, "ROLLBACK") or throw_exception(mysqli_error($identifier));
    }

    public function escape_string($string, $identifier = NULL) {
        if (!isset($identifier)) {
            $identifier = $this->last_identifier;
        }

        if (isset($identifier)) {
            return mysqli_real_escape_string($identifier, $string);
        } else {
            return $string;
        }
    }

    public function get_generated_id($identifier) {
        return mysqli_insert_id($identifier);
    }

}

class DBConnection {

    private $identifier;
    private $query;
    private $auto_commit = FALSE;

    public function set_auto_commit($value = TRUE) {
        $this->auto_commit = $value;
    }

    public function set_query($query) {
        $this->query = $query;
    }

    public function execute() {
        App::$CURRENT->DB->manualQuery($this->query, $this->identifier, FALSE);

        if ($this->auto_commit) {
            $this->commit();
        }
    }

    public function query() {
        $val = App::$CURRENT->DB->manualQuery($this->query, $this->identifier, TRUE);
        if ($this->auto_commit) {
            $this->commit();
        }
        return $val;
    }

    public function get_generated_id() {
        return App::$CURRENT->DB->get_generated_id($this->identifier);
    }

    public function rollback() {
        App::$CURRENT->DB->rollback($this->identifier);
    }

    public function commit() {
        App::$CURRENT->DB->commit($this->identifier);
    }

    public function __construct() {
        $this->identifier = App::$CURRENT->DB->manualOpen();
    }

    public function close() {
        App::$CURRENT->DB->manualClose($this->identifier);
    }

}

?>
