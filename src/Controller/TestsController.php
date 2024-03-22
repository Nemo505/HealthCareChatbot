<?php

declare(strict_types=1);

namespace App\Controller;

require 'vendor/autoload.php';
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';
require_once(ROOT . DS . 'vendor' . DS . 'kazue' . DS . 'jpn_stop_words.php');

use Statickidz\GoogleTranslate;
use LanguageDetection\Language;
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

        return $question ? $question->question : null;
    }

    //for japanese
    public function addTranMessages()
    {
        $this->autoRender = false;
        $data = $this->request->getData();

        $newUserMessage = isset($data['content']) ? $data['content'] : null;

        $ld = new Language;
        $detectedLanguage = $ld->detect($newUserMessage)->bestResults()->close();

        if (isset($detectedLanguage['ja'])) {
            $trans = new GoogleTranslate();
            $japaneseMessage = $trans->translate('ja', 'en', $newUserMessage);
            $keywords = explode(' ', $japaneseMessage);
        } else {
            $keywords = explode(' ', $newUserMessage);
        }

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

            if ($categoryData !== null && isset($detectedLanguage['ja'])) {
                $trans = new GoogleTranslate();
                if (!empty($categoryData)) {
                    $categoryData['content'] = $trans->translate('en', 'ja', $categoryData['content']);
                }
            }

        } else {

            $suggestedQuestion = $this->suggest($keywords);
            if ($suggestedQuestion == null) {
                $categoryData['content'] =
                "お探しのものが見つかりませんでした。";
            }else{
                $trans = new GoogleTranslate();
                $suggestedTranQ = $trans->translate('en', 'ja', $suggestedQuestion);
                $categoryData['content'] =
                "お探しのものが見つかりませんでした。\"$suggestedTranQ\" を考慮してみてはどうでしょうか？";
            }
        } 

        echo json_encode(['chatbotMessage' => $categoryData]);
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
