<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 7:13 PM
 * Modify manager is layer that will add the modifications to the army
 */
class Modifiers_ModifierManager {

  /**
   * Method will add the modifications to the army to random units
   * The scope of the affected units is defined with the $percent argument
   * @param Army_Army $army
   * @param Modifiers_Interface $modifier
   * @param int $percent
   */
  static function applyModifierToArmy (Army_Army $army, Modifiers_Interface $modifier, $percent = 20) {
    $armyArray = $army->getArmy();
    $armyCount = count($armyArray);
    $applyToUnits = $armyCount * ($percent / 100);

    for ($i = 0; $i < $applyToUnits; $i++) {
      $key = array_rand($armyArray);
      $unit = $armyArray[$key];
      $unit->addModifier($modifier);
    }
  }
}
