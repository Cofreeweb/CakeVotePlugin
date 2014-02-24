<div class="cake-votes clearfix">
	
	<div class="grid_5 alpha">
		<b class="grey"><?= __("Valora este contenido")?></b>
	</div>
	
	<div class="vote-box grid_6 omega">
		
		<span class="btn btn-small bg-green grid_4">
			<? if( !$user_vote): ?>
			    <?= $this->Html->link( '<i class="icon icon-ok white text-xxbig"></i> <span class="none">' . __d( 'vote', "A favor") . '</span>', array(
			        'plugin' => 'vote',
			        'controller' => 'votes', 
			        'action' => 'add',
			        $model,
			        $foreign_key,
			        'positive',
			        'ext' => 'json',
			    ), array(
			        'class' => 'cake-vote',
							'escape' => false,
			    )) ?>
			<? else: ?> 
				<span class="vote-icon vote-inactive"><i class="icon icon-ok white text-xxbig"></i> <span class="none"><? __("A favor") ?></span></span>
			<? endif ?>
			<span class="vote-positive white text-big"><?= $positives ?></span>
		</span>
	
		<span class="btn btn-small bg-red grid_4">
			<? if( !$user_vote): ?>
				<?= $this->Html->link( '<i class="icon icon-not-ok white text-xxbig"></i> <span class="none">' . __d( 'vote', "En contra") . '</span>', array(
		        'plugin' => 'vote',
		        'controller' => 'votes', 
		        'action' => 'add',
		        $model,
		        $foreign_key,
		        'negative',
		        'ext' => 'json',
		    ), array(
		        'class' => 'cake-vote',
						'escape' => false
		    )) ?>
			<? else: ?>
				<span class="vote-icon vote-inactive"><i class="icon icon-not-ok white text-xxbig"></i> <span class="none"><? __("En contra") ?></span></span>
			<? endif ?>
			<span class="vote-negative white text-big"><?= $negatives ?></span>
		</span>
		
	</div>
</div>

<?/* if( !$user_vote): ?>

    <?= $this->Html->link( __d( 'vote', "A favor"), array(
        'plugin' => 'vote',
        'controller' => 'votes', 
        'action' => 'add',
        $model,
        $foreign_key,
        'positive',
        'ext' => 'json',
    ), array(
        'class' => 'cake-vote'
    )) ?>
  
    <?= $this->Html->link( __d( 'vote', "En contra"), array(
        'plugin' => 'vote',
        'controller' => 'votes', 
        'action' => 'add',
        $model,
        $foreign_key,
        'negative',
        'ext' => 'json',
    ), array(
        'class' => 'cake-vote'
    )) ?>
  <? endif */?>