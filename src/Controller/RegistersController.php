<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;

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

    public function addAppointment()
    {
        $this->autoRender = false;
        $data = $this->request->getData();
        $this->request->getSession()->start();

        $session = $this->request->getSession();
        $step = $session->read('appointment_step');

        $newUserMessage = isset($data['content']) ? $data['content'] : null;

        switch ($step) {
            case 'ask_schedule':
                $categoryData = array(
                    'message' => 'Great! When would you like to schedule?',
                    'action' => 'ask_schedule'
                );
                // Update session step
                $session->write('appointment_step', 'confirm_schedule');
                break;

            case 'confirm_schedule':
                // Store the schedule date
                $session->write('schedule_date', $newUserMessage);
                // Update session step
                $session->write('appointment_step', 'complete');
                $categoryData = array(
                    'message' => 'Thank you for scheduling on ' . $newUserMessage . '. I will send an email to confirm the date',
                    'action' => 'complete'
                );

                $mailer = new Mailer('default');
                $mailer
                    ->setTransport('smtp')
                    ->setViewVars([
                        'name' => 'chyu',
                        'email' => 'dahliahalesia8@gmail.com',
                        'appointmentDate' => $newUserMessage, // Include appointment date
                    ])
                    ->setFrom(['noreply[at]codethep!xel.com' => 'Code The Pixel'])
                    ->setTo('dahliahalesia8@gmail.com')
                    ->setEmailFormat('html')
                    ->setSubject('Booking an appointment')
                    ->viewBuilder()
                        ->setTemplate('new_appointment');
                $mailer->deliver();
                break;

            default:
                // Initial step, ask if user wants to schedule
                $session->write('appointment_step', 'ask_schedule');
                $categoryData = array(
                    'message' => 'Would you like to schedule? (yes/no)',
                    'action' => 'confirm'
                );
                break;
        }

        // Send response back to AJAX call
        echo json_encode($categoryData);
    }




}
