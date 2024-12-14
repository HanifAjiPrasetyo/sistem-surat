<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Support\Facades\Auth;

class WargaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('warga')
            ->path('warga')
            ->login()
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Purple,
                'secondary' => Color::Violet,
            ])
            ->navigationItems([
                NavigationItem::make('Pindah ke Panel Admin')
                    ->icon('heroicon-o-cog')
                    ->url('/admin')
                    ->sort(100)
                    ->visible(function () {
                        return Auth::user()->hasRole('admin');
                    }),
                NavigationItem::make('divider')
                    ->label('———————————————')
                    ->url(null)
                    ->icon(null)
                    ->sort(99)
                    ->visible(function () {
                        return Auth::user()->hasRole('admin');
                    }),
            ])
            ->discoverResources(in: app_path('Filament/Warga/Resources'), for: 'App\\Filament\\Warga\\Resources')
            ->discoverPages(in: app_path('Filament/Warga/Pages'), for: 'App\\Filament\\Warga\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Warga/Widgets'), for: 'App\\Filament\\Warga\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
