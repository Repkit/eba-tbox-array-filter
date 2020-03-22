<?php

namespace TBoxArrayFilter;

use TBoxArrayFilter\Services\ArrayFilterCondition;


class ArrayFilter implements Interfaces\FilterInterface
{

    /**
     *
     * @var array that contains fields of the element that need to be sorted ex for Hotel array('Stars' => array(1,2,3)) or array('Type'=>'Hotel')
     */
    public $FilterData = array ();

    /**
     *
     * @var bool true-include all that have fields set as filter
     *          false-exclude all that have fields set as filter
     */
    public $Method = true;
    
    public $SortType = null;
    
    public $SortOrder = null;
    
    public function Apply(array $Array)
    {        
        $method = $this->Method;

        foreach ($this->FilterData as $filter)
        {
            if( !isset($filter['name']) || empty($filter['name']) ){
                continue;
            }
            if( !isset($filter['term']) ){
                continue;
            }
            $field = $filter['name'];
            $term = $filter['term'];
            if( isset($filter['type']) && !empty($filter['type']) )
            {
                $type = $filter['type'];
            }
            else
            {
              $type = 'equal';  
            }

            $new_array = $this->ArrayFilterCustom($Array,
                function($obj) use ($field,$type,$term,$method) {
                    if(isset($obj[$field]))
                    {
                        $value = $obj[$field];
                        $arrayFilterCondition = new ArrayFilterCondition();
                        $arrayFilterCondition->setValue($value)
                                             ->setTerm($term);
                        if ($arrayFilterCondition->evaluate($type)) {
                            return $method;
                        }
                    }
                    return ! $method;
                });
            $Array = $new_array;
        }
        
        return $Array;
    }
    private function ArrayFilterCustom($Array,$Callback)
    {
        
        $newArray = array();
        $sort = false;
        if(isset($this->SortType) && !empty($this->SortType) && isset($this->SortOrder) && !empty($this->SortOrder))
        {
            $sort = true;
        }
        foreach($Array as $value)
        {
                if(call_user_func($Callback, $value) == $this->Method)
                {
                    if($sort && !empty($newArray))
                    {
                        $newArray = $this->addValue($newArray, $value);
                    }
                    else
                    {
                         $newArray[] = $value;
                    }
                }
        }
        return $newArray;
    }
    private function addValue($Array,$Value)
    {
        $array = $Array;
        $startIndex = 0;
        $stopIndex = count($array) - 1;
        $middle = 0;
        
        while ($startIndex < $stopIndex)
        {
            $middle = floor(($stopIndex + $startIndex) / 2);
            if($this->SortOrder != 'desc')
            {
                if (intval($Value[$this->SortType]) < intval($array[$middle][$this->SortType]))
                {
                    $stopIndex = $middle - 1;
                }
                else
                {
                    $startIndex = $middle + 1;
                }
            }
            else
            {
                if (intval($Value[$this->SortType]) > intval($array[$middle][$this->SortType]))
                {
                    $stopIndex = $middle - 1;
                }
                else
                {
                    $startIndex = $middle + 1;
                }
            }
        }
        
        if($this->SortOrder != 'desc')
        {
            $offset = intval($Value[$this->SortType]) <=  intval($array[$startIndex][$this->SortType]) ? $startIndex : $startIndex + 1;
        }
        else
        {
             $offset = intval($Value[$this->SortType]) >=  intval($array[$startIndex][$this->SortType]) ? $startIndex : $startIndex + 1;
        }
        
        array_splice($array, $offset, 0, array($Value));

        return $array;
    }
}
