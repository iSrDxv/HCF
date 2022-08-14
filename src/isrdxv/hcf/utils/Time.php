<?php

namespace isrdxv\hcf\utils;

class Time {
    
    /**
	 * @param string|int $time
	 * @return String
	 */
	public static function getTimeElapsed($time): string {
	  $time = is_string($time) ? intval($time) : $time;
		$seconds = $time % 60;
		$minutes = null;
		$hours = null;
		$days = null;

		if($time >= 60){
			$minutes = floor(($time % 3600) / 60);
			if($time >= 3600){
				$hours = floor(($time % (3600 * 24)) / 3600);
				if($time >= 3600 * 24){
					$days = floor($time / (3600 * 24));
				}
			}
		}
		return ($minutes !== null ? ($hours !== null ? ($days !== null ? "$days days " : "")."$hours hours " : "")."$minutes minutes " : "")."$seconds seconds";
	}

	/**
	 * @param int|string $time
	 * @return String
	 */
	public static function getTimeRemaining($time): string {
		$remaning = is_string($time) ? intval($time) - time() : $time - time();

		$s = $remaning % 60;
		$m = null;
		$h = null;
		$days = null;

		if($remaning >= 60){
			$m = floor(($remaning % 3600) / 60);
			if($remaning >= 3600){
				$h = floor(($remaning % 86400) / 3600);
				if($remaning >= 3600 * 24){
					$days = floor($remaning / 86400);
				}
			}
		}
		return ($m !== null ? ($h !== null ? ($days !== null ? "$days days " : "")."$h hours " : "")."$m minutes " : "")."$s seconds";
	}
	
}
