<?php

namespace App\Transformers;

class ChartTransformer extends Transformer
{
    public function transform($chart)
    {
        return [
            'gid' => $chart['gid'],
            'pid' => $chart['pid'],
            'detail' => $chart['detail'],
            'off' => $chart['off'],
            'def' => $chart['def'],
            'type' => $chart['type'],
            'qb' => $chart['qb'],
            'trg' => $chart['trg'],
            'bc' => $chart['bc'],
            'qtr' => $chart['qtr'],
            'los' => $chart['los'],
            'dwn' => $chart['dwn'],
            'ytg' => $chart['ytg'],
            'yfog' => $chart['yfog'],
            'zone' => $chart['zone'],
            'yds' => $chart['yds'],
            'succ' => $chart['succ'],
            'fd' => $chart['fd'],
            'sg' => $chart['sg'],
            'nh' => $chart['nh'],
            'comp' => $chart['comp'],
            'ints' => $chart['ints'],
            'back' => $chart['back'],
            'xlm' => $chart['xlm'],
            'mot' => $chart['mot'],
            'box' => $chart['box'],
            'boxdb' => $chart['boxdb'],
            'pap' => $chart['pap'],
            'trick' => $chart['trick'],
            'qbp' => $chart['qbp'],
            'qbhi' => $chart['qbhi'],
            'qbhu' => $chart['qbhu'],
            'qbru' => $chart['qbru'],
            'sneak' => $chart['sneak'],
            'scrm' => $chart['scrm'],
            'ttscrm' => $chart['ttscrm'],
            'htm' => $chart['htm'],
            'pru' => $chart['pru'],
            'blz' => $chart['blz'],
            'dblz' => $chart['dblz'],
            'spru' => $chart['spru'],
            'oop' => $chart['oop'],
            'oopd' => $chart['oopd'],
            'avt' => $chart['avt'],
            'dotr' => $chart['dotr'],
            'cov' => $chart['cov'],
            'phyb' => $chart['phyb'],
            'cnb' => $chart['cnb'],
            'cball' => $chart['cball'],
            'uball' => $chart['uball'],
            'shov' => $chart['shov'],
            'side' => $chart['side'],
            'high' => $chart['high'],
            'crr' => $chart['crr'],
            'intw' => $chart['intw'],
            'drp' => $chart['drp'],
            'avsk' => $chart['avsk'],
            'fread' => $chart['fread'],
            'scre' => $chart['scre'],
            'pfp' => $chart['pfp'],
            'mbt' => $chart['mbt'],
            'ttsk' => $chart['ttsk'],
            'ttpr' => $chart['ttpr'],
            'tay' => $chart['tay'],
            'dot' => $chart['dot'],
            'yac' => $chart['yac'],
            'yaco' => $chart['yaco'],
            'ytru' => $chart['ytru'],
            'covdis1' => $chart['covdis1'],
            'covdis2' => $chart['covdis2'],
            'defpr1' => $chart['defpr1'],
            'defpr2' => $chart['defpr2'],
            'defhi' => $chart['defhi'],
            'defhu1' => $chart['defhu1'],
            'defhu2' => trim($chart['defhu2']),
        ];
    }
}