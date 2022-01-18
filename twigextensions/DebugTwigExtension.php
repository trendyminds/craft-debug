<?php

namespace modules\debug\twigextensions;

use Craft;

use craft\helpers\Template;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DebugTwigExtension extends AbstractExtension
{
	public function getFunctions()
	{
		return [
			new TwigFunction('debug', function ($data) {
				// Only output data if devMode is enabled. Otherwise just return nothing.
				if (! Craft::$app->getConfig()->getGeneral()->devMode) {
					return;
				}

				// Parse the data passed to our function into readable JSON
				$data = json_encode($data);

				// Return the data back into the template, but in a console.log() wrapper
				return Template::raw("
					<script>
						console.log($data)
					</script>
				");
			}),
		];
	}
}
