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
use App\Utility\Trie;

class TestsController extends AppController
{

    public function index()
    {
        $user = $this->Authentication->getIdentity(); // Get the currently authenticated user
        $this->set(compact('user'));
    }


    public function addNlpMessages()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $newUserMessage = isset($data['content']) ? $data['content'] : null;
        $keywords = array_map('strtolower', explode(' ', $newUserMessage));

        $this->loadModel('Generals');
        
        $categoryCounts = []; // Initialize an array to store counts of matched keywords for each category

        foreach ($keywords as $keyword) {
            $conditions = ['LOWER(Generals.keyword) LIKE' => "%$keyword%"];
            $result = $this->Generals->find('all', [
                'conditions' => $conditions,
            ])->toArray();

            foreach ($result as $row) {
                $categoryId = $row['id'];
                if (!isset($categoryCounts[$categoryId])) {
                    $categoryCounts[$categoryId] = 0;
                }
                $categoryCounts[$categoryId]++;
            }
        }

        // Find the category with the highest count of matched keywords
        $bestCategoryId = null;
        $maxKeywordCount = 0;
        foreach ($categoryCounts as $categoryId => $count) {
            if ($count > $maxKeywordCount) {
                $bestCategoryId = $categoryId;
                $maxKeywordCount = $count;
            }
        }

        // Retrieve data for the best category if found
        $categoryData = [];
        if ($bestCategoryId !== null) {
            $categoryData = $this->Generals->find('all', [
                'conditions' => ['Generals.id' => $bestCategoryId],
            ])->first();
        }else{
            $suggestedQuestion = $this->suggest($keywords);
            $categoryData['content'] =
            "I couldn't find what you were looking for. How about considering \"$suggestedQuestion\"?";
        } 

        echo json_encode(['chatbotMessage' => $categoryData]);
    }

    public function suggest($keywords){
        $question = $this->Generals->find('all', [
            'conditions' => ['LOWER(Generals.question) LIKE' => '%' . implode('%', $keywords) . '%'],
        ])->first();

        return $question ? $question->question : "Sorry, I couldn't find any relevant question.";
    }

    //using Trie Testing
    public function someAction()
    {
        $this->autoRender = false;

        $data = $this->request->getData();
        $newUserMessage = isset($data['content']) ? $data['content'] : null;
        $keys = array_map('strtolower', explode(' ', $newUserMessage));

        // Instantiate a Trie object
        $trie = new Trie();

        // Insert the words into the Trie
        foreach ($keys as $key) {
            $trie->insert($key);
        }

        // Perform a search for a specific word
        $searchWord = "the";
        $searchResult = $trie->search($searchWord);
        if ($searchResult) {
            echo "present";
        } else {
            echo "no results";
        }

        // Set the search result to be passed to the view
        $this->set('searchResult', $searchResult);

        // Pass the Trie object to the view if needed
        $this->set('trie', $trie);
    }
}
