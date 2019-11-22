<?php

use App\FileVersion;
use App\FileUpload;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutEvents;
use Laravel\Lumen\Testing\WithoutMiddleware;

class GetAllVersionsControllerTest extends TestCase
{
    use WithoutEvents;
    use WithoutMiddleware;
    use DatabaseMigrations;

    protected $strategy;
    protected $response;

    public function setUp(): void
    {
        parent::setUp();
        //2 of the same file
        $this->createNewFileUpload(1);
        $this->createNewFileVersion(1,1);
        $this->createNewFileVersion(1,2);

      //soft deleted
        $this->createNewFileUpload(2,"soft_deleted_file.txt", true);
        $this->createNewFileVersion(2,3);

      //single
        
        $this->createNewFileUpload(3,"single_file.txt");
        $this->createNewFileVersion(3,4);
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

    public function testGetAllVersionsInZIPFile() : void
    {
        // given
            $fileID = 1;
        
        // when
        $result = $this->get('/versions-all/'.$fileID);
        
        // then
        $result->seeStatusCode(Response::HTTP_OK);
        $this->assertEquals($this->response->headers->get('content-type'),'application/zip');
        $this->assertEquals($this->response->headers->get('content-disposition'),'attachment; filename=test.zip');
       
    }

    public function testGetVersionWhenThereIsOnlyOne() : void
    {
        // given
            $fileID = 3;
        
        // when
        $result = $this->get('/versions-all/'.$fileID);
        
        // then
        $result->seeStatusCode(Response::HTTP_OK);
        $this->assertEquals($this->response->headers->get('content-type'),'text/plain');
        $this->assertEquals($this->response->headers->get('content-disposition'),'attachment; filename=single_file.txt');
       
    }
    
    public function testGetVersionWithIDThatDoesNotExist() : void
    {
        // given
        $fileID = 2221;

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.']
            ],
        ];
        // when
         $result = $this->get('/versions-all/'.$fileID);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testGetVersionWithIDThatIsNotInteger() : void
    {
        // given
        $fileID = "I am not integer";

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The file id must be an integer.']
            ],
        ];
        // when
         $result = $this->get('/versions-all/'.$fileID);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

    public function testGetVersionThatIsSoftDeleted() : void
    {
        // given
        $fileID = 2;

        $response = [
            'content' => [], 'error_messages' => [
                'file_id' => ['The selected file id is invalid.']
            ],
        ];
        // when
         $result = $this->get('/versions-all/'.$fileID);
        // then
        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJsonContains($response);
    }

}