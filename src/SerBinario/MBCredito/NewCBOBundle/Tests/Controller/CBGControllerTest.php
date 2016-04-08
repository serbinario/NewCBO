<?php

namespace SerBinario\MBCredito\NewCBOBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CBGControllerTest extends WebTestCase
{
    public function testViewimportfile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewImportFile');
    }

}
