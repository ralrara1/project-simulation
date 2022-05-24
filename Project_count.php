<?php
    $host = "localhost";
    $user = "root";
    $passwd = "";


    $connect = mysqli_connect($host, $user, $passwd) or die("mysql서버 접속 에러");
    mysqli_select_db($connect, 'apm_db') or die("DB 접속 에러");

    $YY = date('Y');
    $MM = date('m');
    $DD = date('d');
    $dat = $YY."-".$MM."-".$DD;


    $sql = "select * from count_table where redate = '$dat' ";
    $result = mysqli_query($connect, $sql);
    $list = mysqli_num_rows($result);


    if(!$list) {
        $count = 0;
    } else {
        $row = mysqli_fetch_array($result);
        $count = $row['cnt'];
    }


    if($count == 0) {
        $count++;
        $to_sql = "insert into count_table (cnt, redate) values ($count, '$dat')";
    } else {
        $count++;
        $to_sql = "update count_table set cnt = $count where redate='$dat' ";
    }





    mysqli_query($connect, $to_sql);


    $tot_sql = "select sum(cnt) from count_table";
    $tot_rst = mysqli_query($connect, $tot_sql);


    $tot_row = mysqli_fetch_array($tot_rst);
    $total = $tot_row[0];
    mysqli_close($connect);


    echo " <br><center><h2> Welcome to My coding storage space! </h2><hr>";
    echo "데이터베이스를 이용한 카운터입니다! <br><br><br> ";
    echo "[ 오늘 : <font color = blue>";
    for($a=0; $a < 8 - strlen(strval($count)); $a++) echo "0";
    echo $count . "</font> ] <br> ";
    echo "[ 전체 : <font color = blue>";
    for($a=0; $a < 8 - strlen(strval($total)); $a++) echo "0";
    echo $total . "</font> ] <br> ";

?>