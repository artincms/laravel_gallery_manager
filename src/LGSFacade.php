<?php
namespace ArtinCMS\LGS;
use Illuminate\Support\Facades\Facade;

class LGSFacade extends Facade
{
	protected static function getFacadeAccessor() {
		return 'LGS';
	}
}