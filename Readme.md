ArrayFilter
===================

Array filter using trip standard. 

Installation
------------

* copy files to your project
* include files from src directory or use the autoloader generated by composer
* use it as described below


Usage
-----

```php
<?php
require '../vendor/autoload.php';

use TBoxArrayFilter\ArrayFilter;

$arrayFilter = new ArrayFilter();
$arrayFilter->SortType = 'Timestamp';
$arrayFilter->SortOrder = 'desc';
$arrayFilter->FilterData = array(
	array(
		'name' => 'Status',
		'term' => 1
	),
);
$filteredOrders = $arrayFilter->Apply($orders);


```
    

