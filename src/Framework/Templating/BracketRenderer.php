<?php

namespace Framework\Templating;

class BracketRenderer extends AbstractRenderer
{
    /**
     * Renders a view and returns a string.
     *
     * @param $view
     * @param array $vars The template variables
     * @return string
     */
    public function render(string $view, array $vars = [])
    {
        $template = $this->loadTemplate($view);

        $mapping = $this->getVariablesMapping($vars);
        return str_replace(array_keys($mapping), array_values($mapping), $template);
    }

    /**
     * @param array $vars
     * @return array
     */
    private function getVariablesMapping(array $vars)
    {
        $mapping = [];
        foreach ($vars as $name => $value) {
            $key = sprintf('[[%s]]', $name);
            $mapping[$key] = $value;
        }

        return $mapping;
    }

    /**
     * @param $view
     * @return string
     */
    private function loadTemplate(string $view)
    {
        return file_get_contents($this->getTemplatePath($view));
    }
}