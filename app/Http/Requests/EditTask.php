<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditTask extends CreateTask
{
    public function rules()
    {
        $rule = parent::rules();

        $status_rule = Rule::in(array_keys(Task::STATUS));
        // 「Task::STATUS」のkey「array_keys()」に
        // 含まれているかどうか「Rule::in()」という条件

        return $rule + [
            'status' => 'required|'. $status_rule,
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);
        // 「Task::STATUS」の['label']keyの値を得て配列にする

        $status_labels = implode('、', $status_labels);
        // ['label']を得た配列の要素を「句読点（、）」でつなげる
        // 出力「未着手、着手中、完了」

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
    }
}
