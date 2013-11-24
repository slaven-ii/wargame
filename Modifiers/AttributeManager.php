<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 6:17 PM
 * Attribute manager is used with the unit in order to provide control of the unit modifications
 */
class Modifiers_AttributeManager {

  /**
   * Array of the modifiers that the user currently have
   * @var array
   */
  private $_modifiers = array();

  /**
   * Owner of the Attribute manager, the unit
   * @var Units_Abstract
   */
  private $_owner;

  /**
   * Add the modification to the array
   * @param Modifiers_Interface $modifier
   * @param Units_Abstract $unit
   */
  public function addModifier (Modifiers_Interface $modifier, Units_Abstract $unit) {
    array_push($this->_modifiers, $modifier);
    $this->_owner = $unit;
  }

  public function setOwner (Units_Abstract $unit) {
    $this->_owner = $unit;
  }

  /**
   * This method is manipulating the modifications of the units that is on
   * The victim will check for the unit modifications and send the modifications that is immune to
   *
   * @param Units_Abstract $victim
   * @param array $immune
   * @return array
   * @throws Exception
   */
  public function getAttackSum (Units_Abstract $victim, $immune = array()) {
    if (!is_array($immune)) {
      throw new Exception("Immune list must be array that contains modifiers name");
    }

    $modifiersMessage = array();

    $attackSum = 0;
    $selfMutilation = 0;

    foreach ($this->_modifiers as $modifier) {
      if (!in_array($modifier->getType(), $immune)) {
        //unit is not immune to this modifier

        if ($modifier->getType() == Modifiers_Abstract::MODIFIER_TYPE_ATTACK) {
          //Modifier is of the attack type, it will add attack to the attacker

          $modifiersMessage[] = $this->setAttackMessage($victim, $modifier);

          //let's calculate the value of the attack with the attack modifiers
          $attackSum += $this->_owner->getAttack() * $modifier->getAttackModify();
        }
        if ($modifier->getType() == Modifiers_Abstract::MODIFIER_TYPE_SELF_MUTILATION) {
          //Modifications is of the selfMutilation type, so it will take additional damage for unit

          $modifiersMessage[] = $this->setMutilationMessage($victim, $modifier);

          //let's injure the unit with the selfMutilation
          $selfMutilation += $modifier->getSelfDamage();
        }

      } else {
        //Unit is immune to this modifier
        $modifiersMessage[] = $victim->getType() . " is immune to " . $modifier->getModifierName();
      }
    }

    //return the sum of the attack and selfMutilation, as well as the modifiers messages
    return array(
      'attackSum' => $attackSum,
      'selfMutilation' => $selfMutilation,
      'messages' => $modifiersMessage
    );
  }

  /**
   * create message of the attack modifier that will affect the unit
   * @param $victim
   * @param $modifier
   * @return string
   */
  private function setAttackMessage ($victim, $modifier) {

    return $victim->getType() . " took " . $modifier->getAttackModify() . "x extra damage" .
    " because enemy " . $this->_owner->getType() . " have " . $modifier->getModifierName();
  }

  /**
   * create message of the self mutilation modifier that will affect the unit
   * @param $victim
   * @param $modifier
   * @return string
   */
  private function setMutilationMessage ($victim, $modifier) {
    return $victim->getType() . " was affected by " . $modifier->getModifierName();
  }
}
