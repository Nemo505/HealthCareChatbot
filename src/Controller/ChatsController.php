<?php
declare(strict_types=1);

namespace App\Controller;
require 'vendor/autoload.php';
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';
require_once(ROOT . DS . 'vendor' . DS . 'kazue' . DS . 'jpn_stop_words.php');

use DonatelloZa\RakePlus\RakePlus;
use Statickidz\GoogleTranslate;
use LanguageDetection\Language;
use Cake\Utility\Text;

class ChatsController extends AppController
{
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
                $conditions['OR'][] = ['Generals.keyword LIKE' => "%$keyword%"];
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

    //nlp
    public function getNlp()
    {
        $user = $this->Authentication->getIdentity(); // Get the currently authenticated user
        $this->set(compact('user'));
    }

    public function addNlpMessages()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $newUserMessage = isset($data['content']) ? $data['content'] : null;
        $newUserMessage = preg_replace('/[?,]/', '', $newUserMessage);
        
        // Get keywords
        $keywords = $this->get_keywords($newUserMessage);

        $this->loadModel('Symptoms');

        $conditions = [];
        foreach ($keywords as $keyword) {
            $conditions['OR'][] = ['Symptoms.keyword LIKE' => "%$keyword%"]; // Change $keywords to $keyword
        }

        $categoryData = $this->Symptoms->find('all', [
            'conditions' => $conditions,
        ])->first();

        echo json_encode(['chatbotMessage' => $categoryData, 'keywords' => $keywords]);

    }

    //get keywords
    public function remove_punctuation($text) {
        // $text = mb_convert_kana($text, "KVC"); //Normalize to full-width characters
        $charactersToRemove = ['「', '」', '、', '。', '・', '※'];
        $text = str_replace($charactersToRemove, '', $text);
        return $text;
    }

    public function get_keywords($text) {
        $stopwords = require(ROOT . DS . 'vendor' . DS . 'kazue' . DS . 'jpn_stop_words.php');

        // Remove stopwords from the user input text
        $userTextWithoutStopwords = str_replace($stopwords, ",", $text);
        $userTextArray = explode(",", $userTextWithoutStopwords);

        $userTextArray = array_filter($userTextArray);

        // Output the modified text
        return $userTextArray;
    }
    

}
