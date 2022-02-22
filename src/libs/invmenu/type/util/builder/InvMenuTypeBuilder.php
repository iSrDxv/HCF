<?php

declare(strict_types=1);

namespace libs\invmenu\type\util\builder;

use libs\invmenu\type\InvMenuType;

interface InvMenuTypeBuilder{

	public function build() : InvMenuType;
}
