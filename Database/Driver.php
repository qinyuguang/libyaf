<?php
namespace Database;

interface Driver
{
	public function __construct(array $config);

	public function getDatabaseDriver();
}

