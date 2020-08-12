<?php

namespace App\Services;

class ArrayService
{
    /**
     * Analogous to Javascript's Object.entries
     *
     * @param array $arr
     * @return array
     */
    public function entries(array $arr) : array
    {
        return \array_reduce(
            \array_keys($arr),
            function($entries, $key) use ($arr) {
                $entries[] = [
                    $key,
                    \is_array($arr[$key])
                        ? $this->entries($arr[$key])
                        : $arr[$key]
                ];
                return $entries;
            },
            []
        );
    }
}
