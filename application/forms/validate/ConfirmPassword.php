<?php
    class Form_Validate_ConfirmPassword extends Zend_Validate_Abstract
    {
        const NOT_MATCH = 'notMatch';
     
        protected $_messageTemplates = array(
            self::NOT_MATCH => 'La contrasenya no coincideix'
        );
     
        public function isValid($value, $context = null)
        {
            $value = (string) $value;
            $this->_setValue($value);
          
            
            if (is_array($context)) {
                if (!empty($context['conf_password']) && ($value == $context['conf_password']))
                {
                    
                    return true;
                }
            } elseif (is_string($context) && ($value == $context)) {
                return true;
            }
     
            $this->_error(self::NOT_MATCH);
            return false;
        }
    }
?>
