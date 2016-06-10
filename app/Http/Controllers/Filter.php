<?php

namespace App\Http\Controllers;

class Filter
{
    /**
     * @param $array        {Object}    e.g. Category::find(1)->get();
     * @param $parameters   {Array}     parameters from Illuminate\Http\Request -> e.g. $request->all()
     */
    public function __construct($array, $parameters) {
        $this->globalArray = $array;
        $this->globalParameters = $parameters;
        $this->containedPivot = [];
        $this->usedPivots = [];
    }

    /**
     * get a specific eloquent from pivot based on parameters
     *
     * @param $keyword {String} - keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function getPivot($keyword) {
        $array = $this->globalArray;
        $parameters = $this->globalParameters;

        // no given params will return an empty array
        if (!isset($parameters[$keyword])) {
            return $this;
        }

        $array = $array->map(function($item) use ($parameters, $keyword) {

            if (empty($item)) return [];

            // sort and cast parameters
            foreach ($parameters[$keyword] as $count => $id) {
                $filter[] = (int) $id;
            }

            $result = $item->$keyword->whereIn('id', $filter);

            return $result;
        })
        ->reject(function($item) {
            return empty($item);
        })->values();

        $this->globalArray = $array;
        return $this;
    }

    /**
     * get a specific eloquent from pivot based on parameters
     *
     * @param $keyword {String} keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function getUsedPivots($keyword) {
        $cachedArray = $this->globalArray;
        $parameters = $this->globalParameters;
        $pivots = $this->getPivot($keyword)->getObject();

        // check if there is a pivot table and return the $keywords id
        foreach ($pivots as $pivot) {
            foreach($pivot as $item) {
                if (isset($item['pivot'][$keyword . '_id'])) {
                    $this->usedPivots[$keyword][] = ($item['pivot'][$keyword . '_id']);
                }
            }
        }

        if (isset($this->usedPivots[$keyword])) {
            // remove duplicates of $usedPivots
            $this->usedPivots[$keyword] = array_unique($this->usedPivots[$keyword], SORT_REGULAR);
        }

        // reset globalArray back to cached array
        $this->globalArray = $cachedArray;
        return $this;
    }

    /**
     * filter eloquents based on parameters
     *
     * @param $keyword {String} keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function byParameters($keyword) {
        $array = $this->globalArray;
        $arraycached = $this->globalArray;
        $parameters = $this->globalParameters;

        // no given params will return an empty array
        if (!isset($parameters[$keyword])) {
            return $this;
        }


        // sort and cast parameters
        foreach ($parameters[$keyword] as $count => $id) {
            $filteredParams[] = (int) $id;
        }

        // filter part - filters elements by id in added foreign table named $keyword
        // e.g. filters Category::with('job')
        $array = $array->map(function($item) use ($filteredParams, $keyword) {

            if (empty($item)) return [];

            if (isset($item[$keyword . '_id'])) {
                // check for belongsTo and hasOne relation
                foreach ($filteredParams as $p) {
                    if ((int)$item[$keyword . '_id'] === $p) {
                        // return [];
                        return $item;
                    }
                }

            } else {
                // check for ManyToMany
                foreach ($item->$keyword as $key) {
                    foreach ($filteredParams as $p) {
                        if ((int)$key->id === $p) {
                            return $item;
                        }
                    }
                }
            }

            // var_dump($item);
            return [];
        })
        ->reject(function($item) {
            return empty($item);
        })
        ->values();

        $this->globalArray = $array;
        return $this;
    }

    /**
     * $keyword should be the same name as the method in the specific model with relations
     *
     * @param $keyword {String} keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function saveToPivot($keyword) {
        $array = $this->globalArray;
        $parameters = $this->globalParameters;

        if (!isset($parameters[$keyword])) {
            return $this;
        } 

        foreach ($parameters[$keyword] as $p) {
            $array->$keyword()->attach((int)$p);
        }

        $this->globalArray = $array;
        return $this;
    }

    /**
     * delete an existing pivot
     *
     * @param $keyword {String} keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function deleteFromPivot($keyword) {
        $array = $this->globalArray;
        $parameters = $this->globalParameters;

        if (!isset($parameters[$keyword . '_unset'])) {
            return $this;
        } 

        foreach ($parameters[$keyword . '_unset'] as $p) {
            $array->$keyword()->detach((int)$p);
        }

        $this->globalArray = $array;
        return $this;
    }

    /**
     * prepare the parameters for update the pivot
     *
     * @param $keyword {String} keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function prepareParameterForPivotUpdate($keyword) {
        $parameters = $this->globalParameters;
        // todo filter which pivots exist
        $idToDelete = $this
            ->getUsedPivots($keyword)
            ->usedPivots;

        if (!isset($parameters[$keyword])) return $this;

        // sort and cast parameters
        foreach ($parameters[$keyword] as $count => $item) {
            $filteredParams[] = (int) $item;
        }

        // adds values from $parameters[$keyword] which are not used in $idToDelete
        $idToAdd = array_filter($parameters[$keyword], function ($item) use ($idToDelete, $keyword) {

            if (!isset($idToDelete[$keyword])) return true;

            foreach ($idToDelete[$keyword] as $del) {
                if ((int)$item == (int)$del) {
                    return false;
                }   
            }

            return true;
        });

        // set own parameter for deleteFromPivot
        if (isset($idToDelete[$keyword])) {
            $this->globalParameters[$keyword . '_unset'] = array_unique($idToDelete[$keyword]);
        }

        $this->globalParameters[$keyword] = array_unique($idToAdd);

        return $this;
    }

    public function updatePivot($keyword) { 
        $this->saveToPivot($keyword);
        $this->deleteFromPivot($keyword);

        return $this;
    }

    /**
     * same as byParameters but reset globalArray and
     * add match into new array $this->containedPivot
     *
     * @param $keyword {String} keyword in the GET request -> ?job[]=2&job[]=1
     *
     * @return $this
     */
    public function byUsedPivots($keyword) {
        $array = $this->globalArray;
        $cachedArray = $this->globalArray;
        $parameters = $this->globalParameters;

        // no given params will return an empty array
        if (!isset($parameters[$keyword])) {
            return $this;
        }

        // sort and cast parameters
        foreach ($parameters[$keyword] as $count => $item) {
            $filteredParams[] = (int) $item;
        }

        // sort part - sorts by 
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


        $this->globalArray = $cachedArray;
        $this->containedPivot[] = $array;
        return $this;
    }

    /**
     * usage in combination with byUsedPivots()
     * checks for found pivot tables
     *
     * @return {Boolean} if in $this->containedPivot are values
     */
    public function isUsedByPivots() {

        // based on byUsedPivots generated $containedPivot 
        // it will check if there is a ID found by
        // the given parameters
        foreach ($this->containedPivot as $item) {
            foreach ($item as $i) {
                if (count($i) === 1) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * returns the array of the Illuminate\Database\Eloquent\Collection object
     *
     * @return {Array}
     */
    public function getArray() {
        return $this->globalArray->toArray();
    }

    /**
     * returns full Illuminate\Database\Eloquent\Collection object
     *
     * @return Illuminate\Database\Eloquent\Collection {Object}
     */
    public function getObject() {
        return $this->globalArray;
    }
}
