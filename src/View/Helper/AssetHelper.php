<?php

namespace App\View\Helper;

use Cake\View\Helper;

class AssetHelper extends Helper
{
    private $json = null;

    /**
     * Retourne le chemin l'asset correspondant (cache busting)
     * @param $file - Lien vers l'asset
     * @return string - Lien vers l'asset versionné
     */
    public function path($file)
    {
        if (!$this->json) {
            $this->json = json_decode(file_get_contents(WWW_ROOT . '/assets.json'), true);
        }

        return ($this->isLocal()) ? 'http://localhost:8080/webroot' . $this->json[$file] : $this->json[$file];
    }

    /**
     * Indique s'il s'agit d'un environnement de développement (lié à webpack)
     * @return bool
     */
    private function isLocal()
    {
        return file_exists(WWW_ROOT . 'hot');
    }

}
