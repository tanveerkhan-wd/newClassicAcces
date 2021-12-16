<?php
namespace App\Common\Facades;
use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade {
	protected static function getFacadeAccessor() {
		return new Settings();
	}
}