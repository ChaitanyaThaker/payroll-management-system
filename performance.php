<?php
	include_once 'header_h.php';
	include_once 'roles.php';
?>
<?php
$id=$_POST['employeeid'];
$q2="SELECT * from employee where Employee_id=".$id.";";
$status2 = mysqli_query($connection_obj,$q2);
if($status2)
            {
              while($data2= mysqli_fetch_assoc($status2))
              {
                
                
                $ename=$data2['Employee_name'];
              }
            }

?>
<form action="salary.php" method="post">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>EMPLOYEE PERFOEMANCE</h2>
            </div>
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                       <div class="header">
                            <h2>
                                <b>PERFORMANCE ANALYSIS OF <?php echo $ename; ?>
                        <div class="body">
                        <h3>


<?php

$id=$_POST['employeeid'];
$_SESSION['sal_id']=$id;
//$enm=$_POST['employeename'];
$blank=0;
$absent=0;
$present=0;
$bonus_cnt=0;
$checkincnt=0;
$checkoutcnt=0;
$checkincnt1=0;
$checkoutcnt1=0;
$checkincnt2=0;
$checkoutcnt2=0;
$bonus_day=0;



$q2="SELECT * from employee where Employee_id=".$id.";";
$status2 = mysqli_query($connection_obj,$q2);
if($status2)
            {
              while($data2= mysqli_fetch_assoc($status2))
              {
                echo "Employee id is: ".$data2['Employee_id']."<br>";
                echo "Employee name is: ".$data2['Employee_name']."<br>";
                echo "Employee's Shift id is: ".$data2['Shift_id']."<br>";
                $sid=$data2['Shift_id'];
                $ename=$data2['Employee_name'];
              }
            }


$q1="SELECT * from payroll where Employee_id=".$id.";";

$status1 = mysqli_query($connection_obj,$q1);

             if($status1)
            {
              $data1 = mysqli_fetch_assoc($status1); 
              
            }
            $q3="SELECT * from employee_attendance where Employee_id='$id'";
$status3 = mysqli_query($connection_obj,$q3);
             $cnt=mysqli_num_rows($status3);
            
             $q4="SELECT * from shift where Shift_id='$sid'";
            $status4 = mysqli_query($connection_obj,$q4);
             
            if($status4)
            {
              while($data4= mysqli_fetch_assoc($status4))
              {
                echo "Shift id :".$data4['Shift_id']."<br>";
                echo "Shift timings are: ".$data4['In_time']." to ".$data4['Out_time']."<br>";
                 $sit=$data4['In_time'];
            
            $sot=$data4['Out_time'];

              }
            }
             
            if($status3)
            {
              while($check_data = mysqli_fetch_assoc($status3))
              {
             
                $bio_id=$check_data['Employee_id'];
               // echo $check_data['Checkout_time']."<br><br>";
              if($check_data['Checkin_time']=='' OR $check_data['Checkout_time']=='')
              {
                $blank++;
              }
              if($check_data['Checkin_time']=='' AND $check_data['Checkout_time']=='')
              {
                $absent++;
              }
              if((($check_data['Checkin_time']>$sit) && ($check_data['Checkin_time']!='')) && ($check_data['Checkout_time']!=''))
                {
                  $checkincnt++;
                  
                }
                if((($check_data['Checkout_time']<$sot) && ($check_data['Checkout_time']!='')) && ($check_data['Checkin_time']!=''))
                {
                  $checkoutcnt++;
                  
                }
                if((($check_data['Checkin_time']<$sit) && ($check_data['Checkin_time']!='')) && ($check_data['Checkout_time']!=''))
                {
                  $checkincnt1++;
                  
                }
                if((($check_data['Checkout_time']>$sot) && ($check_data['Checkout_time']!='')) && ($check_data['Checkin_time']!=''))
                {
                  $checkoutcnt1++;
                  
                }
                if((($check_data['Checkin_time']==$sit) && ($check_data['Checkin_time']!='')) && ($check_data['Checkout_time']!=''))
                {
                  $checkincnt2++;
                  
                }
                if((($check_data['Checkout_time']==$sot) && ($check_data['Checkout_time']!='')) && ($check_data['Checkin_time']!=''))
                {
                  $checkoutcnt2++;
                  
                }
              }
            }


          
         
            
           
             echo "<br><br>";
             
           
             echo "bio employee id is:".$bio_id."<br><br>";

            echo "<b><u>Mistakes</u></b><br><br>";
            echo $ename." came late for ".$checkincnt." times.<br><br>";
             echo  $ename." goes early for ".$checkoutcnt." times.<br><br>";
             echo "<b><u>Goodness</u></b><br><br>";
               echo  $ename." came early for ".$checkincnt1." times.<br><br>";
               echo  $ename." goes late for ".$checkoutcnt1." times.<br><br>";
               echo  $ename." came on time for ".$checkincnt2." times.<br><br>";
             echo  $ename." goes on time for ".$checkoutcnt2." times.<br><br>";
             ?>
             <?php

             $new1="SELECT * from employee_attendance where Employee_id='$id'";
