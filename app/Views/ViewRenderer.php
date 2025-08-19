<?php

namespace App\Views;

class ViewRenderer
{
    private string $viewsPath;

    public function __construct(string $viewsPath = __DIR__ . "/../Views/")
    {
        $this->viewsPath = $viewsPath;
    }

    public function render(string $view, array $data = []): void
    {
        $viewFile = $this->viewsPath . $view;
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: $viewFile");
        }

        // Extrai as variáveis para o escopo da view
        extract($data);
        
        // Inclui a view
        include $viewFile;
    }

    public function renderWithLayout(string $view, array $data = [], string $layout = 'layout.php'): void
    {
        $data['content'] = $this->getViewContent($view, $data);
        $this->render($layout, $data);
    }

    private function getViewContent(string $view, array $data = []): string
    {
        ob_start();
        extract($data);
        include $this->viewsPath . $view;
        return ob_get_clean();
    }
}

