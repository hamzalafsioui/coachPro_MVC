<?php

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        $viewFile = $this->resolveViewPath($view);
        if (!is_file($viewFile)) {

            throw new RuntimeException("View not found: {$viewFile}");
        }

        extract($data, EXTR_SKIP);
        require $viewFile; // injected into the method render
    }

    protected function renderWithLayout(string $view, array $data = []): void
    {
        $header = BASE_PATH . '/app/Views/partials/header.php';
        $nav = BASE_PATH . '/app/Views/partials/nav.php';
        $footer = BASE_PATH . '/app/Views/partials/footer.php';

        extract($data, EXTR_SKIP);
        if (is_file($header)) {
            require $header;
        }
        if (is_file($nav)) {
            require $nav;
        }

        $this->render($view, $data);

        if (is_file($footer)) {
            require $footer;
        }
    }

    protected function redirect(string $path, int $statusCode = 302): void
    {
        $path = '/' . ltrim($path, '/');
        $url = defined('BASE_URL') ? (BASE_URL . $path) : $path;
        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    private function resolveViewPath(string $view): string
    {
        $relative = str_replace('.', '/', trim($view));
        $relative = ltrim($relative, '/');

        return BASE_PATH . '/app/Views/' . $relative . '.php';
    }
}
