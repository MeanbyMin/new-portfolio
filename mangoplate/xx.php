<?php
$sessionid = session_id();
    $r_idx = $_GET['r_idx'];
    $newRecord = "";

    //숙소상세보기를 한번이라도 했다면
    if(isset($_COOKIE[$sessionid])){
        //이전에 조회한 숙소
        $record = $_COOKIE[$sessionid];
        $recoredArr =  explode(',', $record);
        $isNewRecord = true;
        //지금 조회한 숙소가 전에 조회했던적이 있는지 검사
        foreach($recoredArr as $r){
            if($r_idx == $r){
                $isNewRecord = false;
            }
        }

        //이전에 조회한적 없다면
        if($isNewRecord){
            //이전 조회숙소에 새로운 조회 숙소 추가
            $newRecord = $record.','.$r_idx;
        }else{
            $newRecord = $record;
        }
        
    //숙소 상세보기를 한번도 하지 않았다면
    }else{
        $newRecord = $r_idx;
    }

    setcookie($sessionid, $newRecord, time() + (60*60*24), "/"); 
    ?>