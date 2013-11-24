<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slaven
 * Date: 11/24/13
 * Time: 8:25 PM
 *
 * Modifiers Plague is modifier that will infect the unit and take the $_selfMutilation damage from the unit that
 * have it
 */
class Modifiers_Plague extends Modifiers_Abstract {

  const NAME = 'Plague';
  private $_type = '';
  protected $_selfMutilation = 500;

  public function __construct () {
    $this->_type = Modifiers_Abstract::MODIFIER_TYPE_SELF_MUTILATION;
  }

  public function getModifierName () {
    return self::NAME;
  }

  public function getType () {
    return $this->_type;
  }
}
