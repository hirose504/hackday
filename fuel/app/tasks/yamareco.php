<?php

namespace Fuel\Tasks;

class Yamareco
{
	const FILENAME_FORMAT = "track-%d.gpx";

	public static function download($start = 1, $end = null, $overwrite = false)
	{
		$end or $end = $start;

		for ($i = $start; $i <= $end; $i++)
		{
			$path = realpath(DOCROOT.'/fuel/app/cache/');
			$file = sprintf(static::FILENAME_FORMAT, $i);
			$uri  = "http://www.yamareco.com/modules/yamareco/{$file}";

			if (file_exists($path.'/'.$file) and $overwrite)
			{
				$curl = \Request_Curl::forge($uri)->execute();

				if ($body = $curl->response()->body())
				{
					try
					{
						\File::create($path, $file, $body);
					}
					catch (\FileAccessException $e)
					{
						\File::update($path, $file, $body);
					}

					\Cli::write("downloaded: $file");
				}
			}
			else
			{
				\Cli::write("file exists: $file");
			}
		}
	}
}
