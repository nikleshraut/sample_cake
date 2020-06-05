<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <div class="containter border p-4">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <?= $this->Form->create($user) ?>
                <fieldset>
                    <legend><?= __('Add User') ?></legend>
                    <?php
                        echo $this->Form->control('email');
                        echo $this->Form->control('password');
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit'),['class'=>'']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
