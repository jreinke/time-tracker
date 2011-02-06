<?php
function format_time($time, $color = false)
{
  $time = (string) $time;

  if (false !== ($pos = strpos($time, '.')))
  {
    $left = substr($time, 0, $pos);
    $right = substr($time, $pos);
    $time = $left . rtrim($right, '0.');
  }

  if (empty($time))
  {
    $time = 0;
  }

  if ($color)
  {
    if ($time > 0)
    {
      $time = '<span class="positive">' . $time . '</span>';
    }
    else if ($time < 0)
    {
      $time = '<span class="negative">' . $time . '</span>';
    }
  }

  return $time;
}