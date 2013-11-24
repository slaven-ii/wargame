<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/21/13
 * Time: 7:30 PM
 *
 * Abstract class for Units, all units must inherit this class
 */

abstract class Units_Abstract implements Units_Interface {

  /**
   * Unit current health
   * @var
   */
  protected $_health;
  /**
   * Attack power of the unit
   * @var
   */
  protected $_attack;
  /**
   * Type of the unit
   * @var
   */
  protected $_type;

  /**
   * Manager for the unit attributes (attack or health modifiers)
   * @var
   */
  protected $_attributeManager;


  /**
   * Dependency injection for the Attribute manager
   * @param Modifiers_AttributeManager $manager
   */
  public function setAttributeManager (Modifiers_AttributeManager $manager) {
    $this->_attributeManager = $manager;
  }

  /**
   * Setter for the attribute modifier
   * @param Modifiers_Interface $modifier
   */
  public function addModifier (Modifiers_Interface $modifier) {
    $this->_attributeManager->addModifier($modifier, $this);
  }

  /**
   * Get unit attribute manager
   * @return Modifiers_AttributeManager
   */
  public function getAttributeManager () {
    return $this->_attributeManager;
  }

  /**
   * Get unit attack power
   * @return int
   */
  public function getAttack () {
    return $this->_attack;
  }

  /**
   * Get unit type
   * @return string
   */
  public function getType () {
    return $this->_type;
  }

  /**
   * Get current unit health
   * @return int
   */
  public function getHealth () {
    return $this->_health;
  }

  /**
   * If health is 0 or less the unit is dead
   * @return bool
   */
  public function isDead () {

    if ($this->_health <= 0) {
      return true;
    }

    return false;
  }

  /**
   * The attack() and takeDamage() functions defined in interface take callback
   * check if the callback is valid function that could be called
   * @param $callback
   * @return bool
   */
  protected function isCallbackValid ($callback) {
    if (isset($callback)) {
      if (is_callable($callback)) {
        return true;
      }
    }

    return false;
  }


}
