<?php

namespace PlanA23\EGPayment\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PlanA23\EGPayment\Interfaces\PaymentInterface;
use PlanA23\EGPayment\Traits\SetRequiredFields;
use PlanA23\EGPayment\Traits\SetVariables;

class FawryPayment implements PaymentInterface
{
    use SetVariables,SetRequiredFields;

    public $fawry_url;
    public $fawry_secret;
    public $fawry_merchant;
    public $verify_route_name;
    public $fawry_display_mode;
    public $fawry_pay_mode;

    public function __construct()
    {
        $this->fawry_url = config('PlanA23-payments.FAWRY_URL');
        $this->fawry_merchant = config('PlanA23-payments.FAWRY_MERCHANT');
        $this->fawry_secret = config('PlanA23-payments.FAWRY_SECRET');
        $this->fawry_display_mode = config('PlanA23-payments.FAWRY_DISPLAY_MODE');
        $this->fawry_pay_mode = config('PlanA23-payments.FAWRY_PAY_MODE');
        $this->verify_route_name = config('PlanA23-payments.VERIFY_ROUTE_NAME');
    }


    /**
     * @param $amount
     * @param null $user_id
     * @param null $user_first_name
     * @param null $user_last_name
     * @param null $user_email
     * @param null $user_phone
     * @param null $source
     * @return string[]
     * @throws MissingPaymentInfoException
     */
    public function pay($amount = null, $user_id = null, $user_first_name = null, $user_last_name = null, $user_email = null, $user_phone = null, $source = null): array
    {
        $this->setPassedVariablesToGlobal($amount,$user_id,$user_first_name,$user_last_name,$user_email,$user_phone,$source);
        $required_fields = ['amount', 'user_id', 'user_first_name', 'user_last_name', 'user_email', 'user_phone'];
        $this->checkRequiredFields($required_fields, 'FAWRY');

        $unique_id = uniqid();

        $data = [
            'fawry_url' => $this->fawry_url,
            'fawry_merchant' => $this->fawry_merchant,
            'fawry_secret' => $this->fawry_secret,
            'user_id' => $this->user_id,
            'user_name' => "{$this->user_first_name} {$this->user_last_name}",
            'user_email' => $this->user_email,
            'user_phone' => $this->user_phone,
            'unique_id' => $unique_id,
            'item_id' => 1,
            'item_quantity' => 1,
            'amount' => $this->amount,
            'payment_id'=>$unique_id
        ];

        $secret = $data['fawry_merchant'] . $data['unique_id'] . $data['user_id'] . $data['item_id'] . $data['item_quantity'] . $data['amount'] . $data['fawry_secret'];
        $data['secret'] = $secret;

        return [
            'payment_id' => $unique_id, 
            'html' => $this->generate_html($data),
            'redirect_url'=>""
        ];

    }

    /**
     * @param Request $request
     * @return array|void
     */
    public function verify(Request $request)
    {
        $res = json_decode($request['chargeResponse'], true);
        $reference_id = $res['merchantRefNumber'];

        $hash = hash('sha256', $this->fawry_merchant . $reference_id . $this->fawry_secret);

        $response = Http::get($this->fawry_url . 'ECommerceWeb/Fawry/payments/status/v2?merchantCode=' . $this->fawry_merchant . '&merchantRefNumber=' . $reference_id . '&signature=' . $hash);

        if ($response->offsetGet('statusCode') == 200 && $response->offsetGet('paymentStatus') == "PAID") {
            return [
                'success' => true,
                'payment_id'=>$reference_id,
                'message' => __('PlanA23::messages.PAYMENT_DONE'),
                'process_data' => $request->all()
            ];
        } else if ($response->offsetGet('statusCode') != 200) {
            return [
                'success' => false,
                'payment_id'=>$reference_id,
                'message' => __('PlanA23::messages.PAYMENT_FAILED'),
                'process_data' => $request->all()
            ];
        }
    }

    private function generate_html($data): string
    {
        return view('PlanA23::html.fawry', ['model' => $this, 'data' => $data])->render();
    }

}