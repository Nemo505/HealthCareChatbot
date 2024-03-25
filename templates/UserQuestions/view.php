<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserQuestion $userQuestion
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User Question'), ['action' => 'edit', $userQuestion->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User Question'), ['action' => 'delete', $userQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userQuestion->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List User Questions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User Question'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="userQuestions view content">
            <h3><?= h($userQuestion->questions) ?></h3>
            <table>
                <tr>
                    <th><?= __('Questions') ?></th>
                    <td><?= h($userQuestion->questions) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($userQuestion->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $userQuestion->has('user') ? $this->Html->link($userQuestion->user->username, ['controller' => 'Users', 'action' => 'view', $userQuestion->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Feedback') ?></th>
                    <td><?= h($userQuestion->feedback) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($userQuestion->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Answer Id') ?></th>
                    <td><?= $userQuestion->answer_id === null ? '' : $this->Number->format($userQuestion->answer_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($userQuestion->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($userQuestion->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
