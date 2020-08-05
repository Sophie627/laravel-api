<?php

namespace App\Transformers;

class TouchdownTransformer extends Transformer
{
    public function transform($touchdown)
    {
        return [
            'pid' => $touchdown['pid'],
            'qtr' => $touchdown['qtr'],
            'min' => $touchdown['min'],
            'sec' => $touchdown['sec'],
            'dwn' => $touchdown['dwn'],
            'yds' => $touchdown['yds'],
            'pts' => $touchdown['pts'],
            'player' => $touchdown['player'],
            'type' => trim($touchdown['type']),
        ];
    }
}
