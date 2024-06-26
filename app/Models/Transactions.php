<?php

namespace App\Models;

use App\Classes\WriteToFile;
use App\Helpers\CustomHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transactions extends Model
{
    use HasFactory;

    /**
     * log path
     */
    protected $logPath;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->logPath = base_path('storage/logs/transaction.txt');
    }

    protected $fillable = [
        'unique_id', 'order_id', 'wallet_id', 'type', 'reason', 'amount', 'total_tax', 'additional_amount', 'status',
    ];

    protected $dates = ['created_at', 'deleted_at'];


    const STATUS_FAILED = 5;
    const STATUS_SUCCESS = 10;
    const STATUS_PENDING = 11;

    public static $statuses = [
        self::STATUS_SUCCESS => 'Success',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_FAILED => 'Failed',
    ];

    const TYPE_DEBIT = 0;
    const TYPE_CREDIT = 1;
    public static $types = [
        self::TYPE_DEBIT => "Debit",
        self::TYPE_CREDIT => "Credit",
    ];


    const REASON_TOPUP = 1;
    const REASON_PURCHASE = 2;
    const REASON_DISCOUNT = 3;

    public static $reasons = [
        self::REASON_TOPUP => 'Top up',
        self::REASON_PURCHASE => 'Purchase',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $unique_token = AutoIncrement::getAutoIncrementId('auto_transaction');
            $model->unique_id = 'TNX' .  CustomHelper::generatePassword(10 - strlen($unique_token), 2) . $unique_token;

            if ($model->reason == self::REASON_TOPUP) {
                $model->status = self::STATUS_PENDING;
            }
        });
    }


    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }


    /**
     * Scope a query to only include users of a given aQuery.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $aQuery
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $aQuery)
    {
        if (request('reason')) {
            $query->where('reason', request('reason'));
        }
        if (request('status')) {
            $query->where('status', request('status'));
        }
        if (request('start_date') && request('end_date')) {
            $start_date = date('Y-m-d', strtotime(request('start_date')));
            $end_date = date('Y-m-d', strtotime(request('end_date')));
            $query->orWhereBetween('created_at', array($start_date, $end_date));
        }
        return $query;
    }


    /**
     * save transaction in table.
     * @param User $aUser
     * @param $reason // valid transaction reason
     * @param $type // transaction type
     * @param $amount
     * @param Booking/NULL $booking
     * @param array $params
     * @return Transaction/boolean
     */
    public function makeTransaction($aUser, $reason, $type, $amount, $booking = null, $params = [])
    {
        DB::beginTransaction();
        try {
            $wallet = $aUser->wallet;
            if (!$wallet) {
                WriteToFile::logMessage($this->logPath, 'Error to make transaction wallet not found : user' . $aUser->id);
                return false;
            }

            $transaction_array = array_merge([
                'wallet_id' => $aUser->wallet->id,
                'type' => $type,
                'reason' => $reason,
                'amount' => $amount,
            ], $params);

            /* check wallet */
            $riffle_wallet = $wallet->riffle_wallet;
            $use_wallet = $wallet->use_wallet;
            $total_wallet = $wallet->total_wallet;
            if ($type == self::TYPE_CREDIT) {
                $riffle_wallet += $amount;
            } else {
                $use_wallet += $amount;
            }

            if (array_diff_key($transaction_array, array_flip($this->fillable))) {
                WriteToFile::logMessage($this->logPath, 'Invalid params request while making transaction params: ' . json_encode($transaction_array));
                return false;
            }

            $transaction = self::create($transaction_array);
            if (!$transaction) {
                WriteToFile::logMessage($this->logPath, 'Error to save save transaction params: ' . json_encode($transaction_array));
                return false;
            }

            $wallet->update([
                'riffle_wallet' => $riffle_wallet,
                'use_wallet' => $use_wallet,
                'total_wallet' => ($riffle_wallet - $use_wallet),
            ]);
            DB::commit();

            return ($transaction) ? $transaction : false;
        } catch (\Throwable $th) {
            DB::rollBack();
            WriteToFile::logMessage($this->logPath, 'Error to save save transaction params: ' . $aUser->id . ' Error : ' . $th->getMessage());
            return false;
        }
    }
}
