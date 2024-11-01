<?php

class NPFW_View
{
	public static function npfw_render($view, $data = [])
	{
		$fileName = __DIR__ . '/../views/' . $view . '.php';
		ob_start();
		extract($data);
		include $fileName;
		$output = ob_get_clean();

		return $output;
	}
}
