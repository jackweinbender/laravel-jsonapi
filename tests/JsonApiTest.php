<?php

namespace Jackweinbender\LaravelJsonapi\Tests;

use Jackweinbender\LaravelJsonapi\JsonApi;
use Jackweinbender\LaravelJsonapi\Tests\ItemStub;
use Illuminate\Database\Eloquent\Collection;

class JsonApiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testItemThrowsExceptionForNotItemd(){
      $jsonApi = new JsonApi();
      $jsonApi->item("Not Item Class");
    }
    public function testItemReturnsInstanceOfSelf(){
      $jsonApi = new JsonApi();
      $item = new ItemStub();

      $this->assertInstanceOf(get_class($jsonApi), $jsonApi->item($item));
    }
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCollectionThrowsExceptionForNotCollection(){
      $jsonApi = new JsonApi();
      $jsonApi->collection("Not Collection Class");
    }
    public function testCollectionReturnsInstanceOfSelf(){
      $jsonApi = new JsonApi();
      $collection = new Collection();

      $this->assertInstanceOf(get_class($jsonApi), $jsonApi->collection($collection));
    }
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testIncludesThrowsExceptionForNotArray(){
      $jsonApi = new JsonApi();
      $jsonApi->includes("Not Array");
    }
    public function testIncludesReturnsInstanceOfSelf(){
      $jsonApi = new JsonApi();
      $array = array();

      $this->assertInstanceOf(get_class($jsonApi), $jsonApi->includes($array));
    }
    public function testIncludesAssignsVariable(){
      $jsonApi = new JsonApi();
      $array = array(1, 2, 3);
      $jsonApi->includes($array);

      $this->assertEquals($array, $jsonApi->includes);
    }
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testMakeDataThrowsExceptionForNotJsonApiModelAbstract(){
      $jsonApi = new JsonApi();
      $jsonApi->makeData("Not JsonApiModelAbstract");
    }
    public function testMakeDataReturnsExpected(){
      $expected =  array (
        'id' => 999,
        'type' => 'itemstub',
        'attributes' => array(
          'one' => 1,
          'two' => 2,
        ),
      );

      $jsonApi = new JsonApi();
      $item = new ItemStub();

      $this->assertEquals($jsonApi->makeData($item), $expected);
    }
}