$status_new1 = mysqli_query($connection_obj,$new1);
$new2="SELECT * from holidays";
$status_new2 = mysqli_query($connection_obj,$new2);
$cnt_workdays=0;
$holiday_count=0;
$bioarray=array();
$holiarray=array();
$bonus_result=array();
if($status_new1)
{
  while($data_new1 = mysqli_fetch_assoc($status_new1))
  {
      $bioarray[]=$data_new1['Bio_date'];
  }
}
/*foreach($bioarray as $value)
{
  echo $value."<br>";
}*/
//print_r($bioarray);
if($status_new2)
{
  while($data_new2 = mysqli_fetch_assoc($status_new2))
{

    
    $n1=($data_new2['Holiday_date']);
    $n2=strtotime($n1);
    $dat=date("d",$n2);
    //echo "holiday:".$dat."<br>";
    $holiarray[]=$dat;
    for($i=1;$i<=30;$i++)
    {
      if($i==$dat)
      {
        $holiday_count++;
        echo "Holiday date".$i."<br>";
      }
    }
  }
}

foreach($bioarray as $value)
{
  foreach($holiarray as $value1)
{
  if($value==$value1)
  {
    //echo $value1."<br>";
    $bonus_day++;
      echo "Bonus worked on date:".$value1."<br>";
  
  //echo $value1."<br>";
 // echo $value1."<br>";
 }
}
  
}

/*$temp=0;
if($bioarray==$holiarray)
{
  $temp++;
  echo $temp;
}*/

//$res=array_intersect($bioarray, $holiarray);

 // print_r($res);
$_SESSION['bonus_day']=$bonus_day;

 $present=30-$absent+$bonus_day-$holiday_count;
          echo "Total blank entries are ".$blank."<br>";
            echo "Total absent days are ".$absent."<br>";
            echo "Total present days are ".$present."<br>";

  $cnt_workdays=30-$holiday_count;
  echo "Bonus days worked in a month are:".$bonus_day."<br>";
  echo "Holidays  are:".$holiday_count."<br>";
  echo "Work days  are:".$cnt_workdays."<br>";
     







  
          $month=date("m");
             $year=date("Y");

             $p=$present;
             $work_days=$cnt_workdays;
             $balance=3-$absent;
             
             $q5="INSERT INTO payroll (`Employee_id`, `Payroll_month`, `Payroll_year`, `Present_days`,`Working_days`, `Balance_leaves`) values('".$id."','".$month."','".$year."','".$p."','".$work_days."','".$balance."')";
             $status5=mysqli_query($connection_obj,$q5);

  

        




?>
<?php 

                           include_once 'config/config.php';


$id=$_POST['employeeid'];
            $new="SELECT * from employee where Employee_id=".$id.";";
            $status_new = mysqli_query($connection_obj,$new);
        if($status_new)
        {
            
             $row_new = mysqli_fetch_assoc($status_new);
            }
                 /* echo"<a href=salary.php?id=".$row_new['Employee_id']." >
                      <button class='btn btn-primary waves-effect' name='submit' align='center'  value='OK'>
                           
                           </button></a></td>";*/
                           $_SESSION['sal_id']=$id;
                           
                        $per_day=$row_new['Basic_salary']/30;
                        $bonus_amount=($per_day*$bonus_day);
                        $absent_count=$absent*$per_day;
                        $_SESSION['cutoff']=$absent_count;

$net_sal=$row_new['Basic_salary']-$row_new['PT']+$bonus_amount-$absent_count;
echo "Absent day cut amount :".$absent_count."<br>";
echo "Professional tax counted :".$row_new['PT'],"<br>";
echo "Per day pay is:".$per_day."<br>";
echo "Bonus amount:".$bonus_amount."<br>";
echo "Basic salary is:".$row_new['Basic_salary']."<br>";
echo "Net salary is:".$net_sal."<br>";

echo "<center><a href='salary.php?id=".$row_new['Employee_id']."&basic=".$row_new['Basic_salary']."&net=".$net_sal."&bonus=".$bonus_amount."'><button class='btn btn-primary waves-effect' name=submit type='button'>
                           <i class='material-icons'>check_circle</i>
                        </button></a></td>";


                        $t1="INSERT INTO payroll_details (`Employee_id`, `Net_salary`, `Bonus`) values('".$id."','".$net_sal."','".$bonus_amount."')";
                        $status_t1 = mysqli_query($connection_obj,$t1);
        
  
     
 
                        
                                              
                  
                ?>


                </section>
</form>
<?php
	include_once 'footer_h.php';
?>