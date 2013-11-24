<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 8:17 PM
 * Log class that is taking care of the displaying logs from the battle
 */
class Log_Log {

  /**
   * if html true the log will end with the <br> for browser support
   * if html is false the newline will be added
   * @param Actions_Damage $damage
   * @param $modifiers
   * @param $html
   */
  public function addLog (Actions_Damage $damage, $modifiers, $html) {
    $log = $damage->getVictim()->getType() . " take: " . $damage->getDamageTaken() . "dmg ";
    $log .= implode(", ", $modifiers['messages']);

    if ($damage->getVictim()->isDead()) {
      $log .= " " . $damage->getVictim()->getType() . " is dead!!";
    }

    if ($html) {
      $log .= "<br >";
    } else {
      $log .= "\n";
    }


    echo $log;
  }
}
