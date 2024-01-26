<?php
declare(strict_types=1);

namespace App\Controller;
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';

use Statickidz\GoogleTranslate;
use LanguageDetection\Language;

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
        $user = $this->Authentication->getIdentity(); // Get the currently authenticated user
        $this->set(compact('user'));
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
        $newUserMessage = isset($data['content']) ? $data['content'] : null;

        $ld = new Language;
        $detectedLanguage = $ld->detect($newUserMessage)->bestResults()->close();

        if (isset($detectedLanguage['ja'])) {
            $trans = new GoogleTranslate();
            $japaneseMessage = $trans->translate('ja', 'en', $newUserMessage);
            $keywords = explode(' ', $japaneseMessage);
        }else{
            $keywords = explode(' ', $newUserMessage);
        }
        
        if ($category === 'General Information') {
            $this->loadModel('Generals');

            $conditions = [];
            foreach ($keywords as $keyword) {
                $conditions['OR'][] = ['Generals.title LIKE' => "%$keyword%"];
            }
            
            $categoryData = $this->Generals->find('all', [
                'conditions' => $conditions,
            ])->first();
            
        } elseif ($category === 'Symptom') {
            $this->loadModel('Symptoms');

            $conditions = [];
            foreach ($keywords as $keyword) {
                $conditions['OR'][] = ['Symptoms.name LIKE' => "%$keyword%"];
            }
            
            $categoryData = $this->Symptoms->find('all', [
                'conditions' => $conditions,
            ])->first();

        } elseif ($category === 'Treatment') {
            $this->loadModel('Treatments');
            
            $conditions = [];
            foreach ($keywords as $keyword) {
                $conditions['OR'][] = ['Treatments.name LIKE' => "%$keyword%"];
            }

            $categoryData = $this->Treatments->find('all', [
                'conditions' => $conditions,
            ])->first();
        } 

        if ($categoryData !== null && isset($detectedLanguage['ja'])) {
            $trans = new GoogleTranslate();

            if ($categoryData->has('content')) {
                $categoryData = $trans->translate('en', 'ja', $categoryData->content);
            }elseif ($categoryData->has('description')) {
                $categoryData = $trans->translate('en', 'ja', $categoryData->name);
            }
        }
        echo json_encode(['chatbotMessage' => $categoryData]);
        
        
    }

    public function googleTranslate()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $newUserMessage = isset($data['content']) ? $data['content'] : null;

        $ld = new Language;
        $detectedLanguage = $ld->detect($newUserMessage)->bestResults()->close();
        if (isset($detectedLanguage['ja'])) {
            $trans = new GoogleTranslate();
            $translatedMessage = $trans->translate('ja', 'en', $newUserMessage);
        }else{
            $trans = new GoogleTranslate();
            $translatedMessage = $trans->translate('en', 'ja', $newUserMessage);
        }
        echo json_encode(['translatedMessage' => $translatedMessage]);

    }

}
