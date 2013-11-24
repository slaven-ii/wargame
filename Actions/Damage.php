<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 4:08 PM
 *
 * Actions_Damage is representing the abstraction for the unit taking damage
 * it helps for sending needed data from and to attacker - victim
 *
 * We have Modifiers that are changing the attack of the attacker so we need to have some layers between it
 *
 */

class Actions_Damage extends Actions_Attack {

  /**
   * calculated damage that the victim will be affected
   * @var int
   */
  private $_damageTaken = 0;
  /**
   * Victim unit
   * @var Units_Abstract
   */
  private $_victim;

  /**
   * Unit that is attacking
   * @var Actions_Attack
   */
  private $_attackObject;

  public function __construct (Actions_Attack $attackObj, Units_Abstract $victim) {
    $this->_attackObject = $attackObj;
    $this->_victim = $victim;
  }

  public function setDamageTaken ($damage) {
    $this->_damageTaken = $damage;
  }

  public function getAttacker () {
    return $this->_attackObject;
  }

  public function getVictim () {
    return $this->_victim;
  }

  public function getDamageTaken () {
    return $this->_damageTaken;
  }
}
