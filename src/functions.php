<?php


/**
 * @param array $data
 * @return Validator
 */
function v(array $data = []): Validator
{
    $v = new Validator();
    
    foreach ($data as $name => $datum)
    {
        $v->add($name, $datum[0], $datum[1] ?? false);
    }
    
    return $v;
}
