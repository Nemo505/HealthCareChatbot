<?php

declare(strict_types=1);

namespace App\Controller;

require 'vendor/autoload.php';
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';
require_once(ROOT . DS . 'vendor' . DS . 'kazue' . DS . 'jpn_stop_words.php');

use Statickidz\GoogleTranslate;
use LanguageDetection\Language;

class RegistersController extends AppController
{

    public function index()
    {
        $user = $this->Authentication->getIdentity(); // Get the currently authenticated user
        $this->set(compact('user'));
    }


    //for japanese
    public function addRegisterMessages()
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
        $categoryData = "";

        $registrationInProgress = false;
        $registrationStep = 0; // Track the registration steps
        
        foreach ($keywords as $keyword) {
            if ($registrationInProgress) {
                switch ($registrationStep) {
                    case 0:
                        // Step 0: Ask for the full name
                        $fullName = $newUserMessage;
                        $registrationStep++;
                        $categoryData .= "Thanks, $fullName. Please provide your email address.";
                        break;
                    case 1:
                        // Step 1: Ask for the email address
                        $email = $newUserMessage;
                        $registrationStep++;
                        $categoryData .= "Got it. Is your email address $email correct? (Yes/No)";
                        break;
                    case 2:
                        // Step 2: Confirm details
                        if (strtolower($newUserMessage) === "yes") {
                            $categoryData .= "Great! Your registration is complete.";
                        } else {
                            $registrationStep = 0; // Reset to the beginning
                            $categoryData .= "Let's start over. Please provide your full name again.";
                        }
                        // Either way, registration is complete, exit the loop
                        $registrationInProgress = false;
                        break;
                    default:
                        $registrationInProgress = false;
                        break;
                }
            } else {
                if ($keyword === "register") {
                    // Start registration process
                    $registrationInProgress .= true;
                    $registrationStep = 0;

                    $trans = new GoogleTranslate();
                    if (isset($detectedLanguage['ja'])) {
                        $categoryData .= $trans->translate('en', 'ja', "To register you, I'll need some details. Let's start with your full name. What's your name?");
                    } else {
                        $categoryData .= "To register you, I'll need some details. Let's start with your full name. What's your name?";
                    }

                    break; 
                }
            }
        }

        echo json_encode(['chatbotMessage' => $categoryData]);
    }

}
