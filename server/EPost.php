<?php

/**
 * Description of Post
 *
 * @author natalem_info
 */
class EPost {

    public $nomMedia;
    public $commentaire;
    public $typeMedia;
    public $datePosted;

    public function IsImage($index = 0) {
        return (strpos($this->typeMedia[$index], 'image') !== false);
    }

    public function IsVideo($index = 0) {
        return (strpos($this->typeMedia[$index], 'video') !== false);
    }

}
