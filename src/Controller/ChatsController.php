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

    public function getMessages() {
        $this->autoRender = false; 
        $this->loadModel('Generals'); // Load the Message model
        $messages = $this->Generals->find('all')->toArray();
        echo json_encode($messages);
    }

    public function addMessages() {
        $this->autoRender = false;
        
        $data = $this->request->getData();

        // Assuming 'category' in the AJAX request
        $category = isset($data['category']) ? $data['category'] : null;
        $newUserMessage = isset($data['newUserMessage']) ? $data['newUserMessage'] : null;

        if ($category === 'General Information') {
            $this->loadModel('Generals');
            $categoryData = $this->Generals->find()
                        ->where(['title LIKE' => '%' . $newUserMessage . '%'])
                        ->first();
            
        } elseif ($category === 'Symptom') {
            $this->loadModel('Symptoms');
            $categoryData = $this->Symptoms->find()
                        ->where(['name LIKE' => '%' . $newUserMessage . '%'])
                        ->first();

        } elseif ($category === 'Treatment') {
            $this->loadModel('Treatments');
            $categoryData = $this->Treatments->find()
                        ->where(['name LIKE' => '%' . $newUserMessage . '%'])
                        ->first();
        } 
        echo json_encode(['chatbotMessage' => $categoryData]);
        
    }

}
