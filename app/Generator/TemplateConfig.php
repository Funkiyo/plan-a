<?php

namespace App\Generator;

use App\Exceptions\GeneratorException;
use Illuminate\Support\Str;

class TemplateConfig
{
    protected $type;
    protected $name;
    protected $scopes;
    protected $template;

    public $fileName;
    public $fileDir;
    public $filePath;
    public $namespace;
    public $className;
    public $templatePath;

    public function __construct( string $type, string $name, array $scopes, string $template = null )
    {
        $this->type = strtolower( $type );
        $this->name = $name;
        $this->scopes = $scopes;
        $this->template = $template ?? 'default';
        $this->initNamesAndPaths();
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    protected function initNamesAndPaths()
    {
        $this->className = static::slugToTitleCase( $this->name );
        $this->fileName = $this->className . '.php';

        $pathComponents = collect( [] );
        $pathComponents->push( ucfirst( $this->type ) );
        foreach ( $this->scopes as $scope ) {
            $pathComponents->push( static::slugToTitleCase( $scope ) );
        }

        $this->fileDir = $pathComponents->join( DIRECTORY_SEPARATOR );
        $this->filePath = $this->fileDir . DIRECTORY_SEPARATOR . $this->fileName;

        $pathComponents->prepend( 'App' );
        $this->namespace = $pathComponents->join( '\\' );

        $this->templatePath = resource_path( DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->type . DIRECTORY_SEPARATOR . $this->template . '.template' );
    }

    public function getField( string $field )
    {
        if ( ! isset( $this->{$field} ) ) {
            throw new GeneratorException( "$field is not set." );
        }
        return $this->{$field};
    }

    public static function slugToTitleCase( string $slug ): string
    {
        return Str::of( $slug )->replace( '-', ' ' )->title()->replace( ' ', '' );
    }
}
