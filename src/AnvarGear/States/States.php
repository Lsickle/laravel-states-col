<?php

namespace AnvarGear\States;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{

    /**
     * @var string
     * Path to the directory containing states data.
     */
    protected $states = [];

    /**
     * @var string
     * The table for the countries in the database, is "departaments" by default.
     */
    protected $table;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->table = \Config::get('colombia.table_departament');
    }


    /**
     * Get the states from the JSON file, if it hasn't already been loaded.
     *
     * @return array
     */
    protected function getStates()
    {
        //Get the states from the JSON file
        if (sizeof($this->states) == 0) {
            $this->states = json_decode(file_get_contents(__DIR__ . '/Models/states.json'), true);
        }
        //Return the states
        return $this->states;
    }

    /**
     * Returns one state
     *
     * @param string $id The state id
     *
     * @return array
     */
    public function getOne($id)
    {
        $states = $this->getStates();
        return $states[$id];
    }


    /**
     * Returns a list of states
     *
     * @param string sort
     *
     * @return array
     */
    public function getList($sort = null)
    {
        //Get the states list
        $states = $this->getStates();

        //Sorting
        $validSorts = [
            'name',
            'iso_3166_3',
            'capital',
            'dane_code',
            'region',
        ];

        if (! is_null($sort) && in_array($sort, $validSorts)) {
            uasort($states, function ($a, $b) use ($sort) {
                if (!isset($a[$sort]) && !isset($b[$sort])) {
                    return 0;
                } elseif (!isset($a[$sort])) {
                    return -1;
                } elseif (!isset($b[$sort])) {
                    return 1;
                } else {
                    return strcasecmp($a[$sort], $b[$sort]);
                }
            });
        }

        //Return the states
        return $states;
    }

    /**
     * Returns a list of countries suitable to use with a select element in Laravelcollective\html
     * Will show the value and sort by the column specified in the display attribute
     *
     * @param string display
     *
     * @return array
     */
    public function getListForSelect($display = 'name')
    {
        foreach ($this->getList($display) as $key => $value) {
            $states[$key] = $value[$display];
        }
        //return the array
        return $states;
    }
}