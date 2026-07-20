<?php

use App\Controllers\ClientController;
use CodeIgniter\Test\CIUnitTestCase;

final class ClientControllerFeeTest extends CIUnitTestCase
{
    public function testRetraitSansTransfertPrepayéConserveLesFraisStandards(): void
    {
        $controller = new ClientController();

        $result = $controller->resolveRetraitFees(250.0, null);

        $this->assertSame(250.0, $result['frais_appliques']);
        $this->assertFalse($result['deja_paye_par_expediteur']);
    }

    public function testRetraitAvecTransfertPrepayéExonèreLesFrais(): void
    {
        $controller = new ClientController();

        $result = $controller->resolveRetraitFees(250.0, ['id' => 12, 'frais_appliques' => 250.0]);

        $this->assertSame(0.0, $result['frais_appliques']);
        $this->assertTrue($result['deja_paye_par_expediteur']);
    }
}
