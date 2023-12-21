<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Symptoms Controller
 *
 * @property \App\Model\Table\SymptomsTable $Symptoms
 * @method \App\Model\Entity\Symptom[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SymptomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $symptoms = $this->paginate($this->Symptoms);

        $this->set(compact('symptoms'));
    }

    /**
     * View method
     *
     * @param string|null $id Symptom id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $symptom = $this->Symptoms->get($id, [
            'contain' => ['Treatments'],
        ]);

        $this->set(compact('symptom'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $symptom = $this->Symptoms->newEmptyEntity();
        if ($this->request->is('post')) {
            $symptom = $this->Symptoms->patchEntity($symptom, $this->request->getData());
            if ($this->Symptoms->save($symptom)) {
                $this->Flash->success(__('The symptom has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The symptom could not be saved. Please, try again.'));
        }
        $this->set(compact('symptom'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Symptom id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $symptom = $this->Symptoms->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $symptom = $this->Symptoms->patchEntity($symptom, $this->request->getData());
            if ($this->Symptoms->save($symptom)) {
                $this->Flash->success(__('The symptom has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The symptom could not be saved. Please, try again.'));
        }
        $this->set(compact('symptom'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Symptom id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $symptom = $this->Symptoms->get($id);
        if ($this->Symptoms->delete($symptom)) {
            $this->Flash->success(__('The symptom has been deleted.'));
        } else {
            $this->Flash->error(__('The symptom could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
