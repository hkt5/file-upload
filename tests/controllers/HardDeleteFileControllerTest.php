<?php

use App\FileVersion;
use App\FileUpload;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutEvents;
use Laravel\Lumen\Testing\WithoutMiddleware;

class HardDeleteFileControllerTest extends TestCase
{
    use WithoutEvents;
    use WithoutMiddleware;
    use DatabaseMigrations;

    protected $strategy;
    protected $response;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->createNewFileUpload(1);
        $this->createNewFileVersion(1,1);

      //soft deleted
        $this->createNewFileUpload(2,"soft_deleted_file.txt", true);
        $this->createNewFileVersion(2,3);
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
    public function testHardDeleteFile() : void
    {
        // given
        $data = [
            'file_id' => 1,
        ];

        // when
        $result = $this->delete('/delete-hard/file', $data);
        
        // then
        $result->seeStatusCode(Response::HTTP_OK);
        $result->seeJsonContains(['id' => 1]);
    }
    
    public function testHardDeleteFileThatDoesNotExist() : void
    {
        // given
        $data = [
            'file_id' => 22344
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.'],
                'id' => ['The id field is required.']
            ],
        ];
        // when
         $result = $this->delete('/delete/version', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testHardDeleteFileThatIsSoftDeleted() : void
    {
        // given
        $data = [
            'file_id' => 2
        ];

        // when
         $result = $this->delete('/delete-hard/file', $data);
        // then
        $result->seeStatusCode(Response::HTTP_OK);
        $result->seeJsonContains(['id' => 2]);
    }


    public function testDeleteHardFileWithIDThatIsNotInteger() : void
    {
        // given
        $data = [
            'file_id' => 'not an integer',
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The file id must be an integer.']
            ],
        ];
        // when
         $result = $this->delete('/delete-hard/file', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }
    
}