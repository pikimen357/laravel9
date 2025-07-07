<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testUpload(){
        $image = UploadedFile::fake()->image('avatar.jpg');

        $this->post('/file/upload',
                    ["picture" => $image])
            ->assertStatus(200)
            ->assertSeeText('OK avatar.jpg');
    }
}
