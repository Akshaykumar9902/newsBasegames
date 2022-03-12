<?php

namespace App\Http\Controllers\F1F2;

use App\Http\Controllers\Production\PlaynotiController;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\CustomeOppController;
use Cache;
use User;
use Auth;


class NewClientController extends  CustomeOppController
{

    public function __construct(Request $req)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $ptl = Route::current()->parameter('ptl');
        if ($ptl == 'web') {
            $this->middleware('auth');
        }
        if ($ptl == 'mob') {
            $this->middleware('auth:api');
        }
        $this->arr = array();
        $param = $req->getQueryString();
        if ($param) {
            parse_str($param, $arr);
            $this->arr = $arr;
            $this->url = $param;
            if (array_key_exists("page", $arr)) $this->page = $arr['page'];
            if (array_key_exists("q", $arr)) $this->q = $arr['q'];
            if (array_key_exists("n", $arr)) {
                $this->n = $arr['n'];
            } else {
                $this->n = 10;
            }
        } else {
            $this->n = 10;
        }
    }

    public function dashboardview(Request $request, $ptl = null)
    {

        //  $data_scr = Cache::get('data_scr');
        //  $data_sig_posi = Cache::get('data_position');
        //   $data = Cache::get('data');
        $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
        $data_sig_posi = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        $data_scr = DB::select("select * from f1f2_stock_data_view  order by id desc limit 1");
        $news = DB::select("select * from f1f2_news_history  order by id desc limit 1");
        //   echo  json_encode($news);
        //     $news1=($news[0]->news);
        //   $news2=json_decode($news1);
        //      foreach($news2 as $k=>$v){
        //          echo $k;
        //          echo $v->title;

        //      }

        //     echo  json_encode($data_scr);
        $intra = "Intra";
        if ($request->ajax()) {
            return view('F1F2.Client.NewDashAjax2')->with(array('data' => $data, 'data_scr' => $data_scr, 'data_sig_posi' => $data_sig_posi, 'news' => $news));
        }

        return view('F1F2.Client.NewDash')->with(array('data' => $data, 'data_scr' => $data_scr, 'data_sig_posi' => $data_sig_posi, 'news' => $news));
    }

    public function dashdata(Request $request, $ptl = null)
    {
        $comp = $request->get("comp");
        //  $comp="NTPC";
        //  $date = date('Y-m-d');
        //  $data_scr = Cache::get('data_scr');
        //  $data_position = Cache::get('data_position');
        // //  $data = Cache::get('data');
        //  $data = DB::select("select $comp from f1f2_intraday_signal_view_table  order by id desc limit 1");


        //   echo  json_encode($data_position);
        //     echo  json_encode($data_scr);
        //   if($request->ajax()) {
        //   return view('F1F2.Client.NewDashAjax')->with(array('intra_data'=>$data,'data_scr'=>$data_scr,'data_position'=>$data_position));
        //   }

        $data = DB::select("select $comp from f1f2_stock_data_view  order by id desc limit 1");
        $data_sig_posi = DB::select("select $comp from f1f2_positional_signal_view_table order by id desc limit 1");
        $data_sig_intra = DB::select("select $comp from f1f2_intraday_signal_view_table order by id desc limit 1");

        $data_man_posi = DB::select("select $comp from f1f2_positional_manual_signal order by id desc limit 1");
        $data_man_intra = DB::select("select $comp from f1f2_intraday_manual_signal order by id desc limit 1");
        //   echo  json_encode($data_sig_intra);
        //  echo (json_decode($data_sig_intra[0]->AXISBANK)->time);
        if ($request->ajax()) {
            return view('F1F2.Client.NewDashAjax')->with(array(
                'data' => $data, 'data_sig_intra' => $data_sig_intra, 'data_sig_posi' => $data_sig_posi,
                "param" => $this->arr,  "manualp" => $data_man_posi, "manuali" => $data_man_intra
            ));
        }
    }

    public function index(Request $request, $ptl = null)
    {

        $u = "user";
        $date = date('Y-m-d');
        $data_scr = DB::select("select * from f1f2_stock_data_view  order by id desc limit 1");
        $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        if ($ptl != 'api') {
            if ($request->ajax()) {
                return view('F1F2.Client.stocktable')->with(array('data' => $data, 'data_scr' => $data_scr));
            }
            return view('F1F2.Client.StockData')->with(array('data' => $data, 'data_scr' => $data_scr));
        }
        if ($ptl == 'api') {
            return json_encode(array('data' => $data, 'data_scr' => $data_scr));
        }
    }

    // public function index_intra(Request $request, $ptl = null){
    //   $u ="user";
    //      $date = date('Y-m-d');
    //      $data_scr = DB::select("select * from f1f2_stock_data_view  order by id desc limit 1");
    //      $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
    //     if($ptl != 'api'){
    //     if($request->ajax()) {
    //          return view('F1F2.Client.stocktable')->with(array('data'=>$data,'data_scr'=>$data_scr));
    //     }
    //       return view('F1F2.Client.StockData')->with(array('data'=>$data,'data_scr'=>$data_scr));
    //     }
    //     if($ptl == 'api'){
    //         return json_encode(array('data'=>$data,'data_scr'=>$data_scr));
    //     } 

    // }


    //   public function index_intra(Request $request, $ptl = null){
    //          $u ="user";
    //          $date = date('Y-m-d');
    //          $time = date('G:i:s');
    //          $data = null; $data_scr = null;
    //          $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
    //          $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");

    //       if(strtotime($time) > strtotime('09:15:00') && strtotime($time) < strtotime('15:30:00') ){
    //       $data_scr = Cache::get('data_scr');
    //       $data = Cache::get('data');
    //       }
    //       else{
    //           $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
    //         $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
    //       }
    //          if($ptl != 'api'){
    //           if($request->ajax()) {
    //              return view('F1F2.Client.stocktable')->with(array('data'=>$data,'data_scr'=>$data_scr));
    //           }
    //          return view('F1F2.Client.StockData')->with(array('data'=>$data,'data_scr'=>$data_scr, "head"=>"Intra Day Calls"));
    //          }
    //          if($ptl == 'api'){ 
    //          return json_encode(array('data'=>$data,'data_scr'=>$data_scr));
    //          }

    //     }


    public function index_intra(Request $request, $ptl = null)
    {
        $u = "user";
        $date = date('Y-m-d');
        $time = date('G:i:s');
        //  $data = null; $data_scr = null;
        $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
        $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
        //  echo json_encode($data);
        // $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        if (strtotime($time) > strtotime('09:15:00') && strtotime($time) < strtotime('15:30:00')) {
            //   $data_scr = Cache::get('data_scr');
            //   $data = Cache::get('data');
            //   echo json_encode($data);
        } else {
            $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
            $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
            //  echo json_encode($data);
            //   $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        }
        if ($ptl != 'api') {
            //   echo json_encode($data);
            if ($request->ajax()) {
                return view('F1F2.Client.stocktable')->with(array('data' => $data, 'data_scr' => $data_scr));
            }
            //  echo json_encode($data);
            return view('F1F2.Client.StockData')->with(array('data' => $data, 'data_scr' => $data_scr, "head" => "Intra Day Calls"));
        }
        if ($ptl == 'api') {
            return json_encode(array('data' => $data, 'data_scr' => $data_scr));
        }
    }

    public function index_future(Request $request, $ptl = null)
    {
        $u = "user";
        $date = date('Y-m-d');
        $time = date('G:i:s');
        $M = date('M');
        $M = "NOV";
        $fu = array();
        $skk = array();

        $M = strtoupper($M);
        $y = date('y');
        $data = null;
        $data_scr = null;

        //  $data_scr = Cache::get('data_scr');
        $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");

        $d = 0;


        //   $ss = json_decode($data_scr, true);
        // echo $ss["ZEEL"];
        $ss = json_decode($data_scr[0]->FUTURES, true);
        // echo $data_scr[0]->FUTURES;
        // echo "<br><br>";
        foreach ($data_scr as $k => $v) {
            foreach ($v as $kk => $vv) {
                if ($kk != "id" and $kk != "NIFTY" and $kk != "datetime") {
                    if ($kk != "FUTURES") {
                        $ftr = DB::select("select $kk from f1f2_future_table order by id desc limit 1");

                        foreach ($ftr as $fr) {
                            $gc = $fr->$kk;
                            $ga = json_decode($gc);

                            //  if(isset($ga->call)){
                            //      echo $ga->call;
                            //  }
                        }
                    }
                    if ($kk == "BAJAJAUTO") {
                        $kk = "BAJAJ-AUTO";
                    }

                    if (isset($ss[$kk . $y . $M . "FUT"])) {
                        $so = json_decode($vv);
                        $skk[$kk]["stock"] = $so->stock;

                        $sk = json_decode($ss[$kk . $y . $M . "FUT"]);
                        $skk[$kk]["FuStock"] = $sk->stock;
                        //   echo "<br>";
                        $skk[$kk]["PerChange"] = number_format((1 - $so->stock / $sk->stock) * 100, 2);
                        if ($skk[$kk]["PerChange"] >= 1) {
                            $skk[$kk]["call"] = "BUY";
                            if (isset($ga->call)) {
                                if ($ga->call != $skk[$kk]["call"]) {
                                    echo "noti";
                                    $title = "Alert Hedging " . $kk;
                                    $ck = $kk;
                                    if ($kk == "BAJAJ-AUTO") {
                                        $ck = "BAJAJAUTO";
                                    }
                                    DB::insert("insert into f1f2_future_history_table ($ck) value(?)", [json_encode($skk[$kk])]);
                                    $description = $kk . " Buy in Equity %change : " . $skk[$kk]["PerChange"] . " EQ price : " . $skk[$kk]["stock"] . " Futures price :" . $skk[$kk]["FuStock"];
                                    $rel = $this->push_notification_android($title, $description);
                                }
                            }
                        } else if ($skk[$kk]["PerChange"] <= -1) {
                            $skk[$kk]["call"] = "SELL";

                            if (isset($ga->call)) {
                                if ($ga->call != $skk[$kk]["call"]) {
                                    echo "noti" . $d;
                                    $d++;
                                    $ck = $kk;
                                    if ($kk == "BAJAJ-AUTO") {
                                        $ck = "BAJAJAUTO";
                                    }
                                    DB::insert("insert into f1f2_future_history_table ($ck) value(?)", [json_encode($skk[$kk])]);
                                    $title = "Alert Hedging " . $kk;
                                    $description = $kk . " Buy in Futures %change : " . $skk[$kk]["PerChange"] . " Futures price :" . $skk[$kk]["FuStock"] . " EQ price : " . $skk[$kk]["stock"];
                                    $rel = $this->push_notification_android($title, $description);
                                }
                            }
                        } else {
                            $skk[$kk]["call"] = "HOLD";
                        }
                        $cm = $kk;
                        if ($kk == "BAJAJ-AUTO") {
                            $cm = "BAJAJAUTO";
                        }
                        DB::update("update f1f2_future_table  set $cm =?", [json_encode($skk[$kk])]);
                        DB::update("update f1f2_company_array  set futures =? where instrument = ?", [$skk[$kk]["call"], $cm]);
                        //   echo "<br><br>";
                    }
                }
            }
        }

        // foreach($skk as $k=>$v){
        //     echo $k;

        //   echo $v["stock"];
        // }



        //         $value = Cache::remember('future',60, function () {
        //   return $skk->get();
        // });

        // $hash=$skk;

        //  $ftr = DB::select("select * from f1f2_future_table order by id desc limit 1");

        // return json_encode($skk);



        Cache::forget('future');
        //                 Cache::forget('data_scr');
        Cache::forever('future', $skk);
        // Cache::forever('data_scr', $data_scr);

        if ($ptl != 'api') {


            if ($request->ajax()) {
                return view('F1F2.Client.stocktablefutures')->with(array('data' => $skk));
            }
            return view('F1F2.Client.StockDatafutures')->with(array('data' => $skk, "head" => "Futures Calls"));
        }
        if ($ptl == 'api') {
            return json_encode(array('data' => $data, 'data_scr' => $data_scr));
        }
    }

    public function index_futureCache(Request $request, $ptl = null)
    {
        $value = Cache::get('future');
        //   $value = Cache::get('future');  
        echo json_encode($value);
    }

    public function DT(Request $request, $ptl = null)
    {
        $col = DB::select("select * from f1f2_company_array");
        foreach ($col as $bb) {
            $comp =  $bb->instrument;

            $DT =  $bb->DT;
            $DB =  $bb->DB;
            $TT =  $bb->TT;
            $TB =  $bb->TB;

            $data = DB::select("SELECT $comp FROM f1f2_stock_data_view");
            foreach ($data as $dd) {
                if ($dd->$comp != null) {
                    $stock = json_decode($dd->$comp)->stock;
                }
            }
            if ($DT < $stock) {
                $title = "DOUBLE TOP";
                $description = $comp . " HIT " . $title . " AT " . $stock;
                $rel = $this->push_notification_android($title, $description);
            }
            if ($TT < $stock) {
                $title = "TRIPLE TOP";
                $description = $comp . " HIT " . $title . " AT " . $stock;
                $rel = $this->push_notification_android($title, $description);
            }
            if ($DB > $stock) {
                $title = "DOUBLE BOTTOM";
                $description = $comp . " HIT " . $title . " AT " . $stock;
                $rel = $this->push_notification_android($title, $description);
            }
            if ($TB > $stock) {
                $title = "TRIPLE BOTTOM";
                $description = $comp . " HIT " . $title . " AT " . $stock;
                $rel = $this->push_notification_android($title, $description);
            }
        }
    }

    public function index_intrarev(Request $request, $ptl = null)
    {
        $u = "user";
        $date = date('Y-m-d');
        $time = date('G:i:s');
        $data = null;
        $data_scr = null;
        $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
        $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
        // $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        if (strtotime($time) > strtotime('09:15:00') && strtotime($time) < strtotime('15:30:00')) {
            $data_scr = Cache::get('data_scr');
            $data = Cache::get('data');
        } else {
            $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
            $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
            //   $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        }

        if ($ptl != 'api') {
            if ($request->ajax()) {
                return view('F1F2.Client.stocktablerev')->with(array('data' => $data, 'data_scr' => $data_scr));
            }
            return view('F1F2.Client.StockDatarev')->with(array('data' => $data, 'data_scr' => $data_scr, "head" => "Intra Day Calls"));
        }
        if ($ptl == 'api') {
            return json_encode(array('data' => $data, 'data_scr' => $data_scr));
        }
    }


    public function index_intrarevb(Request $request, $ptl = null)
    {
        $u = "user";
        $date = date('Y-m-d');
        $time = date('G:i:s');
        $data = null;
        $data_scr = null;
        $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
        $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
        // $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");


        if (strtotime($time) > strtotime('09:15:00') && strtotime($time) < strtotime('15:30:00')) {
            $data_scr = Cache::get('data_scr');
            $data = Cache::get('data');
        } else {
            $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
            $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
            //   $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        }
        if ($ptl != 'api') {
            if ($request->ajax()) {
                return view('F1F2.Client.stocktablerevb')->with(array('data' => $data, 'data_scr' => $data_scr));
            }
            return view('F1F2.Client.StockDatarevb')->with(array('data' => $data, 'data_scr' => $data_scr, "head" => "Intra Day Calls"));
        }
        if ($ptl == 'api') {
            return json_encode(array('data' => $data, 'data_scr' => $data_scr));
        }
    }


    public function push_notification_android($title, $description)
    {
        $res = array();
        $tbl = 'prd_playnotis';
        $arr = array();
        $arr['title'] = $title;
        $arr['description'] = $description;
        $arr['is_active'] = 'Yes';

        $con = DB::table($tbl)->insert($arr);

        if ($con == true) {

            $id =  DB::table($tbl)->orderBy('id', 'desc')->first();
            $up = DB::update('update ' . $tbl . ' set unique_id = CONCAT("PNT_",LPAD(id, 4, "0")) where id = ?', [$id->id]);
            //  echo '<script>alert("data inserted successfully")</script>';
            //  $title=$req->get('title');
            //  $description=$req->get('description');
            //  $this->push_notification_android($title,$description);
        }

        /*api_key available in:
 Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
        $api_key = 'AAAAwo0A6q4:APA91bGg0i-Y00GkEeQp7F_ClcyF4JmR9IA5o4fI2WgHBBPHp0OqWapHXPSoh1JHtp6hBpZ9EfkJmOf8TOBQEMtfZzdVLjxaH6nUQsoFlyDbjUSmEji4vqqkCSYWrCoVCRQp9dkElTEn';
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';


        $con = DB::select("select * from users where device_id <> '' and playf1f2=1 and testuser=1");
        $total = count($con);
        // $total=244;


        foreach ($con as $v) {
            $vv = $v->device_id;
            // 	  echo "<br>";
            array_push($res, $vv);
        }





        if ($total > 1000) {
            $cc1 = $total / 1000;
            $cc = ceil($cc);
        } else {




            // $title="Akshay";
            // $description="Description f1f2";

            $data = array('body' => $description);
            $notification = array('body' => $description, 'title' => $title);

            $fields = array(
                'registration_ids' => $res,
                'notification' => $notification,
                'data' => array('body' => $data)
            );

            $headers = array(
                'Authorization: key=' . $api_key,
                'Content-Type: application/json'
            );



            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            // return $result;  



        }
    }

    public function clientTrade(Request $request, $ptl = null)
    {
        $u = "user";
        $date = date('Y-m-d');
        $time = date('G:i:s');
        $data = null;
        $data_scr = null;
        $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
        $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
        // $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        //   if(strtotime($time) > strtotime('09:15:00') && strtotime($time) < strtotime('15:30:00') ){
        //   $data_scr = Cache::get('data_scr');
        //   $data = Cache::get('data');
        //   }
        //   else{
        $data_scr = DB::select("select * from f1f2_stock_data_view order by id desc limit 1");
        $data = DB::select("select * from f1f2_intraday_signal_view_table  order by id desc limit 1");
        //   $data = DB::select("select * from f1f2_positional_signal_view_table  order by id desc limit 1");
        //   }
        if ($ptl != 'api') {
            if ($request->ajax()) {
                return view('F1F2.Client.stocktableTrade')->with(array('data' => $data, 'data_scr' => $data_scr));
            }
            // return json_encode(array('data'=>$data,'data_scr'=>$data_scr));
            return view('F1F2.Client.StockDataTrade')->with(array('data' => $data, 'data_scr' => $data_scr, "head" => "Intra Day Calls"));
        }
        if ($ptl == 'api') {
            return json_encode(array('data' => $data, 'data_scr' => $data_scr));
        }
    }

    public function TransactShare(Request $req, $ptl = null)
    {

        $message = array();
        $date = date('Y-m-d');
        $time = date('G:i:s');
        $id = 0;
        $idh = 0;
        $ApiURL = "https://tt-lb-v2.nscript.com/api/addorder.php?site=federalcapital";

        //check for holiday
        $holi = DB::select("select holiday_date from prd_holidays where holiday_date =?", [$date]);
        if (sizeof($holi) > 0) {
            $message['alert'] = 'Its Holiday Today';
        } else {
            $day = date('D');
            if ($day == 'Sat' || $day == 'Sun') {
                $message['alert'] = 'Today is weekly off';
            } else {
                if (strtotime($time) >= strtotime('09:15:00') && strtotime($time) <= strtotime('20:30:00')) {

                    $tbl = 'playf1f2_transaction';
                    $comp = $req->input('comp');
                    $client = $req->input('client');
                    $pr = $req->input('price');
                    $qty = $req->input('qty');
                    $tr = $req->input('tr');
                    $token1 = $req->input('token1');
                    $bse_token = $req->input('bse_token');


                    $userid = Auth::user()->userid;
                    $arr = array();
                    $ar = array();
                    $ar["userid"] = $userid;
                    $ar["companyname"] = $comp;

                    $arr["userid"] = $userid;
                    $arr["companyname"] = $comp;
                    $arr["transaction"] = $tr;
                    $arr["price"] = $pr;
                    $arr["qty"] = $qty;
                    // $data = DB::table($tbl)->where('userid','=',$userid)->orderBy('id', 'DESC')->first();
                    if ($tr == "BUY") {
                        if ($qty > 0) {
                            $webSig = "Buy";
                            $bse_c = 1;
                            $targ_api = 0;
                            $features = DB::select("select * from f1f2_features ");

                            $login_token = $features[0]->login_token;
                            if ($client == "B") {
                                $users_code = DB::select("SELECT * FROM `order_LMH` WHERE other = '$client'");
                            } else {
                                $users_code = DB::select("SELECT * FROM `order_LMH` WHERE type = '$client'");
                            }
                            foreach ($users_code as $ck => $cv) {
                                $code = $cv->client_code;

                                $ch = curl_init($ApiURL . '&volume=' . $qty . '&price=' . $pr . '&tprice=0&dqty=0&ioc=0&blockdeal=N&pro_client=1&buy_sell=' . $bse_c . '&series=EQ&login_token=' . $login_token . '&user_id=1313679&user_name=' . $code . '&token=' . $token1 . '&nse_token=0&bse_token=' . $bse_token . '&symbol=' . $comp . '&oe_destination=1&oe_market_id=1&oe_good_till_date=2&oe_segment=1&oe_book_type=1&oe_group=A&OEFIELD3=N&OEInstrumentType=&OEExpiryDate=0&OEOptionType=&OEStrikePrice=0&OEAdminUSID=1313679&OESettlor=NA&OEField1=1&oe_status=2&oe_good_till_cancel=');

                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                // execute!
                                $response = curl_exec($ch);
                                // echo "<br>";

                                // close the connection, release resources used
                                curl_close($ch);
                            }
                            $message['msg'] = $response . 'Transaction successfully completed';
                        } else {
                            $message['alert1'] = 'Buy Incorrect quantity';
                        }
                    }
                    if ($tr == "SELL") {

                        if ($qty > 0) {
                            $webSig = "Sell";
                            $bse_c = 0;
                            $targ_api = 1;
                            $features = DB::select("select * from f1f2_features ");

                            $login_token = $features[0]->login_token;

                            if ($client == "B") {
                                $users_code = DB::select("SELECT * FROM `order_LMH` WHERE other = '$client'");
                            } else {
                                $users_code = DB::select("SELECT * FROM `order_LMH` WHERE type = '$client'");
                            }
                            foreach ($users_code as $ck => $cv) {
                                $code = $cv->client_code;

                                $ch = curl_init($ApiURL . '&volume=' . $qty . '&price=' . $pr . '&tprice=0&dqty=0&ioc=0&blockdeal=N&pro_client=1&buy_sell=' . $bse_c . '&series=EQ&login_token=' . $login_token . '&user_id=1313679&user_name=' . $code . '&token=' . $token1 . '&nse_token=0&bse_token=' . $bse_token . '&symbol=' . $comp . '&oe_destination=1&oe_market_id=1&oe_good_till_date=2&oe_segment=1&oe_book_type=1&oe_group=A&OEFIELD3=N&OEInstrumentType=&OEExpiryDate=0&OEOptionType=&OEStrikePrice=0&OEAdminUSID=1313679&OESettlor=NA&OEField1=1&oe_status=2&oe_good_till_cancel=');

                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                // execute!
                                $response = curl_exec($ch);
                                // echo "<br>";

                                // close the connection, release resources used
                                curl_close($ch);
                            }


                            $message['msg'] = 'response ' . $response . 'Transaction successfully completed';
                        } else {
                            $message['alert1'] = 'Sell Incorrect quantity';
                        }
                    }
                } else {
                    $message['alert'] = 'Stock Market is Closed';
                }
            }
        }

        if ($ptl == 'api') {
            return json_encode(array('data' => $message));
        }

        return $message;
    }

    public function delivaryTrades(Request $req, $ptl = null)
    {
        $stockdata = 'f1f2_stock_data_view';
        $ApiURL = "https://tt-lb-v2.nscript.com/api/addorder.php?site=federalcapital";
        $features = DB::select("select * from f1f2_features ");
        $date = date('Y-m-d');
        $time = date('G:i:s');
        $client = "DT";
        $status = $features[0]->delivery_new;
        $login_token = $features[0]->login_token;
        $holi = DB::select("select holiday_date from prd_holidays where holiday_date =?", [$date]);
        if (sizeof($holi) > 0) {
            echo 'Its Holiday Today. ';
        } else {
            $day = date('D');
            //   if($day == 'Sat' || $day == 'Sun') { 
            if ($day == 'Sun') {
                echo 'Today is Weekly Off.';
            } else {

                if (strtotime($time) > strtotime('09:20:00') && strtotime($time) < strtotime('15:00:00') && $status = 1) {
                    $col = DB::select("select * from f1f2_delivery_new");
                    // return json_encode($col);
                    $data = DB::select("select * from $stockdata");
                    //  if(count($data>0)){

                    foreach ($col as $bb) {
                        $qty =  $bb->qty;
                        echo $company =  $bb->company;
                        echo $id = $bb->id;
                        echo "<br>";
                        $buy_price =  $bb->buy_price;
                        $statusDelivery =  $bb->status;
                        $target = $bb->target;
                        $stop_loss = $bb->stop_loss;

                        $dataComp = DB::select("select * from f1f2_company_array where instrument='$company'");
                        if ($dataComp) {
                            $bse_token = $dataComp[0]->bse_token;
                            $token = $dataComp[0]->token;
                            foreach ($data as $con) {
                                //  echo $con->$comp;
                                $dd = json_decode($con->{$company});
                                $stock = $dd->stock;

                                if ($stock <= $buy_price && $statusDelivery == 0) {
                                    $users_code = DB::select("SELECT * FROM `order_LMH` WHERE type = '$client'");
                                    foreach ($users_code as $ck => $cv) {
                                        $code = $cv->client_code;

                                        $webSig = "Buy";
                                        $bse_c = 1;
                                        $targ_api = 0;

                                        $ch = curl_init($ApiURL . '&volume=' . $qty . '&price=0&tprice=0&dqty=0&ioc=0&blockdeal=N&pro_client=1&buy_sell=' . $bse_c . '&series=EQ&login_token=' . $login_token . '&user_id=1313679&user_name=' . $code . '&token=' . $token . '&nse_token=0&bse_token=' . $bse_token . '&symbol=' . $company . '&oe_destination=1&oe_market_id=1&oe_good_till_date=2&oe_segment=1&oe_book_type=1&oe_group=A&OEFIELD3=N&OEInstrumentType=&OEExpiryDate=0&OEOptionType=&OEStrikePrice=0&OEAdminUSID=1313679&OESettlor=NA&OEField1=1&oe_status=2&oe_good_till_cancel=');

                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                        // execute!
                                        echo $response = curl_exec($ch);
                                        DB::update("update f1f2_delivery_new set status = ? where id = ?", [1, $bb->id]);
                                    }
                                }
                                if ($stock >= $target && $statusDelivery == 1) {
                                    $users_code = DB::select("SELECT * FROM `order_LMH` WHERE type = '$client'");
                                    foreach ($users_code as $ck => $cv) {
                                        $code = $cv->client_code;

                                        $webSig = "Buy";
                                        $bse_c = 0;
                                        $targ_api = 1;

                                        $ch = curl_init($ApiURL . '&volume=' . $qty . '&price=0&tprice=0&dqty=0&ioc=0&blockdeal=N&pro_client=1&buy_sell=' . $bse_c . '&series=EQ&login_token=' . $login_token . '&user_id=1313679&user_name=' . $code . '&token=' . $token . '&nse_token=0&bse_token=' . $bse_token . '&symbol=' . $company . '&oe_destination=1&oe_market_id=1&oe_good_till_date=2&oe_segment=1&oe_book_type=1&oe_group=A&OEFIELD3=N&OEInstrumentType=&OEExpiryDate=0&OEOptionType=&OEStrikePrice=0&OEAdminUSID=1313679&OESettlor=NA&OEField1=1&oe_status=2&oe_good_till_cancel=');

                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                                        // execute!
                                        echo $response = curl_exec($ch);
                                        DB::update("update f1f2_delivery_new set status = ? where id = ?", [2, $bb->id]);
                                    }
                                    //  }



                                }
                            }
                        }else{
                            echo "wrong name".$company;
                        }
                    }
                }
            }
        }
    }
}
