<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Generals Controller
 *
 * @property \App\Model\Table\GeneralsTable $Generals
 * @method \App\Model\Entity\General[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GeneralsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $generals = $this->paginate($this->Generals);

        $this->set(compact('generals'));
    }

    /**
     * View method
     *
     * @param string|null $id General id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $general = $this->Generals->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('general'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $general = $this->Generals->newEmptyEntity();
        if ($this->request->is('post')) {
            $general = $this->Generals->patchEntity($general, $this->request->getData());
            if ($this->Generals->save($general)) {
                $this->Flash->success(__('The general has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The general could not be saved. Please, try again.'));
        }
        $this->set(compact('general'));
    }

    /**
     * Edit method
     *
     * @param string|null $id General id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $general = $this->Generals->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $general = $this->Generals->patchEntity($general, $this->request->getData());
            if ($this->Generals->save($general)) {
                $this->Flash->success(__('The general has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The general could not be saved. Please, try again.'));
        }
        $this->set(compact('general'));
    }

    /**
     * Delete method
     *
     * @param string|null $id General id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $general = $this->Generals->get($id);
        if ($this->Generals->delete($general)) {
            $this->Flash->success(__('The general has been deleted.'));
        } else {
            $this->Flash->error(__('The general could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
