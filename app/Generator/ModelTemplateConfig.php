<?php

namespace App\Generator;

use App\Exceptions\GeneratorException;
use Illuminate\Support\Str;

class ModelTemplateConfig extends TemplateConfig
{
    public $tableName;

    public function __construct( string $type, string $name, array $scopes, string $template = null )
    {
        parent::__construct( $type, $name, $scopes, $template );
    }

    public function initNamesAndPaths()
    {
        parent::initNamesAndPaths();

        $this->tableName = $this->name;
    }
}
