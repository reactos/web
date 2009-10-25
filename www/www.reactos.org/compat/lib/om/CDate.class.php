<?php

/**
 * class CDate
 * 
 */
class CDate
{

  /**
   * 
   *
   * @param string date
   * @return age as string
   * @access public
   */
  public static function getAge( $date )
  {
    if ($date == null) {
      return '';
    }
  
    $time = strtotime($date);
    $diff = time()-$time;

    if (date('Y',$diff)-1970 > 1) { // >= 2 years
      return (date('Y',$diff)-1970).' Years';
    }
    else {
      $plus = (date('Y',$diff)-1970)*12;
      if (date('n',$diff)-1+$plus > 1) {
        return (date('n',$diff)-1+$plus).' Months';
      }
      elseif (date('z',$diff) > 1) {
        return (date('z',$diff)-1).' Days';
      }
      else {
        $plus = (date('z',$diff)-1)*24;
        if (date('G',$diff)+$plus > 1) {
          return (date('G',$diff)+$plus).' Hours';
        }
        else {
          $plus = (date('G',$diff)-1)*60;
          if (date('i',$diff)+$plus > 1) {
            return (date('i',$diff)+$plus).' Minutes';
          }
          else {
            return date('U',$diff).' Seconds';
          }
        }
      }
    } // 

  } // end of member function getAge



} // end of CDate
?>
