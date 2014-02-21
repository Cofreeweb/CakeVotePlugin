<?php

class VoteHelper extends AppHelper 
{
  public $helpers = array('Html', 'Form', 'Session');
  
  
  private $_models = array();
  
  
  
  public function beforeRender() 
  {
    if( !$this->request->is( 'ajax'))
    {
      $this->Html->script( '/vote/js/vote.jquery', array(
          'inline' => false,
          'once' => true
      ));
    }
  }
  
/**
 * Guess the location for a model based on its name and tries to create a new instance
 * or get an already created instance of the model
 *
 * @param string $model
 * @return Model model instance
 */
	protected function _getModel($model) {
		$object = null;
		if( !$model || $model === 'Model') {
			return $object;
		}

		if( array_key_exists($model, $this->_models)) {
			return $this->_models[$model];
		}

		if( ClassRegistry::isKeySet($model)) {
			$object = ClassRegistry::getObject($model);
		} elseif( isset($this->request->params['models'][$model])) {
			$plugin = $this->request->params['models'][$model]['plugin'];
			$plugin .=( $plugin) ? '.' : null;
			$object = ClassRegistry::init(array(
				'class' => $plugin . $this->request->params['models'][$model]['className'],
				'alias' => $model
			));
		} elseif( ClassRegistry::isKeySet($this->defaultModel)) {
			$defaultObject = ClassRegistry::getObject($this->defaultModel);
			if( in_array($model, array_keys($defaultObject->getAssociated()), true) && isset($defaultObject->{$model})) {
				$object = $defaultObject->{$model};
			}
		} else {
			$object = ClassRegistry::init($model, true);
		}

		$this->_models[$model] = $object;
		if( !$object) {
			return null;
		}

		$this->fieldset[$model] = array('fields' => null, 'key' => $object->primaryKey, 'validates' => null);
		return $object;
	}
	
  /**
   * Setup the guest id in session and cookie.
   */
  private function __setupGuest() 
  {
    if( !$this->Session->check( 'Vote.guest_id')) 
    {
      App::import( 'Core', 'String');
      $uuid = String::uuid();

      CakeSession::write( 'Vote.guest_id', $uuid);
    } 
    elseif( Configure::read( 'Vote.guest')) 
    {
      // $this->Session->write( 'Vote.guest_id', $uuid);
    }
  }
  
  
  public function display( $options = array())
  {
    if( Configure::read( 'Vote.guest') && !$this->Session->check( Configure::read( 'Vote.sessionUserId'))) 
    {
      $this->__setupGuest();
    }
    
    if( !$this->Session->read( Configure::read( 'Vote.sessionUserId')) 
        &&( Configure::read( 'Vote.guest') && $this->Session->read( 'Vote.guest_id'))) 
    {
      $user_id = $this->Session->read( 'Vote.guest_id');
    } 
    else 
    {
      $user_id = $this->Session->read( Configure::read( 'Vote.sessionUserId'));
    }
    
    $user_vote = $this->_getModel( 'Vote.Vote')->field( 'type', array(
        'Vote.model' => $options ['model'],
        'Vote.foreign_key' => $options ['id'],
        'Vote.user_id' => $user_id
    ));
    
    $positives = $this->_getModel( 'Vote.Vote')->find( 'count', array(
        'conditions' => array(
            'Vote.model' => $options ['model'],
            'Vote.foreign_key' => $options ['id'],
            'Vote.type' => 'positive'
        )
    ));
    
    $negatives = $this->_getModel( 'Vote.Vote')->find( 'count', array(
        'conditions' => array(
            'Vote.model' => $options ['model'],
            'Vote.foreign_key' => $options ['id'],
            'Vote.type' => 'negative'
        )
    ));
    
    return $this->_View->element( 'Vote.vote', array(
        'user_vote' => $user_vote,
        'positives' => $positives,
        'negatives' => $negatives,
        'model' => $options ['model'],
        'foreign_key' => $options ['id']
    ));
  }
  
  
  
  public function render( $options = array())
  {
    $_options = array(
        'name' => 'default',
        'config' => 'plugin.rating'
    );
    
    $options = array_merge( $_options, $options);
    
    $out = '<div id="'. $options ['model'] .'_rating_'. $options ['id'] .'" class="rating">' .
      $this->view( $options ['model'], $options ['id'], base64_encode(json_encode(array('name' => $options ['name'], 'config' => $options ['config'])))) .
      '</div>';
    
    return $out;
  }
}
?>