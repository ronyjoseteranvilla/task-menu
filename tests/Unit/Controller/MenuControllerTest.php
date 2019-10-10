<?php 

namespace Tests\Unit\Controller\MenuControllerTest;

use App\Http\Controllers\MenuController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MenuControllerTest extends TestCase{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function check_if_updates_menus(){
        $data = [
            "field"=> "Menu",
            "max_depth"=> 5,
            "max_children"=> 5
        ];
        $response = $this->json('POST', '/api/menus/', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure(
            [
                'id',
                'field',
                'max_depth',
                'max_children'
            ]
        );
        $menu = $response->getData();
        $dataUpdate = [
            "field"=> "Menu changed Name",
            "max_depth"=> 6,
            "max_children"=> 5
        ];
        $responseUpdate = $this->json('PUT','/api/menus/'.$menu->id, $dataUpdate);
        $this->assertEquals($dataUpdate['field'],$responseUpdate->getData()->field);        
    }

    /**
     * @test
     */
    public function check_if_inserts_menu()
    {

        $data = [
            "field"=> "menu222",
            "max_depth"=> 5,
            "max_children"=> 5
        ];
        $response = $this->json('POST', '/api/menus/', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure(
            [
                'id',
                'field',
                'max_depth',
                'max_children'
            ]
        );
        
    } 
    
    /** 
     * @test
     */
    public function check_if_returns_insert_value()
    {
        $data = [
            "field"=> "menu222",
            "max_depth"=> 5,
            "max_children"=> 5
        ];
        $response2 = $this->json('POST', '/api/menus/', $data);
        
        $response = $this->json('GET', '/api/menus/1');
        $response->assertStatus(200);        
        $response->assertJsonStructure(
            [
                'id',
                'field',
                'max_depth',
                'max_children'
            ]
        );

    }

    /**
     * @test
     */
    public function check_unit_test_show_method(){
        $data = [
            "field"=> "Menu",
            "max_depth"=> 5,
            "max_children"=> 5
        ];
        $response = $this->json('POST', '/api/menus/', $data);
        $insertedMenu = $response->getData();
        $menu = new MenuController();
        $value = $menu->show($insertedMenu->id);
        $showMenu = $value->resolve();        
        $this->assertEquals($showMenu['field'], $data['field']);
        $this->assertArrayHasKey('id', $showMenu);
    }
}