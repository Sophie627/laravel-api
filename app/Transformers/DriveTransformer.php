<?php

namespace App\Transformers;

class DriveTransformer extends Transformer
{
    public function transform($drive)
    {
        return [
            'uid' => $drive['uid'],
            'gid' => $drive['gid'],
            'fpid' => $drive['fpid'],
            'tname' => $drive['tname'],
            'drvn' => $drive['drvn'],
            'obt' => $drive['obt'],
            'qtr' => $drive['qtr'],
            'min' => $drive['min'],
            'sec' => $drive['sec'],
            'yfog' => $drive['yfog'],
            'plays' => $drive['plays'],
            'succ' => $drive['succ'],
            'rfd' => $drive['rfd'],
            'pfd' => $drive['pfd'],
            'ofd' => $drive['ofd'],
            'ry' => $drive['ry'],
            'ra' => $drive['ra'],
            'py' => $drive['py'],
            'pa' => $drive['pa'],
            'pc' => $drive['pc'],
            'peyf' => $drive['peyf'],
            'peya' => $drive['peya'],
            'net' => $drive['net'],
            'res' => trim($drive['res']),
        ];
    }
}
