<div style="max-width: 40rem; margin: 0 auto; padding: 2rem;">
    <?= $this->Flash->render() ?>
    <div style="background: linear-gradient(to right, rgba(235, 209, 209, 0.4), rgba(234, 232, 232, 0.76));
                box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 35rem;
                border-radius: 0.5rem; padding: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Login</h3>
        <?= $this->Form->create() ?>
        <fieldset style="margin-bottom: 1.5rem;">
            <legend style="font-size: 0.875rem; margin-bottom: 0.75rem;">Please Enter your Email and password</legend>
            <div style="margin-bottom: 1rem;">
                <?= $this->Form->control('email', [
                    'required' => true, 
                    'style' => 'width: 100%; padding: 2.2rem; border: 1px solid #ccc; border-radius: 2rem;
                    background: linear-gradient(to right, #d39f8763, rgba(234, 232, 232, 0.76))'
                    ]) ?>
            </div>
            <div style="margin-bottom: 1.5rem;">
                 <?= $this->Form->control('password', [
                    'required' => true, 
                    'style' => 'width: 100%; padding: 2.2rem; border: 1px solid #ccc; border-radius: 2rem;
                    background: linear-gradient(to right, #d39f8763, rgba(234, 232, 232, 0.76))'
                    ]) ?>
            </div>
        </fieldset>
        <div style=" display:flex; justify-content:space-between">

            <?= $this->Form->submit(__('Login'), ['style' => 'background: linear-gradient(to right, #248A52, rgba(235, 167, 167, 0.57));
                                                                color: #fff; 
                                                                border: none; 
                                                                border-radius: 0.25rem; 
                                                                cursor: pointer;']) ?>
            <?= $this->Form->submit(__('Register'), ['style' => 'background: linear-gradient(to right, #248A52, rgba(235, 167, 167, 0.57));
                                                                color: #fff; 
                                                                border: none; 
                                                                border-radius: 0.25rem; 
                                                                cursor: pointer;']) ?>
        </div>
        <?= $this->Form->end() ?>

    </div>
</div>
