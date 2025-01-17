<?php

namespace h4kuna\Assets;

use Nette\Http;

class File
{

	/** @var string */
	private $rootFs;

	/** @var Http\Url */
	private $url;

	/** @var CacheAssets */
	private $cache;

	/** @var string */
	private $hostUrl;

	/** @var string */
	private $basePath;


	public function __construct($rootFs, Http\Url $url, CacheAssets $cache)
	{
		$this->rootFs = $rootFs;
		$this->url = $url;
		$this->cache = $cache;
	}


	public function createUrl($file)
	{
		if (substr($file, 0, 2) == '//') {
			$host = $this->getHostUrl() . '/';
			$file = substr($file, 2);
		} else {
			$host = $this->getBasePath();
		}

		return $host . $file . '?' . $this->cache->load($this->rootFs . DIRECTORY_SEPARATOR . $file);
	}


	private function getHostUrl()
	{
		if ($this->hostUrl === null) {
			$this->hostUrl = $this->url->getHostUrl();
		}

		return $this->hostUrl;
	}


	private function getBasePath()
	{
		if ($this->basePath === null) {
			$this->basePath = $this->url->getBasePath();
		}
		return $this->basePath;
	}

}
