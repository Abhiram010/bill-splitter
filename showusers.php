<?php
$l = [[1, -137], [2, -87], [3, 163], [4, 63]];
$from = [];
$to = [];
$totaldebt = 0;
foreach ($l as $value) {
    if ($value[1] < 0) {
        array_push($from, $value);
        $totaldebt = $totaldebt + $value[1];
    } else {
        array_push($to, $value);
    }
}


echo $totaldebt;
// var_dump($from);
// var_dump($to);
$counter = 0;
foreach ($from as $thevalue) {
    // var_dump($thevalue);
    while ($thevalue[1] <= 0) {
        $thevalue[1] = getDebt($thevalue, $to, $counter);

        if ($thevalue[1] > 0) {
        }
    }
    $counter = $counter + 1;
}


function getDebt($thevalue, $to, $counter)
{
    return $thevalue[1] + $to[$counter][1];
}



/*
get the all the values

The value will be sent nex if left
when subtracted save the user_id from and user_id to, amount


case 1 = 
100 -103 = -3
200 -103 = -97
10 -103 = -93


*/