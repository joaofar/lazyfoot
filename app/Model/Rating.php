<?php
App::uses('AppModel', 'Model');
/**
 * Goal Model
 *
 * @property Player $Player
 * @property Game $Game
 */
class Rating extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'player_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mean' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'standard_deviation' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Player' => array(
			'className' => 'Player',
			'foreignKey' => 'player_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


/**
 * current method
 * 
 * Devolve o rating mais recente do jogador
 * @param  int $id [player id]
 * @param  int $gameID
 * @return array
 */
	public function current($id, $gameID = null)
	{
		//verificar se o jogador tem ratings
		if (!$gameID) {
			//se não houver gameID, devolve o mais recente
			$currentRating = $this->find('first', array(
			'conditions' => array('Rating.player_id' => $id),
			'order' => array('id' => 'desc')
			));
		} else {
			$currentRating = $this->find('first', array(
			'conditions' => array('Rating.player_id' => $id, 'Rating.game_id <' => $gameID),
			'order' => array('id' => 'desc')
			));
		}


		if (!$currentRating) {
			//se não tiver, cria um novo com valores default
			//estas variáveis estão definidas no bootstrap.php
			$currentRating = array('Rating' => array(
				'player_id' => $id,
                'mean' => Configure::read('MEAN'),
                'standard_deviation' => Configure::read('STANDARD_DEVIATION')
                ));

            return $currentRating['Rating'];
		}else{
			//se tiver, devolve a última rating
			return $currentRating['Rating'];
		}
	}

	public function ratingExists($id, $gameId)
	{
		$rating = $this->find('first', array(
			'conditions' => array(
				'Rating.player_id' => $id,
				'Rating.game_id' => $gameId
				)
			));

		if($rating){
			return $rating['Rating']['id'];
		}else{
			return false;
		}
	}

	public function rankingList($nMinPre = null)
	{
		$playersList = $this->Player->find('list', array(
            'fields' => array('Player.id', 'Player.nome'),
            'conditions' => array('Player.presencas >=' => $nMinPre)
            ));

		foreach ($playersList as $id => $name) {
			$currentRating = $this->current($id);

			$index[$name] = $currentRating['mean'];

			// $playerRatingList[] = array(
			// 	'id' => $id,
			// 	'name' => $name,
			// 	'mean' => $currentRating['mean']);


		
		}

		arsort($index);
		return $index;

	}

	// 10277
	// 781 696 971
	// 204,05€










}
	



























?>