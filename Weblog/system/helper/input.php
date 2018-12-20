<?php

namespace system\helper;

class Input
{

	public static function inject($string)
	{
	    $autorises = "abcdefghijklmnopqrstuvxzwyABCDEFGHIJKLMNOPQRSTUVXZWY1234567890éèàçù, ©@'\".-_$^*!/&()[]£#~{}%?=+;:|`¬\<> ,";

	    if(is_array($string))
	    {
			foreach ($string as $value)
			{
				for ($i=0; $i<strlen($value); $i++)
				{
			        if (strpos($autorises, substr($value, $i, 1)) === FALSE)
			        	return TRUE;
				}
			}
	    }
	    else
	    {
			for ($i=0; $i<strlen($string); $i++)
			{
	        	if (strpos($autorises, substr($string, $i, 1)) === FALSE)
	        		return TRUE;
			}
	    }

	    return FALSE;
	}
}