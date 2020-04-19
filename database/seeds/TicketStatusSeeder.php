<?php

use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_status')->insert([
            ['title'=>'Open','color'=>'#779500','active'=>true,'awaiting'=>true,'auto_close'=>false,'order'=>1],
            ['title'=>'Answered','color'=>'#000000','active'=>true,'awaiting'=>false,'auto_close'=>true,'order'=>2],
            ['title'=>'Customer-Reply','color'=>'#ff6600','active'=>true,'awaiting'=>true,'auto_close'=>true,'order'=>3],
            ['title'=>'On Hold','color'=>'#224488','active'=>true,'awaiting'=>false,'auto_close'=>false,'order'=>5],
            ['title'=>'In Progress','color'=>'#cc0000','active'=>true,'awaiting'=>false,'auto_close'=>false,'order'=>6],
            ['title'=>'Closed','color'=>'#888888','active'=>false,'awaiting'=>false,'auto_close'=>false,'order'=>10],
        ]);
    }
}
