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

			if ( ! file_exists($path.'/'.$file) or $overwrite)
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

	public static function parse($id = null)
	{
		$path = realpath(DOCROOT.'/fuel/app/cache/');

		if (empty($id))
		{
			$contents = \File::read_dir($path, 0, array('\.gpx$' => 'file'));

			foreach ($contents as $content)
			{
				if (preg_match('/[0-9]+/', $content, $matches))
				{
					static::parse(reset($matches));
				}
			}
		}

		else
		{
			$file = sprintf(static::FILENAME_FORMAT, $id);

			\Debug::dump($path.'/'.$file);

			try
			{
				$content = \File::read($path.'/'.$file, true);
				$gpx = \Format::forge($content, 'xml')->to_array();

				$yamareco = \Model_Yamareco::forge();

				$yamareco->id = $id;
				$yamareco->name = \Arr::get($gpx, 'trk.name');
				$yamareco->line = \Arr::get($gpx, 'trk.trkseg.trkpt');

				if ($yamareco->save())
				{
					// 成功
				}
			}
			catch (\FileAccessException $e)
			{
				// 何もしない
			}
		}
	}
}
