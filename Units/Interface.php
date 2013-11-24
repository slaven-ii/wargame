<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/21/13
 * Time: 7:28 PM
 *
 * Interface for unit
 */

interface Units_Interface {

  /**
   * Main method for attacking, it takes enemy army as the argument, as well as callbacks for attack and
   * for attacked unit with the damage
   *
   * @param Army_Army $army
   * @param null $attackCallback
   * @param null $victimCallback
   * @return mixed
   */
  public function attack (Army_Army $army, $attackCallback = null, $victimCallback = null);

  /**
   * This method i called when the unit is under attack, i takes Actions_Attack object and it calculates
   * the damage taken
   * @param Actions_Attack $attack
   * @param null $callback
   * @return mixed
   */
  public function takeDamage (Actions_Attack $attack, $callback = null);

  public function isDead ();
}
