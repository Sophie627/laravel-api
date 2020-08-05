<?php

namespace App\Transformers;

class Pass2Transformer extends Transformer
{
    public function transform($pass)
    {
        return [
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
