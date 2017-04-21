<?php

namespace App\View\Helper;

use Cake\View\Helper;

class AssetHelper extends Helper
{
    private $json = null;

    public function path($file)
    {
        $parts = explode('.', $file);

        if ($this->isLocal()) {
            if ($parts[1] === 'css') {
                return null;
            }
            return 'http://localhost:8080/' . $file;
        }

        if (!$this->json) {
            $this->json = json_decode(file_get_contents(WWW_ROOT . '/assets.json'), true);
        }

        return $this->json[$file];
    }

    private function isLocal()
    {
        return strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
    }

}
