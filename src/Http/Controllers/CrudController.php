<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers;

use Merlion\Http\Controllers\Concerns\AsCurdController;
use Merlion\Http\Controllers\Concerns\HasDestroy;
use tinker\packages\singapura\merlion\src\Http\Controllers\Concerns\HasForm;
use Merlion\Http\Controllers\Concerns\HasIndex;
use tinker\packages\singapura\merlion\src\Http\Controllers\Concerns\HasShow;

abstract class CrudController
{
    use AsCurdController;
    use HasIndex;
    use HasForm;
    use HasShow;
    use HasDestroy;
}
