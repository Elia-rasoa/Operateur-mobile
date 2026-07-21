<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

abstract class BaseAdminController extends BaseController
{
    /**
     * Render a view inside the admin layout.
     */
    protected function render(string $view, array $data = [], string $title = 'Administration'): string
    {
        // Render the content view
        $content = view($view, $data);

        // Wrap it in the layout
        return view('admin/layout', [
            'title'   => $title,
            'content' => $content,
        ]);
    }
}
