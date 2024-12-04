<?php

namespace App\Helpers;

use App\Models\Langs;
use App\Models\User;
use Illuminate\Http\Request;

class AppLangHelper
{
    /**
     * Set the application locale based on the request.
     *
     * @param Request $request HTTP request instance
     * @return void
     */
    public static function setLocale(Request $request): void
    {
        if ($request->isMethod('post') && $request->has('lang_app')) {
            $locale = $request->post('lang_app');
            self::set($locale);
            GroupsHelper::removeCurrentGroup();
        }
    }

    /**
     * Get the current user's locale.
     *
     * @return string The locale of the current user
     */
    public static function getLocale(): string
    {
        return auth()->user()?->learn_lang ?? '';
    }

    /**
     * Set the current user's locale.
     *
     * @param string $locale The locale to be set
     * @return void
     */
    public static function set(string $locale): void
    {
        /** @var User $user */
        $user = auth()->user();
        $user->update(['learn_lang' => $locale]);
    }

    /**
     * Get the ID of the current locale.
     *
     * @return int The ID corresponding to the current locale
     */
    public static function getId(): int
    {
        $loc = self::getLocale();
        return (int) Langs::getIdByLang($loc);
    }

    /**
     * Retrieve the Langs model for the current locale.
     *
     * @return Langs The Langs model instance for the current locale
     */
    public static function getLang(): Langs
    {
        return Langs::find(self::getId());
    }
}
