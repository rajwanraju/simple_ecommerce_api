<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\DeliveriedOrder;
use Carbon\Carbon;

class DailyOrderUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $orders = Order::where('status','Deliveried')->wheredate('updated_at',date('Y-m-d'))->get();
        foreach ($orders as $order) {

         $deliveriedOrder = new DeliveriedOrder();
         $deliveriedOrder->order_id = $order->order_id;
         $deliveriedOrder->name = $order->name;
         $deliveriedOrder->email = $order->email;
         $deliveriedOrder->products =$order->products;
         $deliveriedOrder->phone_number = $order->phone_number;
         $deliveriedOrder->sub_total =$order->sub_total;
         $deliveriedOrder->grand_total =$order->grand_total; 
         $deliveriedOrder->customer_id = $order->customer_id;
         $deliveriedOrder->shipping_address = $order->shipping_address;
         $deliveriedOrder->deliveried_at = Carbon::yesterday();
         $deliveriedOrder->status = $order->status;
         $deliveriedOrder->save();


         $removeOrder = Order::find($order->id);
         $removeOrder->delete();
     }

     $this->info('Successfully Update Deliveried Orders.');
 }
}
