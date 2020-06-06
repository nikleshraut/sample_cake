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
    <?= $this->Form->create($user,['type'=>'file']) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php if($user->user_image): ?>
            <img width="200" class="img-fluid" src="/documents/<?= $user->user_image ?>">
        <?php else: ?>  
            Image not exist
        <?php endif; ?>
        <?php
            echo $this->Form->control('user_image', ['type'=>'file']);
            echo $this->Form->control('email');
            echo $this->Form->control('password', ['value'=>'']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
