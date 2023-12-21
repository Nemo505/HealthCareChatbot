<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\General> $generals
 */
?>
<div class="generals index content">
    <?= $this->Html->link(__('New General'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Generals') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('content') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($generals as $general): ?>
                <tr>
                    <td><?= $this->Number->format($general->id) ?></td>
                    <td><?= h($general->title) ?></td>
                    <td><?= h($general->content) ?></td>
                    <td><?= h($general->created) ?></td>
                    <td><?= h($general->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $general->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $general->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $general->id], ['confirm' => __('Are you sure you want to delete # {0}?', $general->id)]) ?>
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
