<?php
namespace App\Core;

/**
 * Lightweight server-side view renderer.
 *   View::render('pages.home', ['title' => 'Home'])
 * Layout sections:
 *   $this->extend('layouts.main') in the page file
 *   $this->section('content') ... $this->endSection()
 *   <?= $this->yield('content') ?> inside layout
 */
final class View
{
    private static array $sections = [];
    private static array $stack    = [];
    private static ?string $layout = null;
    private static array $shared   = [];

    public static function share(string $key, $value): void {
        self::$shared[$key] = $value;
    }

    public static function render(string $view, array $data = []): string
    {
        self::$sections = [];
        self::$stack    = [];
        self::$layout   = null;

        $data = array_merge(self::$shared, $data);
        $content = self::capture($view, $data);

        if (self::$layout) {
            // page's body is the default "content" section
            if (!isset(self::$sections['content'])) {
                self::$sections['content'] = $content;
            }
            $layout = self::$layout;
            self::$layout = null;
            return self::capture($layout, $data);
        }
        return $content;
    }

    public static function display(string $view, array $data = []): void {
        echo self::render($view, $data);
    }

    /** Page declares its layout. */
    public function extend(string $layout): void {
        self::$layout = $layout;
    }

    public function section(string $name): void {
        self::$stack[] = $name;
        ob_start();
    }

    public function endSection(): void {
        $name = array_pop(self::$stack);
        self::$sections[$name] = ob_get_clean();
    }

    public function yield(string $name, string $default = ''): string {
        return self::$sections[$name] ?? $default;
    }

    public function include(string $partial, array $data = []): void {
        echo self::capture($partial, array_merge(self::$shared, $data));
    }

    public function component(string $name, array $data = []): void {
        $this->include("components.{$name}", $data);
    }

    private static function capture(string $viewName, array $data): string
    {
        $path = app_path('views/' . str_replace('.', '/', $viewName) . '.php');
        if (!is_file($path)) {
            throw new \RuntimeException("View not found: {$viewName} ({$path})");
        }
        $view = new self();        // exposed as $view inside templates
        $data['view'] = $view;
        ob_start();
        try {
            (static function (string $__path, array $__data) {
                extract($__data, EXTR_SKIP);
                /** @noinspection PhpIncludeInspection */
                require $__path;
            })($path, $data);
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
        return ob_get_clean();
    }
}
