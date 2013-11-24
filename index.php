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
 * Let's create some random army
 * we can add multiple armies
 */
$usa = new Army_Army('U.S.A');
$usa->createArmy(100);

$russia = new Army_Army('Russia');
$russia->createArmy(120);

//$china = new Army_Army('China');
//$china->createArmy(140);

/**
 * War is our main class for gameplay
 */
$war = new War();

/**
 * we can display log from the battle
 * set showLogsInHtml to true in order to get nice logs in browser
 * and set it to false if running the script from console
 */
//$war->showLogs(true);
//$war->showLogsInHtml(true);

/**
 * add armies to the war
 */
$war->setArmy($usa);
$war->setArmy($russia);
//$war->setArmy($china);

/**
 * Let's start the war
 */
$winner = $war->startWar();


/**
 * Display winner and his stats
 */
echo $winner->getName() . " army won in " . $war->getTurns() . " turns with " .
    count($winner->getArmy()) . " survivors \n";


