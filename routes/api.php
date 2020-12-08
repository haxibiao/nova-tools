<?php

use App\Exceptions\UserException;
use App\Explanation;
use App\Question;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
 */

// Route::get('/endpoint', function (Request $request) {
//     //
// });

//搜索用户，刷子查询用
Route::get('/search-users', function (Request $reuqest) {
    $data = [];

    if ($account = $reuqest->get('account')) {

        $user    = User::with('wallet')->where('account', $account)->first();
        $wallets = Wallet::with('user')->where('pay_account', $account)->get();

        if ($user) {
            $user                = $user->toArray();
            $user['pay_account'] = $user['wallet']['pay_account'] ?? null;
            $wallets             = $wallets->each(function ($wallet) use ($user, &$data) {
                if ($wallet->user_id != $user['id']) {
                    $walletUser                = $wallet->user->toArray();
                    $walletUser['pay_account'] = $wallet->pay_account;
                    $data[]                    = $walletUser;
                }
            })->toArray();
            $data = array_merge($data, [$user]);
        }

    }
    return $data;
});

//创建题目
Route::any('/', function (Request $request) {
    $inputs = $request->input('json');

    if (isset($inputs['user'])) {
        $user = User::where('account', $inputs['user'])->first();
        throw_if(is_null($user), UserException::class, '用户不存在');
    } else {
        $user = auth()->user();
    }

    $data = array_merge($inputs, [
        'gold'    => Question::DEFAULT_GOLD,
        'ticket'  => Question::DEFAULT_TICKET,
        'user_id' => $user->id,
        'submit'  => Question::SUBMITTED_SUBMIT,
    ]);

    if (isset($data['question'])) {
        $data['description'] = $data['question'];
    }
    if (isset($data['Selection'])) {
        $data['selections'] = $data['Selection'];
    }

    $data     = Arr::except($data, ['question', 'Selection', 'user']);
    $question = new Question;
    $question->fill($data);
    $question->syncType();
    $question->rank = $question->getDefaultRank();
    $question->save();

    if ($question->id) {
        return successful_response($question);
    }

    throw new UserException('发布失败');
});

//提交题目解释
Route::any('/submit-explanation', function (Request $request) {
    $explanationParams = $request->get('explanation');

    if (!is_array($explanationParams)) {
        throw new UserException('提交失败,没有解析内容!');
    }

    $explanation          = (new Explanation)->fill($explanationParams);
    $explanation->user_id = auth()->id();
    $explanation->save();

    return successful_response($explanation);

});
