<?php
// Scénario 7 — URL inconnue
// GET /inconnue
// Résultat attendu :
// 404 — Page introuvable


// Scénario 8 — Méthode non autorisée
// DELETE /salles
// Résultat attendu :
// 405 — Méthode non autorisée
// La réponse doit contenir un en-tête Allow.


// namespace Tests\Integration;

// use App\Application;
// use FastRoute\Dispatcher;
// use PHPUnit\Framework\TestCase;
// use Psr\Container\ContainerInterface;

// class ApplicationTest extends TestCase
// {
//     private function creerApplication(): Application
//     {
//         $dispatcher = \FastRoute\simpleDispatcher(
//             require dirname(__DIR__, 2) . '/routes/web.php'
//         );

//         $container = $this->createMock(
//             ContainerInterface::class
//         );

//         return new Application($container, $dispatcher);
//     }

//     public function testUrlInconnue(): void
//     {
//         $_SERVER['REQUEST_METHOD'] = 'GET';
//         $_SERVER['REQUEST_URI'] = '/inconnue';

//         $application = $this->creerApplication();

//         ob_start();

//         $application->run();

//         $contenu = ob_get_clean();

//         $this->assertEquals(404, http_response_code());
//         $this->assertStringContainsString('404', $contenu);
//         $this->assertStringContainsString(
//             'Page introuvable',
//             $contenu
//         );
//     }

//     public function testMethodeNonAutorisee(): void
//     {
//         $_SERVER['REQUEST_METHOD'] = 'DELETE';
//         $_SERVER['REQUEST_URI'] = '/salles';

//         $application = $this->creerApplication();

//         ob_start();

//         $application->run();

//         $contenu = ob_get_clean();

//         $this->assertEquals(405, http_response_code());
//         $this->assertStringContainsString('405', $contenu);
//         $this->assertStringContainsString(
//             'Méthode non autorisée',
//             $contenu
//         );
//     }
// }