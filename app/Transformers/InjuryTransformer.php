<?php

namespace App\Transformers;

class InjuryTransformer extends Transformer
{
    public function transform($injury)
    {
        return [
            'uid' => $injury['uid'],
            'gid' => $injury['gid'],
            'player' => $injury['player'],
            'team' => $injury['team'],
            'details' => $injury['details'],
            'pstat' => $injury['pstat'],
            'gstat' => trim($injury['gstat']),
        ];
    }
}
