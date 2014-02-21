<?php
App::uses('VoteAppController', 'Vote.Controller');
/**
 * Votes Controller
 *
 */
class VotesController extends VoteAppController 
{
  
  public $uses = array( 'Vote.Vote');
  
  public $components = array(
      'RequestHandler',
  );
  
  public function beforeFilter()
  {
    parent::beforeFilter();
    
    if( isset( $this->Auth))
    {
      $this->Auth->allow();
    }

  }
  
  public function add( $model, $foreign_key, $type)
  {
    
    if( Configure::read( 'Vote.guest') && $this->Session->read( 'Vote.guest_id')) 
    {
      $user_id = $this->Session->read( 'Vote.guest_id');
    } 
    else 
    {
      $user_id = $this->Session->read( Configure::read( 'Vote.sessionUserId'));
    }
    
    $has = $this->Vote->hasAny( array(
        'Vote.model' => $model,
        'Vote.foreign_key' => $foreign_key,
        'Vote.user_id' => $user_id
    ));
    
    
    if( !$has)
    {
      $this->Vote->create();
      $this->Vote->save( array(
          'model' => $model,
          'foreign_key' => $foreign_key,
          'type' => $type,
          'user_id' => $user_id
      ));
      
      $positives = $this->Vote->find( 'count', array(
          'conditions' => array(
              'Vote.model' => $model,
              'Vote.foreign_key' => $foreign_key,
              'Vote.type' => 'positive'
          )
      ));

      $negatives = $this->Vote->find( 'count', array(
          'conditions' => array(
              'Vote.model' => $model,
              'Vote.foreign_key' => $foreign_key,
              'Vote.type' => 'negative'
          )
      ));
      
      $this->set( array(
          'success' => true,
          'positives' => $positives,
          'negatives' => $negatives,
          '_serialize' => array(
              'success',
              'positives',
              'negatives'
          )
      ));
    }
    else
    {
      $this->set( array(
          'success' => false,
          '_serialize' => array(
              'success'
          )
      ));
    }
  }
  
 
  /**
   * Setup the guest id in session and cookie.
   */
  private function __setupGuest() {
    if (!$this->Session->check('Rating.guest_id') && !$this->Cookie->read( 'Rating.guest_id')) 
    {
      App::import('Core', 'String');
      $uuid = String::uuid();

      $this->Session->write('Rating.guest_id', $uuid);
      $this->Cookie->write('Rating.guest_id', $uuid, false, Configure::read('Rating.guestDuration'));
    } 
    else if (Configure::read('Rating.guest') && $this->Cookie->read('Rating.guest_id')) 
    {
      $this->Session->write('Rating.guest_id', $this->Cookie->read('Rating.guest_id'));
    }
  }
}
