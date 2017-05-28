<?php
namespace App\Controller\Admin;

use App\Controller\AppController as BaseController;
use Cake\Cache\Cache;
use Cake\Event\Event;

/**
 * App Controller
 *
 * @property \App\Model\Table\AppTable $App
 *
 * @method \App\Model\Entity\App[] paginate($object = null, array $settings = [])
 */
class AppController extends BaseController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->deny();
        $this->authorize(2);
    }

    public function cache () {
        $this->request->allowMethod('DELETE');
        $this->authorize(3);

        Cache::clear(false);

        $this->Flash->success(__("Cache vidé avec succès !"));
        return $this->redirect($this->referer());
    }

}
