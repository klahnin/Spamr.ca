<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateLibraryController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Template Library';
        $category  = $request->get('category');
        $bank      = $request->get('bank');

        $query = Template::library()->active()->orderBy('category')->orderBy('bank');
        if ($category) $query->byCategory($category);
        if ($bank)     $query->byBank($bank);
        $templates = $query->paginate(getPaginate());

        return view('Template::admin.template_library.index', compact('pageTitle', 'templates', 'category', 'bank'));
    }
}