<div class="cake-votes">
<p>A favor: <span class="vote-positive"><?= $positives ?></span></p>
<p>En contra: <span class="vote-negative"><?= $negatives ?></span></p>

<? if( !$user_vote): ?>
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
  <? endif ?>
</div>