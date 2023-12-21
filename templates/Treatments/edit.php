<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Treatment $treatment
 * @var string[]|\Cake\Collection\CollectionInterface $symptoms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $treatment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $treatment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Treatments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="treatments form content">
            <?= $this->Form->create($treatment) ?>
            <fieldset>
                <legend><?= __('Edit Treatment') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('symptom_id', ['options' => $symptoms, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
