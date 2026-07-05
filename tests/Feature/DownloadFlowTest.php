<?php

namespace Tests\Feature;

use App\Models\RessourceModel;
use CodeIgniter\Test\FeatureTestCase;

class DownloadFlowTest extends FeatureTestCase
{
    public function testDownloadEndpointCreatesActivationFlow(): void
    {
        $resourceModel = new RessourceModel();
        $resource = $resourceModel->where('slug', 'checklist-entretien')->first();

        $this->assertNotEmpty($resource, 'A free resource fixture is required for this test.');

        $result = $this->withBodyFormat('json')->withBody([
            'resource_id' => $resource['id'],
            'prenom' => 'Alicia',
            'nom' => 'Durand',
            'date_naissance' => '1998-05-20',
            'email' => 'alicia+' . time() . '@example.com',
        ])->post('/api/ressource-download');

        $result->assertStatus(200);

        $body = $result->getJSON(true);
        $this->assertTrue($body['success']);
        $this->assertNotEmpty($body['activationUrl']);
    }
}
