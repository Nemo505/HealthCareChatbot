<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\General $general
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit General'), ['action' => 'edit', $general->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete General'), ['action' => 'delete', $general->id], ['confirm' => __('Are you sure you want to delete # {0}?', $general->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Generals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New General'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="generals view content">
            <h3><?= h($general->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($general->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Content') ?></th>
                    <td><?= h($general->content) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($general->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($general->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($general->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
