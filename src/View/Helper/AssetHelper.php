<?php

namespace App\View\Helper;

use Cake\View\Helper;

class AssetHelper extends Helper
{
    private $json = null;

    public function path($file)
    {
        if (!$this->json) {
            $this->json = json_decode(file_get_contents(WWW_ROOT . '/assets.json'), true);
        }

        return ($this->isLocal()) ? 'http://localhost:8080/webroot' . $this->json[$file] : $this->json[$file];
    }

    private function isLocal()
    {
        return file_exists(WWW_ROOT . 'hot');
    }

}
