<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of menu_item

 *

 * @author David

 */
class MenuItem {

    private $text;
    private $link;

    public function get_text() {

        return $this->text;
    }

    public function get_link() {

        return "index.php?site=" . $this->link;
    }

    public function get_site() {

        return $this->link;
    }

    public function __construct($text, $link, $params = "") {

        $this->text = $text;

        if ($params != "") {

            $this->link = $link . "&$params";
        } else {

            $this->link = $link;
        }
    }

}

class ExternMenuItem {

    private $text;
    private $link;

    public function get_text() {

        return $this->text;
    }

    public function get_link() {

        return $this->link;
    }

    public function get_site() {

        return "portal";
    }

    public function __construct($text, $link) {

        $this->text = $text;

        $this->link = $link;
    }

}
