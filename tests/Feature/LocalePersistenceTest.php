<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;

class LocalePersistenceTest extends TestCase
{
    public function test_locale_persists_across_requests()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $this->post(route('locale.switch'), ['locale' => 'fr'])
            ->assertJson(['success' => true])
            ->assertSessionHas('user.language', 'fr');

        $this->get('/')
            ->assertSessionHas('user.language', 'fr');

        $this->assertEquals('fr', app()->getLocale());
    }
}
