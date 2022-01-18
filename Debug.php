<?php

namespace modules\debug;

use Craft;

use modules\debug\twigextensions\DebugTwigExtension;

use yii\base\Module;

class Debug extends Module
{
	public function init()
	{
		parent::init();

		// Register our Twig extension
		if (Craft::$app->request->getIsSiteRequest()) {
			$extension = new DebugTwigExtension();
			Craft::$app->view->registerTwigExtension($extension);
		}
	}
}
