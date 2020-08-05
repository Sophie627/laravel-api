<?php

namespace App\Transformers;

class PassTransformer extends Transformer
{
    public function transform($pass)
    {
        return [
            'pid' => $pass['pid'],
            'psr' => $pass['psr'],
            'trg' => $pass['trg'],
            'loc' => $pass['loc'],
            'yds' => $pass['yds'],
            'comp' => $pass['comp'],
            'succ' => $pass['succ'],
            'spk' => $pass['spk'],
            'dfb' => trim($pass['dfb']),
        ];
    }
}
