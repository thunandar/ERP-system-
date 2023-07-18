<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Manage the language change of an application. English/Myanmar
 *
 * @author Thu Nandar Aye Min
 *
 * @create date 21/06/2023
 *
 */
class LanguageChangeController extends Controller
{
    /**
     * Change the language according to user's selected language. English/Myanmar
     * 
     * @author Thu Nandar Aye Min
     * @created 05/07/2023
     * @param Request $request
     * @return redirect
     */
    public function changeLanguage(Request $request)
    {
        $locale = $request->input('locale');

        if (in_array($locale, ['en', 'my'])) {
            $request->session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
