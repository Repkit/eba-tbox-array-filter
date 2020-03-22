<?php
namespace TBoxArrayFilter\Tests;

use TBoxArrayFilter\Services\ArrayFilterCondition;


class ArrayFilterConditionTest
{
    public function __construct() {
    }
    
    public function run()
    {
        $classMethods = get_class_methods($this);
        foreach ($classMethods as $method) {
            if (strpos($method, 'test') === 0) {
                echo $method . ' ' . ($this->$method() ? 'OK' : 'Failed') . "\n";
            }
        }
    }
    
    public function testLike()
    {
        $arrayFilterCondition = new ArrayFilterCondition();
        
        $arrayFilterCondition->setTerm('bcd')
                             ->setValue('ABcd');
        $test1 = $arrayFilterCondition->evaluate('like') === TRUE;
        
        $arrayFilterCondition->setTerm('bcd')
                             ->setValue('ABc');
        $test2 = $arrayFilterCondition->evaluate('like') === FALSE;
        
        $arrayFilterCondition->setTerm('abcd')
                             ->setValue('ABCD');
        $test3 = $arrayFilterCondition->evaluate('like') === TRUE;
        
        $arrayFilterCondition->setTerm('abc')
                             ->setValue('aBCD');
        $test4 = $arrayFilterCondition->evaluate('like') === TRUE;
        
        return $test1 && $test2 && $test3 && $test4;
    }
    
    public function testStartsWith()
    {
        $arrayFilterCondition = new ArrayFilterCondition();
        
        $arrayFilterCondition->setTerm('ab')
                             ->setValue('ABc');
        $test1 = $arrayFilterCondition->evaluate('startsWith') === TRUE;

        $arrayFilterCondition->setTerm('abcD')
                             ->setValue('ABc');
        $test2 = $arrayFilterCondition->evaluate('startsWith') === FALSE;

        $arrayFilterCondition->setTerm('bc')
                             ->setValue('ABc');
        $test3 = $arrayFilterCondition->evaluate('startsWith') === FALSE;
        
        return $test1 && $test2 && $test3;
    }
    
    public function testEndsWith()
    {
        $arrayFilterCondition = new ArrayFilterCondition();
        
        $arrayFilterCondition->setTerm('bc')
                             ->setValue('ABc');
        $test1 = $arrayFilterCondition->evaluate('endsWith') === TRUE;

        $arrayFilterCondition->setTerm('aabc')
                             ->setValue('ABc');
        $test2 = $arrayFilterCondition->evaluate('endsWith') === FALSE;

        $arrayFilterCondition->setTerm('ab')
                             ->setValue('ABc');
        $test3 = $arrayFilterCondition->evaluate('endsWith') === FALSE;
        
        return $test1 && $test2 && $test3;
    }
    
    public function testContains()
    {
        $arrayFilterCondition = new ArrayFilterCondition();
        
        $arrayFilterCondition->setTerm('bcd')
                             ->setValue('ABcd');
        $test1 = $arrayFilterCondition->evaluate('contains') === TRUE;
        
        $arrayFilterCondition->setTerm('bcd')
                             ->setValue('ABc');
        $test2 = $arrayFilterCondition->evaluate('contains') === FALSE;
        
        $arrayFilterCondition->setTerm('abcd')
                             ->setValue('ABCD');
        $test3 = $arrayFilterCondition->evaluate('contains') === TRUE;
        
        $arrayFilterCondition->setTerm('abc')
                             ->setValue('aBCD');
        $test4 = $arrayFilterCondition->evaluate('contains') === TRUE;
        
        return $test1 && $test2 && $test3 && $test4;
    }
}