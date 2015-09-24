<?php

namespace Jackweinbender\LaravelJsonapi;

use Illuminate\Database\Eloquent\Collection;

class JsonApi
{
    public $data;

    public $includedObjects;

    public $includes;

    public $meta;

    public function __construct(){

      $this->includedObjects = new Collection();
      $this->includes = [];

    }

    public function item(JsonApiModelAbstract $model){

      $this->data = $this->makeData($model);

      return $this;
    }

    public function collection(Collection $collection){

      $this->data = $collection->map(function($item){
        return $this->makeData($item);
      })->all();

      return $this;

    }

    /**
     * Sets the includes property to an array of includedObjects Models
     *
     * @param  Array  $includes
     * @return $this
     */
  public function includes(Array $includes){

      $this->includes = $includes;

      return $this;

    }

    /**
     * Runs a map function over the included collection yeilding
     * only unique results (to prevent payload duplication)
     * @return Array
     */
    public function makeIncludes(){
      return $this->includedObjects
        ->unique()
        ->map(function($model){
          return $model->resourceObject();
        });
    }

    public function send(){

      $response = array(
        'data' => $this->data,
        'meta' => $this->meta,
      );

      if(!$this->includedObjects->isEmpty()){
        $response['included'] = $this->makeIncludes();
      }

      return $response;

    }

    public function makeData(JsonApiModelAbstract $model){
      $item = $model->resourceObject();

      $relationships = $this->getRelationships($model);

      if($relationships){
        $item['relationships'] = $relationships;
      }

      return $item;

    }

    public function getRelationships($model){

      // Return false if there are no relationships
      if($model->getRelations() == []){ return false; }

      // Initialize relationships array
      $relationships = [];

      // Loop through relationships array
      foreach ($model->getRelations() as $relation => $related) {

        // Checks if relationship is a collection by determining if the
        // method 'isEmpty' exists on the object
        if(method_exists($related, 'isEmpty')){
          // If the key has no value (no related records returned), break;
          if($related->isEmpty()){ break; }

          // If the key is in the includes collection, merge the them
          if(in_array($relation, $this->includes)){
            $this->includedObjects = $this->includedObjects->merge($related);
          }

          // And set the relationship key and value
          $relationships[$relation]['data'] = $related->map(function($item){
            return $item->rid();
          });
        } else {
          if($related == NULL){ break; }

          // If the key is in the includes collection, merge the them
          if(in_array($relation, $this->includes)){
            $this->includedObjects = $this->includedObjects->push($related);
          }

          // And set the relationship key and value
          $relationships[$relation]['data'] = $related->rid();

        }

      }

      // If there still aren't any relationships, return false
      if($relationships == []){ return false; }

      // Otherwise return the relationships array
      return $relationships;

    }

}
