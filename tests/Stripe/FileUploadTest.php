<?php

namespace Stripe_Legacy;

class FileUploadTest extends TestCase
{
    const TEST_RESOURCE_ID = 'file_123';

    /**
     * @before
     */
    public function setUpFixture()
    {
        // PHP <= 5.5 does not support arrays as class constants, so we set up
        // the fixture as an instance variable.
        $this->fixture = array(
            'id' => self::TEST_RESOURCE_ID,
            'object' => 'file_upload',
        );
    }

    public function testIsListable()
    {
        $this->stubRequest(
            'get',
            '/v1/files',
            array(),
            null,
            false,
            array(
                'object' => 'list',
                'data' => array($this->fixture),
                'resource_url' => '/v1/files',
            ),
            200,
            Stripe::$apiUploadBase
        );

        $resources = FileUpload::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe_Legacy\\FileUpload", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->stubRequest(
            'get',
            '/v1/files/' . self::TEST_RESOURCE_ID,
            array(),
            null,
            false,
            $this->fixture,
            200,
            Stripe::$apiUploadBase
        );
        $resource = FileUpload::retrieve(self::TEST_RESOURCE_ID);
        $this->assertSame("Stripe_Legacy\\FileUpload", get_class($resource));
    }

    public function testIsCreatableWithFileHandle()
    {
        $this->stubRequest(
            'post',
            '/v1/files',
            null,
            array('Content-Type: multipart/form-data'),
            true,
            $this->fixture,
            200,
            Stripe::$apiUploadBase
        );
        $fp = fopen(dirname(__FILE__) . '/../data/test.png', 'r');
        $resource = FileUpload::create(array(
            "purpose" => "dispute_evidence",
            "file" => $fp,
        ));
        $this->assertSame("Stripe_Legacy\\FileUpload", get_class($resource));
    }

    public function testIsCreatableWithCurlFile()
    {
        if (!class_exists('\CurlFile', false)) {
            // Older PHP versions don't support this
            return;
        }

        $this->stubRequest(
            'post',
            '/v1/files',
            null,
            array('Content-Type: multipart/form-data'),
            true,
            $this->fixture,
            200,
            Stripe::$apiUploadBase
        );
        $curlFile = new \CurlFile(dirname(__FILE__) . '/../data/test.png');
        $resource = FileUpload::create(array(
            "purpose" => "dispute_evidence",
            "file" => $curlFile,
        ));
        $this->assertSame("Stripe_Legacy\\FileUpload", get_class($resource));
    }
}
