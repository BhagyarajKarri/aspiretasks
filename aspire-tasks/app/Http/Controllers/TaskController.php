<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
        private $loan_amount;
        private $weekly_interest_rate;
        private $terms;
        private $period;
        private $principal;
        private $balance;
        private $term_pay;
    public function index()
    {
        return "This is the controller created for the task";
    }

    public function loancalculation(Request $request)
    {

        $data = array(
        'loan_amount'   => $request->input('loan_amount'),
        'interest_rate'      => $request->input('interest_rate'),
        'weekly_terms'         => $request->input('no_weekly_terms')
        );

        if($this->validate_data($data)) {

                
                $this->loan_amount  = (float) $data['loan_amount'];
                $this->weekly_interest_rate     = (float) $data['interest_rate']/52;
                $this->period = (int) $data['weekly_terms'];
                $this->weekly_interest_rate = ($this->weekly_interest_rate/100) ;

               

                return response()->json([
                    'inputs' => $data,
                    'loan_summary' => $this->getSummary(),
                    'weekly_payment_schedule' => $this->getSchedule(),
                ]);
            }
    }

    public function getSummary()
        {
            $this->calculate();
            $total_pay = $this->term_pay *  $this->period;
            $total_interest = $total_pay - $this->loan_amount;

            return array (
                'total_pay' => $total_pay,
                'total_interest' => $total_interest,
                );
        }

        public function calculate()
        {
            $deno = 1 - 1 / pow((1+ $this->weekly_interest_rate),$this->period);

            $this->term_pay = ($this->loan_amount * $this->weekly_interest_rate) / $deno;
            $weekly_interest_rate = $this->loan_amount * $this->weekly_interest_rate;

            $this->principal = $this->term_pay - $weekly_interest_rate;
            $this->balance = $this->loan_amount - $this->principal;
            return array (
                'payment'   => $this->term_pay,
                'interest'  => $weekly_interest_rate,
                'principal' => $this->principal,
                'balance'   => $this->balance
                );
        }

        public function getSchedule ()
        {
            $schedule = array();
            
            while  ($this->balance >= 0) { 
                //print_r($this->balance);echo "<br>";
                array_push($schedule, $this->calculate());
                $this->loan_amount = $this->balance;
                $this->period--;
            }

            return $schedule;

        }

        public function validate_data($data) {
            $data_format = array(
                'loan_amount'   => 0,
                'weekly_terms'    => 0,
                'interest_rate'      => 0
                );

            $validate_data = array_diff_key($data_format,$data);
            
            if(empty($validate_data)) {
                return true;
            }else{
                echo "<div style='background-color:#ccc;padding:0.5em;'>";
                echo '<p style="color:red;margin:0.5em 0em;font-weight:bold;background-color:#fff;padding:0.2em;">Missing Values</p>';
                foreach ($validate_data as $key => $value) {
                    echo ":: Value <b>$key</b> is missing.<br>";
                }
                echo "</div>";
                return false;
            }
        }
}
