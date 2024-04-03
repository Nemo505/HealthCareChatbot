<!-- View: src/Template/ForgotPasswords/reset.ctp -->

<div style="max-width: 40rem; margin: 0 auto; padding: 2rem;">
    <?= $this->Flash->render() ?>
    <div style="background: linear-gradient(to right, rgba(235, 209, 209, 0.4), rgba(234, 232, 232, 0.76));
                box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
                width: 35rem;
                position:absolute;
                top: 20%;
                border-radius: 0.5rem; padding: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Reset Password</h3>
        <?= $this->Form->create(null, ['url' => ['controller' => 'ForgotPasswords', 'action' => 'reset']]) ?>
        <fieldset style="margin-bottom: 1.5rem;">
            <legend style="font-size: 0.875rem; margin-bottom: 0.75rem;">Enter your New Password</legend>
            <div style="margin-bottom: 1rem;">
                <?= $this->Form->control('password', [
                    'required' => true,
                    'label' => false,
                    'type' => 'password',
                    'style' => 'width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 0.25rem;'
                ]) ?>
            </div>
        </fieldset>
        <div>
            <?= $this->Form->submit(__('Confirm'), ['style' => 'background: linear-gradient(to right, #248A52, rgba(235, 167, 167, 0.57));
                                                                color: #fff; 
                                                                border: none; 
                                                                border-radius: 0.25rem; 
                                                                cursor: pointer;']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>