<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Chats Controller
 *
 * @method \App\Model\Entity\Chat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $chats = $this->loadModel('Users');
        $this->set(compact('chats'));
    }

}
