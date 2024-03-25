<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UserQuestions Controller
 *
 * @property \App\Model\Table\UserQuestionsTable $UserQuestions
 * @method \App\Model\Entity\UserQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserQuestionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $userQuestions = $this->paginate($this->UserQuestions);

        $this->set(compact('userQuestions'));
    }

    /**
     * View method
     *
     * @param string|null $id User Question id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userQuestion = $this->UserQuestions->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('userQuestion'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userQuestion = $this->UserQuestions->newEmptyEntity();
        if ($this->request->is('post')) {
            $userQuestion = $this->UserQuestions->patchEntity($userQuestion, $this->request->getData());
            if ($this->UserQuestions->save($userQuestion)) {
                $this->Flash->success(__('The user question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user question could not be saved. Please, try again.'));
        }
        $users = $this->UserQuestions->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('userQuestion', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Question id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userQuestion = $this->UserQuestions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userQuestion = $this->UserQuestions->patchEntity($userQuestion, $this->request->getData());
            if ($this->UserQuestions->save($userQuestion)) {
                $this->Flash->success(__('The user question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user question could not be saved. Please, try again.'));
        }
        $users = $this->UserQuestions->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('userQuestion', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Question id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userQuestion = $this->UserQuestions->get($id);
        if ($this->UserQuestions->delete($userQuestion)) {
            $this->Flash->success(__('The user question has been deleted.'));
        } else {
            $this->Flash->error(__('The user question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getAnalysis() {
        $userQuestionsTable = $this->loadModel('UserQuestions');
    
    }
}
