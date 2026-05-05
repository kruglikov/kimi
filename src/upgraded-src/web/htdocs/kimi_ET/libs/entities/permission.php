<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Permission
 *
 * @author David
 */
class Permission {
    private $item;
    public function get_id() {
        return $this->item->id;
    }

    public function get_seitenname() {
        return $this->item->seitenname;
    }

    public function get_berechtigung() {
        return $this->item->berechtigung;
    }

    public function __construct($item) {
        $this->item = $item;
    }

    public static function get_permissions($rolle_id, $sitename, $permission) {
        $query = "SELECT b.* FROM berechtigung b WHERE id in (SELECT berechtigung_id FROM `rolle_berechtigung` 
            WHERE rolle_id = $rolle_id) AND b.seitenname = '$sitename'";

        if ($permission != "*") {
            $query .= " AND (b.berechtigung = '$permission' OR b.berechtigung = 'ALL')";
        }
        $response = App::$CURRENT->DB->query($query);

        if ($response == null || !isset($response) || !$response) {
            return null;
        }

        $permissions = array();
        foreach ($response as $value) {
            array_push($permissions, new Permission($value));
        }
        return $permissions;
    }
}
