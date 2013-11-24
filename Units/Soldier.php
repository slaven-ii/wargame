<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/21/13
 * Time: 7:31 PM
 *
 * Soldier object is instance of the unit, it represent the weakest unit in the army
 */

class Units_Soldier extends Units_Abstract {

  protected $_health = 100;
  protected $_attack = 15;
  protected $_type = 'Soldier';

  /**
   * see Units_Interface for description
   *
   * @param Army_Army $enemyArmy
   * @param null $attackCallback
   * @param null $victimCallback
   * @return mixed|void
   */
  public function attack (Army_Army $enemyArmy, $attackCallback = null, $victimCallback = null) {

    $array_army = $enemyArmy->getArmy();

    //we will randomly select the unit from the defending army to attack
    if (count($array_army) > 0) {

      $enemy = array_rand($enemyArmy->getArmy());

      //Create Actions_Attack object that represend the attack of the unit
      $attack = new Actions_Attack($this);
      $attack->setAttackDamage($this->_attack);

      //Send the attack to the enemy unit
      $array_army[$enemy]->takeDamage($attack, $victimCallback);

      if ($this->isCallbackValid($attackCallback)) {
        //Call the callback if provided and send the Actions_Attack object to it
        $attackCallback($attack);
      }
    }

  }

  /**
   * see Units_Interface for description
   * @param Actions_Attack $attack
   * @param null $callback
   * @return mixed|void
   */
  public function takeDamage (Actions_Attack $attack, $callback = null) {
    //Get Actions_Attack object from the attacker and create Actions_Damage object for reporting or loging
    $damageObj = new Actions_Damage($attack, $this);

    //Get the attacker current modifiers, get the sum of the attack form the modifiers
    $modifiers = $attack->getAttacker()->getAttributeManager()->getAttackSum($this);
    $damage = $attack->getAttackDamage() + $modifiers['attackSum'] + $modifiers['selfMutilation'];

    $damageObj->setDamageTaken($damage);

    $this->_health -= $damage;


    if ($this->isCallbackValid($callback)) {
      $callback($damageObj, $modifiers);
    }

  }
}
