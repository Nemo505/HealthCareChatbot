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

        $session = $this->request->getSession();
        $step = $session->read('registration_step');

        $newUserMessage = isset($data['content']) ? $data['content'] : null;

        switch ($step) {
            case 'ask_name':
                // Store the name
                $session->write('name', $newUserMessage);
                // Update session step
                $session->write('registration_step', 'ask_email');
                // Prepare response for asking email
                $categoryData = array(
                    'message' => "素晴らしい、ありがとうございます。" . $newUserMessage . "! あなたのメールアドレスは何ですか？",
                    'action' => 'ask_email'
                );
                break;

            case 'ask_email':
                // Store the email
                $session->write('email', $newUserMessage);
                // Update session step
                $session->write('registration_step', 'complete');
                // You can add further steps or go straight to completion
                // For now, let's assume we go to completion
                $categoryData = array(
                    'message' => "メールアドレスを提供していただき、登録が完了しました！",
                    'action' => 'complete'
                );
                break;

            default:
                // Initial step, ask for name
                $session->write('registration_step', 'ask_name');
                $categoryData = array(
                    'message' => "あなたの登録のために、いくつかの詳細が必要です。まずはフルネームから始めましょう。あなたのお名前は何ですか？",
                    'action' => 'ask_name'
                );
                break;
        }

        // Send response back to AJAX call
        echo json_encode($categoryData);
    }


}
