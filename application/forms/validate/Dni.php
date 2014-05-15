<?php  

class Form_Validate_Dni extends Zend_Validate_Abstract
{
        const DNI_TooShort = 'dniTooShort';
        const DNI_INVALID ="dniInvalid";
     
        protected $_messageTemplates = array(
            self::DNI_INVALID => "'%value%' es un dni no valid",
            self::DNI_TooShort=> "'%value%' no es un dni/nie"
        );
     
     
        public function isValid($cadena)
        {
            $value = (string) $cadena;
            $this->_setValue($value);
            
            if (strlen($cadena) != 9)
            {
                $this->_error(self::DNI_TooShort);
                return false;      
            }
            else {

            //Posibles valores para la letra final
            $valoresLetra = array(
                0 => 'T', 1 => 'R', 2 => 'W', 3 => 'A', 4 => 'G', 5 => 'M',
                6 => 'Y', 7 => 'F', 8 => 'P', 9 => 'D', 10 => 'X', 11 => 'B',
                12 => 'N', 13 => 'J', 14 => 'Z', 15 => 'S', 16 => 'Q', 17 => 'V',
                18 => 'L', 19 => 'H', 20 => 'C', 21 => 'K',22 => 'E'
            );

            //Comprobar si es un DNI
            if (preg_match('/^[0-9]{8}[A-Z]$/i', $cadena))
            {
                //Comprobar letra
                if (strtoupper($cadena[strlen($cadena) - 1]) !=
                    $valoresLetra[((int) substr($cadena, 0, strlen($cadena) - 1)) % 23])
                {
                    $this->_error(self::DNI_INVALID);
                    return false;
                }
                
                return true;
            }
            //Comprobar si es un NIE
            else if(preg_match('/^[XYZ][0-9]{7}[A-Z]$/i', $cadena))
            {
                //Comprobar letra
                if (strtoupper($cadena[strlen($cadena) - 1]) !=
                    $valoresLetra[((int) substr($cadena, 1, strlen($cadena) - 2)) % 23])
                {
                        $this->error(self::DNI_INVALID);
                        return false;
                }   

                //Todo fue bien
                return true;
            }
           }
            
        }
  }
?>
