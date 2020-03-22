<?php
namespace TBoxArrayFilter\Services;


class ArrayFilterCondition
{
    private $_value = NULL;
    
    private $_term = NULL;
    
    
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }
    
    public function setTerm($term)
    {
        $this->_term = $term;
        return $this;
    }

    public function evaluate($type)
    {
        if (!method_exists($this, '_condition' . ucwords($type))) {
            throw new \Exception('Invalid Type parameter');
        }
        $fn = '_condition' . ucwords($type);
        return $this->$fn();
    }
    
    private function _conditionEqual()
    {
        if (is_array($this->_term)) {
            if (in_array($this->_value, $this->_term)) {
                return TRUE;
            }
        } else {
            if ($this->_term == $this->_value) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private function _conditionNotEqual()
    {
        if (is_array($this->_term)) {
            if (!in_array($this->_value, $this->_term)) {
                return TRUE;
            }
        } else {
            if ($this->_term != $this->_value) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private function _conditionLessThan()
    {
        return $this->_value < $this->_term;
    }
    
    private function _conditionGreaterThan()
    {
        return $this->_value > $this->_term;
    }
    
    private function _conditionLessThanOrEqual()
    {
        return $this->_value <= $this->_term;
    }
    
    private function _conditionGreaterThanOrEqual()
    {
        return $this->_value >= $this->_term;
    }
    
    private function _conditionLike()
    {
        $term = $this->_term;
        $term = '/' . str_replace('*', '.*', $term) . '/i';
        return (bool)preg_match($term, $this->_value);
    }
    
    private function _conditionNotLike()
    {
        $term = $this->_term;
        $term = '/' . str_replace('*', '.*',$term) . '/i';
        return (bool)(!preg_match($term, $this->_value));
    }
    
    private function _conditionBetween()
    {
        $term = $this->_term;
        if (is_array($term) && count($term) == 2) {
            $minValue = reset($term);
            $maxValue = end($term);
            if ($minValue <= $this->_value && $maxValue >= $this->_value) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private function _conditionStartsWith()
    {
        return stripos($this->_value, $this->_term) === 0;
    }
    
    private function _conditionEndsWith()
    {
        return strripos($this->_value, $this->_term) === strlen($this->_value) - strlen($this->_term);
    }

    private function _conditionContains()
    {
        return stripos($this->_value, $this->_term) !== FALSE;
    }
}
