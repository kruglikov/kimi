<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of portal_text

 *

 * @author David

 */
class Portal_Text {

    public static function load_text($lang) {

        $query = "SELECT * FROM portaltext WHERE sprache = '$lang'";

        $line = App::$CURRENT->DB->singleObjectQuery($query);



        if (!isset($line)) {

            $line = App::$CURRENT->DB->singleObjectQuery("SELECT * FROM portaltext LIMIT 0, 1");
        }



        return $line->text;
    }

}
?>

