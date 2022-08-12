<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Charts\UserChart;
use App\Models\Documment;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class AdminHomeController extends Controller
{

    private $user;
    private $room;
    public function __construct(
        User $user,
        Room $room
    ) {
        $this->user = $user;
        $this->room = $room;
    }

    public function index(Request $request)
    {

        // dd($request->all());

        $users = Documment::select(DB::raw("COUNT(*) AS count"))
                ->whereYear('date_off', date('Y'))
                ->groupBy(DB::raw("Month(date_off)"))
                ->pluck('count');

        $months = Documment::select(DB::raw("Month(date_off) as month"))
        ->whereYear('date_off', date('Y'))
        ->groupBy(DB::raw("Month(date_off)"))
        ->pluck('month');

        $data = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($months as $index =>$month){
            --$month;
            $data[$month] = $users[$index];
        }

        $totalUser = $this->user->where('active', 1)->get()->count();
        $totalRoom = $this->room->where('active', 1)->get()->count();



        return view('admin.pages.index',[
            'totalUser' => $totalUser,
            'data' => $data,
            'totalRoom' => $totalRoom,
        ]);
    }

    public function apiBieuDo(Request $request)
    {
        $days = $request->days;
        //truy xuất data 5 năm gần đây
        $range = \Carbon\Carbon::now()->subDays($days);

        $stats = DB::table('documments')
        ->where('date_off', '>=', $range)
        ->groupBy('getYear')
        ->orderBy('getYear', 'ASC')
        ->get([
            DB::raw('Date(date_off) as getYear'),
            DB::raw('COUNT(*) as value')
        ]);

        dd($stats->count());
        return $stats;
    }




    ////////////

    public function orderByYear()
    {
        $range = \Carbon\Carbon::now()->subYears(5);

        $orderYear = DB::table('documments')
                    ->select(DB::raw('year(date_off) as getYear'), DB::raw('COUNT(*) as value'))
                    ->where('date_off', '>=', $range)
                    ->groupBy('getYear')
                    ->orderBy('getYear', 'ASC')
                    ->get();

        return view('fdfadmin.chart.get_year', compact('orderYear'));
    }
// function orderByYear() mình sẽ lấy tổng các order trong vòng 5 năm tính từ năm hiện tại và fill vào **bar chart**

    public function orderByDay()
    {
        $range = \Carbon\Carbon::now();
        $get_range = date_format($range,"Y/m/d");
        $date_range = date_format($range,"d/m/Y");
        $sumProductDay = DB::table('orders')
                    ->select(DB::raw('SUM(detail_orders.amount) as countProduct'))
                    ->join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
                    ->join('products', 'detail_orders.product_id', '=', 'products.id')
                    ->where('date_order', '=', $get_range)
                    ->groupBy('date_order')
                    ->first();
        if ($sumProductDay == null)
        {

            return redirect(route('chartYear'))->with('alert',trans('chart.no_order'));
        } else {

        $totalProduct = (INT)($sumProductDay->countProduct);
        $percentProduct = round((100 / $totalProduct), 3);

        $productBuy = DB::table('orders')
                    ->select('products.name as name', DB::raw("SUM(amount) * $percentProduct as y"))
                    ->join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
                    ->join('products', 'detail_orders.product_id', '=', 'products.id')
                    ->where('date_order', '=', $get_range)
                    ->groupBy('product_id')
                    ->get();

        return view('fdfadmin.chart.view_order', compact('productBuy', 'date_range'));

        }
    }
    // ở function này mình tính % từng loại order được đặt vào ngày hôm đó và fill vào **Pie chart**
}
