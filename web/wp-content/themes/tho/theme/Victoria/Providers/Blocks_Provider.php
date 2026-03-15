<?php

namespace Victoria\Providers;

use Victoria\Abstracts\Provider;
use Victoria\Blocks\Hero;
use Victoria\Blocks\Hero_Slideshow;
use Victoria\Blocks\Impact_Stats;
use Victoria\Blocks\Section_Heading;
use Victoria\Blocks\Card_Grid;
use Victoria\Blocks\Logo_Carousel;
use Victoria\Blocks\Cta_Banner;
use Victoria\Blocks\Email_Signup;
use Victoria\Blocks\Text_Image_Split;
use Victoria\Blocks\Social_Links;
use Victoria\Blocks\Blog_Grid;
use Victoria\Blocks\Product_Grid;

class Blocks_Provider extends Provider {
	protected array $items = [
		Hero::class,
		Hero_Slideshow::class,
		Impact_Stats::class,
		Section_Heading::class,
		Card_Grid::class,
		Logo_Carousel::class,
		Cta_Banner::class,
		Email_Signup::class,
		Text_Image_Split::class,
		Social_Links::class,
		Blog_Grid::class,
		Product_Grid::class,
	];
}
