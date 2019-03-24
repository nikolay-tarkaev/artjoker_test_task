<?php
	class View
	{
		
		public $template_view = "default.php";
		
		/*
		$content_view - виды отображающие контент страниц;
		$template_view - общий для всех страниц шаблон;
		$data - массив, содержащий элементы контента страницы.
		*/
		public function generate($content_view, $template_view, $data = null)
		{
			if(is_array($data)) {
				extract($data);
			}
			
			/*
			динамически подключаем общий шаблон (вид),
			внутри которого будет встраиваться вид
			для отображения контента конкретной страницы.
			*/
			include '../app/views/template/'.$template_view;
		}
	}
