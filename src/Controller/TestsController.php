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
        }

        echo json_encode(['chatbotMessage' => $categoryData]);
    }

}
