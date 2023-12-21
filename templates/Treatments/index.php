<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Treatment> $treatments
 */
?>
<div class="treatments index content">
    <?= $this->Html->link(__('New Treatment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Treatments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('symptom_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($treatments as $treatment): ?>
                <tr>
                    <td><?= $this->Number->format($treatment->id) ?></td>
                    <td><?= h($treatment->name) ?></td>
                    <td><?= h($treatment->description) ?></td>
                    <td><?= $treatment->has('symptom') ? $this->Html->link($treatment->symptom->name, ['controller' => 'Symptoms', 'action' => 'view', $treatment->symptom->id]) : '' ?></td>
                    <td><?= h($treatment->created) ?></td>
                    <td><?= h($treatment->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $treatment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $treatment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $treatment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $treatment->id)]) ?>
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
