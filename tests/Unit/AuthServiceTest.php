<?php

namespace Tests\Unit;

use App\Core\SessionManager;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    public function testAuthentificationLaissePasser(): void
    {
        $session = $this->createMock(SessionManager::class);
        $session->expects($this->once())->method('set')->with('responsable', $this->callback(
            fn (array $user): bool => $user['email'] === 'test@example.com'
        ));

        $service = new AuthService($session);
        $this->assertTrue($service->authentifier('test@example.com', 'nimportequoi'));
    }
}
