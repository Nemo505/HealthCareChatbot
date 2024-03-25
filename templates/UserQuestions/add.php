<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserQuestion $userQuestion
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List User Questions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="userQuestions form content">
            <?= $this->Form->create($userQuestion) ?>
            <fieldset>
                <legend><?= __('Add User Question') ?></legend>
                <?php
                    echo $this->Form->control('questions');
                    echo $this->Form->control('category');
                    echo $this->Form->control('answer_id');
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('feedback');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
