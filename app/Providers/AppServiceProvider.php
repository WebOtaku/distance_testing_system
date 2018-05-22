<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Test;
use App\Question;
use App\AnswerVariant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Test::deleted(function (Test $test) {
            $test->questions->each(function (Question $question) {
                $question->delete();
            });
        });

        Question::deleted(function ($question) {
            $question->answerVariants->each(function (AnswerVariant $answerVariant) {
                $answerVariant->delete();
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
