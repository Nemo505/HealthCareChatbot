<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid email or password');
        }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['login']);
    }
    

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->findByEmail($this->request->getData('email'))->first();
            if ($user) {
                // Generate token
                $token = bin2hex(random_bytes(16));
                // Save token to database
                $user->token = $token;
                $this->Users->save($user);

                // Send email with password reset link
                // Code for sending email omitted for brevity
            }
        }
    }

    public function resetPassword($token)
    {
        $result = $this->Authentication->getResult();
        $user = $this->Users->findByToken($token)->first();
        if ($user) {
            // Check token expiration
            $expirationTime = $user->created->modify('+1 hour');
            // if ($expirationTime < Time::now()) {
            //     $this->Flash->error('Password reset link has expired.');
            //     return $this->redirect(['action' => 'forgotPassword']);
            // }

            if ($this->request->is(['post', 'put'])) {
                // Update password
                $user->password = $this->request->getData('password');
                $user->token = null; // Clear token
                if ($this->Users->save($user)) {
                    $this->Flash->success('Password has been reset successfully.');
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Password reset failed. Please try again.');
                }
            }
        } else {
            $this->Flash->error('Invalid password reset token.');
            return $this->redirect(['action' => 'forgotPassword']);
        }

        $this->set(compact('user'));
    }



    
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $avatar = $this->request->getData('avatar');
            if (!empty($avatar)) {
                $uploadPath = WWW_ROOT . 'uploads' . DS . 'avatars';
                                
                $folder = new Folder();
                $folder->create($uploadPath);

                $uploadFileName = time() . $avatar->getClientFilename();
                $avatar->moveTo($uploadPath . DS . $uploadFileName);

                // Save the file name to the user entity
                $user->avatar = $uploadFileName;
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
