<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/21/13
 * Time: 7:27 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
 * Auto load classes
 */
function __autoload ($class_name) {
  $classpath = str_replace("_", DIRECTORY_SEPARATOR, $class_name);
  require_once($classpath . ".php");
}

/**
 * War is our main class for gameplay
 */
$war = new War();

/**
 * Let's create some random army
 * we can add multiple armies
 */
$foundArmies = 0;
foreach($_GET as $key => $armyCount){
    if(strpos($key, 'army' ) !==false){
      $foundArmies++;

      // we have some army, let's create the units
      $armyVariable = $key;
      $armyvariable = new Army_Army($key);
      $armyvariable->createArmy($armyCount);

      /**
       * add armies to the war
       */
      $war->setArmy($armyvariable);
    }


}

if($foundArmies < 2) {
  die('We need at least two armies, you can send armies with get method like: ?army1=50&army2=55');
}
/**
 * we can display log from the battle
 * set showLogsInHtml to true in order to get nice logs in browser
 * and set it to false if running the script from console
 */

$war->showLogs(true);
$war->showLogsInHtml(true);

/**
 * Let's start the war
 */
$winner = $war->startWar();


/**
 * Display winner and his stats
 */
echo $winner->getName() . " army won in " . $war->getTurns() . " turns with " .
    count($winner->getArmy()) . " survivors \n";


