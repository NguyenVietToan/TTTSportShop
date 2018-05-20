<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Sport;
use App\SaleCode;
use DB;
use Illuminate\Http\Request;


class StatisticController extends Controller
{

    //Hiển thị form thống kê theo ngày
    public function getTimeStatistic()
    {
        return view('admin.statistic.set-time');
    }


    //Thống kê: trả về danh sách sp bán được, tổng số lượng, tổng doanh thu, tổng lợi nhuận
    public function getStatistic($data = array())
    {
        //Đầu vào là ngày bắt đầu và ngày kết thúc
        $startDate     = $data['start_date'];
        $endDate       = $data['end_date'];

        //Sản phẩm bán được
        $productSales  = DB::table('products as p')
                        ->select(['p.id', 'p.name', 'p.price', 'p.sale_price', 'p.import_price', 'o.salecode_id', DB::raw('sum(od.qty) as sum_qty')])
                        ->join('order_details as od', 'od.pro_id', '=', 'p.id')
                        ->join('orders as o', 'o.id', '=', 'od.order_id')
                        ->where('od.status', '=', 1)  //các sp được giao thành công
                        ->whereDate('o.date_order', '>=', $startDate)
                        ->whereDate('o.date_order', '<=', $endDate)
                        ->where('o.status_order', '=', '3');    //các đơn hàng đã thành công 
        if (!empty($data['cate_id'])) {
            $productSales = $productSales->where('p.cate_id', '=', $data['cate_id']);
        }
        if (!empty($data['sport_id'])) {
            $productSales = $productSales->where('p.sport_id', '=', $data['sport_id']);
        }
        if (!empty($data['brand_id'])) {
            $productSales = $productSales->where('p.brand_id', '=', $data['brand_id']);
        }
        $productSales = $productSales->groupBy(['p.id', 'p.name', 'p.price', 'p.sale_price', 'p.import_price', 'o.salecode_id'])
            ->get();    

        $profit  = 0; //tổng lợi nhuận
        $revenue = 0; //tổng doanh thu
        $sumQty  = 0; //tổng số lượng sp bán được

        foreach ($productSales as $productSale) {
            $price = $productSale->price;
            if ($productSale->sale_price) {
                $price = $productSale->sale_price;
            }

            $sale_percent = 0;
            if(!empty($productSale->salecode_id)){
                $salecode = SaleCode::find($productSale->salecode_id);
                if(!empty($salecode)){
                    $sale_percent = $salecode->salepercent;
                }
            }

            $productSale->profitOne = $price - $productSale->import_price;  //lãi trên 1 sp
            $tmpRevenue             = $price * $productSale->sum_qty;
            $tmpProfit              = ($price - $productSale->import_price) * $productSale->sum_qty;
            $productSale->revenue   = $tmpRevenue * (100 - $sale_percent)/100;
            $productSale->profit    = $tmpProfit * (100 - $sale_percent)/100;
            $revenue                += $tmpRevenue * (100 - $sale_percent)/100;
            $profit                 += $tmpProfit * (100 - $sale_percent)/100;
            $sumQty                 += $productSale->sum_qty;
        }
        $data = [
            'products' => $productSales,
            'revenue'  => $revenue,
            'profit'   => $profit,
            'sum_qty'  => $sumQty,
        ];
        return $data;
    }


    //Hiển thị kết quả thống kê thường
    public function getResult(Request $request)
    {
        //phải chuyển time về dạng Y-m-d thì mới lấy trong DB được
        $start_date_arr = explode('/', $request->start_date);  //chuyển về dạng mảng
        $start_date     = $start_date_arr[2].'-'.$start_date_arr[1].'-'.$start_date_arr[0];
        $end_date_arr   = explode('/', $request->end_date);
        $end_date       = $end_date_arr[2].'-'.$end_date_arr[1].'-'.$end_date_arr[0];
        if ($start_date >= $end_date) {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Ngày bắt đầu phải trước ngày kết thúc !']);;
        }
        $where = [
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ];
        $data   = $this->getStatistic($where);
        $cates  = Category::all();
        $sports = Sport::all();
        $brands = Brand::all();

        $data['cates']      = $cates;
        $data['sports']     = $sports;
        $data['brands']     = $brands;
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        return view('admin.statistic.result', $data);
    }


    //Hiển thị kết quả thống kê filter
    public function getFilter(Request $request)
    {
        $data   = $this->getStatistic($request->except(['_token']));
        $cates  = Category::all();
        $sports = Sport::all();
        $brands = Brand::all();

        $data['cates']      = $cates;
        $data['sports']     = $sports;
        $data['brands']     = $brands;
        $data['start_date'] = $request->start_date;
        $data['end_date']   = $request->end_date;
        $data['sport_id']   = $request->sport_id;
        $data['cate_id']    = $request->cate_id;
        $data['brand_id']   = $request->brand_id;
        return view('admin.statistic.result', $data);
    }
}
