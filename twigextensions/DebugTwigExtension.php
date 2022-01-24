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
			new TwigFunction('debug', function ($data, $opts = null) {
				// Only output data if devMode is enabled. Otherwise just return nothing.
				if (! Craft::$app->getConfig()->getGeneral()->devMode) {
					return;
				}

				// Parse the data passed to our function into readable JSON
				$parsedData = json_encode($data);

				// An options object we can use for customizing the output
				$options = (object) [
					'view' => $opts['view'] ?? 'log'
				];

				// Return the data back in an inline view if the user requested it and Symfony's VarDumper is installed
				if ($options->view === 'inline' && function_exists('dump')) {
					return \dump($data);
				}

				// If this should render in a table format, let's use `console.table()`
				if ($options->view === 'table') {
					return Template::raw("
						<script>
							console.table($parsedData)
						</script>
					");
				}

				// Return the data back into the template, but in a console.log() wrapper
				return Template::raw("
					<script>
						console.log($parsedData)
					</script>
				");
			}),
		];
	}
}
