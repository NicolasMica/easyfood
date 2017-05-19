<?php

namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;

class UploadableBehavior extends Behavior
{

    protected $_defaultConfig = [
        "field" => "image",
        "name" => "id",
        "ext" => ['jpg', 'jpeg', 'gif', 'png', 'svg', 'bmp'],
        "maxSize" => 30,
        "saveDest" => WWW_ROOT . "uploads" . DS
    ];

    public function upload(Entity $entity){
        $config = $this->getConfig();
        $field = $entity->get($config['field']);

        if ($field !== null) {

            $parts = explode('.', $field['name']);
            $filename = isset($config['fileName']) ? $config['fileName'] : $entity->get($config['name']);
            $filename .= '.' . end($parts);

            $file = new File($config['saveDest'] . $filename);

            if(in_array($file->ext(), $config['ext'])) {
                if(($field['size'] / 1000000) <= $config['maxSize']){
                    if($file->Folder->create($file->Folder->path)) {
                        move_uploaded_file($field['tmp_name'], $file->path);
                    }
                }
            }
        }
    }

    public function remove(Entity $entity){
        $config = $this->getConfig();
        $field = $entity->get($config['name']);
        $folder = new Folder($config['saveDest']);
        $ext = join('|', $config['ext']);

        $files = $folder->find($field . '\.(' . $ext . ')');

        if($files){
            $file = new File($folder->path . $files[0]);
            $file->delete();
        }
    }

    public function afterSave(Event $event, Entity $entity, $options)
    {
        $this->upload($entity);
    }

    public function beforeDelete(Event $event, Entity $entity, $options){
        $this->remove($entity);
    }

}
