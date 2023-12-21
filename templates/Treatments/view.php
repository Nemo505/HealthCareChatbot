<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Treatment $treatment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Treatment'), ['action' => 'edit', $treatment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Treatment'), ['action' => 'delete', $treatment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $treatment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Treatments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Treatment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="treatments view content">
            <h3><?= h($treatment->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($treatment->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($treatment->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Symptom') ?></th>
                    <td><?= $treatment->has('symptom') ? $this->Html->link($treatment->symptom->name, ['controller' => 'Symptoms', 'action' => 'view', $treatment->symptom->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($treatment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($treatment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($treatment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
