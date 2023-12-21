<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Symptom $symptom
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Symptom'), ['action' => 'edit', $symptom->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Symptom'), ['action' => 'delete', $symptom->id], ['confirm' => __('Are you sure you want to delete # {0}?', $symptom->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Symptoms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Symptom'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="symptoms view content">
            <h3><?= h($symptom->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($symptom->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($symptom->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($symptom->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($symptom->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($symptom->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Treatments') ?></h4>
                <?php if (!empty($symptom->treatments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Symptom Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($symptom->treatments as $treatments) : ?>
                        <tr>
                            <td><?= h($treatments->id) ?></td>
                            <td><?= h($treatments->name) ?></td>
                            <td><?= h($treatments->description) ?></td>
                            <td><?= h($treatments->symptom_id) ?></td>
                            <td><?= h($treatments->created) ?></td>
                            <td><?= h($treatments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Treatments', 'action' => 'view', $treatments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Treatments', 'action' => 'edit', $treatments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Treatments', 'action' => 'delete', $treatments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $treatments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
