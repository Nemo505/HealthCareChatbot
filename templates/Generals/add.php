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
            <?= $this->Html->link(__('List Generals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="generals form content">
            <?= $this->Form->create($general) ?>
            <fieldset>
                <legend><?= __('Add General') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('content');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
