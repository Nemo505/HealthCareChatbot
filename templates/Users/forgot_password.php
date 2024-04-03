<!-- src/Template/Users/forgot_password.ctp -->

<!-- Display any flash messages -->
<?= $this->Flash->render() ?>

<!-- Password Reset Request Form -->
<?= $this->Form->create() ?>
<fieldset>
    <legend><?= __('Forgot Password') ?></legend>
    <?= $this->Form->control('email', ['label' => 'Email']) ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>