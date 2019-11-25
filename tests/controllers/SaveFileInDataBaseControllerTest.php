<?php

use App\FileVersion;
use App\FileUpload;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutEvents;
use Laravel\Lumen\Testing\WithoutMiddleware;

class SaveFileInDataBaseControllerTest extends TestCase
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
    

    public function testUploadFile() : void
    {
       
        
        $handle = fopen('test.txt','rb');
        $file = fread($handle, filesize('test.txt'));
        fclose($handle);

        $data = [
            'creator_id' => 1,
            'file' => $file

        ];

         
        $result = $this->post('/upload-file', $data);
       dd($result);
        $result->seeStatusCode(Response::HTTP_OK);
        $result->seeJsonContains(['creator_id' => 1]);
    }
    /*
    public function testRestoreFileThatDoesNotExist() : void
    {
        // given
        $data = [
            'file_id' => 22344
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.']
            ],
        ];
        // when
         $result = $this->patch('/restore/file', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testRestoreFileThatIsNotSoftDeleted() : void
    {
        // given
        $data = [
            'file_id' => 1
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.']
            ],
        ];

        // when
         $result = $this->patch('/restore/file', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }


    public function testRestoreFileWithIdThatIsNotInteger() : void
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
         $result = $this->patch('/restore/file', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testRestoreFileWithMissingID() : void
    {
        // given
        $data = [
    
        ];

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The file id field is required.']
            ],
        ];
        // when
         $result = $this->patch('/restore/file', $data);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }
    */
}