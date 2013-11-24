<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/21/13
 * Time: 7:32 PM
 *
 * Tank unit have multiple targets and it's immune to some modifiers
 */
class Units_Tank extends Units_Abstract {

  protected $_health = 300;
  protected $_attack = 100;
  protected $_type = 'Tank';

  /**
   * number of the affected units that the tank will hit with it's attack
   * @var int
   */
  private $_radius = 4;

  /**
   * array of the modification names that the tank is immune to
   * @var array
   */
  private $_immuneOn = array(Modifiers_Abstract::MODIFIER_TYPE_SELF_MUTILATION);

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
    $arrayArmyCount = count($array_army);
    $radius = $this->_radius;

    //tank is attacking multiple targets
    if ($arrayArmyCount > 0) {

      //Check if there is enough units in the army for the tank to hit
      if ($arrayArmyCount < $this->_radius) {

        //There are less unit's in the army then the tank can hit, set radius to the current army count
        $radius = $arrayArmyCount;
      }

      $enemy = array_rand($enemyArmy->getArmy(), $radius);

      if (is_array($enemy)) {
        //array_rand will return array if there are more then one unit selected
        foreach ($enemy as $enemyKey) {
          //iterate through the randomly selected enemies and attack them
          $this->attackAndCallack($array_army, $enemyKey, $attackCallback, $victimCallback);
        }
      } else {
        //the array_rand returned single value, we will hit only one enemy unit
        $this->attackAndCallack($array_army, $enemy, $attackCallback, $victimCallback);
      }


    }

  }

  /**
   * Helper method for attacking one, or multiple enemy units
   *
   * @param $array_army
   * @param $enemyKey
   * @param $attackCallback
   * @param $victimCallback
   */
  private function  attackAndCallack ($array_army, $enemyKey, $attackCallback, $victimCallback) {
    //createa attack object
    $attack = new Actions_Attack($this);
    $attack->setAttackDamage($this->_attack);

    $array_army[$enemyKey]->takeDamage($attack, $victimCallback);

    if ($this->isCallbackValid($attackCallback)) {
      $attackCallback($attack);
    }
  }


  /**
   * see Units_Interface for description
   *
   * @param Actions_Attack $attack
   * @param null $callback
   * @return mixed|void
   */
  public function takeDamage (Actions_Attack $attack, $callback = null) {


    $damageObj = new Actions_Damage($attack, $this);
    $modifiers = $attack->getAttacker()->getAttributeManager()->getAttackSum($this, $this->_immuneOn);
    $demage = $attack->getAttackDamage() + $modifiers['attackSum'] + $modifiers['selfMutilation'];
    $damageObj->setDamageTaken($demage);

    $this->_health -= $demage;


    if ($this->isCallbackValid($callback)) {
      $callback($damageObj, $modifiers);
    }

  }
}
