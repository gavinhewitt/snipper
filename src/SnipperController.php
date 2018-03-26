<?php

namespace GavinHewitt\Snipper;

use App\Http\Controllers\Controller;
use GavinHewitt\Snipper\Models\SnipperModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Highlight\Highlighter;

class SnipperController extends Controller {

// ------------------------------------------------------------------------------
// DISPLAY
// ------------------------------------------------------------------------------

    public function getIndex()
    {
        $snippets = SnipperModel::all();

        $data = array(
            'snippets' => $snippets,
        );

        app('debugbar')->disable();

        return view('snipper::page-index', $data);
    }

// ------------------------------------------------------------------------------

    public function getShow($id)
    {
        $snippet = SnipperModel::find($id);

        $data = array(
            'snippet' => $snippet,
        );

        return view('snipper::page-show', $data);
    }

// ------------------------------------------------------------------------------

    public function getShowEmbed($id)
    {
        $snippet = SnipperModel::find($id);

        $content = json_encode($snippet->content_html, JSON_PRETTY_PRINT);
        $content = trim($content, '"');
        $content = str_replace('\r<\/span>', '<\/span>\r', $content);
        $content = str_replace("'", "\'", $content);

        $out  = '<div style="position: relative;margin-top: 16px;margin-bottom: 16px;border: 1px solid #ddd;border-radius: 3px;">';
        $out .= '<div style="padding: 5px 10px; background-color: #fafbfc; border-bottom: 1px solid #ddd"><span style="font-weight: 600">'. $snippet->name .'</span><a href="'. route('snippet.raw.show', $snippet->id) .'" style="float: right; font-size: 14px">Raw</a></div>';
        $out .= $content;
        $out .= '</div>';

        $contents = "document.write('<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/github-gist.min.css\">');";
        $contents .= "document.write('". $out ."');";

        return response($contents)->header('Content-Type', 'application/javascript');
    }

// ------------------------------------------------------------------------------

    public function getShowRaw($id)
    {
        $snippet = SnipperModel::find($id);

        return response($snippet->content)->header('Content-Type', 'text/plain');
    }


// ------------------------------------------------------------------------------
// CREATE
// ------------------------------------------------------------------------------

    public function getCreate()
    {
        $data = array(
//            'snippets' => $snippets,
        );

        return view('snipper::page-create-edit-form', $data);
    }

// ------------------------------------------------------------------------------

    /*
     * Description
     *
     * @return Redirect
     */
    public function postCreate(SnipperModel $snippet)
    {
        $snippet->fill(Input::all());

        if ($snippet->save()) {
            return Redirect::route('snippet.index')
                ->with('success', 'Snippet succesvol aangemaakt');
        }
    }


// ------------------------------------------------------------------------------
// EDIT
// ------------------------------------------------------------------------------

    public function getEdit($id)
    {
        $snippet = SnipperModel::find($id);

        $data = array(
            'snippet' => $snippet,
        );

        return view('snipper::page-create-edit-form', $data);
    }

    public function postEdit($id)
    {
        $snippet = SnipperModel::find($id);
        $snippet->fill(Input::all());
        $snippet->content_html = $this->_highlight($snippet->content);

        if ($snippet->save()) {
            return Redirect::route('snippet.index')
                ->with('success', 'Snippet succesvol bijgewerkt');
        }
    }


    private function _highlight($content) {
        // Create a new instance of Highlighter
        $highlighter = new Highlighter();

        // Set the languages you want to detect automatically.
        $highlighter->setAutodetectLanguages(array('php', 'python', 'sql', 'html', 'css', 'scss', 'javascript'));

        $highlightedCodeObject = $highlighter->highlightAuto($content);

//        $snippet->content_html = trim(json_encode($highlightedCodeObject->value), '"');

//        $out  = '<div style="position: relative;margin-top: 16px;margin-bottom: 16px;border: 1px solid #ddd;border-radius: 3px;">';
//        $out .= '<div style="padding: 5px 10px; background-color: #fafbfc; border-bottom: 1px solid #ddd"><span style="font-weight: 600">'. $snippet->name .'</span><a href="'. route('snippet.raw.show', $snippet->id) .'" style="float: right; font-size: 14px">Raw</a></div>';
        $out = '<pre><code class="hljs '. $highlightedCodeObject->language .'">';
        $out .= $highlightedCodeObject->value;
        $out .= '</code></pre>';
//        $out .= '</div>';
        return $out;
    }



}