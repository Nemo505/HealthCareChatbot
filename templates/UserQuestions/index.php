<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\UserQuestion> $userQuestions
 */
?>
<div class="userQuestions index content">
    <?= $this->Html->link(__('New User Question'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('User Questions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('questions') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('answer_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('feedback') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userQuestions as $userQuestion): ?>
                <tr>
                    <td><?= $this->Number->format($userQuestion->id) ?></td>
                    <td><?= h($userQuestion->questions) ?></td>
                    <td><?= h($userQuestion->category) ?></td>
                    <td><?= $userQuestion->answer_id === null ? '' : $this->Number->format($userQuestion->answer_id) ?></td>
                    <td><?= $userQuestion->has('user') ? $this->Html->link($userQuestion->user->username, ['controller' => 'Users', 'action' => 'view', $userQuestion->user->id]) : '' ?></td>
                    <td><?= h($userQuestion->feedback) ?></td>
                    <td><?= h($userQuestion->created) ?></td>
                    <td><?= h($userQuestion->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $userQuestion->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userQuestion->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userQuestion->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
