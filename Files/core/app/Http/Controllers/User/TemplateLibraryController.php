<?php

namespace App\Http\Controllers\User;

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

        return view('Template::user.template_library.index', compact('pageTitle', 'templates', 'category', 'bank'));
    }

    public function use(Request $request)
    {
        $request->validate(['template_id' => 'required|integer']);
        $template = Template::library()->active()->findOrFail($request->template_id);
        return back()->withNotify([['success', "Template \"{$template->name}\" loaded into campaign builder"]])
            ->with('selected_template_id', $template->id);
    }
}