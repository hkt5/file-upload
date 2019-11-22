<?php

use App\FileVersion;
use App\FileUpload;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutEvents;
use Laravel\Lumen\Testing\WithoutMiddleware;

class DeleteVersionControllerTest extends TestCase
{
    use WithoutEvents;
    use WithoutMiddleware;
    use DatabaseMigrations;

    protected $strategy;
    protected $response;

    public function setUp(): void
    {
        parent::setUp();
        $this->createNewFileUpload(1,'some_file.txt');
        $this->createNewFileVersion(1,1,'test.txt');
        $this->createNewFileUpload(2,'soft_deleted_file.txt', true);
        $this->createNewFileVersion(2,2,'test.txt');
    }

    private function createNewFileUpload($id, $name = "test.txt", $softDeleted = false)
    {
        $fileUpload = new FileUpload();
        $fileUpload->file_name = $name;
        $fileUpload->creator_id = 1;
        $fileUpload->id = $id;
        $fileUpload->save();

        if($softDeleted)
        {
            $fileUpload->delete();
        }
    }

    private function createNewFileVersion($fileID,$versionID, $filePath = "test.txt")
    {
        $fileVersion = new FileVersion();
        $fileVersion->file_id = $fileID;
        $fileVersion->id = $versionID;
        $filePath = $filePath;
        $handle = fopen($filePath,"rb");
        $content = fread($handle, filesize($filePath));
        $fileVersion->file_body = $content;
        fclose($handle);
        $fileVersion->file_body = $content;
        $fileVersion->save();
    }
    public function testDeleteVersion() : void
    {
        // given
        $data = [
            'file_id' => 1,
            'id' => 1,
        ];

        // when
        $result = $this->delete('/delete/version', $data);
        
        // then
        $result->seeStatusCode(Response::HTTP_OK);
        $result->seeJsonContains(['file_id' => 1]);
        $result->seeJsonContains(['id' => 1]);
    }
    
    public function testDeleteVersionThatDoesNotExist() : void
    {
        // given
        $data = [
            'file_id' => 1,
            'id' => 18777,
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'id' => ['The selected id is invalid.']
            ],
        ];
        // when
         $result = $this->delete('/delete/version', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testDeleteVersionWithInvalidFileID() : void
    {
        // given
        $data = [
            'file_id' => 19999,
            'id' => 1,
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.']
            ],
        ];
        // when
         $result = $this->delete('/delete/version', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testDeleteVersionWithInvalidVersionID() : void
    {
        // given
        $data = [
            'file_id' => 1,
            'id' => 66666,
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'id' => ['The selected id is invalid.']
            ],
        ];
        // when
         $result = $this->delete('/delete/version', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testDeleteVersionWithVersionIDThatIsNotInteger() : void
    {
        // given
        $data = [
            'file_id' => 1,
            'id' => 'not an integer',
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'id' => ['The id must be an integer.']
            ],
        ];
        // when
         $result = $this->delete('/delete/version', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testDeleteVersionOfFileThatIsSoftDeleted() : void
    {
        // given
        $data = [
            'file_id' => 2,
            'id' => 2,
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.']
            ],
        ];
        // when
         $result = $this->delete('/delete/version', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }
    
}