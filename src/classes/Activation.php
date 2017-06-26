<?php

namespace JB\MPS;

class Activation {
	public static function init() {
		// call functions here to run plugin initialization
		self::createDb();
	}

	private static function createDb() {
		// maybe do some db initialization here
	}
}
