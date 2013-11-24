<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/21/13
 * Time: 8:49 PM
 * Army is taking care of the whole army of units
 */
class Army_Army {

  /**
   * Array of the units in the army
   * @var array
   */
  private $_army = array();

  /**
   * The name of the army
   * @var
   */
  private $_name;

  public function __construct ($name) {
    $this->_name = $name;
  }

  public function getName () {
    return $this->_name;
  }

  /**
   * Let's create the random army with the size of the $armyCount
   * @param $armyCount
   */
  public function createArmy ($armyCount) {
    $this->_army = $this->generateRandomArmy($armyCount);
  }

  public function getArmy () {
    return $this->_army;
  }

  /**
   * Generate the army of the units
   * @param $count
   * @return array
   */
  private function generateRandomArmy ($count) {
    $myArmy = array();

    //randomly generate percentage of the tanks and generals in the army
    $tankspercent = mt_rand(10, 20);
    $generalPercent = mt_rand(10, 20);;

    //calculate exact number of the tanks, generals and soldiers
    $tanks = (int) ($count * ($tankspercent / 100));
    $generals = (int) ($count * ($generalPercent / 100));
    $soldiers = $count - ($tanks + $generals);

    $curtanks = 0;
    $curGeneral = 0;
    $cursoldiers = 0;

    //Todo inject unit from outside the army object in order to support new units
    //create tanks, soldiers and tanks unit
    //also set the dependency of AttributeManager to the unit
    for ($i = 1; $i <= $count; $i++) {

      if ($curtanks < $tanks) {
        $tank = new Units_Tank();
        $tank->setAttributeManager(new Modifiers_AttributeManager());
        $myArmy[] = $tank;
        $curtanks++;
      }

      if ($curGeneral < $generals) {
        $general = new Units_General();
        $general->setAttributeManager(new Modifiers_AttributeManager());
        $myArmy[] = $general;
        $curGeneral++;
      }

      if ($cursoldiers < $soldiers) {
        $cursoldiers++;

        $soldier = new Units_Soldier();
        $soldier->setAttributeManager(new Modifiers_AttributeManager());
        $myArmy[] = $soldier;
      }
    }

    //Everyday i'm shuffling :)
    //Let's mix the army a bit
    shuffle($myArmy);

    return $myArmy;
  }

  /**
   * remove the dead units from the array
   */
  public function removeDead () {
    foreach ($this->_army as $key => $unit) {

      if ($unit->isDead()) {
        unset($this->_army[$key]);
        $this->_army = array_values($this->_army);
      }
    }
  }


}
