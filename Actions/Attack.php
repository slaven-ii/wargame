<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 4:08 PM
 *
 * Actions_Attack is representing the abstraction for the attack move of the unit
 */

class Actions_Attack {

  /**
   * Damage taken with the attack
   * @var int
   */
  protected $_attackDamage = 0;
  /**
   * The unit that is attacking
   * @var Units_Abstract
   */
  protected $_attacker;

  public function __construct (Units_Abstract $unit) {
    $this->_attacker = $unit;
  }

  public function setAttackDamage ($damage) {
    $this->_attackDamage = $damage;
  }

  public function  getAttackDamage () {
    return $this->_attackDamage;
  }

  public function getAttacker () {
    return $this->_attacker;
  }
}
