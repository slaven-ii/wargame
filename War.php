<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 4:32 PM
 *
 * War is handling the battle between multiple armies
 * it's handling logs and different scenarios knowns as modifiers
 */

class War {

  /**
   * array that is holding conflicted armies
   * @var array
   */
  private $_armies = array();

  /**
   * counter for the turn in the game
   * @var int
   */
  private $_turn = 0;

  /**
   * true when left with only one army
   * @var bool
   */
  private $_warEnded = false;

  /**
   * Army_Army object that represents the winning army
   * @var
   */
  private $_winnerArmy;

  /**
   * Show detailed logs of the battle
   * @var bool
   */
  private $_showLogs = false;

  /**
   * if true the logs will end with <br> for browser display
   * default if will add newline at the end of the log row
   * @var bool
   */
  private $_showLogsHtml = false;


  /**
   * Add the army to the war
   * @param Army_Army $army
   */
  public function setArmy (Army_Army $army) {
    array_push($this->_armies, $army);
  }

  /**
   * Start the war and return the winning army object
   * @return Army_Army
   */
  public function startWar () {
    while (!$this->_warEnded) {
      $this->startTurn();

    }

    return $this->_winnerArmy;
  }

  /**
   * Iterate through the attacking army and attack the defending army
   * when every unit attacks the defending army is attacking
   */
  private function startTurn () {
    //Randomly select the attacking and defending army
    $attackArmyKey = array_rand($this->_armies);
    $attackerArmy = $this->_armies[$attackArmyKey];

    //For the modifiers example we will fix them to 5 and 2 turn for activation
    if ($this->_turn == 2) {
      Modifiers_ModifierManager::applyModifierToArmy($attackerArmy, new Modifiers_Motivation());
    }

    if ($this->_turn == 3) {
      Modifiers_ModifierManager::applyModifierToArmy($attackerArmy, new Modifiers_Plague());
    }

    //we must make sure that the same army for attacking and defending won't be selected
    $defendingArmkey = function () use ($attackArmyKey) {
      while (true) {
        $key = array_rand($this->_armies);
        if ($key != $attackArmyKey) {
          return $key;
        }
      }
    };

    $defendingArmy = $this->_armies[$defendingArmkey()];

    $this->opposeArmies($attackerArmy, $defendingArmy);
    $this->opposeArmies($defendingArmy, $attackerArmy);

    $this->_turn++;
  }

  /**
   * Function that attacking the defending army with the attacking army
   * @param Army_Army $attack
   * @param Army_Army $defend
   */
  private function opposeArmies (Army_Army $attack, Army_Army $defend) {

    $log = new Log_Log();

    //callback for attacked unit
    //Show logs if they are turned on
    $victimCallback = function (Actions_Damage $damage, $modifiers) use ($log) {
      if ($this->_showLogs) {
        $log->addLog($damage, $modifiers, $this->_showLogsHtml);
      }

    };

    foreach ($attack->getArmy() as $soldierAttack) {
      $soldierAttack->attack($defend, null, $victimCallback);
      //let's remove the dead units from the army
      $defend->removeDead();

    }

    $this->checkWinner();
  }

  /**
   * We could have multiple armies
   * check if there is only one army that have live units
   */
  private function checkWinner () {
    $totalArmy = count($this->_armies);
    $fallenArmy = 0;

    foreach ($this->_armies as $army) {
      if (count($army->getArmy()) <= 0) {
        $fallenArmy++;

      } else {
        $surrvivedArmy = $army;
      }
    }

    if ($fallenArmy == ($totalArmy - 1)) {
      $this->_warEnded = true;
      $this->_winnerArmy = $surrvivedArmy;
    }
  }

  public function getTurns () {
    return $this->_turn;
  }

  public function showLogs ($logs, $html = false) {
    $this->_showLogs = $logs;
    $this->_showLogsHtml = $html;
  }

  public function showLogsInHtml ($html) {
    $this->_showLogsHtml = $html;
  }


}
