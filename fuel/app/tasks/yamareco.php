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
				$curl = \Request_Curl::forge($uri);
				$curl->set_option('MAX_RECV_SPEED_LARGE', 100*1024);
				$curl->execute();

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
				else
				{
					\Cli::write("not found: $uri");
				}
			}
			else
			{
				\Cli::write("file exists: $file");
			}
		}
	}

	public static function download_from_file($filename)
	{
		$content = \File::read($filename, true);
		$list = \Format::forge($content, 'yaml')->to_array();

		$count = count($list);

		for ($i = 0; $i < $count; $i++)
		{
			\Cli::write("$i/$count");

			if (preg_match('/[0-9]+/', $list[$i], $matches))
			{
				static::download(reset($matches));
			}
		}
	}

	public static function parse($id = null)
	{
		$path = realpath(DOCROOT.'/fuel/app/cache/');

		if (empty($id))
		{
			$contents = \File::read_dir($path, 0, array('\.gpx$' => 'file'));

			$count = count($contents);

			for ($i = 0; $i < $count; $i++)
			{
				\Cli::write("$i/$count");

				if (preg_match('/[0-9]+/', $contents[$i], $matches))
				{
					static::parse(reset($matches));
				}
			}
		}

		else
		{
			$file = sprintf(static::FILENAME_FORMAT, $id);

			try
			{
				$content = \File::read($path.'/'.$file, true);
				$gpx = \Format::forge($content, 'xml')->to_array();

				$name  = \Arr::get($gpx, 'trk.name');
				$trkpt = \Arr::get($gpx, 'trk.trkseg.trkpt', array());

				\DB::query("DELETE FROM `points` WHERE `line_id` = '{$id}'")
				->as_object('Model_Point')->execute();

				foreach ($trkpt as $point)
				{
					$lat = \Arr::get($point, '@attributes.lat');
					$lon = \Arr::get($point, '@attributes.lon');

					if ($lat and $lon)
					{
						$line[] = "{$lon} {$lat}";

						try
						{
							\DB::query("INSERT INTO `points` (`line_id`, `point`) VALUES ('{$id}', GeomFromText('POINT({$lon} {$lat})'))")
							->as_object('Model_Point')->execute();
						}
						catch (\Exception $e)
						{
// 							\Cli::write("error  $file");
						}
					}
				}

				$name = is_string($name) ? $name : '';
				$line = isset($line) ? "GeomFromText('LineString(".implode(',', $line).")')" : '';

				if (empty($line))
				{
					\Cli::write("pass   $file");
					return;
				}

				try
				{
					if (\Model_Line::find($id))
					{
						\DB::query("UPDATE `lines` SET `name` = '{$name}', `line` = {$line} WHERE `id` = '{$id}'")
						->as_object('Model_Line')->execute();
					}
					else
					{
						\DB::query("INSERT INTO `lines` (`id`, `name`, `line`) VALUES ('{$id}', '{$name}', {$line})")
						->as_object('Model_Line')->execute();
					}

					\Cli::write("parsed $file");
				}
				catch (\Exception $e)
				{
					\Cli::write("error  $file");
				}
			}
			catch (\FileAccessException $e)
			{
				// 何もしない
			}
		}
	}
}
