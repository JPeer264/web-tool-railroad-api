<?php 

namespace App\Http\Controllers;

class Filter
{   

    public function __construct($array) {
        $this->globalarray = $array;
    }
    /**
     * get a specific eloquent from pivot based on parameters
     *
     * @param $array        {Object}    e.g. Category::find(1)->get();
     * @param $parameters   {Array}     parameters from Illuminate\Http\Request -> e.g. $request->all()
     * @param $keyword      {String}    keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $array {Array} - filtered array based on parameters
     */
    public function getPivot($parameters, $keyword) {
        $array = $this->globalarray;

        // no given params will return an empty array
        if (!isset($parameters[$keyword])) {
            $this->globalarray = $array->reject(function() {
                return false;
            });

            return $this;
        }

        $array = $array->map(function($item) use ($parameters, $keyword) {

            if (empty($item)) return [];

            // sort and cast parameters
            foreach ($parameters[$keyword] as $id) {
                $filter[] = (int) $id;
            }

            $result = $item->$keyword->whereIn('id', $filter); 

            return $result;
        });

        $this->globalarray = $array;
        return $this;
    }


    /**
     * filter eloquents based on parameters
     *
     * @param $array        {Object}    e.g. Category::find(1)->get();
     * @param $parameters   {Array}     parameters from Illuminate\Http\Request -> e.g. $request->all()
     * @param $keyword      {String}    keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $array {Array} - filtered array based on parameters
     */
    public function byParameters($parameters, $keyword) {
        $array = $this->globalarray;


        // no given params will return an empty array
        if (!isset($parameters[$keyword])) {
            $this->globalarray = $array->reject(function() {
                return false;
            });

            return $this;
        }

        // sort and cast parameters
        foreach ($parameters[$keyword] as $id) {
            $filteredParams[] = (int) $id;
        }

        $array = $array->map(function($item) use ($filteredParams, $keyword) {

            if (empty($item)) return [];

            foreach ($item->$keyword as $key) {
                foreach ($filteredParams as $p) {
                    if ((int)$key->id === $p) {
                        return $item;
                    }
                }
            }

            return [];
        });

        // todo remove empty arrays
        // problem -> when removing with ->inject then it will change from array to object 
        $this->globalarray = $array;
        return $this;
    }

    /**
     * returns the 
     */
    public function getArray() {
        return $this->globalarray;
    }
}
