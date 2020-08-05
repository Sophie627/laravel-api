<?php

namespace App\Transformers;

class KickerTransformer extends Transformer
{
    public function transform($kicker)
    {
        return [
            'uid' => $kicker['uid'],
            'gid' => $kicker['gid'],
            'player' => $kicker['player'],
            'pat' => $kicker['pat'],
            'fgs' => $kicker['fgs'],
            'fgm' => $kicker['fgm'],
            'fgl' => $kicker['fgl'],
            'fp' => $kicker['fp'],
            'game' => $kicker['game'],
            'seas' => $kicker['seas'],
            'year' => $kicker['year'],
            'team' => trim($kicker['team']),
        ];
    }
}
