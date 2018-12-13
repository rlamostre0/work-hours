<?php
function getTotalHours($data){
  $total=0;
  $previousDay='';
  $dayTotal=0;
  foreach($data as $d){
    if($d['type']=='in'){
      $previousDay=$d['created_at'];
    }else if($d['type']=='out'){
      $total += getDiff($previousDay,$d['created_at']);
      $previousDay='';
    }
  }
  if($previousDay!=''){
    $total += getDiff($previousDay,'now');
    $previousDay='';
  }
  return getFormattedTime($total);
}
function getDiff($from,$to){
  $datetime1 = new DateTime($from);
  $datetime2 = new DateTime($to);
  return getTimeInSeconds($datetime1->diff($datetime2));
}
function getTimeInSeconds($obj){
  $obj=json_decode(json_encode($obj),true);
  $total=floatval(0);
  if($obj['d']>0){
    $total+=((floatval($obj['d'])*24)*60)*60;
  }
  if($obj['h']>0){
    $total+=(floatval($obj['h'])*60)*60;
  }
  if($obj['i']>0){
    $total+=floatval($obj['i'])*60;
  }
  if($obj['s']>0){
    $total+=floatval($obj['s']);
  }
  return $total;
}
function getFormattedTime($obj){
  $total=($obj/60)/60;
  $h=floor ( $total );
  $i=($total-$h)*60;
  if((string)$i==(string)60){
    $i=0;
    $h++;
  }
  $s=($i-floor($i))*60;
  if((string)$s==(string)60){
    $s=0;
    $i++;
  }
  return formatLeadDigit(floor($h)).':'.formatLeadDigit(floor($i)).':'.formatLeadDigit(floor($s));
}
function formatLeadDigit($d){
  return ($d<floatval(10)?'0'.$d:$d);
}

getTotalHours([
    [
      'id'=>1,
      'type'=>'in',
      'created_at'=>'2018-12-12 15:42:36',
    ],
    [
      'id'=>2,
      'type'=>'out',
      'created_at'=>'2018-12-12 16:53:40',
    ],
    [
      'id'=>3,
      'type'=>'in',
      'created_at'=>'2018-12-13 01:00:00',
    ]
]);
