<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 8:33 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class Modifiers_Abstract implements Modifiers_Interface {

  /**
   * The attack modify value that will be multiplied with the unit attack
   * @var int
   */
  protected $_attackModify = 0;
  /**
   * Value that the unit should apply on itself
   * @var int
   */
  protected $_selfMutilation = 0;

  /**
   * Currently not supported
   * For tracking the modifier activation
   * some modifications could last only few turs
   * @var int
   */
  static $turn = 0;

  /**
   * constants for different modifiers types
   */
  const MODIFIER_TYPE_ATTACK = 'attack';
  const MODIFIER_TYPE_SELF_MUTILATION = 'selfMutilation';

  public function getAttackModify () {
    return $this->_attackModify;
  }

  public function getSelfDamage () {
    return $this->_selfMutilation;
  }

  public function isOn () {
    if (self::$turn <= $this->_last) {
      return true;
    }

    return false;
  }

}
