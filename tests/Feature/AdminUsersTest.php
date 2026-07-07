<?php

namespace Tests\Feature;

use CodeIgniter\Test\FeatureTestCase;

class AdminUsersTest extends FeatureTestCase
{
    public function testAdminUsersRouteExists(): void
    {
        $result = $this->get('/admin/users');

        $this->assertNotSame(404, $result->getStatusCode());
    }
}
