<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns">

<h3><?= __($article->title) ?></h3>
<p><?= h($article->body) ?></p>
<p><b>Tags:</b> <?= h($article->tag_string) ?></p>
<p><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?></p>
</div>

<div class="row">
	<div class="col-sm-12 text-right">
		<h3>Comments</h3>
	</div>
	<?php if (!empty($article->comments)): ?>
		<?php foreach ($article->comments as $comment): ?>
		<div class="col-sm-6 offset-sm-6 text-right border-bottom mb-2">
			<div class="text-success">User: <?= h($comment->user_id) ?> at <?= h($comment->created) ?></div>
			<div><?= h($comment->comment) ?></div>
			<div>
				<?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comment->id]) ?>
			</div>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<div class="col-sm-4 offset-sm-8 text-right">
		<?= $this->Form->create(null,[
    'url' => [
        'controller' => 'Comments',
        'action' => 'addArticleComments'
    ]]) ?>
	    <fieldset class="mb-2">
	        <legend><?= __('Add Comment') ?></legend>
	        <?php
	            echo $this->Form->control('comment', ['rows'=>4]);
	            echo $this->Form->control('article_id', ['type'=>'hidden', 'value' => $article->id, 'options'=>[$article->id=>$article->title]]);
	            echo $this->Form->control('user_id', ['type'=>'hidden', 'value' => $authUser['id'],'options'=>[$authUser['id']=>$authUser['email']]  ]);
	        ?>
	    </fieldset>
	    <?= $this->Form->button(__('Post Comment')) ?>
	    <?= $this->Form->end() ?>
	</div>
</div>