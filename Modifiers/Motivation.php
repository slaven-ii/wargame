<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 6:07 PM
 *
 * Modifiers Motivation is modifier that will add the motivation to the unit and it will increase the attack of
 * the unit by the multiplication of the $_attackModify param
 */
class Modifiers_Motivation extends Modifiers_Abstract {

  const NAME = 'Motivation';
  private $_type = '';
  protected $_attackModify = 3;

  public function __construct () {
    $this->_type = Modifiers_Abstract::MODIFIER_TYPE_ATTACK;
  }

  public function getModifierName () {
    return self::NAME;
  }

  public function getType () {
    return $this->_type;
  }
}
