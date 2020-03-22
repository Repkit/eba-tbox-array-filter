<?php

namespace TBoxArrayFilter\Interfaces;

interface FilterInterface
{
	/**
     * Retrieve filtered collections
     *
     * @return array|bool
     *   Filtered collection array or false in case filter data is not valid
     */
    public function Apply(array $Array);

}
