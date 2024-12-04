<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class UiLangHelper
{
    /**
     * Retrieves a language-specific message by its message ID.
     *
     * @param string $mess_id The message ID to retrieve the language message for.
     * @return string The language-specific message.
     */
    public static function get($mess_id): string
    {
        return Lang::get('messages.' . $mess_id);
    }

    /**
     * Gets the current user's UI language or the default app locale.
     *
     * @return string The current UI language or the default app locale.
     */
    public static function getLocale(): string
    {
        return auth()->user()?->ui_lang ?? config('app.locale');
    }

    /**
     * Sets the user's UI language based on the request's 'lang_ui' parameter.
     *
     * @param Request $request The HTTP request containing potential 'lang_ui' parameter.
     */
    public static function setLocale(Request $request): void
    {
        if ($request->has('lang_ui')) {
            $locale = $request->get('lang_ui');
            self::set($locale);
        }
    }

    /**
     * Updates the authenticated user's UI language.
     *
     * @param string $locale The locale to set for the user's UI language.
     */
    public static function set(string $locale): void
    {
        /** @var User $user */
        $user = auth()->user();
        $user?->update(['ui_lang' => $locale]);
    }
}
