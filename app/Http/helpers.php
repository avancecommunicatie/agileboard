<?php

if (! function_exists('collectionToSelect')) {
    function collectionToSelect($collection, $addEmpty = false, $value = 'name', $key = 'id'){
        if(is_object($collection)){
            $array = (array_combine($collection->lists($key)->toArray(), $collection->lists($value)->toArray()));
            if($addEmpty) {
                $array = array(0 => 'Geen') + $array;
            }
            return $array;
        }
        return false;
    }
}
