<?php

namespace Jackweinbender\LaravelJsonapi\Tests;

use Jackweinbender\LaravelJsonapi\JsonApiModelAbstract;

class ItemStub extends JsonApiModelAbstract {

  public function resourceObject(){
    return  array (
      'id' => 999,
      'type' => 'itemstub',
      'attributes' => array(
        'one' => 1,
        'two' => 2,
      ),
    );
  }

}
