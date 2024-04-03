<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\MailerAwareTrait;//for instance creating a new Mailer
use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;

class ForgotPasswordController extends AppController
{
    use MailerAwareTrait;

    public function index()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $usersTable = TableRegistry::getTableLocator()->get('Users');
            $user = $usersTable->findByEmail($email)->first();
            if ($user) {
                // Generate and save reset token
                $token = bin2hex(random_bytes(32));
                $user->password_reset_token = $token;
                $user->password_reset_expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in an hour
                $usersTable->save($user);

                $mailer = new Mailer('default');
                $mailer
                ->setTransport('default')
                    ->setViewVars([
                        'user' => $user,
                        'email' => 'dahliahalesia8@gmail.com',
                    ])
                    ->setFrom(['noreply@codethepixel.com' => 'Code The Pixel'])
                    ->setTo('dahliahalesia8@gmail.com')
                    ->setEmailFormat('html')
                    ->setSubject('Reset Your Password')
                    ->viewBuilder()
                    ->setTemplate('reset_password');
                $mailer->deliver();

                // Send email with reset link
                // $this->getMailer('User')->send('resetPassword', [$user]);
            }
            $this->Flash->success(__('If your email exists in our system, you will receive an email with instructions to reset your password.'));
        }
    }

    public function view($id = null)
    {
        $forgotPassword = $this->ForgotPassword->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('forgotPassword'));
    }

    public function reset($token){
        $this->set('token', $token);
    }

}
