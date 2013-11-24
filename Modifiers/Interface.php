<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 6:07 PM
 * Modifiers Interface that will be implemented in all modifiers that should modify unit's attack of health
 */
interface Modifiers_Interface {

  /**
   * method that will return the value of the attack modify
   * @return int
   */
  public function getAttackModify ();

  /**
   * method that will return the value that unit unit should take on itself
   * @return int
   */
  public function getSelfDamage ();

  /**
   * get type of the modifier
   * @return string
   */
  public function getType ();

  /**
   * method that will return if the modifier is on
   *
   * @return bool
   */
  public function isOn ();
}
