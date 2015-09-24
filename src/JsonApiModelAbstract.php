<?php

namespace Jackweinbender\LaravelJsonapi;

use Illuminate\Database\Eloquent\Model;
use \ReflectionClass;

abstract class JsonApiModelAbstract extends Model implements JsonApiModelInterface
{

  /**
   * The 'type' property for the JSON API response object. According to
   * the spec, all objects need them. You can set this manually, or
   * use the sensible default of a lowercase version of the
   * class name in lowercase
   *
   * @var String
   */
  protected $modelType;
  protected $modelId;
  /**
   * Returns attribute array from parent getAttribute function
   * Child class should override to include cast properties
   *
   * @return Array of attributes
   */
  public function attributes(){

    return $this->getAttributes();

  }

  /**
   * Returns the Model as a resource Object.
   *
   * @return Array
   */
  public function resourceObject(){
    return array(
      'id' => $this->getModelId(),
      'type' => $this->getModelType(),
      'attributes' => $this->attributes(),
    );
  }


  public function getModelId(){

    if(isset($this->modelId)){
      $id = $this->modelId;
      return $this->$id;
    }

    return $this->id;

  }
  /**
   * Returns the a reference ID object for the model
   *
   * @return Array
   */
  public function rid(){
    return array(
      'type' => $this->getModelType(),
      'id' => $this->getModelId(),
    );
  }


  /**
   * Returns an object
   * @return [type] [description]
   */
  public function includedObject(){
    return array(
       $this->getUniqueKey() => $this->resourceObject(),
    );
  }

  /**
   * Generates a unique ID based on the model type and its DB key
   * This allows multiple models to reference the same related
   * obect without duplicating it in the payload.
   *
   * @return String
   */
  public function getUniqueKey(){
    return $this->getmodelType() . $this->getModelId();
  }

  /**
   * Returns the modelType if already set, otherwise sets
   * the proerty and returns it
   *
   * @return String the class name as in lowercase
   */
  public function getModelType(){

    if(isset($this->modelType)){
      return $this->modelType;
    }

    return $this->setModelType();
  }

  /**
   * Sets the modelType property and returns its new value
   *
   * @return String the class name as in lowercase
   */
  protected function setModelType(){

    $this->modelType = $this->getClassName() . 's';

    return $this->modelType;

  }

  /**
   * Gets the class name via ReflectionClass::getShortName
   *
   * @return String the class name as in lowercase
   */
  protected function getClassName(){

    $modelClass = new ReflectionClass($this);

    return strtolower($modelClass->getShortName());
  }

}
